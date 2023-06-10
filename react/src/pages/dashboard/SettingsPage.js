import React, {useState} from "react";
import {connect} from "react-redux";
import Form from 'react-bootstrap/Form';
import API from "../../helpers/Axios";
import {useTranslation} from "react-i18next";
import UserAvatar from "../../components/UserAvatar";
import Button from "react-bootstrap/Button";

const SettingsPage = ({auth, dispatch}) => {
    const { t, i18n } = useTranslation();
    const [isChangeProfileSubmitting, setIsChangeProfileSubmitting] = useState( false);
    const [isChangePassSubmitting, setIsChangePassSubmitting] = useState( false);
    const [validated, setValidated] = useState(false);
    const [profileSetErrors, setProfileSetErrors] = useState({});

    const handleSubmit = (event) => {
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            setIsChangeProfileSubmitting(true);
            const data = new FormData();
            data.append('name', name);
            data.append('email', email);
            artworkFile && data.append('artwork', artworkFile)
            API.post('auth/user/settings/profile', data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(res => {
                dispatch({type: 'UPDATE_USER_INFO', user: res.data});
                setIsChangeProfileSubmitting(false);
                if(artworkFile) {
                    setCurrentAvatar(res.data.artwork_url);
                }
            }).catch (error => {
                setIsChangeProfileSubmitting(false);
                setProfileSetErrors(error.response.data.errors);
            });
        }
        setValidated(true);
        event.preventDefault();
    };
    const [currentAvatar, setCurrentAvatar] = useState(auth.user.artwork_url);
    const [artworkFile, setArtworkFile] = useState(null);
    const artworksSelectedHandler = (e) => {
        setArtworkFile(e.target.files[0]);
        setCurrentAvatar(URL.createObjectURL(e.target.files[0]));
    }

    const [isChangePassError, setIsChangePassError] = useState( false);
    const [passwordSetErrors, setPasswordSetErrors] = useState({});
    const [passValidated, setPassValidated] = useState(false);
    const handleChangePassSubmit = (event) => {
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            const data = new FormData(event.target);
            setIsChangePassSubmitting(true);
            API.post('auth/user/settings/password', data)
                .then(res => {
                    setIsChangePassSubmitting(false);
                    setIsChangePassError(false);
                }).catch (error => {
                setIsChangePassSubmitting(false);
                setPasswordSetErrors(error.response.data.errors);
            });
        }
        setPassValidated(true);
        event.preventDefault();
    };
    const [name, setName] = useState(auth.user.name);
    const [email, setEmail] = useState(auth.user.email);

    return (
        <>
            <div className="container px-lg-3 px-0" style={{maxWidth: 800}}>
                <div className="card p-4">
                    <h5 className="mb-4">{t('Settings')}</h5>
                    <Form noValidate validated={validated} onSubmit={handleSubmit} encType="multipart/form-data">
                        <div className="d-flex mb-5">
                            <div className="flex-shrink-0">
                                <UserAvatar
                                    name={auth.user.name}
                                    url={currentAvatar}
                                    width="108"
                                />
                            </div>
                            <div className="flex-grow-1 ms-3">
                                <button className="btn btn-outline-primary position-relative" type="button">
                                    <span>Upload new image</span>
                                    <input
                                        style={{
                                            position: 'absolute',
                                            top: 0,
                                            left: 0,
                                            right: 0,
                                            bottom: 0,
                                            opacity: 0,
                                            cursor: 'pointer',
                                            zIndex: 1,
                                        }}
                                        type="file"
                                        onChange={artworksSelectedHandler}
                                        accept="image/*"
                                    />
                                </button>
                            </div>
                        </div>
                        <Form.Group className="mb-3">
                            <Form.Label>{t('Name')}</Form.Label>
                            <Form.Control
                                required
                                type="text"
                                placeholder={t('Your name')}
                                value={name}
                                onChange={e => setName(e.target.value)}
                            />
                        </Form.Group>
                        <Form.Group className="mb-3">
                            <Form.Label>{t('Email')}</Form.Label>
                            <Form.Control
                                required
                                type="email"
                                placeholder="Your email"
                                value={email}
                                onChange={e => {
                                    setEmail(e.target.value);
                                    const { email, ...newState } = profileSetErrors;
                                    setProfileSetErrors(newState);
                                }}
                                isValid={false}
                                isInvalid={profileSetErrors.hasOwnProperty('email')}
                            />
                            <Form.Control.Feedback type="invalid">{profileSetErrors.hasOwnProperty('email') && profileSetErrors.email[0]}</Form.Control.Feedback>
                        </Form.Group>
                        <Button
                            disabled={isChangeProfileSubmitting}
                            className="btn btn-primary mt-4"
                            type="submit"
                        >
                            <span>{t('Save changes')}</span>
                            {isChangeProfileSubmitting && (
                                <span className="spinner-border spinner-border-sm ms-3" role="status" aria-hidden="true"></span>
                            )}
                        </Button>
                    </Form>
                </div>
                <div className="card p-4 mt-4">
                    <h5 className="mb-4">{t('Change Password')}</h5>
                    <Form noValidate validated={passValidated} onSubmit={handleChangePassSubmit}>
                        <Form.Group className="mb-3">
                            <Form.Label>Current Password</Form.Label>
                            <Form.Control
                                required
                                type="password"
                                placeholder={t('Your Current Password')}
                                name="current_password"
                                onChange={e => {
                                    const { current_password, ...newState } = passwordSetErrors;
                                    setPasswordSetErrors(newState);
                                }}
                                isInvalid={passwordSetErrors.hasOwnProperty('current_password')}
                            />
                            <Form.Control.Feedback type="invalid">{passwordSetErrors.hasOwnProperty('current_password') && passwordSetErrors.current_password[0]}</Form.Control.Feedback>
                        </Form.Group>
                        <Form.Group className="mb-3">
                            <Form.Label>{t('Your New Password')}</Form.Label>
                            <Form.Control
                                required
                                type="password"
                                placeholder={t('Type Your New Password')}
                                name="password"
                                onChange={e => {
                                    const { password, ...newState } = passwordSetErrors;
                                    setPasswordSetErrors(newState);
                                }}
                                isInvalid={passwordSetErrors.hasOwnProperty('password')}
                            />
                            <Form.Control.Feedback type="invalid">{passwordSetErrors.hasOwnProperty('password') && passwordSetErrors.password[0]}</Form.Control.Feedback>
                        </Form.Group>
                        <Form.Group className="mb-3">
                            <Form.Label>{t('Confirm New Password')}</Form.Label>
                            <Form.Control
                                required
                                type="password"
                                placeholder={t('Confirm Your New Password')}
                                name="password_confirmation"
                                onChange={e => {
                                    const { password_confirmation, ...newState } = passwordSetErrors;
                                    setPasswordSetErrors(newState);
                                }}
                                isInvalid={passwordSetErrors.hasOwnProperty('password_confirmation')}
                            />
                            <Form.Control.Feedback type="invalid">{passwordSetErrors.hasOwnProperty('password_confirmation') && passwordSetErrors.password_confirmation[0]}</Form.Control.Feedback>
                        </Form.Group>
                        <Button
                            disabled={isChangePassSubmitting}
                            className="btn btn-primary mt-4"
                            type="submit"
                        >
                            <span>{t('Save changes')}</span>
                            {isChangePassSubmitting && (
                                <span className="spinner-border spinner-border-sm ms-3" role="status" aria-hidden="true"></span>
                            )}
                        </Button>
                    </Form>
                </div>
            </div>
        </>
    )
}

export default connect(({auth}) => ({auth}))(SettingsPage);
