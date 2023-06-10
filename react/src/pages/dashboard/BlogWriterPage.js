import React, {useState} from "react";
import {connect} from "react-redux";
import ToolCard from "../../components/ToolCard";
import Button from 'react-bootstrap/Button';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';
import InputGroup from 'react-bootstrap/InputGroup';
import Row from 'react-bootstrap/Row';

const BlogWriterPage = () => {
    const [subHeadings, setSubHeadings] = useState([{},{},{}]);
    const [activeTabIndex, setActiveTabIndex] = useState(0);

    const [validated, setValidated] = useState(false);
    const handleSubmit = (event) => {
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }

        setValidated(true);
    };

    const [title, setTitle] = useState('');
    const [isTitleForm, setIsTitleForm] = useState(false);
    const [description, setDescription] = useState('');


    return (
        <div className="container">
            <div className="text-center">
                <h1>Write quality blog posts with AI</h1>
                <p className="mb-5">Go from a blog idea to an engaging blog post in minutes by following the steps below.</p>
            </div>
            <div className="m-auto" style={{maxWidth: 780}}>
                <div className="card overflow-hidden">
                    <ul className="nav nav-tabs nav-fill">
                        {[
                            {
                                title: 'Details'
                            },
                            {
                                title: 'Title'
                            },
                            {
                                title: 'Intro'
                            },
                            {
                                title: 'Outline'
                            },
                            {
                                title: 'Content'
                            }
                        ].map((item, index) => (
                            <li
                                key={index}
                                className="nav-item"
                            >
                                <button
                                    className={activeTabIndex === index ? "nav-link active" : "nav-link"}
                                    aria-current="page"
                                    onClick={() => setActiveTabIndex(index)}
                                >
                                    <div className="d-flex align-items-center">
                                        <span className="badge rounded-pill bg-secondary me-2">{index+1}</span>
                                        <span>{item.title}</span>
                                    </div>
                                </button>
                            </li>
                        ))}
                    </ul>
                    <div className="p-4">
                        <Form noValidate validated={validated} onSubmit={handleSubmit}>
                            {activeTabIndex === 0 && (
                                <>
                                    <Row className="mb-3">
                                        <Form.Group as={Col}>
                                            <Form.Label>Language</Form.Label>
                                            <Form.Select>
                                                <option value="1">English</option>
                                                <option value="2">France</option>
                                                <option value="3">Vietnamese</option>
                                            </Form.Select>
                                        </Form.Group>
                                        <Form.Group as={Col}>
                                            <Form.Label>Creativity</Form.Label>
                                            <Form.Select>
                                                <option value="high">High</option>
                                                <option value="regular">Regular</option>
                                            </Form.Select>
                                        </Form.Group>
                                    </Row>
                                    <Form.Group className="mb-3">
                                        <div className="d-flex align-items-center justify-content-between">
                                            <Form.Label>What do you want to write about?</Form.Label>
                                            <small className="text-muted">{description.length}/200</small>
                                        </div>
                                        <Form.Group>
                                            <Form.Control
                                                required
                                                as="textarea"
                                                placeholder="Explain what is your blog post about (min. 40 characters). A blog article explaining how copywriting can drive more traffic to your website."
                                                rows="4"
                                                maxLength={200}
                                                value={description}
                                                onChange={(e) => {
                                                    setDescription(e.currentTarget.value)
                                                }}
                                            />
                                        </Form.Group>
                                        {description.length < 40 && (
                                            <small className="text-danger">{40 - description.length} more characters needed in your description.</small>
                                        )}
                                    </Form.Group>
                                    <Form.Group className="mb-3">
                                        <Form.Label>Focus Keywords <small className="text-muted">(separated with a comma)</small></Form.Label>
                                        <Form.Control
                                            required
                                            type="text"
                                            placeholder="The 25 Best Places to Live in the US in 2022"
                                            defaultValue=""
                                        />
                                    </Form.Group>
                                    <Form.Group className="mb-3">
                                        <Form.Label>Targeted Keyword (optional)</Form.Label>
                                        <Form.Control
                                            type="text"
                                            placeholder="ai copywriting"
                                            defaultValue=""
                                        />
                                    </Form.Group>
                                    <div className="d-grid w-100 mt-5">
                                        <button className="btn btn-lg btn-primary">Next</button>
                                    </div>
                                </>
                            )}
                            {activeTabIndex === 1 && (
                                <>
                                    <p className="fw-bold">Generate a post title or write your own</p>
                                    <p className="text-secondary">Let's generate or write a title for your blog post. The description you previously filled and the title you choose will have an influence on the generated content</p>
                                    <div className="d-flex justify-content-between mt-5 gap-3">
                                        <button
                                            type="button"
                                            className="btn btn-primary w-100"
                                        >Generate titles</button>
                                        <button
                                            onClick={() => setIsTitleForm(true)}
                                            className="btn btn-outline-secondary w-100"
                                            type="button"
                                        >I'll write my own</button>
                                    </div>
                                    <hr/>
                                    {isTitleForm && (
                                        <Form.Group>
                                            <Form.Control
                                                type="text"
                                                placeholder="Blog title"
                                                value={title}
                                                maxLength={180}
                                                onChange={(e) => setTitle(e.currentTarget.value)}
                                            />
                                        </Form.Group>
                                    )}
                                    {!isTitleForm && (
                                        <>
                                            {[
                                                {
                                                    title: 'Bitcoin Price Surge Sparks Market FOMO Among Small BC Addresses'
                                                },
                                                {
                                                    title: 'Small BTC Addresses Are Feeling the FOMO of Bitcoin\'s Price Surge'
                                                }
                                            ].map((item, index) => (
                                                <div
                                                    key={index}
                                                    className="card p-3 mb-3"
                                                >
                                                    <div className="d-flex justify-content-between">
                                                        <p className="fw-bold mb-0">{item.title}</p>
                                                        <a className="btn btn-outline-secondary align-self-start">Select</a>
                                                    </div>
                                                </div>
                                            ))}
                                        </>
                                    )}
                                </>
                            )}
                            {activeTabIndex === 2 && (
                                <>
                                    <p className="fw-bold">Generate an intro paragraph or write your own</p>
                                    <p className="text-secondary">Let's now write your blog introduction which will be the beginning of an amazing blog post. You will be able to edit it afterwards.</p>
                                    <div className="d-flex justify-content-between mt-5 gap-3">
                                        <button
                                            type="button"
                                            className="btn btn-primary w-100"
                                        >Generate intros</button>
                                        <button
                                            onClick={() => setIsTitleForm(true)}
                                            className="btn btn-outline-secondary w-100"
                                            type="button"
                                        >I'll write my own</button>
                                    </div>
                                    <div className="mt-5">
                                        {[
                                            {
                                                title: 'Have you ever felt a sudden rush of fear\n' +
                                                    'that you\'re missing out on something?\n' +
                                                    'That\'s what many cryptocurrency\n' +
                                                    'investors have been feeling lately, as\n' +
                                                    'Bitcoin prices skyrocketed over\n' +
                                                    '$20,000. As a result of this FOMO (fear\n' +
                                                    'of missing out), we\'ve seen an increase in\n' +
                                                    'the number of small Bitcoin holders. In\n' +
                                                    'this article, we\'ll explore the data behind\n' +
                                                    'this trend and discuss what it means for\n' +
                                                    'the crypto industry.'
                                            },
                                            {
                                                title: 'Small BTC Addresses Are Feeling the FOMO of Bitcoin\'s Price Surge'
                                            }
                                        ].map((item, index) => (
                                            <div
                                                key={index}
                                                className="card p-3 mb-3"
                                            >
                                                <div className="d-flex justify-content-between">
                                                    <p className="fw-bold mb-0">{item.title}</p>
                                                    <a className="btn btn-outline-secondary align-self-start">Select</a>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </>
                            )}
                            {activeTabIndex === 3 && (
                                <>
                                    <p className="fw-bold">Generate an outline (subheadings) for your post</p>
                                    <p className="text-secondary">Let's now write your blog outline which will be the structure of your article. You will be able to edit it afterwards.</p>
                                    <div className="d-flex justify-content-between mt-5 gap-3">
                                        <button
                                            type="button"
                                            className="btn btn-primary w-100"
                                        >Generate outlines</button>
                                        <button
                                            onClick={() => setIsTitleForm(true)}
                                            className="btn btn-outline-secondary w-100"
                                            type="button"
                                        >I'll write my own</button>
                                    </div>
                                    <div className="mt-5">
                                        {[
                                            {
                                                outline: 'Introduction to the Bitcoin Market\n' +
                                                    'What is FOMO?\n' +
                                                    'How did BTC prices surge and cause FOMO?\n' +
                                                    'Impact of the FOMO on Small BTC Addresses\n' +
                                                    'Impact on the Overall Crypto Market\n' +
                                                    'Strategies to Avoid and Minimize FOMO\n' +
                                                    'Conclusion'
                                            }
                                        ].map((item, index) => (
                                            <div
                                                key={index}
                                                className="card p-3 mb-3"
                                            >
                                                <div className="d-flex justify-content-between">
                                                   <div>
                                                       {item.outline.split("\n").map((line, lineIndex) => (
                                                           <p key={lineIndex} className="fw-bold mb-0">- {line}</p>
                                                       ))}
                                                   </div>
                                                    <a className="btn btn-outline-secondary align-self-start">Select</a>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </>
                            )}
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default connect(({auth}) => ({auth}))(BlogWriterPage);
