import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import API from "../helpers/Axios";
import {useNavigate, useParams} from "react-router-dom";
import {useTranslation} from "react-i18next";
import moment from 'moment';
import { Icon } from '@iconify/react';

const BlogPage = () => {
    const { slug } = useParams();
    const linkTo = useNavigate();
    const { t, i18n } = useTranslation();
    const [isLoading, setIsLoading] = useState(true);

    const [articles, setArticles] = useState([]);
    const getArticles = () => {
        API.post(`blog`)
            .then(res => {
                setArticles(res.data.posts.data);
                setIsLoading(false);
            }).catch (error => {
            console.log(error);
        });
    }

    useEffect(() => {
        getArticles();
    }, [slug]);

    return isLoading ? (<div style={{flex: 1, justifyContent: 'center', alignItems: 'center'}} >Loading...</div>) : (
        <>
            <div className="container">
                <div className="row">
                    <div className="col-lg-4 col-12">
                        <div className="mt-5 mb-4">
                            <h3>Recent Posts</h3>
                        </div>
                        <ul className="list-unstyled">
                            {articles.map((item, index) => (
                                <li className="d-flex align-items-center mb-3">
                                    <Icon icon="material-symbols:circle" className="text-secondary"/>
                                    <a href="#" className="ms-3 text-secondary text-decoration-none fw-bold">{item.title}</a>
                                </li>
                            ))}
                        </ul>
                        <div className="mt-5 mb-4">
                            <h3>Tags</h3>
                        </div>
                    </div>
                    <div className="col-lg-8 col-12">
                        {articles.map((item, index) => (
                            <div key={index} className="single-blog-item lg-blog-item border-bottom py-5 mb-5">
                                {item.artwork_url && (
                                    <div className="post-feature blog-thumbnail">
                                        <a href={`/blog/${item.alt_name}`}>
                                            <img className="w-100 rounded" src={item.artwork_url} alt="Blog Images"/>
                                        </a>
                                    </div>
                                )}
                                <div className="post-info lg-blog-post-info">
                                    <div className="post-categories my-3">
                                        {item.categories.map((category, cIndex) => (
                                            <a>{category.name}</a>
                                        ))}
                                    </div>

                                    <h3 className="mb-4">
                                        <a className="text-dark text-decoration-none fs-1 fw-bold" href={`/blog/${item.alt_name}`}>{item.title}</a>
                                    </h3>

                                    <div className="d-flex align-items-center gap-3 text-secondary">
                                        <div className="post-author">
                                            {item.user && (
                                                <a className="text-secondary text-decoration-none">
                                                    {item.user.artwork_url && (
                                                        <img className="w-36px rounded-circle" src={item.user.artwork_url} alt=""/>
                                                    )}
                                                    <span className="ms-2">{item.user.name}</span>
                                                </a>
                                            )}
                                        </div>
                                        <div className="d-flex align-items-center">
                                            <Icon icon="uil:calender" width="20"/>
                                            <span className="ms-2">{moment(item.created_at).format('ll')}</span>
                                        </div>
                                        <div className="d-flex align-items-center">
                                            <Icon icon="ic:outline-remove-red-eye" width="20"/>
                                            <span className="ms-2">{item.view_count} views</span>
                                        </div>
                                    </div>
                                    <div className="my-4">
                                        <div
                                            dangerouslySetInnerHTML={{__html: item.short_content}}
                                        />
                                    </div>
                                    <a
                                        href={`/blog/${item.alt_name}`}
                                        className="btn btn-lg btn-primary">{t('Read more')}</a>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </>
    )
}

export default connect(({auth}) => ({auth}))(BlogPage);
