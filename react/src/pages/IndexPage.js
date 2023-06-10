import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import {Route, Routes, useNavigate} from "react-router-dom";
import HomePage from "./HomePage";
import {useTranslation} from "react-i18next";
import {Dropdown} from "react-bootstrap";
import i18n from "i18next";
import {store} from "../store/configureStore";
import { Icon } from '@iconify/react';
import API from "../helpers/Axios";
import StaticPage from "./StaticPage";
import BlogPage from "./BlogPage";

const IndexPage = ({auth, display}) => {
    const linkTo = useNavigate();
    const { t } = useTranslation();
    const switchLanguage = (lang) => {
        fetch(`/assets/lang/${lang}.json`)
            .then((response) => response.json())
            .then((data) => {
                i18n.addResourceBundle(lang, 'translation', data);
            }).then(() => {
            i18n.changeLanguage(lang);
            store.dispatch({type: 'SWITCH_LANGUAGE', lang: lang});
        });
    }

    const [pages, setPages] = useState([]);
    useEffect(() => {
        API.post('/pages')
            .then(res => {
                setPages(res.data)
            }).catch (error => {
            console.log(error);
        });
    }, []);

    return (
        <div className="w-100">
            <div className="hero-bg"></div>
            <div className="container py-3">
                <header>
                    <div className="d-flex flex-column flex-md-row align-items-center justify-content-between pb-3 mb-4 border-bottom">
                        <div className="d-flex align-items-center text-dark text-decoration-none">
                            <div className="d-flex align-items-center">
                                <a
                                    onClick={(e) => {
                                        linkTo(`/`);
                                        e.preventDefault();
                                    }}
                                    href={`/`}
                                    className="d-flex align-items-center text-decoration-none text-dark">
                                    <img width="32" height="32" src="/assets/images/logo.png" alt={t('AI Engine')}/>
                                    <span className="fw-bold ms-2">{t('AI Engine')}</span>
                                </a>
                            </div>
                        </div>
                        <nav className="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                            <a className="me-3 py-2 text-dark text-decoration-none" href="/#hiw">{t('How it works')}</a>
                            <a className="me-3 py-2 text-dark text-decoration-none" href="/#us">{t('Use Cases')}</a>
                            <a className="me-3 py-2 text-dark text-decoration-none" href="/#features">{t('Futures')}</a>
                            <a className="py-2 text-dark text-decoration-none" href="/#pricing">{t('Pricing')}</a>
                        </nav>
                        <nav className="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                            {auth.isLogged && (
                                <>
                                    <a
                                        onClick={(e) => {
                                            linkTo(`/dashboard`);
                                            e.preventDefault();
                                        }}
                                        href={`/dashboard`}
                                        className="btn btn-outline-primary"
                                    >{t('my_dashboard')}</a>
                                </>
                            )}
                            {!auth.isLogged && (
                                <>
                                    <a
                                        onClick={(e) => {
                                            linkTo(`/sign-in`);
                                            e.preventDefault();
                                        }}
                                        href={`/sign-in`}
                                        className="me-3 py-2 text-dark text-decoration-none">Login</a>
                                    <a
                                        onClick={(e) => {
                                            linkTo(`/sign-up`);
                                            e.preventDefault();
                                        }}
                                        href={`/sign-up`}
                                        className="btn btn-outline-primary"
                                    >{t('Start free trial')}</a>
                                </>
                            )}
                            <Dropdown
                                className="ms-2"
                            >
                                <Dropdown.Toggle
                                    className="btn-outline-primary bg-transparent border-0"
                                >
                                    <img width="24" height="24" className="rounded" src={`/assets/flags/${display.language}.svg`}/>
                                </Dropdown.Toggle>
                                <Dropdown.Menu>

                                    {[
                                        {
                                            name: 'English',
                                            code: 'en',
                                        },
                                        {
                                            name: 'Portuguese',
                                            code: 'pt',
                                        },
                                        {
                                            name: 'Vietnamese',
                                            code: 'vi',
                                        }
                                    ].map((item, index) => (
                                        <Dropdown.Item
                                            onClick={() => {
                                                switchLanguage(item.code)
                                            }}
                                            key={index}
                                            className="d-flex align-items-center py-2"
                                        >
                                            <img width="24" height="24" className="rounded" src={`/assets/flags/${item.code}.svg`} alt={item.name}/>
                                            <small className="ms-2">{item.name}</small>
                                        </Dropdown.Item>
                                    ))}
                                </Dropdown.Menu>
                            </Dropdown>
                        </nav>
                    </div>
                </header>
                <main>
                    <Routes>
                        <Route exact path="/" element={<HomePage/>}/>
                        <Route exact path="/blog/:slug?" element={<BlogPage/>}/>
                        <Route exact path="/page/:slug" element={<StaticPage/>}/>
                    </Routes>
                </main>
            </div>
            <footer className="footer-color py-lg-5 pt-5 pb-3 bg-dark border-top">
                <div className="container py-2">
                    <div className="px-2">
                        <div className="row">
                            <div className="col-12 col-md">
                                <div className="mb-2">
                                    <a
                                        onClick={(e) => {
                                            linkTo(`/`);
                                            e.preventDefault();
                                        }}
                                        href={`/`}
                                        className="d-flex align-items-center text-decoration-none text-white">
                                        <img width="32" height="32" src="/assets/images/logo.png" alt={t('AI Engine')}/>
                                        <span className="fw-bold ms-2">AI Engine</span>
                                    </a>
                                </div>
                                <small className="d-block mt-4 mb-4" style={{maxWidth: 300}}>{t('company_description')}</small>
                            </div>
                            <div className="col-lg-6 col-12 px-lg-5 px-3">
                                <div className="row mt-lg-0 mt-4">
                                    <div className="col-6 col-md">
                                        <h5 className="text-white mb-4">{t('About')}</h5>
                                        <ul className="list-unstyled text-small">
                                            <li className="mb-2"><a className="link-footer text-decoration-none" href="/#pricing">Pricing</a></li>
                                            <li className="mb-2">
                                                <a
                                                    onClick={(e) => {
                                                        linkTo(`/sign-in`);
                                                        e.preventDefault();
                                                    }}
                                                    href={`sign-in`}
                                                    className="link-footer text-decoration-none">{t('Login')}</a>
                                            </li>
                                            <li className="mb-2">
                                                <a
                                                    onClick={(e) => {
                                                        linkTo(`/sign-up`);
                                                        e.preventDefault();
                                                    }}
                                                    href={`sign-up`}
                                                    className="link-footer text-decoration-none">{t('Sign Up')}</a></li>
                                            <li className="mb-2">
                                                <a
                                                    onClick={(e) => {
                                                        linkTo(`/blog`);
                                                        e.preventDefault();
                                                    }}
                                                    href={`/blog`}
                                                    className="link-footer text-decoration-none">{t('Blog')}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div className="col-6 col-md">
                                        <h5 className="text-white mb-4">{t('Information')}</h5>
                                        <ul className="list-unstyled text-small">
                                            {pages.map((item, index) => (
                                                <li  key={index} className="mb-2">
                                                    <a
                                                        onClick={(e) => {
                                                            linkTo(`/page/${item.alt_name}`);
                                                            e.preventDefault();}
                                                        }
                                                        href={`/page/${item.alt_name}`}
                                                        className="link-footer text-decoration-none"
                                                    >{item.title}</a>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="d-flex align-items-center justify-content-between mt-5">
                            <div>
                                <small className="d-block">© 2023. All licenses belong to AI Engine.</small>
                            </div>
                            <div
                                className="d-flex gap-2"
                            >
                                {[
                                    {
                                        link: t('facebook_page'),
                                        icon: 'ri:facebook-fill'
                                    },
                                    {
                                        link: t('twitter_page'),
                                        icon: 'teenyicons:twitter-solid'
                                    },
                                    {
                                        link: t('linkein_page'),
                                        icon: 'akar-icons:linkedin-v2-fill'
                                    },
                                    {
                                        link: t('tiktok_page'),
                                        icon: 'icon-park-solid:tiktok'
                                    },
                                    {
                                        link: t('instagram_page'),
                                        icon: 'ant-design:instagram-filled'
                                    }
                                ].map((item, index) => (
                                    <a
                                        key={index}
                                        href={item.link}
                                        target="_blank"
                                        className="w-40px rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white">
                                        <Icon icon={item.icon} />
                                    </a>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    )
}

export default connect(({auth, display}) => ({auth, display}))(IndexPage);
