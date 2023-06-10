import React, {useState} from "react";
import {connect} from "react-redux";
import Row from "react-bootstrap/Row";
import Form from "react-bootstrap/Form";
import Col from "react-bootstrap/Col";
import LanguagesForm from "../../components/LanguagesForm";
import {Icon} from "@iconify/react";
import {useNavigate} from "react-router-dom";
import {useTranslation} from "react-i18next";


const ForgotPasswordPage = () => {
    const linkTo = useNavigate();
    const { t } = useTranslation();

    const [validated, setValidated] = useState(false);

    const handleSubmit = (event) => {
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }

        setValidated(true);
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
                    <div className="auth-form p-3 p-lg-5">
                        <h2>{t('Reset your password')}</h2>
                        <Form noValidate validated={validated} onSubmit={handleSubmit}>
                            <Form.Group className="mb-3">
                                <Form.Label>Email</Form.Label>
                                <Form.Control
                                    className="form-control"
                                    required
                                    type="email"
                                    placeholder="Your Email"
                                    defaultValue=""
                                />
                            </Form.Group>
                            <button className="w-100 btn btn-primary">Send me reset code</button>
                        </Form>
                        <a onClick={(e) => {linkTo(`/sign-in`);e.preventDefault();}} href={`/sign-in`} className="mt-3 w-100 btn btn-outline-secondary">Go back login</a>
                    </div>
                </div>
            </div>
        </main>
    )
}

export default connect(({auth}) => ({auth}))(ForgotPasswordPage);
