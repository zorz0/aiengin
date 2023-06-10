import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import {Icon} from "@iconify/react/dist/iconify";
import API from "../../helpers/Axios";
import {useNavigate} from "react-router-dom";
import {useTranslation} from "react-i18next";

const PlansPage = ({auth}) => {
    const linkTo = useNavigate();
    const { t, i18n } = useTranslation();
    const [plans, setPlans] = useState([]);
    const getPlans = () => {
        API.post('plans')
            .then(res => {
                setPlans(res.data);
            }).catch (error => {
            console.log(error);
        });
    }

    useEffect(() => {
        getPlans();
    }, []);


    return (
        <>
            <div className="container px-2">
                <div className="row row-cols-1 row-cols-md-3 mb-3 text-center">
                    {plans.map((item, index) => (
                        <div className="col" key={index} >
                            <div className="card mb-4 rounded-3 shadow-sm">
                                <div className="py-3">
                                    <h4 className="my-0 fw-bolder">{item.title}</h4>
                                </div>
                                <div className="card-body px-5">
                                    <h1 className="card-title pricing-card-title mb-5">{window.CURRENCY_SYMBOL}{item.price}<br/><small className="text-muted fw-light">/{t(`plan_period_${item.plan_period_format.toLowerCase()}`)}</small></h1>
                                    <ul className="list-unstyled mt-3 mb-4">
                                        {item.description.split('\n').map((text, iIndex) => (
                                            <li key={iIndex} className="d-flex align-items-center mb-2">
                                                <Icon icon="material-symbols:check" width="24" className="text-success"/>
                                                <span className="fw-light ms-3">{text}</span>
                                            </li>
                                        ))}
                                    </ul>
                                    <a
                                        onClick={(e) => {
                                            linkTo(auth.isLogged ? `/subscribe/${item.id}` : `/sign-up`);
                                            e.preventDefault();
                                        }}
                                        href={auth.isLogged ? `/subscribe/${item.id}` : `/sign-up`}
                                        type="button" className="w-100 btn btn-lg btn-outline-primary d-flex align-items-center justify-content-center">
                                        <span className="me-2">{t('Upgrade')}</span>
                                        <Icon icon="material-symbols:arrow-forward-rounded" width="24" className="text-secondary"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </>
    )
}

export default connect(({auth}) => ({auth}))(PlansPage);
