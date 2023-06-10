import React, {useCallback, useEffect, useState} from "react";
import {connect} from "react-redux";
import Button from 'react-bootstrap/Button';
import Form from 'react-bootstrap/Form';
import InputGroup from 'react-bootstrap/InputGroup';
import LanguageForm from "../../components/LanguagesForm";
import {Icon} from "@iconify/react";
import {addWindowClass, copyText, textGenerator} from "../../helpers/Utils";
import { debounce } from 'lodash';
import { OverlayTrigger, Popover } from 'react-bootstrap';
import SubmittingButton from "../../components/SubmittingButton";
import API from "../../helpers/Axios";
import {useNavigate, useParams} from "react-router-dom";
import {store} from "../../store/configureStore";
import {useTranslation} from "react-i18next";
import {Base64} from "js-base64";

const ArticleGeneratorPage = () => {
    const generatePDF = () => {
        if(typeof window.jspdf !== "undefined") {
            const elementHTML = `<div style="color: black; font-family: 'Times New Roman',serif">${editor.getData()}<div>`;
            const doc = new window.jspdf.jsPDF;
            doc.setTextColor(0, 0, 0);
            doc.html(elementHTML, {
                callback: function(doc) {
                    doc.save('document.pdf');
                },
                margin: [10, 10, 10, 10],
                autoPaging: 'text',
                x: 0,
                y: 0,
                width: 190,
                windowWidth: 675
            });
        } else {
            alert('Loading library, please wait a bit and try later.');
        }
    }

    const { id } = useParams();
    const { t } = useTranslation();
    const linkTo = useNavigate();
    const [editorLoaded, setEditorLoaded] = useState(false);
    const [editor, setEditor] = useState(null);
    const [stepIndex, setStepIndex] = useState(!isNaN(id) ? 1 : 0);

    const handleEditorLoad = async () => {
        const { default: ClassicEditor } = await import('@ckeditor/ckeditor5-build-classic');
        const newEditor = await ClassicEditor.create(document.querySelector('#editor'));
        setEditor(newEditor);
        newEditor.model.document.on('change:data', () => {
            const data = newEditor.getData();
            setArticle(data);
        });
    }

    useEffect(() => {
        setIsLoading(false);
        if(stepIndex === 1) {
            (async () => {
                setTimeout(async () => {
                    await handleEditorLoad()
                }, 1000)
            })();
        }
    }, [stepIndex])


    const [isCopied, setIsCopied] = useState(false);

    useEffect(() => {
        if(isCopied) {
            setTimeout(() => setIsCopied(false), 5000)
        }
    }, [isCopied])

    useEffect(() => {
        if(editor) {
            if (stepIndex === 1 && id !== undefined) {
                API.post('auth/content/get-by-id', {
                    id: id
                }).then(res => {
                    if (editorInstance) {
                        editorInstance.setData(res.data.content);
                    }
                    setArticle(res.data.content);
                    editor.setData(res.data.content);
                    //addWindowClass('sidebar-hide');
                }).catch(error => {
                    setStepIndex(0);
                    linkTo(`/dashboard/tools/article-composer`);
                    setIsLoading(false);
                });
            }
        }
    }, [editor]);

    const [isLoading, setIsLoading] = useState( !isNaN(id) ? 1 : 0);
    const [isSubmitting, setIsSubmitting] = useState( false);


    const [subHeadings, setSubHeadings] = useState([{value: ''}, {value: ''}, {value: ''}]);

    const [validated, setValidated] = useState(false);
    const [keywords, setKeywords] = useState('');
    const [title, setTitle] = useState('');
    const [isTitleInvalid, setIsTitleInvalid] = useState(false);

    const [isWritingArticle, setIsWritingArticle] = useState(false);
    const [article, setArticle] = useState('');


    const handleSubmit = (event) => {
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            try {
                generateArticle();
                setIsWritingArticle(true);
                setStepIndex(1);
            } catch (e) {
                console.log(e);
            }

        }
        setValidated(true);
        event.preventDefault();
    };

    const [isGeneratingKeywords, setIsGeneratingKeywords] = useState(false);
    const generateKeywords = () => {
        if(!title.length) {
            setIsTitleInvalid(true);
            return;
        }
        setIsGeneratingKeywords(true);
        const data = new FormData();
        data.append('action', Base64.encode(`generate 3 short keywords for subject -> ${title}`));

        textGenerator(data).then(res => {
            setIsGeneratingKeywords(false);
            let array = res.data.text.split("\n").map(item => {
                let parts = item.split(".");
                return parts.length > 1 ? parts[1].trim() : parts[0].trim();
            }).filter(item => item.length > 0);
            setKeywords(array.join(', '))
        });
    }

    const [isGeneratingSubheadings, setIsGeneratingSubheadings] = useState(false);
    const generateSubheadings = () => {
        if(!title.length) {
            setIsTitleInvalid(true);
            return;
        }
        setIsGeneratingSubheadings(true);
        const data = new FormData();
        data.append('action', Base64.encode(`Generate ${subHeadings.length} subheadings for subject -> ${title}`));
        textGenerator(data).then(res => {
            setIsGeneratingSubheadings(false);
            let lines = res.data.text.split("\n");
            let array = [];
            lines.forEach(function(line, index) {
                let parts = line.split(". ");
                if (parts.length > 1) {
                    let object = {
                        value: parts[1].trim()
                    };
                    array.push(object);
                }
            });
            if(array.length === subHeadings.length) {
                setSubHeadings(array);
            }
        });
    }

    const [topKeywords, setTopKeywords] = useState([]);
    const [editorInstance, setEditorInstance] = useState(null);

    const countKeywords = useCallback(
        debounce(() => {
            const editorContent = editorInstance.getData().replace(/(<([^>]+)>)/gi, "");
            const commonWords = ['nbsp', 'these', 'should', 'a', 'an', 'and', 'as', 'at', 'be', 'by', 'for', 'from', 'has', 'have', 'in', 'is', 'it', 'of', 'on', 'that', 'the', 'there', 'this', 'to', 'was', 'were', 'with', 'which', 'who', 'whom', 'whose', 'you', 'your', 'yours', 'i', 'me', 'my', 'mine', 'we', 'us', 'our', 'ours', 'he', 'him', 'his', 'she', 'her', 'hers', 'they', 'them', 'their', 'theirs', 'its', 'since', 'some', 'such'];
            let words = editorContent.toLowerCase().match(/\b\w+\b/g).filter(word => word.length > 3 && !commonWords.includes(word));
            const wordCount = {};
            let totalWords = 0;
            words.forEach((word) => {
                totalWords++;
                if (word in wordCount) {
                    wordCount[word]++;
                } else {
                    wordCount[word] = 1;
                }
            });
            const topKeywords = Object.entries(wordCount)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 10)
                .map(([word, count]) => [word, count, (count / totalWords) * 100]);

            setTopKeywords(topKeywords);
        }, 500),
        []
    );

    const [score, setScore] = useState(null);


    const handleEditorChange = useCallback((event, editor) => {
        //countKeywords();
        //countScore();
    }, [countKeywords]);

    const generateArticle = () => {
        setProcesses(Array.from({length: subHeadings.length}, (_, i) => i));
        runProcess(Array.from({length: subHeadings.length}, (_, i) => i), subHeadings);
    }


    function countSyllables(word) {
        const vowels = 'aeiouy';
        let syllables = 0;
        let prevLetterWasVowel = false;

        word = word.toLowerCase().replace(/[^a-z]/g, '');

        for (let i = 0; i < word.length; i++) {
            const letter = word[i];
            const isVowel = vowels.indexOf(letter) !== -1;

            if (isVowel && !prevLetterWasVowel) {
                syllables++;
            }

            prevLetterWasVowel = isVowel;
        }

        if (word.slice(-1) === 'e') {
            syllables--;
        }

        return syllables || 1;
    }
    function isPassiveVoice(sentence) {
        const passiveVoiceRegex = /(?:\b(?:am|are|were|is|been|being|be)\b\s+)(.+)\b(by\s+.+)\b/gi;
        return passiveVoiceRegex.test(sentence);
    }
    const rateArticle = debounce((article, setScore, setResults) => {
        if (!article) {
            setScore(null);
            setResults([]);
            return;
        }

        const editorContent = article.replace(/(<([^>]+)>)/gi, "");
        const commonWords = ['nbsp', 'these', 'should', 'a', 'an', 'and', 'as', 'at', 'be', 'by', 'for', 'from', 'has', 'have', 'in', 'is', 'it', 'of', 'on', 'that', 'the', 'there', 'this', 'to', 'was', 'were', 'with', 'which', 'who', 'whom', 'whose', 'you', 'your', 'yours', 'i', 'me', 'my', 'mine', 'we', 'us', 'our', 'ours', 'he', 'him', 'his', 'she', 'her', 'hers', 'they', 'them', 'their', 'theirs', 'its', 'since', 'some', 'such'];
        let words = editorContent.toLowerCase().match(/\b\w+\b/g).filter(word => word.length > 3 && !commonWords.includes(word));
        const wordForKeyWordCount = {};
        let totalWords = 0;
        words.forEach((word) => {
            totalWords++;
            if (word in wordForKeyWordCount) {
                wordForKeyWordCount[word]++;
            } else {
                wordForKeyWordCount[word] = 1;
            }
        });
        const topKeywords = Object.entries(wordForKeyWordCount)
            .sort((a, b) => b[1] - a[1])
            .slice(0, 10)
            .map(([word, count]) => [word, count, (count / totalWords) * 100]);

        setTopKeywords(topKeywords);



        const results = [];

        // Count the number of <h1>, <h2>, and <p> tags in the article
        const articleElement = document.createElement('article');
        articleElement.innerHTML = article;
        const headingCount = articleElement.querySelectorAll('h1, h2').length;
        const paragraphCount = articleElement.querySelectorAll('p').length;

        // Calculate the score based on the number of headings and paragraphs
        let score = 0;
        if (headingCount > 0) {
            score += 50;
        }
        if (paragraphCount > 0) {
            score += 50;
        }

        // Check for subheadings
        const subheadings = articleElement.querySelectorAll('h3, h4, h5, h6');
        if (subheadings.length === 0) {
            results.push({
                message: 'The text does not contain any subheadings. Add at least one subheading.',
                type: 'bad'
            });
        }

        // Check Flesch Reading Ease
        const sentences = articleElement.innerText.split(/[.?!]/g).filter(Boolean);
        const wordCount = articleElement.innerText.trim().split(/\s+/g).length;
        const syllableCount = articleElement.innerText.trim().split(/\s+/g).reduce((count, word) => count + countSyllables(word), 0);
        const fleschScore = 206.835 - 1.015 * (wordCount / sentences.length) - 84.6 * (syllableCount / wordCount);
        if (fleschScore < 60) {
            results.push({
                message: 'The copy is considered difficult to read. Try to make shorter sentences, using less difficult words to improve readability.',
                type: 'bad'
            });
        }

        // Check for long paragraphs
        const maxParagraphLength = 150;
        articleElement.querySelectorAll('p').forEach((paragraph) => {
            const paragraphWords = paragraph.innerText.trim().split(/\s+/g).length;
            if (paragraphWords > maxParagraphLength) {
                results.push({
                    message: `One of the paragraphs contains more than the recommended maximum of ${maxParagraphLength} words. Are you sure all information is about the same topic, and therefore belongs in one single paragraph?`,
                    type: 'bad'
                });
            }
        });

        const maxSentenceLength = 20;
        const transitionWords = ['additionally', 'also', 'besides', 'furthermore', 'likewise', 'moreover', 'similarly'];
        let longSentenceCount = 0;
        let transitionWordCount = 0;
        sentences.forEach((sentence) => {
            const words = sentence.trim().split(/\s+/g);
            if (words.length > maxSentenceLength) {
                longSentenceCount++;
            }
            transitionWords.forEach((transitionWord) => {
                if (sentence.toLowerCase().includes(transitionWord)) {
                    transitionWordCount++;
                }
            });
        });
        const longSentencePercentage = (longSentenceCount / sentences.length) * 100;
        if (longSentencePercentage > 25) {
            results.push({
                message: `${Math.round(longSentencePercentage)}% of the sentences contain more than ${maxSentenceLength} words, which is more than the recommended maximum of 25%. Try to shorten the sentences.`,
                type: 'bad'
            });
        } else {
            results.push({
                message: `${Math.round(transitionWordCount / sentences.length * 100)}% of the sentences contain a transition word or phrase, which is great.`,
                type: 'good'
            });
        }
        const passiveVoiceThreshold = 10;
        let passiveVoiceCount = 0;
        sentences.forEach((sentence) => {
            if (isPassiveVoice(sentence)) {
                passiveVoiceCount++;
            }
        });
        const passiveVoicePercentage = (passiveVoiceCount / sentences.length) * 100;
        if (passiveVoicePercentage > passiveVoiceThreshold) {
            results.push({
                message: `The text contains passive voice in ${passiveVoicePercentage.toFixed(1)}% of the sentences, which is more than the recommended maximum of ${passiveVoiceThreshold}%. Try to use their active counterparts.`,
                type: 'bad'
            });
        }
        // Check for transition words
        const transitionWordThreshold = 30;
        let transitionWordCount2 = 0;
        sentences.forEach((sentence) => {
            const words = sentence.trim().split(/\s+/g);
            transitionWords.forEach((transitionWord) => {
                if (words.includes(transitionWord)) {
                    transitionWordCount2++;
                }
            });
        });
        const transitionWordPercentage = (transitionWordCount2 / sentences.length) * 100;
        if (transitionWordPercentage > transitionWordThreshold) {
            results.push({
                message: `The text contains transition words in ${transitionWordPercentage.toFixed(1)}% of the sentences, which is great!`,
                type: 'good'
            });
        }
        setScore(score);
        setResults(results);
    }, 500);

    const [results, setResults] = useState([]);

    const popover = (
        <Popover id="popover-basic">
            <Popover.Header as="h3">SEO Score</Popover.Header>
            <Popover.Body>
                <ul className="list-unstyled mb-0">
                    {results.map((result, index) => (
                        <li key={index} className="mb-2">
                            <span>
                                <Icon icon="material-symbols:circle" className={result.type === 'bad' ? 'text-warning' : 'text-success'}/>
                            </span>
                            <span className="ms-1">{result.message}</span>
                        </li>
                    ))}
                </ul>
            </Popover.Body>
        </Popover>
    );

    const [processes, setProcesses] = useState([]);
    const [isRunning, setIsRunning] = useState(false);
    const [currentWritingByIndex, setCurrentWritingByIndex] = useState(0);

    const [contentsFromSubheading, setContentsFromSubheading] = useState([]);

    const runProcess = async (processes, data) => {
        if (processes.length === 0) {
            setIsRunning(false);
            return;
        }

        setIsRunning(true);
        const currentProcess = processes[0];
        setCurrentWritingByIndex(currentProcess);
        try {
            console.log(`Running process: ${currentProcess}`);

            await new Promise(resolve => {
                API.post('auth/user/text-generator', {
                    action: Base64.encode(`write content for subheading -> ${subHeadings[currentProcess].value} --> of subject --> ${title}`)
                }).then((res) => {
                    //setContentsFromSubheading([...contentsFromSubheading, res.data.text.replace(/^\s+|\s+$/g, '')]);
                    setContentsFromSubheading(prevState => [...prevState, res.data.text.replace(/^\s+|\s+$/g, '')]);

                    if(res.data && res.data.usage) {
                        setTimeout(() => {
                            store.dispatch({type: 'UPDATE_TOKENS', tokens: store.getState().common.tokens - res.data.usage});
                        }, 5000)
                    }
                    resolve(true);
                }).catch (error => {
                    //setContentsFromSubheading([...contentsFromSubheading, '']);
                    setContentsFromSubheading(prevState => [...prevState, '']);
                    resolve(true);

                });
            });
        } catch (error) {
            console.error(`Error running process: ${currentProcess}`);
        }
        setProcesses(processes.slice(1));
        await runProcess(processes.slice(1), data);
    };

    useEffect(() => {
        rateArticle(article, setScore, setResults);
        setEditorLoaded(true);
    }, [article]);

    useEffect(() => {
        if(!processes.length && contentsFromSubheading.length) {
            setTimeout(() => {
                console.log(contentsFromSubheading);
                let contentHTML = `<h2>${title}</h2>`;
                contentHTML += subHeadings.map((item, index) => {
                    const paragraphs = contentsFromSubheading[index].split("\n").map(paragraph => `<p>${paragraph}</p>`).join('');
                    return `
                    <h3>${item.value}</h3>
                    ${paragraphs}
                  `;
                }).join('');
                if (editorInstance) {
                    editorInstance.setData(contentHTML);
                }
                setArticle(contentHTML);
                editor.setData(contentHTML);
            }, 500)
        }
    }, [processes.length])

    return isLoading ? (<div style={{flex: 1, justifyContent: 'center', alignItems: 'center'}} >Loading...</div>) : (
        <>
            {stepIndex === 0 && (
                <div className="container px-lg-3 px-0">
                    <div className="text-center">
                        <h1>{t('Generate Articles With AI')}</h1>
                        <p className="mb-5">{t('Turn a title and outline into a long and engaging article.')}</p>
                    </div>
                    <div className="card p-4">
                        <Form noValidate validated={validated} onSubmit={handleSubmit} method="post">
                            <Form.Group className="mb-3">
                                <Form.Label>Language</Form.Label>
                                <LanguageForm/>
                            </Form.Group>
                            <Form.Group className="mb-3">
                                <Form.Label>Article title</Form.Label>
                                <Form.Control
                                    name="title"
                                    required
                                    type="text"
                                    placeholder="Gold Price Predictions Next 5 Years"
                                    value={title}
                                    onChange={e => {
                                        setTitle(e.target.value);
                                        setIsTitleInvalid(false)
                                    }}
                                    isInvalid={isTitleInvalid}
                                />
                            </Form.Group>
                            <Form.Group className="mb-3">
                                <div className="d-flex align-items-center justify-content-between mb-1">
                                    <Form.Label>Focus Keywords <small className="text-muted">(minimum 3)</small></Form.Label>
                                    <button
                                        disabled={isGeneratingKeywords}
                                        onClick={generateKeywords}
                                        className="btn btn-sm btn-outline-secondary" type="button">
                                        <Icon icon="mingcute:lightning-line" />
                                        <small className="ms-1">Generate</small>
                                        {isGeneratingKeywords && (
                                            <div className="spinner-border spinner-border-sm ms-2" role="status">
                                                <span className="visually-hidden">Loading...</span>
                                            </div>
                                        )}
                                    </button>
                                </div>
                                <Form.Control
                                    name="keyword"
                                    required
                                    type="text"
                                    placeholder="Add keyword, e.g. economy, gold price"
                                    value={keywords}
                                    onChange={e => {
                                        setKeywords(e.target.value);
                                    }}
                                />
                            </Form.Group>
                            <Form.Group className="mb-3">
                                <div className="d-flex align-items-center justify-content-between mb-1">
                                    <Form.Label>Article subheadings <small className="text-muted">(minimum 3)</small></Form.Label>
                                    <button
                                        disabled={isGeneratingSubheadings}
                                        onClick={generateSubheadings}
                                        className="btn btn-sm btn-outline-secondary" type="button">
                                        <Icon icon="mingcute:lightning-line" />
                                        <small className="ms-1">Generate</small>
                                        {isGeneratingSubheadings && (
                                            <div className="spinner-border spinner-border-sm ms-2" role="status">
                                                <span className="visually-hidden">Loading...</span>
                                            </div>
                                        )}
                                    </button>
                                </div>
                                {subHeadings.map((item, index) => (
                                    <InputGroup key={index}  className="mb-3">
                                        <Form.Control
                                            type="text"
                                            placeholder="Subheading"
                                            name="subheading[]"
                                            required
                                            value={item.value}
                                            onChange={e => {
                                                setSubHeadings(prev => {
                                                    const newSubHeadings = [...prev];
                                                    newSubHeadings[index].value = e.target.value;
                                                    return newSubHeadings;
                                                });
                                            }}
                                        />
                                        {index === (subHeadings.length - 1) && (
                                            <button
                                                onClick={() => {
                                                    setSubHeadings([...subHeadings, {value: ''}]);
                                                }}
                                                className="btn btn-outline-secondary" type="button">
                                                <Icon icon="ic:baseline-plus" width="24"/>
                                            </button>
                                        )}
                                        {subHeadings.length > 3 && (
                                            <button
                                                onClick={() => {
                                                    setSubHeadings((prevItems) => [
                                                        ...prevItems.slice(0, index),
                                                        ...prevItems.slice(index + 1)
                                                    ]);
                                                }}
                                                className="btn btn-outline-secondary" type="button">
                                                <Icon icon="ic:baseline-minus" width="24"/>
                                            </button>
                                        )}
                                    </InputGroup>
                                ))}
                            </Form.Group>
                            <div className="d-flex align-items-center justify-content-center mt-4">
                                <Button className="btn-block" type="submit">Write my article</Button>
                            </div>
                        </Form>
                    </div>
                </div>
            )}
            {stepIndex === 1 && (
                <div className="w-100 card">
                    {!!processes.length && (
                        <div style={{zIndex: 5}} className="position-absolute w-100 h-100 bg-secondary bg-opacity-75 d-flex flex-column justify-content-center align-items-center">
                            <p className="fs-5">Writing content for the subheading</p>
                            <p className="fs-3">"{subHeadings[currentWritingByIndex].value}"</p>
                            <div className="spinner-border text-primary" role="status">
                                <span className="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    )}
                    <div className="d-flex flex-lg-row flex-column justify-content-between bg-white m-3">
                        <div className="w-100">
                            <div className="h-100">
                                <div>
                                    {!editorLoaded && <div>Loading editor...</div>}
                                    <div
                                        id="editor"
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="article-editor-sidebar flex-grow-1">
                            <div className="h-100">
                                <div className="p-3">
                                    <SubmittingButton
                                        onClick={() => {
                                            setIsSubmitting(true);
                                            API.post('auth/content/save', {
                                                id: id || null,
                                                type: 'article-composer',
                                                content: article
                                            }).then(res => {
                                                setIsSubmitting(false);
                                                const lastSegment = window.location.href.split('/').pop().trim();
                                                if (!/^\d+$/.test(lastSegment)) {
                                                    window.history.pushState(null, '', window.location.href + '/' + res.data.id);
                                                }
                                            }).catch (error => {
                                                setIsSubmitting(false);
                                            });
                                        }}
                                        isSubmitting={isSubmitting}
                                    />
                                    <button
                                        onClick={() => {
                                            copyText(article);
                                            setIsCopied(true);
                                        }}
                                        className="btn btn-outline-secondary mt-3 w-100">
                                        {isCopied && (
                                            <>
                                                <Icon icon="mdi:check-circle" className="text-success" />
                                                <small className="ms-1">{t('Copied')}</small>
                                            </>
                                        )}
                                        {!isCopied && (
                                            <>
                                                <Icon icon="mdi:content-copy" />
                                                <small className="ms-1">{t('Copy content')}</small>
                                            </>
                                        )}
                                    </button>
                                    <button
                                        onClick={generatePDF}
                                        className="btn btn-outline-secondary mt-3 w-100"
                                    >
                                        <Icon icon="grommet-icons:document-pdf" />
                                        <small className="ms-1">{t('Download PDF')}</small>
                                    </button>
                                </div>
                                <hr/>
                                <div className="p-3 d-flex align-items-center">
                                   <span className="fw-bold">SEO score</span>
                                    <OverlayTrigger
                                        trigger={['hover', 'focus']}
                                        placement="bottom"
                                        overlay={popover}
                                    >
                                        <Button className="ms-4">
                                            <span className="fw-bold">{score}</span>
                                        </Button>
                                    </OverlayTrigger>
                                </div>
                                <hr/>
                                <div className="row">
                                    <div className="col-6">
                                        <div className="d-flex flex-column text-center">
                                            <small className="fw-bold text-secondary">Words</small>
                                            <small className="fw-bold">{article.replace(/(<([^>]+)>)/gi, "").split(" ").length}</small>
                                        </div>
                                    </div>
                                    <div className="col-6">
                                        <div className="d-flex flex-column text-center">
                                            <small className="fw-bold text-secondary">Headings</small>
                                            <small className="fw-bold">{(article.match(/<h[1-6][^>]*>/g) || []).length}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div className="row">
                                    <div className="col-6">
                                        <div className="d-flex flex-column text-center">
                                            <small className="fw-bold text-secondary">Paragraph</small>
                                            <small className="fw-bold">{(article.match(/<p\b[^>]*>/gi) || []).length}</small>
                                        </div>
                                    </div>
                                    <div className="col-6">
                                        <div className="d-flex flex-column text-center">
                                            <small className="fw-bold text-secondary">Links</small>
                                            <small className="fw-bold">{(article.match(/<a\s+(?:[^>]*?\s+)?href=(["'])(.*?)\1/g) || []).length}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div className="row">
                                    <div className="col-6">
                                        <div className="d-flex flex-column text-center">
                                            <small className="fw-bold text-secondary">Characters</small>
                                            <small className="fw-bold">{article.length}</small>
                                        </div>
                                    </div>
                                    <div className="col-6">
                                        <div className="d-flex flex-column text-center">
                                            <small className="fw-bold text-secondary">Sentences</small>
                                            <small className="fw-bold">{(article.match(/(\s|^)[A-Z][^?!.]*[.?!]/g) || []).length}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <ul className="list-unstyled px-3">
                                    <small className="fw-bold text-secondary">Top Keywords</small>
                                    {topKeywords.map(([word, count, percentage]) => (
                                        <li key={word} className="d-flex align-items-center justify-content-between border-bottom py-2">
                                            <small className="text-secondary flex-grow-1">{word}</small>
                                            <small className="text-secondary mx-4">{count}</small>
                                            <small className="text-secondary">{percentage.toFixed(0)}%</small>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    )
}

export default connect(({auth}) => ({auth}))(ArticleGeneratorPage);
