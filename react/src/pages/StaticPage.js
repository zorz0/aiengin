import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import API from "../helpers/Axios";
import {useNavigate, useParams} from "react-router-dom";
import {useTranslation} from "react-i18next";
import moment from 'moment';

const StaticPage = () => {
    const { slug } = useParams();
    const linkTo = useNavigate();
    const { t, i18n } = useTranslation();
    const [isLoading, setIsLoading] = useState(true);

    const [page, setPage] = useState([]);
    const getPage = () => {
        API.post(`page/${slug}`)
            .then(res => {
                setPage(res.data);
                setIsLoading(false);
            }).catch (error => {
            console.log(error);
        });
    }

    useEffect(() => {
        setIsLoading(true);
        getPage();
    }, [slug]);

    return isLoading ? (<div style={{flex: 1, justifyContent: 'center', alignItems: 'center'}} >Loading...</div>) : (
        <>
            <div className="container px-lg-3 px-0">
                <div className="card">
                    <div className="position-relative">
                        <div className="card-body p-5 bg-info bg-opacity-50">
                            <div className="text-center">
                                <h3 className="fw-semibold">{page.title}</h3>
                                <p className="mb-0 text-secondary">Last update: {moment(page.created_at).format('ll')}</p>
                            </div>
                        </div>
                        <div className="shape">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlnsXlink="http://www.w3.org/1999/xlink" width={'100%'} height={60} preserveAspectRatio="none" viewBox="0 0 1440 60">
                                <g mask="url(&quot;#SvgjsMask1001&quot;)">
                                    <path d="M 0,4 C 144,13 432,48 720,49 C 1008,50 1296,17 1440,9L1440 60L0 60z"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div className="position-relative">
                        <div className="p-4">
                            <div
                                dangerouslySetInnerHTML={{__html: page.content}}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default connect(({auth}) => ({auth}))(StaticPage);
