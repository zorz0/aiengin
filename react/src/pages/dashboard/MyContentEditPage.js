import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import {Icon} from "@iconify/react/dist/iconify";
import {copyText, hexToRgbA} from "../../helpers/Utils";
import API from "../../helpers/Axios";
import {useTranslation} from "react-i18next";
import {useNavigate, useParams} from "react-router-dom";
import SubmittingButton from "../../components/SubmittingButton";
import {Dropdown} from "react-bootstrap";

const ExportToggle = React.forwardRef(({ children, onClick }, ref) => (
    <button
        ref={ref}
        onClick={(e) => {
            e.preventDefault();
            onClick(e);
        }}
        className="btn btn-outline-secondary d-flex align-items-center"
    >
        {children}
    </button>
));

const MyContentEditPage = () => {
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

    const [editorLoaded, setEditorLoaded] = useState(false);
    const [editor, setEditor] = useState(null);

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
        (async () => {
            setTimeout(async () => {
                await handleEditorLoad()
            }, 1000)
        })();
    }, [])

    const { id } = useParams();
    const linkTo = useNavigate();
    const { t } = useTranslation();
    const [isLoading, setIsLoading] = useState(false);
    const [article, setArticle] = useState('');
    const [isCopied, setIsCopied] = useState(false);

    useEffect(() => {
        if(editor) {
            API.post('auth/content/get-by-id', {
                id: id
            }).then(res => {
                editor.setData(res.data.content);
                setArticle(res.data.content);
                setEditorLoaded(true);
            }).catch (error => {
                linkTo(`/dashboard/tools/article-composer`);
                setIsLoading(false);
            });
        }
    }, [editor]);

    const [isSubmitting, setIsSubmitting] = useState( false);

    useEffect(() => {
        if(isCopied) {
            setTimeout(() => setIsCopied(false), 5000)
        }
    }, [isCopied])

    return isLoading ? (<div style={{flex: 1, justifyContent: 'center', alignItems: 'center'}} >Loading...</div>) : (
        <>
            <div className="w-100">
                <div className="d-flex align-items-center justify-content-between bg-white p-3 rounded">
                    <div className="d-flex align-items-center">
                        <a
                            onClick={(e) => {
                                linkTo(`/dashboard/my-content`);
                                e.preventDefault();
                            }}
                            href={`/dashboard/my-content`}
                            className="btn btn-outline-secondary">
                            <Icon icon="ic:outline-arrow-back" />
                        </a>
                    </div>
                    <div className="d-flex align-items-center gap-2">
                        <div className="d-flex align-items-center gap-4">
                            {[
                                {
                                    title: 'words',
                                    content: article.trim().split(/\s+/).length
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
                                copyText(article.replace(/<\/?[^>]+>/g, '').replace(/<\/?p>/g, '\n'));
                                setIsCopied(true);
                            }}
                            className="btn btn-outline-secondary d-lg-flex d-none align-items-center">
                            {isCopied && (
                                <>
                                    <Icon icon="mdi:check-circle" className="text-success" />
                                    <small className="ms-1">{t('Copied')}</small>
                                </>
                            )}
                            {!isCopied && (
                                <>
                                    <Icon icon="mdi:content-copy" />
                                    <small className="ms-1">{t('Copy')}</small>
                                </>
                            )}
                        </button>
                        <Dropdown>
                            <Dropdown.Toggle as={ExportToggle}>
                                <Icon icon="mdi:export"/>
                                <span className="ms-2">{t('Export')}</span>
                            </Dropdown.Toggle>
                            <Dropdown.Menu>
                                <Dropdown.Item
                                    onClick={generatePDF}
                                >
                                    <small className="flex-grow-1 ms-2 text-wrap">{t('PDF')}</small>
                                </Dropdown.Item>
                                <Dropdown.Item
                                    onClick={() => {
                                        copyText(article.replace(/<\/?[^>]+>/g, '').replace(/<\/?p>/g, '\n'));
                                        setIsCopied(true);
                                    }}
                                >
                                    <small className="flex-grow-1 ms-2 text-wrap">{t('Copy')}</small>
                                </Dropdown.Item>
                            </Dropdown.Menu>
                        </Dropdown>
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
                    </div>
                </div>
                <div className="card p-3 mt-3">
                    <div>
                        {!editorLoaded && <div>Loading editor...</div>}
                        <div
                            id="editor"
                        />
                    </div>
                </div>
            </div>
        </>
    )
}

export default connect(({auth}) => ({auth}))(React.memo(MyContentEditPage));

