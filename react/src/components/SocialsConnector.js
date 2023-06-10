import React, {useState, useEffect} from "react";
import {Icon} from "@iconify/react/dist/iconify";
import {useTranslation} from "react-i18next";
import API from "../helpers/Axios";
import {store} from "../store/configureStore";
import {useNavigate} from "react-router-dom";

const SocialsConnector = ({title}) => {
    const { t } = useTranslation();
    const linkTo = useNavigate();

    useEffect(() => {
        function handleMessage(e) {
            console.log(e.data);
            store.dispatch({type: 'UPDATE_ACCESS_TOKEN', accessToken: e.data.token});
            setTimeout(() => {
                API.post('auth/user')
                    .then(res => {
                        store.dispatch({type: 'TOGGLE_AUTH', user: res.data});
                        setTimeout(() => {
                            linkTo(`/dashboard`);
                        }, 100);
                    });
            }, 500);
        }
        window.addEventListener('message', handleMessage);
        return () => {
            window.removeEventListener('message', handleMessage);
        };
    }, []);

    return (
       <>
           {window.FACEBOOK_LOGIN && (
               <button
                   onClick={() => {
                       window.open('/connect/redirect/facebook', "_blank");
                   }}
                   className="btn btn-facebook btn-block d-flex align-items-center justify-content-between" type="button">
                   <Icon icon="ic:baseline-facebook" width="24"/>
                   <div className="flex-grow-1 text-center">{title} Facebook</div>
               </button>
           )}
           {window.FACEBOOK_LOGIN && (
               <button
                   onClick={() => {
                       window.open('/connect/redirect/google', "_blank");
                   }}
                   className="btn btn-google btn-block d-flex align-items-center justify-content-between" type="button">
                   <Icon icon="ant-design:google-circle-filled" width="24"/>
                   <div className="flex-grow-1 text-center">{title} Google</div>
               </button>
           )}
       </>
    )
}

export default SocialsConnector;
