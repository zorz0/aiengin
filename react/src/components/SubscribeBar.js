import React, {useState, useEffect} from "react";
import {copyText} from "../helpers/Utils";
import {Icon} from "@iconify/react/dist/iconify";
import {useTranslation} from "react-i18next";
import {connect} from "react-redux";
import {useNavigate} from "react-router-dom";

const SubscribeBar = ({ auth }) => {
    const linkTo = useNavigate();
    const { t } = useTranslation();
    const [isDisplayed, setIsDisplayed] = useState(false);
    useEffect(() => {
        if(auth.user.tokens === 0) {
            setIsDisplayed(true)
        }
    }, [auth.user.tokens])

    return isDisplayed && (
        <div className="w-100 d-flex align-items-center justify-content-center py-2 subscribe-bar">
            <small>{t('Subscribe to write more')}</small>
            <Icon icon="ic:outline-arrow-forward" className="mx-2" width="24"/>
            <a
                onClick={(e) => {
                    linkTo(`/dashboard/plans`);
                    e.preventDefault();
                }}
                href={`/dashboard/plans`}
                className="fw-bolder text-decoration-none">{t('Go to Plans')}</a>
        </div>
    )
}

export default connect(({auth}) => ({auth}))(SubscribeBar);
