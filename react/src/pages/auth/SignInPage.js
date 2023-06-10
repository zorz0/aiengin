import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import Form from "react-bootstrap/Form";
import {Icon} from "@iconify/react";
import {useNavigate} from "react-router-dom";
import API from "../../helpers/Axios";
import {store} from "../../store/configureStore";
import {useTranslation} from "react-i18next";
import Button from "react-bootstrap/Button";
import SocialsConnector from "../../components/SocialsConnector";


const SignInPage = () => {
    const { t } = useTranslation();
    const linkTo = useNavigate();
    const [isSubmitting, setIsSubmitting] = useState( false);
    const [validated, setValidated] = useState(false);
    const [isUnauthorized, setIsUnauthorized] = useState(false);

    const handleSubmit = (event) => {
        if(isSubmitting) {
            event.preventDefault();
            return
        }
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            const data = new FormData(event.target);
            setIsSubmitting(true);
            API.post('auth/login', data)
                .then(res => {
                    store.dispatch({type: 'UPDATE_ACCESS_TOKEN', accessToken: res.data.access_token});
                    store.dispatch({type: 'TOGGLE_AUTH', user: res.data.user});
                    setTimeout(() => {
                        linkTo(`/dashboard`);
                    }, 100);
                }).catch (error => {
                setIsSubmitting(false);
                setIsUnauthorized(prev => true);
            });
        }
        setValidated(true);
        event.preventDefault();
    };

    useEffect(() => {
        isUnauthorized && setValidated(false);
    }, [isUnauthorized])

    return (
        <main className="bg-light d-flex justify-content-center align-items-center min-vh-100">
            <div className="container">
                <div className="auth-content bg-white rounded overflow-hidden">
                    <div style={{backgroundColor: '#fdb528'}} className="auth-image d-none d-lg-flex align-items-center justify-content-center px-5 overflow-hidden">
                        <figure>
                            <blockquote className="blockquote mb-4">
                                <Icon icon="clarity:block-quote-line" width="40" className="text-white"/>
                                <h2 className="text-white">Transform content creation with AI Engine! Save time and drive results with data-driven success. Unleash your team's potential and watch their impactful content soar.</h2>
                            </blockquote>
                            <figcaption className="blockquote-footer text-white">
                                Elon Musk in <cite>The Blogger</cite>
                            </figcaption>
                        </figure>
                    </div>
                    <div className="auth-form p-3 px-lg-5 pt-lg-3 pb-lg-5">
                        <button className="btn btn-link px-0 mb-2" onClick={() =>  linkTo(-1)}>
                            <Icon icon="material-symbols:arrow-back-rounded" width="24" className="text-secondary"/>
                        </button>
                        <h2 className="mb-4">Log in</h2>
                        <div className="d-grid gap-3">
                            <SocialsConnector
                                title={t('Sign in with')}
                            />
                        </div>
                        <hr className="my-4"/>
                        <Form noValidate validated={validated} onSubmit={handleSubmit}>
                            <Form.Group className="mb-3">
                                <Form.Label>Email</Form.Label>
                                <Form.Control
                                    name="email"
                                    className="form-control"
                                    required
                                    type="email"
                                    placeholder="Your Email"
                                    isInvalid={isUnauthorized}
                                    onChange={e => {
                                        setIsUnauthorized(false);
                                    }}
                                />
                                <Form.Control.Feedback type="invalid">{t('These credentials do not match our records.')}</Form.Control.Feedback>
                            </Form.Group>
                            <Form.Group>
                                <Form.Label>Password</Form.Label>
                                <Form.Control
                                    required
                                    name="password"
                                    className="form-control"
                                    type="password"
                                    placeholder="Your Password"
                                    onChange={e => {
                                        setIsUnauthorized(false);
                                    }}
                                    isInvalid={isUnauthorized}
                                />
                            </Form.Group>
                            <a onClick={(e) => {linkTo(`/forgot-password`);e.preventDefault();}} href={`/forgot-password`} className="mb-3 text-end d-block mt-1 text-decoration-none">Forgot your password?</a>
                            <Button
                                disabled={isSubmitting}
                                className="w-100 btn btn-primary"
                                type="submit"
                            >
                                {isSubmitting && (<span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>)}
                                {!isSubmitting && (<span>{t('Login')}</span>)}
                            </Button>
                        </Form>
                        <p className="mt-3 mb-1">Don't have an account? <a onClick={(e) => {linkTo(`/sign-up`);e.preventDefault();}} href={`/sign-up`} className="text-decoration-none">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </main>
    )
}

export default connect(({auth}) => ({auth}))(SignInPage);
