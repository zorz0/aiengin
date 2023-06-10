import React, {useState} from "react";
import {connect} from "react-redux";
import Form from "react-bootstrap/Form";
import {Icon} from "@iconify/react";
import {useNavigate} from "react-router-dom";
import API from "../../helpers/Axios";
import {store} from "../../store/configureStore";
import Button from "react-bootstrap/Button";
import {useTranslation} from "react-i18next";
import SocialsConnector from "../../components/SocialsConnector";

const SignUpPage = () => {
    const { t } = useTranslation();
    const linkTo = useNavigate();
    const [validated, setValidated] = useState(false);
    const [isSubmitting, setIsSubmitting] = useState( false);
    const [signupErrors, setSignUpErrors] = useState({});

    const handleSubmit = (event) => {
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            const data = new FormData(event.target);
            setIsSubmitting(true);
            API.post('auth/signup', data)
                .then(res => {
                    store.dispatch({type: 'UPDATE_ACCESS_TOKEN', accessToken: res.data.access_token});
                    store.dispatch({type: 'TOGGLE_AUTH', user: res.data.user});
                    setTimeout(() => {
                        linkTo(`/dashboard`);
                    }, 100);
                }).catch (error => {
                setIsSubmitting(false);
                setSignUpErrors(error.response.data.errors);
                setValidated(false);
            });
        }
        setValidated(true);
        event.preventDefault();
    };

    return (
        <main className="bg-light d-flex justify-content-center align-items-center min-vh-100">
            <div className="container py-5">
                <div className="auth-content bg-white rounded overflow-hidden">
                    <div className="auth-image d-none d-lg-flex align-items-center justify-content-center px-5 overflow-hidden">
                        <figure>
                            <blockquote className="blockquote mb-4">
                                <Icon icon="clarity:block-quote-line" width="40" className="text-white"/>
                                <h2 className="text-white">By using AI Engine, my team saves a lot of time by working on the right content and in a more data-driven way.</h2>
                            </blockquote>
                            <figcaption className="blockquote-footer text-white">
                                Miranda Smith in <cite>The AI Maker</cite>
                            </figcaption>
                        </figure>
                    </div>
                    <div className="auth-form p-3 px-lg-5 pt-lg-3 pb-lg-5">
                        <button className="btn btn-link px-0 mb-2" onClick={() =>  linkTo(-1)}>
                            <Icon icon="material-symbols:arrow-back-rounded" width="24" className="text-secondary"/>
                        </button>
                        <h2 className="mb-4">{t('Create your account')}</h2>
                        <div className="d-grid gap-3">
                            <SocialsConnector
                                title={t('Continue with')}
                            />
                        </div>
                        <hr className="my-4"/>
                        <Form noValidate validated={validated} onSubmit={handleSubmit}>
                            <Form.Group className="mb-3">
                                <Form.Label>Name</Form.Label>
                                <Form.Control
                                    name="name"
                                    className="form-control"
                                    required
                                    type="text"
                                    placeholder="Your Name"
                                />
                            </Form.Group>
                            <Form.Group className="mb-3">
                                <Form.Label>Email</Form.Label>
                                <Form.Control
                                    name="email"
                                    className="form-control"
                                    required
                                    type="email"
                                    placeholder="Your Email"
                                    onChange={e => {
                                        const { email, ...newState } = signupErrors;
                                        setSignUpErrors(newState);
                                    }}
                                    isInvalid={signupErrors.hasOwnProperty('email')}
                                />
                                <Form.Control.Feedback type="invalid">{signupErrors.hasOwnProperty('email') && t(signupErrors.email[0])}</Form.Control.Feedback>
                            </Form.Group>
                            <Form.Group className="mb-3">
                                <Form.Label>Password</Form.Label>
                                <Form.Control
                                    name="password"
                                    className="form-control"
                                    required
                                    type="password"
                                    placeholder="Your Password"
                                    isInvalid={signupErrors.hasOwnProperty('password')}
                                    onChange={e => {
                                        const { password, ...newState } = signupErrors;
                                        setSignUpErrors(newState);
                                    }}
                                />
                                <Form.Control.Feedback type="invalid">{signupErrors.hasOwnProperty('password') && t(signupErrors.password[0])}</Form.Control.Feedback>
                            </Form.Group>
                            <Form.Group className="mb-3">
                                <Form.Label>Confirm Password</Form.Label>
                                <Form.Control
                                    name="password_confirmation"
                                    className="form-control"
                                    required
                                    type="password"
                                    placeholder="Comfirm Your Password"
                                    defaultValue=""
                                />
                            </Form.Group>
                            <Button
                                disabled={isSubmitting}
                                type="submit"
                                className="w-100 btn btn-primary"
                            >
                                {isSubmitting && (<span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>)}
                                {!isSubmitting && (<span>{t('Create account')}</span>)}
                            </Button>
                        </Form>
                        <p className="mt-3 mb-1">{t('Already have an account?')} <a onClick={(e) => {linkTo(`/sign-in`);e.preventDefault();}} href={`/sign-in`} className="text-decoration-none">{t('Log in')}</a></p>
                        <small className="text-muted">{t('By creating your account, you agree to the Terms of Service and Privacy Policy')}</small>
                    </div>
                </div>
            </div>
        </main>
    )
}

export default connect(({auth}) => ({auth}))(SignUpPage);
