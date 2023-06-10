import React, {useState} from "react";
import {connect} from "react-redux";
import { Icon } from '@iconify/react';

const BlogWriterContentPage = () => {
    const [subHeadings, setSubHeadings] = useState([{},{},{}]);
    const [collapseEditingIndex, setCollapseEditingIndex] = useState(0);

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
        <>
            <div className="d-flex align-items-center justify-content-between bg-white p-3 rounded">
                <div className="d-flex align-items-center">
                    <button>Back</button>
                    {[
                        {
                            title: 'Language',
                            content: 'English (US)'
                        },
                        {
                            title: 'Creativiy',
                            content: 'Regular'
                        },
                        {
                            title: 'Keyword',
                            content: 'cryptocurrencies'
                        },
                        {
                            title: 'Description',
                            content: 'Fear of missing out (FOMO) was prevalent i...'
                        }
                    ].map((item, index) => (
                        <div
                            key={index}
                            className="d-flex flex-column ms-4"
                        >
                            <small className="text-uppercase mb-1 text-secondary">{item.title}</small>
                            <span className="badge bg-light text-dark">{item.content}</span>
                        </div>
                    ))}
                </div>
                <div className="d-flex align-items-center gap-2">
                    <div className="d-flex align-items-center gap-4">
                        {[
                            {
                                title: 'SEO score',
                                content: '2'
                            },
                            {
                                title: 'words',
                                content: '45'
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
                    <button className="btn btn-outline-secondary">Export</button>
                    <button className="btn btn-primary">Save</button>
                </div>
            </div>
            <div className="mt-5">
                <div className="d-flex align-items-center justify-content-between">
                    <small className="text-secondary text-uppercase fw-bold">Title</small>
                    <div className="d-flex align-items-center">
                        <button className="btn border-0">
                            <Icon icon="mdi:content-copy" />
                            <small className="text-secondary ms-1">Copy content</small>
                        </button>
                        <button className="btn border-0">
                            <Icon icon="ic:outline-help-outline" />
                            <small className="text-secondary ms-1">Help</small>
                        </button>
                    </div>
                </div>
                <div className="bg-white p-3 rounded">
                    <input className="border-0 fs-5 w-100 shadow-none outline-none" value="The Bitcoin price surge has led to a market FOMO among small BTC addresses" />
                </div>
                <div className="mt-5">
                    <div className="d-flex align-items-center justify-content-between">
                        <small className="text-secondary text-uppercase fw-bold">Post intro</small>
                        <div className="d-flex align-items-center">
                            <button className="btn border-0">
                                <Icon icon="mingcute:lightning-line" />
                                <small className="text-secondary ms-1">Generate</small>
                            </button>
                            <button className="btn border-0">
                                <Icon icon="mdi:content-copy" />
                                <small className="text-secondary ms-1">Copy content</small>
                            </button>
                        </div>
                    </div>
                    <div
                        className={'bg-white p-3 mb-3 position-relative rounded'}
                    >
                        <textarea rows="2" className="border-0 w-100 shadow-none outline-none" placeholder="Write something">ssfs</textarea>
                    </div>
                </div>
                <div className="mt-5">
                    <div className="d-flex align-items-center justify-content-between">
                        <small className="text-secondary text-uppercase fw-bold">Post content</small>
                        <div className="d-flex align-items-center">
                            <button className="btn border-0">
                                <Icon icon="mdi:content-copy" />
                                <small className="text-secondary ms-1">Copy content</small>
                            </button>
                        </div>
                    </div>
                    {[
                        {
                            title: 'SEO score',
                            content: '2'
                        },
                        {
                            title: 'words',
                            content: '45'
                        },
                    ].map((item, index) => (
                        <div
                            key={index}
                            className={`bg-white p-3 rounded ${collapseEditingIndex ===  index && `${index !== 0 && `mt-3`} mb-3 position-relative`}`}
                            onMouseEnter={() => setCollapseEditingIndex(index)}
                        >
                            <input className="border-0 fs-5 w-100 shadow-none outline-none" value="The Bitcoin price surge has led to a market FOMO among small BTC addresses" />
                            {(collapseEditingIndex ===  index) && (
                                <>
                                    <hr/>
                                    <textarea rows="2" className="border-0 w-100 shadow-none outline-none" placeholder="Write something">ssfs</textarea>
                                </>
                            )}
                            <div
                                className="d-flex flex-column justify-content-between subheading-editor-buttons"
                            >
                                <a>
                                    <Icon icon="mingcute:lightning-line" />
                                </a>
                                <a>
                                    <Icon icon="tabler:chevron-up" />
                                </a>
                                <a>
                                    <Icon icon="tabler:chevron-down" />
                                </a>
                                <a>
                                    <Icon icon="ic:baseline-delete-outline" />
                                </a>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </>
    )
}

export default connect(({auth}) => ({auth}))(BlogWriterContentPage);
