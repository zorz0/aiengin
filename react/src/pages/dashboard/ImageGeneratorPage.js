import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import Button from 'react-bootstrap/Button';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';
import Row from 'react-bootstrap/Row';
import {useLocation, useParams} from "react-router-dom";
import {Icon} from "@iconify/react";
import API from "../../helpers/Axios";
import {store} from "../../store/configureStore";
import {useTranslation} from "react-i18next";
import CopyImageButton from "../../components/CopyImageButton";
import {Base64, encodeURL} from "js-base64";
import { saveAs } from 'file-saver';

const CommonToolPage = ({navigation, route}) => {
    const { t } = useTranslation();
    const [tabIndex, setTabIndex] = useState(0);

    const [validated, setValidated] = useState(false);
    const [textAreaValue, setTextAreaValue] = useState('');
    const [variants, setVariants] = useState(2);
    const [variantsContent, setVariantsContent] = useState([]);
    const [savedIndexes, setSavedIndexes] = useState([]);
    const [savingIndexes, setSavingIndexes] = useState([]);
    const [savedContents, setSavedContents] = useState([]);
    const [deletingId, setDeletingId] = useState(null);
    const [downloadingIds, setDownloadingIds] = useState([]);

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
            if(name !== 'language' && value !== '' && value !== 'none') {
                builtString += name + '=' + value + ' & ';
            }
        }

        setIsRunning(true);
        const currentProcess = processes[0];
        try {
            console.log(`Running process: ${currentProcess}`);

            await new Promise(resolve => {
                API.post('auth/user/image-generator', {
                    action: Base64.encode(`${builtString.replace(/_/g, ' ')}`)
                }).then((res) => {
                    store.dispatch({type: 'UPDATE_TOKENS', tokens: store.getState().common.tokens - 50});
                    setVariantsContent((prev) => {
                        const newArray = [...prev];
                        newArray[currentProcess] = res.data.data[0]['url'];
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
        setSavingIndexes([...savingIndexes, index]);
        API.post('auth/content/save-image', {
            type: 'image-generator',
            content: text
        }).then(res => {
            setSavedIndexes([...savedIndexes, index]);
            setSavingIndexes(savingIndexes.filter((value, i) => i !== index));
        }).catch (error => {

        });
    }

    const getSavedContents = () => {
        API.post('auth/contents', {
            type: 'image-generator',
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

    const downloadImage = (imageId, imageUrl) => {
        setDownloadingIds([...downloadingIds, imageId]);
        const currentTimestamp = Date.now();
        const fileName = `image-${currentTimestamp}.png`;
        fetch(imageUrl)
            .then(res => res.blob())
            .then(blob => {
                saveAs(blob, fileName);
                setDownloadingIds(downloadingIds.filter((value, i) => i !== imageId));
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
                        <div className="card-tool-icon" style={{backgroundColor: 'rgba(228,152,150,0.3)'}}>
                            <Icon icon="ph:image-square-fill" style={{color: 'white'}} width="24" />
                        </div>
                        <span className="ms-2 fw-bold">{t('Image Generator')}</span>
                    </div>
                    <p className="text-secondary">{t('Generate professional quality images from text for your website or blog.')}</p>
                    <p className="fw-bolder">This tool will deduct 50 words per image.</p>
                    <Form noValidate validated={validated} onSubmit={handleSubmit}>
                        <Form.Group className="mb-3">
                            <div className="d-flex align-items-center justify-content-between">
                                <Form.Label>{t('Image Description?')}</Form.Label>
                                <small className="text-muted">{textAreaValue.length}/200</small>
                            </div>
                            <Form.Control
                                name="image_description"
                                required
                                as="textarea"
                                type="text"
                                placeholder={t('Astronaut behind the wheel of a sports car on the moon captured in a photograph.')}
                                rows="5"
                                maxLength={200}
                                value={textAreaValue}
                                onChange={(e) => {
                                    setTextAreaValue(e.currentTarget.value)
                                }}
                            />
                        </Form.Group>
                        <Form.Group className="mb-3">
                            <Form.Label>{t('Engine')}</Form.Label>
                            <Form.Select name="image_engine">
                                <option value="realistic">Realistic</option>
                                <option value="fictional">Fictional</option>
                            </Form.Select>
                        </Form.Group>
                        <Form.Group className="mb-3">
                            <Form.Label>{t('Style')}</Form.Label>
                            <Form.Select name="image_engine">
                                <option value="none">None</option><option value="3d render">3d Render</option><option value="abstract">Abstract</option><option value="anime">Anime</option><option value="art deco">Art Deco</option><option value="cartoon">Cartoon</option><option value="digital art">Digital Art</option><option value="illustration">Illustration</option><option value="line art">Line Art</option><option value="one line drawing">One Line Drawing</option><option value="origami">Origami</option><option value="pixel art">Pixel Art</option><option value="photography">Photography</option><option value="pop art">Pop Art</option><option value="retro">Retro</option><option value="unreal engine">Unreal Engine</option><option value="vaporwave">Vaporwave</option>
                            </Form.Select>
                        </Form.Group>
                        <Row className="mb-3">
                            <Form.Group as={Col}>
                                <Form.Label>Medium</Form.Label>
                                <Form.Select name="medium">
                                        <option value="none">None</option><option value="acrylics">Acrylics</option><option value="canvas">Canvas</option><option value="chalk">Chalk</option><option value="charcoal">Charcoal</option><option value="classic oil">Classic Oil</option><option value="crayon">Crayon</option><option value="glass">Glass</option><option value="ink">Ink</option><option value="modern oil painting">Modern Oil Painting</option><option value="pastel">Pastel</option><option value="pencil">Pencil</option><option value="spray paint">Spray Paint</option><option value="water color painting">Water Color Painting</option><option value="wood panel">Wood Panel</option>
                                </Form.Select>
                            </Form.Group>
                            <Form.Group as={Col}>
                                <Form.Label>Artist</Form.Label>
                                <Form.Select name="medium">
                                <option value="none">None</option><option value="andy warhol">Andy Warhol</option><option value="ansel adams">Ansel Adams</option><option value="claude monet">Claude Monet</option><option value="dr. seuss">Dr. Seuss</option><option value="pablo picasso">Pablo Picasso</option><option value="pixar">Pixar</option><option value="salvador dali">Salvador Dali</option><option value="south park">South Park</option><option value="van gogh">Van Gogh</option>
                                </Form.Select>
                            </Form.Group>
                        </Row>
                        <Row className="mb-3">
                            <Form.Group as={Col}>
                                <Form.Label>Medium</Form.Label>
                                <Form.Select name="image_mood">
                                        <option value="none">None</option><option value="aggressive">Aggressive</option><option value="angry">Angry</option><option value="boring">Boring</option><option value="bright">Bright</option><option value="calm">Calm</option><option value="cheerful">Cheerful</option><option value="chilling">Chilling</option><option value="colorful">Colorful</option><option value="dark">Dark</option><option value="neutral">Neutral</option>
                                </Form.Select>
                            </Form.Group>
                            <Form.Group as={Col}>
                                <Form.Label>Artist</Form.Label>
                                <Form.Select name="image_details">
                                    <option value="none">None</option><option value="ambient light">Ambient light</option><option value="black &amp; white">Black &amp; White</option><option value="close-up">Close-up</option><option value="full face portrait">Full face portrait</option><option value="high resolution">High resolution</option><option value="highly-detailed">Highly-detailed</option><option value="photorealistic">Photorealistic</option><option value="realistic">Realistic</option><option value="sharp">Sharp</option>
                                </Form.Select>
                            </Form.Group>
                        </Row>
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
                                    <div className="row">
                                        {variantsContent.map((text, index) => (
                                            <div
                                                key={index}
                                                className="col-lg-6 col-12 g-3">
                                                <div
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
                                                            className="image-result-card"
                                                        >
                                                            <img src={text} style={{width: '100%'}}/>
                                                        </div>
                                                        {(!processes.includes(index)) && (
                                                            <div className="d-flex flex-row-reverse">
                                                                <CopyImageButton
                                                                    text={text}
                                                                />
                                                                <button
                                                                    onClick={() => !savingIndexes.includes(index) &&  !savedIndexes.includes(index) && saveContent(text, index)}
                                                                    className="btn border-0 text-secondary">
                                                                    {savingIndexes.includes(index) && (
                                                                        <>
                                                                            <div className="spinner-border spinner-border-sm" role="status">
                                                                                <span className="visually-hidden">Loading...</span>
                                                                            </div>
                                                                            <small className="ms-1">{t('Saving')}</small>
                                                                        </>
                                                                    )}
                                                                    {!savingIndexes.includes(index) && savedIndexes.includes(index) && (
                                                                        <>
                                                                            <Icon icon="mdi:check-circle" className="text-success" />
                                                                            <small className="ms-1">{t('Saved')}</small>
                                                                        </>
                                                                    )}
                                                                    {!savingIndexes.includes(index) && !savedIndexes.includes(index) && (
                                                                        <>
                                                                            <Icon icon="mdi:content-save-all-outline" />
                                                                            <small className="ms-1">{t('Save')}</small>
                                                                        </>
                                                                    )}
                                                                </button>
                                                                <button
                                                                    onClick={() => downloadImage(index, `/download-image/${Base64.encode(text)}`)}
                                                                    className="btn border-0 text-secondary">
                                                                    {downloadingIds.includes(index) && (
                                                                        <>
                                                                            <div className="spinner-border spinner-border-sm" role="status">
                                                                                <span className="visually-hidden">Loading...</span>
                                                                            </div>
                                                                            <small className="ms-1">{t('Downloading')}</small>
                                                                        </>
                                                                    )}
                                                                    {!downloadingIds.includes(index) && (
                                                                        <>
                                                                            <Icon icon="material-symbols:download" />
                                                                            <small className="ms-1">{t('Download')}</small>
                                                                        </>
                                                                    )}
                                                                </button>
                                                            </div>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                )}
                                {!variantsContent.length && (
                                    <>
                                        <p className="text-center">{t('Generate results by filling up the form on the left and clicking on "Generate".')}</p>
                                        <div className="d-flex align-items-center flex-column text-center p-5">
                                            <div className="w-48px rounded d-flex justify-content-center align-items-center" style={{backgroundColor: 'rgba(228,152,150,0.3)'}}>
                                                <Icon icon="ph:image-square-fill" style={{color: 'white'}} width="24" />
                                            </div>
                                            <h3 className="mt-3">{t('Image Generator')}</h3>
                                        </div>
                                    </>
                                )}
                            </>
                        )}
                        {tabIndex === 1 && (
                            <div className="row">
                                {!savedContents.length && (
                                    <p className="text-center m-5">{t('This is where your saved content will appear.')}</p>
                                )}
                                {savedContents.map((item, index) => (
                                    <div className="col-lg-6 col-12 g-3">
                                        <div
                                            key={index}
                                            className="card"
                                        >
                                            <div className="mx-3 mt-3" style={{minHeight: 64}}>
                                                <div
                                                    className="image-result-card"
                                                >
                                                    <img src={item.content} style={{width: '100%'}}/>
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
                                                    <CopyImageButton
                                                        text={item.content}
                                                    />
                                                    <button
                                                        onClick={() => downloadImage(item.id, item.content)}
                                                        className="btn border-0 text-secondary">
                                                        {downloadingIds.includes(item.id) && (
                                                            <>
                                                                <div className="spinner-border spinner-border-sm" role="status">
                                                                    <span className="visually-hidden">Loading...</span>
                                                                </div>
                                                                <small className="ms-1">{t('Downloading')}</small>
                                                            </>
                                                        )}
                                                        {!downloadingIds.includes(item.id) && (
                                                            <>
                                                                <Icon icon="material-symbols:download" />
                                                                <small className="ms-1">{t('Download')}</small>
                                                            </>
                                                        )}
                                                    </button>
                                                </div>
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
