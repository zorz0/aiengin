import React, {useState} from "react";
import {connect} from "react-redux";
import moment from 'moment';
import {useTranslation} from "react-i18next";
import API from "../../helpers/Axios";
import {store} from "../../store/configureStore";
import {useNavigate} from "react-router-dom";

const ArticleGeneratorPage = ({auth, common}) => {
    const linkTo = useNavigate();
    const { t } = useTranslation();
    const [isCanceling, setIsCanceling] = useState(false);

    const [validated, setValidated] = useState(false);
    const handleSubmit = (event) => {
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }

        setValidated(true);
    };

    const cancelSubscription = () => {
        API.post('auth/user/subscription/cancel')
            .then(res => {
                API.post('auth/user')
                    .then(res => {
                        store.dispatch({type: 'UPDATE_USER_INFO', user: res.data});
                    }).catch (error => {
                    console.log(error);
                });
            }).catch (error => {
            console.log(error);
        });
    }

    return (
        <>
            <div className="container px-lg-3 px-0" style={{maxWidth: 800}}>
                <div className="card p-4">
                    <div className="row">
                        <div className="col-lg-6 col-12">
                            <h5 className="mb-4">{t('Current plan')}</h5>
                            <p className="mb-1 d-flex align-items-center">
                                <span>{t('Your current plan is')}</span>
                                <span className="ms-2 badge bg-secondary">{auth.user.subscription ? auth.user.subscription.service.title : t('Free trial')}</span></p>
                            <p className="text-secondary">{t('A straightforward introduction suitable for anyone.')}</p>
                            <p className="mb-1">{t('Active until')} {auth.user.subscription ? moment(auth.user.subscription.next_billing_date).format('ll') : t('Forever')}</p>
                            <p className="text-secondary">Your trial is good to use until you run out of free token</p>
                        </div>
                        <div className="col-lg-6 col-12">
                            <div className="h-100 d-flex align-items-center">
                                <div className="w-100">
                                    <div className="d-flex align-items-center justify-content-between w-100 mb-2">
                                        <small className="fw-bold">{t('Active until')} {auth.user.subscription ? moment(auth.user.subscription.next_billing_date).format('ll') : t('Forever')}</small>
                                        <small><span className="fw-bold">{auth.user.tokens}</span> {t('words left')}</small>
                                    </div>
                                    <div className="progress w-100 progress-sm">
                                        <div className={`progress-bar ${(common.tokens/1500)*100 > 20 ? 'bg-success' : 'bg-danger'}`} role="progressbar" style={{width: `${(common.tokens/1500)*100}%`}} aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="mt-3">
                        {!auth.user.subscription && (
                            <a
                                onClick={(e) => {
                                    linkTo(`/dashboard/plans`);
                                    e.preventDefault();
                                }}
                                href={`/dashboard/plans`}
                                className="btn btn-primary text-uppercase">{t('Upgrade Plan')}</a>

                        )}
                        {auth.user.subscription && !isCanceling && (
                            <button
                                onClick={() => setIsCanceling(true)}
                                className="btn btn-outline-danger text-uppercase">{t('Cancel Subscription')}</button>
                        )}
                        {auth.user.subscription && isCanceling && (
                            <div className="alert alert-warning">
                                <p>{t('cancel_subscription_confirm')}</p>
                                <div className="d-flex gap-3">
                                    <button
                                        onClick={cancelSubscription}
                                        className="btn btn-danger">{t('Confirm to cancel')}</button>
                                    <button
                                        onClick={() => setIsCanceling(false)}
                                        className="btn btn-success">{t('No take me back')}</button>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </>
    )
}

export default connect(({auth, common}) => ({auth, common}))(ArticleGeneratorPage);
