import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import Form from "react-bootstrap/Form";
import {Icon} from "@iconify/react";
import {useNavigate, useParams} from "react-router-dom";
import API from "../../helpers/Axios";
import {store} from "../../store/configureStore";
import {useTranslation} from "react-i18next";
import axios from "axios";
const GLOBAL = require('../../config/Global');

const SubscribePage = ({auth}) => {
    const { id } = useParams();
    const linkTo = useNavigate();
    const [isSubmitting, setIsSubmitting] = useState( false);
    const [validated, setValidated] = useState(false);
    const [plan, setPlan] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const { t, i18n } = useTranslation();
    const [isPaying, setIsPaying] = useState(false);

    useEffect(() => {
        function handleMessage(e) {
            setIsPaying(false);
            API.post('auth/user')
                .then(res => {
                    store.dispatch({type: 'UPDATE_USER_INFO', user: res.data});
                    setTimeout(() => {
                        linkTo(`/dashboard`);
                    }, 100);
                });
        }
        window.addEventListener('message', handleMessage);
        return () => {
            window.removeEventListener('message', handleMessage);
        };
    }, []);

    const handleSubmit = (event) => {
        if(isSubmitting) {
            event.preventDefault();
            return
        }
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        setValidated(true);

        const data = new FormData(event.target);
        setIsSubmitting(true);
        API.post('auth/login', data)
            .then(res => {
                setIsSubmitting(false);
                store.dispatch({type: 'UPDATE_ACCESS_TOKEN', accessToken: res.data.access_token});
                setTimeout(() => {
                    API.post('auth/user')
                        .then(res => {
                            store.dispatch({type: 'TOGGLE_AUTH', user: res.data});
                            setTimeout(() => {
                                linkTo(`/dashboard`);
                            }, 100);
                        });
                }, 100);
            }).catch (error => {
            console.log(error.response);
            setIsSubmitting(false);
        });
        event.preventDefault();
    };

    const [payments, setPayments] = useState(null);

    const getAvailablePayments = () => {
        axios.post(GLOBAL.API_URL.replace('/api', '') + '/available-payments', {
            'api-token': auth.accessToken
        }).then(function (res) {
            setPayments(res.data);
        }).catch(function (error) {
            console.log(error);
        });
    }

    const getPlanById = () => {
        API.post(`/plan/${id}`)
            .then(res => {
                setPlan(res.data);
                setIsLoading(false);
            }).catch (error => {
            console.log(error);
        });
    }

    useEffect(() => {
        getAvailablePayments();
        getPlanById();
    }, []);

    return isLoading ? (
        <div className="w-100 vh-100 d-flex justify-content-center align-items-center">
            <div className="spinner-border ms-2" role="status">
                <span className="visually-hidden">Loading...</span>
            </div>
        </div>
    ) : (
        <main className="bg-light d-flex justify-content-center align-items-center min-vh-100">
            <div className="container py-5">
                <div className="row bg-white rounded overflow-hidden">
                    <div className="col-lg-5 col-12 p-3 p-lg-5">
                        <button className="btn btn-link px-0" onClick={() =>  linkTo(-1)}>
                            <Icon icon="material-symbols:arrow-back-rounded" width="24" className="text-secondary"/>
                        </button>
                        <h2 className="mb-4">{plan.title}</h2>
                        <hr className="my-4"/>
                        {auth.isLogged && (
                            <p className="mb-1">Your account: {auth.user.email || auth.user.name }</p>
                        )}
                        <p className="">Billing: {plan.plan_period_format === 'M' ? t('Monthly') : t('Yearly')}</p>
                        <div className="d-flex flex-column">
                            <small className="text-secondary mb-0">{t('Total charge:')}</small>
                            <h4 className="fw-bolder mb-0"> {window.CURRENCY_SYMBOL}{plan.price}</h4>
                        </div>
                        <hr />
                        <p className="fw-bold">{t('Choose payment method')}</p>
                        {isPaying && (
                            <div className="d-flex flex-column align-items-center justify-content-center mb-4">
                                <span className="spinner-border" role="status" aria-hidden="true"></span>
                            </div>
                        )}
                        <div className="row g-2">
                            {payments && Object.keys(payments).map((key, index) => (
                                <div className="col-6" key={index}>
                                    <a
                                        onClick={() => {
                                            setIsPaying(true);
                                            window.open(payments[key].subscriptionLink.replace(':id', id) + '?token=' + auth.accessToken, "_blank");
                                        }}
                                        target="_blank"
                                        style={{
                                            backgroundColor: payments[key].buttonColor
                                        }}
                                        className="btn btn-link text-decoration-none text-white d-flex align-items-center border-0 rounded w-100 px-3 py-3">
                                        <div
                                            dangerouslySetInnerHTML={{__html: payments[key].buttonIcon}}
                                        />
                                        <span className="ms-3">{payments[key].name}</span>
                                    </a>

                                </div>
                            ))}
                        </div>
                        <hr className="mb-2"/>
                        <small className="text-secondary"><Icon icon="material-symbols:lock-outline" /> {t('Your data is properly secured. We use SSL encryption and are PCI DSS-compliant')}</small>
                    </div>
                    <div style={{backgroundColor: '#fdb528'}} className="col-lg-7 col-12 d-none d-lg-flex align-items-center justify-content-center overflow-hidden">
                        <figure>
                            <svg fill="#ffffff" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink" viewBox="0 0 470 470" xmlSpace="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" strokeWidth={0} /><g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round" /><g id="SVGRepo_iconCarrier"> <g> <path d="M411.559,202.471c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S415.97,202.471,411.559,202.471z" /> <path d="M75.559,78.471c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S79.97,78.471,75.559,78.471z" /> <path d="M55.559,100.471c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S59.97,100.471,55.559,100.471z" /> <path d="M468.334,194.624v-49.358c0-4.142-3.357-7.5-7.5-7.5h-11.518v-89.32c0-4.142-3.357-7.5-7.5-7.5H277.478V26.407 C277.478,11.846,265.632,0,251.071,0H218.93c-14.561,0-26.407,11.846-26.407,26.407v14.539H9.166c-4.142,0-7.5,3.358-7.5,7.5 v28.526c0,1.837,0.674,3.61,1.895,4.983l5.08,5.714l-5.08,5.714c-1.22,1.373-1.895,3.146-1.895,4.983v46.9 c0,4.142,3.358,7.5,7.5,7.5h11.518v91.778c0,4.142,3.358,7.5,7.5,7.5h171.837h69.96h190.853c4.143,0,7.5-3.358,7.5-7.5v-28.527 c0-1.837-0.674-3.61-1.895-4.983l-5.079-5.713l5.079-5.714C467.66,198.234,468.334,196.461,468.334,194.624z M453.334,191.772 l-7.614,8.565c-2.526,2.842-2.526,7.124,0,9.966l7.614,8.565v18.175H35.684v-84.278h406.05c0.055,0.001,0.111,0.001,0.166,0h11.435 V191.772z M16.666,101.218l7.614-8.565c2.526-2.842,2.526-7.124,0-9.966l-7.614-8.565V55.946h417.65v81.82H16.666V101.218z M218.93,15h32.142c6.289,0,11.406,5.117,11.406,11.407v14.539h-54.955V26.407C207.522,20.117,212.64,15,218.93,15z" /> <path d="M262.478,274.544V455h-54.955V274.544c0-4.142-3.358-7.5-7.5-7.5c-4.143,0.001-7.5,3.358-7.5,7.5V455H119.27 c-4.142,0-7.5,3.358-7.5,7.5s3.358,7.5,7.5,7.5H350.73c4.143,0,7.5-3.358,7.5-7.5s-3.357-7.5-7.5-7.5h-73.253V274.544 c0-4.141-3.356-7.498-7.497-7.5C265.835,267.044,262.478,270.402,262.478,274.544z" /> <path d="M354.183,100.198l-38.574-20c-2.164-1.122-4.74-1.122-6.904,0l-35.122,18.21l-35.124-18.21 c-2.164-1.122-4.74-1.122-6.904,0l-35.123,18.21l-35.129-18.211c-2.164-1.122-4.739-1.122-6.903,0l-38.581,20 c-3.677,1.907-5.113,6.433-3.207,10.11c1.334,2.574,3.953,4.05,6.665,4.05c1.162,0,2.342-0.271,3.445-0.843l35.129-18.211 l35.129,18.211c2.164,1.122,4.74,1.122,6.904,0l35.123-18.21l35.124,18.21c2.164,1.122,4.74,1.122,6.904,0l35.122-18.21 l35.122,18.21c3.678,1.908,8.204,0.472,10.11-3.206C359.295,106.631,357.86,102.105,354.183,100.198z" /> <path d="M354.183,198.247l-38.574-20c-2.164-1.122-4.74-1.122-6.904,0l-35.122,18.21l-35.124-18.21 c-2.164-1.122-4.74-1.122-6.904,0l-35.123,18.21l-35.129-18.211c-2.164-1.122-4.739-1.122-6.903,0l-38.581,20 c-3.677,1.907-5.113,6.433-3.207,10.11c1.334,2.574,3.953,4.05,6.665,4.05c1.162,0,2.342-0.271,3.445-0.843l35.129-18.211 l35.129,18.211c2.164,1.122,4.74,1.122,6.904,0l35.123-18.21l35.124,18.21c2.164,1.122,4.74,1.122,6.904,0l35.122-18.21 l35.122,18.21c3.678,1.907,8.204,0.472,10.11-3.206C359.295,204.68,357.86,200.154,354.183,198.247z" /> </g> </g></svg>
                        </figure>
                    </div>
                </div>
            </div>
        </main>
    )
}

export default connect(({auth}) => ({auth}))(SubscribePage);
