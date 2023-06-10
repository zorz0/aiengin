import React, {useRef, useState} from "react";
import {connect} from "react-redux";
import Form from 'react-bootstrap/Form';
import LanguageForm from "../../components/LanguagesForm";
import { Icon } from '@iconify/react';
import TextAreaFitContent from "../../components/TextAreaFitContent";
import API from "../../helpers/Axios";
import {store} from "../../store/configureStore";
import Button from "react-bootstrap/Button";
import {useTranslation} from "react-i18next";
import { Base64 } from 'js-base64';

const ContentReframerPage = () => {
    const { t } = useTranslation();
    const defaultContentObject = {
        text: '',
        rewritten: '',
        isRewriting: false
    };
    const [stepIndex, setStepIndex] = useState(0);
    const [inputString, setInputString] = useState('');
    const [generatedWords, setGeneratedWords] = useState(0);

    const [validated, setValidated] = useState(false);
    const handleSubmit = (event) => {
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            const paragraphs = makeParagraphs(inputString, 100);
            let array = [];
            paragraphs.forEach((row, index) => {
                let object = {
                    text: row,
                    rewritten: '',
                    isRewriting: true
                }
                array.push(object);
            });
            setContents(prev => ([...array]));
            setStepIndex(1);
            setTimeout(() => {
                setProcesses(Array.from({length: array.length}, (_, i) => i));
                runProcess(Array.from({length: array.length}, (_, i) => i), array);
            }, 1000);
        }
        setValidated(true);
    };

    const [contents, setContents] = useState([defaultContentObject]);

    const addMoreContent = () => {
        setContents(prev => ([...contents, {text: '', rewritten: '', isRewriting: false}]));
    }

    const makeParagraphs = (content, limit = 50) => {
        content = content.replace(/\n{2,}/g, "\n").trim();
        if (content.endsWith("\n")) {
            content = content.slice(0, -1);
        }

        const paragraphs = content.split("\n");
        const limitedParagraphs = [];

        for (const paragraph of paragraphs) {
            const words = paragraph.split(" ");
            let limitedParagraph = "";
            let wordCount = 0;
            let lastFullStopIndex = -1;

            for (let i = 0; i < words.length; i++) {
                const word = words[i];

                if (word.endsWith(".")) {
                    lastFullStopIndex = i;
                }

                if (wordCount + 1 <= limit) {
                    limitedParagraph += `${word} `;
                    wordCount += 1;
                } else {
                    if (lastFullStopIndex !== -1 && lastFullStopIndex < i) {
                        i = lastFullStopIndex;
                    }
                    limitedParagraphs.push(`${(limitedParagraph).trim()}`);
                    limitedParagraph = "";
                    wordCount = 0;
                    lastFullStopIndex = -1;
                }
            }

            if (limitedParagraph) {
                limitedParagraphs.push(`${(limitedParagraph).trim()}`);
            }
        }

        return limitedParagraphs;
    }

    const [processes, setProcesses] = useState([]);
    const [isRunning, setIsRunning] = useState(false);

    const runProcess = async (processes, contents) => {
        console.log('processes', processes);
        if (processes.length === 0) {
            setIsRunning(false);
            return;
        }

        setIsRunning(true);
        const currentProcess = processes[0];
        try {
            console.log(`Running process: ${currentProcess}`);
            await new Promise(resolve => {
                API.post('auth/user/text-generator', {
                    action: Base64.encode(`rewrite paragraph -> ${contents[currentProcess].text}`)
                }).then((res) => {
                    if(res.data && res.data.usage) {
                        store.dispatch({type: 'UPDATE_TOKENS', tokens: store.getState().common.tokens - res.data.usage});
                    }
                    setContents(prevContents => {
                        const newContents = [...prevContents];
                        newContents[currentProcess].text = prevContents[currentProcess].text;
                        newContents[currentProcess].rewritten = res.data.text.toString().replace(/\n{2,}/g, "\n").trim();
                        newContents[currentProcess].isRewriting = false;
                        const newWordCount = generatedWords + res.data.text.toString().trim().split(/\s+/).length;
                        setGeneratedWords(newWordCount);
                        return newContents;
                    });
                    resolve(true);
                }).catch (error => {
                    resolve(true);
                    setContents(prevContents => {
                        const newContents = [...prevContents];
                        newContents[currentProcess].text = prevContents[currentProcess].text;
                        newContents[currentProcess].rewritten = prevContents[currentProcess].rewritten;
                        newContents[currentProcess].isRewriting = false;
                        return newContents;
                    });
                });
            });
        } catch (error) {
            console.error(currentProcess, error);
        }
        setProcesses(processes.slice(1));
        await runProcess(processes.slice(1), contents);
    };

    return (
        <>

            {stepIndex === 0 && (
                <div className="container px-lg-3 px-0" style={{maxWidth: 600}}>
                    <div className="text-center">
                        <h1>Rewrite content with AI</h1>
                        <p className="mb-0">The most intelligent solution for rephrasing articles or any written material.</p>
                        <p className="mb-5">The material is divided into various segments that can be revised independently.</p>
                    </div>
                    <div className="card p-4">
                        <Form noValidate validated={validated} onSubmit={handleSubmit}>
                            <Form.Group className="mb-3">
                                <Form.Label>Language</Form.Label>
                                <LanguageForm/>
                            </Form.Group>
                            <Form.Group className="mb-3">
                                <Form.Label>What would you like to rewrite?</Form.Label>
                                <TextAreaFitContent
                                    placeholder={t('Paste the content of the article that you want to rewrite')}
                                    value={inputString}
                                    setValue={(e) => {
                                        setInputString(e.target.value)
                                    }}
                                    rows="15"
                                />
                            </Form.Group>
                            <div className="d-flex align-items-center justify-content-center mt-4">
                                <Button className="btn btn-primary" type="submit">Rewrite</Button>
                            </div>
                        </Form>
                    </div>
                </div>
            )}
            {stepIndex === 1 && (
                <div className="w-100">
                    <div className="d-flex align-items-center justify-content-between bg-white p-3 rounded">
                        <div className="d-flex align-items-center">
                            <button
                                onClick={() => {
                                    setStepIndex(0);
                                    setContents([defaultContentObject]);
                                }}
                                className="btn btn-outline-secondary">
                                <Icon icon="ic:outline-arrow-back" />
                            </button>
                        </div>
                        <div className="d-flex align-items-center gap-2">
                            <div className="d-flex align-items-center gap-4">
                                {[
                                    {
                                        title: 'words',
                                        content: generatedWords
                                    },
                                ].map((item, index) => (
                                    <div
                                        key={index}
                                        className="d-flex flex-column"
                                    >
                                        <span className="fw-bold">{item.content}</span>
                                        <small className="text-secondary">{item.title}</small>
                                    </div>
                                ))}
                            </div>
                            <div className="vr ms-3 me-3"></div>
                            <button
                                onClick={() => {
                                    navigator.clipboard.writeText(contents.map((item) => item.rewritten).join("\n"));
                                }}
                                className="btn btn-outline-secondary d-flex align-items-center">
                                <Icon icon="mdi:content-copy" />
                                <span className="ms-2">Copy</span>
                            </button>
                        </div>
                    </div>
                    <div className="mt-5">
                        {contents.map((item, index) => (
                            <div
                                key={index}
                                className="d-flex flex-lg-row flex-column justify-content-between align-items-center gap-lg-4 mb-3">
                                <div className="card w-100 flex-grow-1 p-3">
                                    <TextAreaFitContent
                                        rows="5"
                                        maxLength={500}
                                        value={item.text}
                                        setValue={e => {
                                            setContents(prevContents => {
                                                const newContents = [...prevContents];
                                                newContents[index].text = e.target.value;
                                                return newContents;
                                            });
                                        }}
                                        placeholder="Write something"
                                    />
                                </div>
                                <div className="my-lg-0 my-3">
                                    {(item.isRewriting || processes.includes(index)) && (
                                        <button
                                            className="btn btn-warning">
                                            <Icon icon="material-symbols:arrow-forward-rounded" width="32" className="text-white"/>
                                        </button>
                                    )}
                                    {(!item.isRewriting && !processes.includes(index)) && (
                                        <button
                                            onClick={() => {
                                                setProcesses([...processes, index]);
                                                if(processes.length === 0) {
                                                    setTimeout(() => {
                                                        runProcess([index], contents);
                                                    }, 500)
                                                }
                                            }}
                                            className="btn btn-primary">
                                            <Icon icon="material-symbols:arrow-forward-rounded" width="32" className="text-white"/>
                                        </button>
                                    )}
                                </div>
                                <div className="card w-100 flex-grow-1">
                                    {(item.isRewriting || processes.includes(index)) && (
                                        <div className="position-absolute w-100 h-100 bg-secondary bg-opacity-25 d-flex justify-content-center align-items-center">
                                            <div className="spinner-border text-primary" role="status">
                                                <span className="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    )}
                                    <div className="p-3">
                                        <TextAreaFitContent
                                            defaultValue={item.rewritten}
                                            placeholder=""
                                            rows="5"
                                        />
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                    <div className="d-flex justify-content-center mt-4">
                        <button onClick={addMoreContent} className="btn btn-outline-secondary d-flex align-items-center">
                            <Icon icon="mdi:plus-circle-outline" />
                            <span className="ms-2">Add section below</span>
                        </button>
                    </div>
                </div>
            )}
        </>
    )
}

export default connect(({auth}) => ({auth}))(ContentReframerPage);
