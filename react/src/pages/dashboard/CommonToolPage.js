import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import ToolCard from "../../components/ToolCard";
import Button from 'react-bootstrap/Button';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';
import InputGroup from 'react-bootstrap/InputGroup';
import Row from 'react-bootstrap/Row';
import LanguagesForm from "../../components/LanguagesForm";
import {useLocation, useParams} from "react-router-dom";
import {Icon} from "@iconify/react";
import {copyText, hexToRgbA} from "../../helpers/Utils";
import API from "../../helpers/Axios";
import {store} from "../../store/configureStore";
import {useTranslation} from "react-i18next";
import CopyButton from "../../components/CopyButton";
import tools from "../../helpers/tools.json";
import {Base64} from "js-base64";

const findSection = (pathName) => {
    for (const e of tools) {
        const tool = e.tools.find(tool => tool.alt_name === pathName);
        if (tool) {
            return tool;
        }
    }
    return null;
}

const CommonToolPage = ({navigation, route}) => {
    const { t } = useTranslation();
    const [tabIndex, setTabIndex] = useState(0);
    const { slug } = useParams();
    const location = useLocation();
    const [pathName, setPathName] = useState(location.pathname.replace('/dashboard/tools/', ''));

    useEffect(() => {
        setPathName(location.pathname.replace('/dashboard/tools/', ''));
    }, [slug])

    const [isLoading, setIsLoading] = useState(true);

    const sectionObject = findSection(pathName);
    const [validated, setValidated] = useState(false);

    const [textAreaValue, setTextAreaValue] = useState('');
    const [variants, setVariants] = useState(2);
    const [variantsContent, setVariantsContent] = useState([]);
    const [isSubmitting, setIsSubmitting] = useState( false);
    const [savedIndexes, setSavedIndexes] = useState([]);
    const [savedContents, setSavedContents] = useState([]);
    const [deletingId, setDeletingId] = useState(null);

    useEffect(() => {
        if (variants < 1) {
            setVariants(1);
        }
        if (variants > 20) {
            setVariants(20);
        }
    }, [variants]);


    const [processes, setProcesses] = useState([]);
    const [isRunning, setIsRunning] = useState(false);

    const handleSubmit = (event) => {
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            const data = new FormData(event.target);
            setProcesses(Array.from({length: variants}, (_, i) => i));
            runProcess(Array.from({length: variants}, (_, i) => i), data);
            setVariantsContent(Array.from({length: variants}, (_, i) => ''));
            setSavedIndexes([]);
            setTabIndex(0);
        }
        setValidated(true);
        event.preventDefault();
        event.stopPropagation();
    };

    const runProcess = async (processes, data) => {
        if (processes.length === 0) {
            setIsRunning(false);
            return;
        }

        let builtString = '';

        for (const [name, value] of data.entries()) {
            console.log(name, value);
            if(name !== 'language') {
                builtString += name + '=' + value + ' & ';
            }
        }

        setIsRunning(true);
        const currentProcess = processes[0];
        try {
            console.log(`Running process: ${currentProcess}`);

            await new Promise(resolve => {
                API.post('auth/user/text-generator', {
                    action: Base64.encode(`write ${slug.replace(/-/g, ' ')} with data --> ${builtString.replace(/_/g, ' ')}`)
                }).then((res) => {
                    if(res.data && res.data.usage) {
                        store.dispatch({type: 'UPDATE_TOKENS', tokens: store.getState().common.tokens - res.data.usage});
                    }
                    setVariantsContent((prev) => {
                        const newArray = [...prev];
                        newArray[currentProcess] = res.data.text.replace(/^\s+|\s+$/g, '').split("\n").map(paragraph => `<p>${paragraph}</p>`).join('');
                        return newArray;
                    });
                    resolve(true);
                }).catch (error => {
                    resolve(true);

                });
            });
        } catch (error) {
            console.error(`Error running process: ${currentProcess}`);
        }
        setProcesses(processes.slice(1));
        await runProcess(processes.slice(1), data);
    };

    const saveContent = (text, index) => {
        API.post('auth/content/save', {
            type: slug,
            content: text
        }).then(res => {
            setSavedIndexes([...savedIndexes, index])
        }).catch (error => {

        });
    }

    const getSavedContents = () => {
        API.post('auth/contents', {
            type: slug,
        }).then(res => {
            setSavedContents(res.data.data)
        }).catch (error => {

        });
    }

    const deleteContent = (id, index) => {
        setSavedContents((prev) => [
            ...prev.slice(0, index),
            ...prev.slice(index + 1)
        ]);
        API.post('auth/content/delete', {
            id: deletingId,
        }).then(res => {

        }).catch (error => {

        });
    }

    useEffect(() => {
        getSavedContents();
    }, [savedIndexes]);


    return (
        <div className="row">
            <div className="col-lg-4 col-12">
                <div className="card p-3">
                    <div className="d-flex align-items-center mb-3">
                        <div className="card-tool-icon" style={{backgroundColor: hexToRgbA(sectionObject.icon_color)}}>
                            <Icon icon={sectionObject.icon_name} style={{color: sectionObject.icon_color}} width="24" />
                        </div>
                        <span className="ms-2 fw-bold">{t(sectionObject.title)}</span>
                    </div>
                    <p className="text-secondary">{t(sectionObject.description)}</p>
                    <Form noValidate validated={validated} onSubmit={handleSubmit}>
                        <Row className="mb-3">
                            <Form.Group as={Col}>
                                <Form.Label>Language</Form.Label>
                                <LanguagesForm />
                            </Form.Group>
                            <Form.Group as={Col}>
                                <Form.Label>Creativity</Form.Label>
                                <Form.Select name="creativity">
                                    <option value="high">High</option>
                                    <option value="regular">Regular</option>
                                </Form.Select>
                            </Form.Group>
                        </Row>
                        {(pathName === 'blog-section-author' || pathName === 'paragraph-writer-for-blogs') && (
                            <>
                                <Form.Group className="mb-3">
                                    <Form.Label>Title of your blog article</Form.Label>
                                    <Form.Control
                                        name="blog_title"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder={t('5 ways to boost your sales with copywriting')}
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <Form.Label>Subheading / Bullet Point</Form.Label>
                                    <Form.Control
                                        name="subheading"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="Identify Your Target Audience and Speak to Their Needs"
                                    />
                                </Form.Group>
                            </>
                        )}
                        {(pathName === 'blog-introduction-maker' || pathName === 'blog-outline-tool') && (
                            <>
                                <Form.Group className="mb-3">
                                    <Form.Label>Title of your blog article</Form.Label>
                                    <Form.Control
                                        name="article_title"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="5 ways to boost your sales with copywriting"
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>What is your blog post about?</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/200</small>
                                    </div>
                                    <Form.Control
                                        name="post_content"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="a blog article about the best tools to increase your website traffic"
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                            </>
                        )}
                        {(pathName === 'blog-conclusion-writer') && (
                            <>
                                <Form.Group className="mb-3">
                                    <Form.Label>Article title or topic</Form.Label>
                                    <Form.Control
                                        name="topic"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="5 ways to boost your sales with copywriting"
                                    />
                                </Form.Group>
                            </>
                        )}
                        {(pathName === 'paragraph-creator') && (
                            <>
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>{t('What is your paragraph about?')}</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/1200</small>
                                    </div>
                                    <Form.Control
                                        name="paragraph_content"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder={t('The best cryptocurrency to invest in')}
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <Form.Label>{t('Keyword to include')}</Form.Label>
                                    <Form.Control
                                        name="include_keyword"
                                        required
                                        placeholder="Cryptocurrencies"
                                        rows="4"
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <Form.Label>{t('Tone of voice')}</Form.Label>
                                    <Form.Select name="tone_of_voice">
                                        <option value="professional">Professional</option>
                                        <option value="childish">Childish</option>
                                        <option value="luxurious">Luxurious</option>
                                        <option value="friendly">Friendly</option>
                                        <option value="confident">Confident</option>
                                        <option value="exciting">Exciting</option>
                                    </Form.Select>
                                </Form.Group>
                            </>
                        )}
                        {(pathName === 'engaging-blog-titles' || pathName === 'blog-inspiration-generator' || pathName === 'listicles-blog-titles') && (
                            <>
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>{t('What is your blog post about?')}</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/200</small>
                                    </div>
                                    <Form.Control
                                        name="post_content"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="a blog article about the best tools to increase your website traffic"
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                            </>
                        )}
                        {(pathName === 'talk-points-generator') && (
                            <>
                                <Form.Group className="mb-3">
                                    <Form.Label>{t('Article title')}</Form.Label>
                                    <Form.Control
                                        name="article_title"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder={t('5 ways to boost your sales with copywriting')}
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <Form.Label>{t('Subheading')}</Form.Label>
                                    <Form.Control
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder={t('Why you should use an AI writer')}
                                    />
                                </Form.Group>
                            </>
                        )}
                        {['pros-cons-maker', 'generate-startup-names'].includes(pathName) && (
                            <>
                                {pathName === 'pros-cons-maker' && (
                                    <Form.Group className="mb-3">
                                        <Form.Label>{t('Product Name')}</Form.Label>
                                        <Form.Control
                                            name="product_name"
                                            required
                                            placeholder={t('Product Name')}
                                            rows="4"
                                        />
                                    </Form.Group>
                                )}
                                {pathName === 'generate-startup-names' && (
                                    <Form.Group className="mb-3">
                                        <Form.Label>{t('Seed Words')}</Form.Label>
                                        <Form.Control
                                            name="seed_words"
                                            required
                                            placeholder="e.g. fit, flow..."
                                            rows="4"
                                        />
                                    </Form.Group>
                                )}
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>{t('Product Description?')}</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/1200</small>
                                    </div>
                                    <Form.Control
                                        name="product_description"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="Explain here to the AI what your product (or service) is about. Rewrite to get different results."
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                            </>
                        )}

                        {(['web-page-headlines', 'subtitles-for-websites', 'frequently-asked-questions', 'answers-for-faqs', 'pain-stimulate-solution', 'user-testimonials-reviews', 'how-your-product-works', 'our-story', 'call-to-action-phrases', 'facebook-ad-content', 'facebook-ad-headline-writing', 'google-ads-headline-creation', 'google-ads-description-writing', 'create-product-descriptions', 'craft-unique-value-proposition', 'turn-features-into-benefits', 'write-welcome-emails', 'cancellation-email', 'write-email-subject-lines', 'generate-confirmation-emails']).includes(pathName) && (
                            <>
                                {!(['answers-for-faqs', 'frequently-asked-questions', 'pain-stimulate-solution', 'user-testimonials-reviews', 'how-your-product-works', 'call-to-action-phrases', 'facebook-ad-content', 'facebook-ad-headline-writing', 'google-ads-headline-creation', 'create-product-descriptions']).includes(pathName) && (
                                    <Form.Group className="mb-3">
                                        <Form.Label>Tone of voice</Form.Label>
                                        <Form.Select
                                            name="tone_of_voice"
                                        >
                                            <option value="professional">Professional</option>
                                            <option value="childish">Childish</option>
                                            <option value="luxurious">Luxurious</option>
                                            <option value="friendly">Friendly</option>
                                            <option value="confident">Confident</option>
                                            <option value="exciting">Exciting</option>
                                        </Form.Select>
                                    </Form.Group>
                                )}
                                <Row className="mb-3">
                                    {(pathName !== 'user-testimonials-reviews') && (
                                        <Form.Group as={Col}>
                                            <Form.Label>{t('Audience')}</Form.Label>
                                            <Form.Control
                                                name="audience"
                                                required
                                                type="text"
                                                placeholder="Freelancers, Designers,..."
                                            />
                                        </Form.Group>
                                    )}
                                    <Form.Group as={Col} controlId="validationCustom02">
                                        <Form.Label>Product Name</Form.Label>
                                        <Form.Control
                                            name="product_name"
                                            required
                                            type="text"
                                            placeholder="Netflix, Spotify, Uber..."
                                        />
                                    </Form.Group>
                                </Row>
                                {(pathName === 'generate-confirmation-emails') && (
                                    <Form.Group className="mb-3">
                                        <Form.Label>Confirmation of</Form.Label>
                                        <Form.Control
                                            name="confirmation_of"
                                            required
                                            type="text"
                                            placeholder="Sale, Sign-up,..."
                                        />
                                    </Form.Group>
                                )}
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>Product Description?</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/400</small>
                                    </div>
                                    <Form.Control
                                        name="product_description"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="Explain here to the AI what your product (or service) is about. Rewrite to get different results."
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                                {(pathName === 'answers-for-faqs') && (
                                    <Form.Group className="mb-3">
                                        <Form.Label>What is the question you are generating answers for?</Form.Label>
                                        <Form.Control
                                            name="answers_for"
                                            required
                                            type="text"
                                            placeholder="Your question here"
                                        />
                                    </Form.Group>
                                )}
                            </>
                        )}

                        {(['business-social-media-post', 'define-company-mission', 'write-vision-statement', 'write-press-releases']).includes(pathName) && (
                            <>
                                <Row className="mb-3">
                                    {(pathName !== 'user-testimonials-reviews') && (
                                        <Form.Group as={Col}>
                                            <Form.Label>Company Name</Form.Label>
                                            <Form.Control
                                                name="company_name"
                                                required
                                                type="text"
                                                placeholder="Amazon"
                                            />
                                        </Form.Group>
                                    )}
                                </Row>
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>Company Description?</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/400</small>
                                    </div>
                                    <Form.Control
                                        name="company_description"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="Explain here to the AI what your product (or service) is about. Rewrite to get different results."
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                                {!['define-company-mission', 'write-vision-statement'].includes(pathName) && (
                                    <Row className="mb-3">
                                        <Form.Group as={Col}>
                                            <Form.Label>{t('What is this post about?')}</Form.Label>
                                            <Form.Control
                                                name="post_content"
                                                required
                                                type="text"
                                                placeholder={t('Release of our product')}
                                            />
                                        </Form.Group>
                                    </Row>
                                )}
                            </>
                        )}
                        {(['instagram-hashtag-recommendations']).includes(pathName) && (
                            <Row className="mb-3">
                                <Form.Group as={Col}>
                                    <Form.Label>{t('Enter a keyword')}</Form.Label>
                                    <Form.Control
                                        name="post_content"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder={t('e.g yoga')}
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                            </Row>
                        )}
                        {(['personal-social-media-update', 'instagram-post-captions']).includes(pathName) && (
                            <Row className="mb-3">
                                <Form.Group as={Col}>
                                    <Form.Label>{t('What is this post about?')}</Form.Label>
                                    <Form.Control
                                        name="post_content"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder={t('Heading to the beach on weekend')}
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                            </Row>
                        )}
                        {['youtube-video-titles', 'write-video-intros', 'organize-video-scripts', 'generate-video-content'].includes(pathName) && (
                            <>
                                <Form.Group className="mb-3">
                                    <Form.Label>Tone of voice</Form.Label>
                                    <Form.Select name="tone_of_voice">
                                        <option value="professional">Professional</option>
                                        <option value="childish">Childish</option>
                                        <option value="luxurious">Luxurious</option>
                                        <option value="friendly">Friendly</option>
                                        <option value="confident">Confident</option>
                                        <option value="exciting">Exciting</option>
                                    </Form.Select>
                                </Form.Group>
                                {(['generate-video-content']).includes(pathName) && (
                                    <Form.Group className="mb-3">
                                        <Form.Label>Section title</Form.Label>
                                        <Form.Control
                                            name="section_title"
                                            required
                                            type="text"
                                            placeholder="e.g. Benefits of using an AI Copywriter"
                                        />
                                    </Form.Group>
                                )}
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>What is your video about?</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/200</small>
                                    </div>
                                    <Form.Control
                                        name="video_description"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="Explain here what your video is about, include as many details as possible. I.e. A video tutorial about boosting your traffic with an AI Writer."
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                            </>
                        )}
                        {(pathName === 'youtube-video-descriptions') && (
                            <Form.Group className="mb-3">
                                <div className="d-flex align-items-center justify-content-between">
                                    <Form.Label>What is the title of your video?</Form.Label>
                                    <small className="text-muted">{textAreaValue.length}/100</small>
                                </div>
                                <Form.Control
                                    name="video_title"
                                    required
                                    as="textarea"
                                    type="text"
                                    placeholder="learn how to boost your traffic with an AI-Powered content writing tool."
                                    rows="5"
                                    maxLength={100}
                                    value={textAreaValue}
                                    onChange={(e) => {
                                        setTextAreaValue(e.currentTarget.value)
                                    }}
                                />
                            </Form.Group>
                        )}
                        {(pathName === 'youtube-tag-generator') && (
                            <Form.Group className="mb-3">
                                <Form.Label>Enter your video title or a keyword</Form.Label>
                                <Form.Control
                                    name="video_title"
                                    required
                                    type="text"
                                    placeholder="yoga"
                                />
                            </Form.Group>
                        )}
                        {(pathName === 'twitter-threads-creation') && (
                            <Form.Group className="mb-3">
                                <div className="d-flex align-items-center justify-content-between">
                                    <Form.Label>What is this thread about</Form.Label>
                                    <small className="text-muted">{textAreaValue.length}/400</small>
                                </div>
                                <Form.Control
                                    name="thread_content"
                                    required
                                    as="textarea"
                                    type="text"
                                    placeholder="The 5 best Tesla safety features"
                                    rows="5"
                                    maxLength={400}
                                    value={textAreaValue}
                                    onChange={(e) => {
                                        setTextAreaValue(e.currentTarget.value)
                                    }}
                                />
                            </Form.Group>
                        )}
                        {(pathName === 'twitter-post-ideas') && (
                            <Form.Group className="mb-3">
                                <div className="d-flex align-items-center justify-content-between">
                                    <Form.Label>What is this tweet about</Form.Label>
                                    <small className="text-muted">{textAreaValue.length}/400</small>
                                </div>
                                <Form.Control
                                    name="tweet_content"
                                    required
                                    as="textarea"
                                    type="text"
                                    placeholder="Tesla Cars"
                                    rows="5"
                                    maxLength={400}
                                    value={textAreaValue}
                                    onChange={(e) => {
                                        setTextAreaValue(e.currentTarget.value)
                                    }}
                                />
                            </Form.Group>
                        )}
                        {(pathName === 'linkedin-profile-posts') && (
                            <>
                                <Form.Group className="mb-3">
                                    <Form.Label>Audience</Form.Label>
                                    <Form.Control
                                        name="audience"
                                        required
                                        type="text"
                                        placeholder="Freelancers, Designers, Teenagers..."
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <Form.Label>What is this post about</Form.Label>
                                    <Form.Control
                                        name="post_content"
                                        required
                                        type="text"
                                        placeholder="Release of our app"
                                    />
                                </Form.Group>
                            </>
                        )}
                        {(pathName === 'quora-answer-writing') && (
                            <Form.Group className="mb-3">
                                <div className="d-flex align-items-center justify-content-between">
                                    <Form.Label>Quora Question</Form.Label>
                                    <small className="text-muted">{textAreaValue.length}/200</small>
                                </div>
                                <Form.Control
                                    name="question"
                                    required
                                    as="textarea"
                                    type="text"
                                    placeholder="What is something that rich people know that the rest of us would benefit from?"
                                    rows="5"
                                    maxLength={200}
                                    value={textAreaValue}
                                    onChange={(e) => {
                                        setTextAreaValue(e.currentTarget.value)
                                    }}
                                />
                            </Form.Group>
                        )}

                        {(pathName === 'personal-bio-writing') && (
                            <>
                                <Row className="mb-3">
                                    <Form.Group as={Col}>
                                        <Form.Label>Full Name</Form.Label>
                                        <Form.Control
                                            name="full_name"
                                            required
                                            type="text"
                                            placeholder="Elon Musk"
                                        />
                                    </Form.Group>
                                    <Form.Group as={Col} controlId="validationCustom02">
                                        <Form.Label>Current Position</Form.Label>
                                        <Form.Control
                                            name="current_position"
                                            required
                                            type="text"
                                            placeholder="CEO at Tesla"
                                        />
                                    </Form.Group>
                                </Row>
                                <Row className="mb-3">
                                    <Form.Group as={Col}>
                                        <Form.Label>Current Industry</Form.Label>
                                        <Form.Control
                                            name="current_industry"
                                            required
                                            type="text"
                                            placeholder="Cars"
                                        />
                                    </Form.Group>
                                    <Form.Group as={Col} controlId="validationCustom02">
                                        <Form.Label>Current City</Form.Label>
                                        <Form.Control
                                            name="current_city"
                                            required
                                            type="text"
                                            placeholder="Austin, Texas"
                                        />
                                    </Form.Group>
                                </Row>
                                <Form.Group className="mb-3">
                                    <Form.Label>Childhood</Form.Label>
                                    <Form.Control
                                        name="childhood"
                                        required
                                        type="text"
                                        placeholder="Born and raised in United State"
                                    />
                                </Form.Group>
                                <Row className="mb-3">
                                    <Form.Group as={Col}>
                                        <Form.Label>Hobbies</Form.Label>
                                        <Form.Control
                                            name="hobbies"
                                            required
                                            type="text"
                                            placeholder="Bitcoin, Trade"
                                        />
                                    </Form.Group>
                                    <Form.Group as={Col} controlId="validationCustom02">
                                        <Form.Label>Interests</Form.Label>
                                        <Form.Control
                                            name="interests"
                                            required
                                            type="text"
                                            placeholder="Girl"
                                        />
                                    </Form.Group>
                                </Row>
                                <Row className="mb-3">
                                    <Form.Group as={Col}>
                                        <Form.Label>Skills</Form.Label>
                                        <Form.Control
                                            name="skills"
                                            required
                                            type="text"
                                            placeholder="Talking"
                                        />
                                    </Form.Group>
                                    <Form.Group as={Col} controlId="validationCustom02">
                                        <Form.Label>Character Traits</Form.Label>
                                        <Form.Control
                                            name="character_traits"
                                            required
                                            type="text"
                                            placeholder="Hard Worker"
                                        />
                                    </Form.Group>
                                </Row>
                                <Form.Group className="mb-3">
                                    <Form.Label>Point of View</Form.Label>
                                    <Form.Select name="point_of_view">
                                        <option value="first_person">First Person</option>
                                        <option value="third_person">Third Person</option>
                                    </Form.Select>
                                </Form.Group>
                            </>
                        )}
                        {['write-newsletters'].includes(pathName) && (
                            <>
                                <Form.Group className="mb-3">
                                    <Form.Label>Tone of voice</Form.Label>
                                    <Form.Select name="tone_of_voice">
                                        <option value="professional">Professional</option>
                                        <option value="childish">Childish</option>
                                        <option value="luxurious">Luxurious</option>
                                        <option value="friendly">Friendly</option>
                                        <option value="confident">Confident</option>
                                        <option value="exciting">Exciting</option>
                                    </Form.Select>
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <Form.Label>Subject</Form.Label>
                                    <Form.Control
                                        name="subject"
                                        required
                                        type="text"
                                        placeholder="e.g. Benefits of using an AI Copywriter"
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <Form.Label>Company Name</Form.Label>
                                    <Form.Control
                                        name="company_name"
                                        required
                                        type="text"
                                        placeholder="Amazon"
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>Business Description?</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/200</small>
                                    </div>
                                    <Form.Control
                                        name="business_description"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="Briefly describe what your business is about."
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                            </>
                        )}
                        {['meta-description-creation'].includes(pathName) && (
                            <>
                                <Form.Group className="mb-3">
                                    <Form.Label>Type of Page</Form.Label>
                                    <Form.Select name="type_of_page">
                                        <option value="landing_page">Landing page</option>
                                        <option value="product_page">Product page</option>
                                        <option value="category_page">Category page</option>
                                        <option value="blog_article">Blog article</option>
                                    </Form.Select>
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <Form.Label>Website</Form.Label>
                                    <Form.Control
                                        name="website_name"
                                        required
                                        type="text"
                                        placeholder="Shoppe, Google"
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>Website Description?</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/200</small>
                                    </div>
                                    <Form.Control
                                        name="website_description"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="Briefly describe what your website or business is about."
                                        rows="5"
                                        maxLength={200}
                                        value={textAreaValue}
                                        onChange={(e) => {
                                            setTextAreaValue(e.currentTarget.value)
                                        }}
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <Form.Label>Targeted Keyword</Form.Label>
                                    <Form.Control
                                        name="targeted_keyword"
                                        required
                                        type="text"
                                        placeholder="car insurance, nyc business lawyer,..."
                                    />
                                </Form.Group>

                            </>
                        )}
                        {['write-cold-emails'].includes(pathName) && (
                            <>
                                <Form.Group className="mb-3">
                                    <Form.Label>Tone of voice</Form.Label>
                                    <Form.Select name="tone_of_voice">
                                        <option value="professional">Professional</option>
                                        <option value="childish">Childish</option>
                                        <option value="luxurious">Luxurious</option>
                                        <option value="friendly">Friendly</option>
                                        <option value="confident">Confident</option>
                                        <option value="exciting">Exciting</option>
                                    </Form.Select>
                                </Form.Group>
                                <Row className="mb-3">
                                    <Form.Group as={Col}>
                                        <Form.Label>Sender's Name</Form.Label>
                                        <Form.Control
                                            name="sender_name"
                                            required
                                            type="text"
                                            placeholder="Adriana"
                                        />
                                    </Form.Group>
                                    <Form.Group as={Col}>
                                        <Form.Label>Recipient's Name</Form.Label>
                                        <Form.Control
                                            name="recipient_name"
                                            required
                                            type="text"
                                            placeholder="Elon Musk"
                                        />
                                    </Form.Group>
                                </Row>
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>Sender's Information</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/200</small>
                                    </div>
                                    <Form.Control
                                        name="sender_information"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="e.g. A rising star"
                                        rows="2"
                                        maxLength={200}
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3">
                                    <div className="d-flex align-items-center justify-content-between">
                                        <Form.Label>Recipient's Information</Form.Label>
                                        <small className="text-muted">{textAreaValue.length}/200</small>
                                    </div>
                                    <Form.Control
                                        name="recipient_information"
                                        required
                                        as="textarea"
                                        type="text"
                                        placeholder="e.g. Owner of Amazon, an e-commerce retailer."
                                        rows="2"
                                        maxLength={200}
                                    />
                                </Form.Group>
                            </>
                        )}
                        <div className="d-flex align-items-center justify-content-between">
                            <div className="d-flex align-items-center justify-content-between w-100">
                                <div className="d-flex bg-light rounded tool-variants align-items-center ps-3 pe-1">
                                    <span className="fw-bold tool-variants-number">{variants}</span>
                                    <div className="d-flex flex-column ms-2">
                                        <a
                                            onClick={() => setVariants(variants+1)}
                                            role="button"
                                            className="text-secondary"
                                        >
                                            <Icon icon="ic:baseline-plus" width="20"/>
                                        </a>
                                        <a
                                            onClick={() => setVariants(variants-1)}
                                            role="button"
                                            className="text-secondary"
                                        >
                                            <Icon icon="ic:baseline-minus" width="20"/>
                                        </a>
                                    </div>
                                </div>
                                <Button className="ms-2 btn btn-primary btn-lg flex-grow-1" type="submit" disabled={isRunning}>
                                    {isRunning && (<span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>)}
                                    {!isRunning && (<span>Generate</span>)}
                                </Button>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
            <div className="col-lg-8 col-12 mt-lg-0 mt-3">
                <div className="card bg-transparent overflow-hidden">
                    <div className="ps-3 pe-3 py-2 bg-white d-flex align-items-center justify-content-between">
                        <div>
                            <button
                                onClick={() => setTabIndex(0)}
                                className={`btn btn-sm rounded-pill me-2 ${tabIndex === 0 && 'btn-primary'}`}>New</button>
                            <button
                                onClick={() => setTabIndex(1)}
                                className={`btn btn-sm rounded-pill me-2 ${tabIndex === 1 && 'btn-primary'}`}>Saved</button>
                        </div>
                    </div>
                    <div className="p-3">
                        {tabIndex === 0 && (
                            <>
                                {!!variantsContent.length && (
                                    <div className="d-grid gap-2">
                                        {variantsContent.map((text, index) => (
                                            <div
                                                key={index}
                                                className="card"
                                            >
                                                {(processes.includes(index)) && (
                                                    <div className="position-absolute w-100 h-100 bg-secondary bg-opacity-25 d-flex justify-content-center align-items-center">
                                                        <div className="spinner-border text-primary" role="status">
                                                            <span className="visually-hidden">Loading...</span>
                                                        </div>
                                                    </div>
                                                )}
                                                <div className="mx-3 mt-3" style={{minHeight: 64}}>
                                                    <div
                                                        className="text-result-card"
                                                        dangerouslySetInnerHTML={{__html: text}}
                                                    />
                                                    {(!processes.includes(index)) && (
                                                        <div className="d-flex flex-row-reverse">
                                                            <CopyButton
                                                                text={text}
                                                            />
                                                            <button
                                                                onClick={() => !savedIndexes.includes(index) && saveContent(text, index)}
                                                                className="btn border-0 text-secondary">
                                                                {savedIndexes.includes(index) && (
                                                                    <>
                                                                        <Icon icon="mdi:check-circle" className="text-success" />
                                                                        <small className="ms-1">Saved</small>
                                                                    </>
                                                                )}
                                                                {!savedIndexes.includes(index) && (
                                                                    <>
                                                                        <Icon icon="mdi:content-save-all-outline" />
                                                                        <small className="ms-1">Save</small>
                                                                    </>
                                                                )}
                                                            </button>
                                                        </div>
                                                    )}
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                )}
                                {!variantsContent.length && (
                                    <>
                                        <p className="text-center">Generate results by filling up the form on the left and clicking on "Generate".</p>
                                        <div className="d-flex align-items-center flex-column text-center p-5">
                                            <div className="w-48px rounded d-flex justify-content-center align-items-center" style={{backgroundColor: hexToRgbA(sectionObject.icon_color)}}>
                                                <Icon icon={sectionObject.icon_name} style={{color: sectionObject.icon_color}} width="28" />
                                            </div>
                                            <h3 className="mt-3">{t(sectionObject.title)}</h3>

                                        </div>
                                    </>
                                )}
                            </>
                        )}
                        {tabIndex === 1 && (
                            <div className="d-grid gap-2">
                                {!savedContents.length && (
                                    <p className="text-center m-5">{t('This is where your saved content will appear.')}</p>
                                )}
                                {savedContents.map((item, index) => (
                                    <div
                                        key={index}
                                        className="card"
                                    >
                                        <div className="mx-3 mt-3" style={{minHeight: 64}}>
                                            <div
                                                className="text-result-card"
                                                dangerouslySetInnerHTML={{__html: item.content}}>
                                            </div>
                                            <div className="d-flex flex-row-reverse">
                                                {deletingId === item.id && (
                                                    <button
                                                        onClick={() => deleteContent(item.id, index)}
                                                        className="btn border-0 text-danger">
                                                        <Icon icon="mdi:delete-outline" />
                                                        <small className="ms-1">Delete ?</small>
                                                    </button>
                                                )}
                                                {deletingId !== item.id && (
                                                    <button
                                                        onClick={() => setDeletingId(item.id)}
                                                        className="btn border-0 text-secondary">
                                                        <Icon icon="mdi:delete-outline" />
                                                        <small className="ms-1">Delete</small>
                                                    </button>
                                                )}
                                                <CopyButton
                                                    text={item.content}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    )
}

export default connect(({auth}) => ({auth}))(CommonToolPage);
