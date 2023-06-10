import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import {Route, Routes, useNavigate} from "react-router-dom";
import { Icon } from '@iconify/react';
import PlansPage from "./dashboard/PlansPage";
import {useTranslation} from "react-i18next";

//        fetch('templates/landing-page.html')

const IndexPage = () => {
    const linkTo = useNavigate();
    const { t } = useTranslation();

    useEffect(() => {
        if(window.EXTENAL_HTML) {
            let container = document.getElementById('html-container');
            fetch('templates/landing-page.html')
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    container.addEventListener('click', handleLinkClick);
                });

            return () => {
                if (container) {
                    container.removeEventListener('click', handleLinkClick);
                }
            };
        }
    }, []);

    const handleLinkClick = event => {
        const link = event.target.closest('a');
        if (link) {
            event.preventDefault();
            console.log(`Link clicked: ${link.pathname}`);
            linkTo(link.pathname);
        }
    };

    if(window.EXTENAL_HTML) {
        return (
            <>
                <div id="html-container">
                </div>
                <PlansPage/>
            </>
        );
    }

    return (
        <>
            <div className="row mt-5 py-lg-5 ">
                <div className="col-lg-6 col-12 py-lg-5 pe-lg-5 px-3">
                    <small className="text-uppercase text-primary fw-bold">{t('Write better, faster')}</small>
                    <h1 className="mb-3 mt-3 fw-bolder">{t('Generate Content AI')}</h1>
                    <p className="fs-5 text-secondary fw-light">{t('Leverage AI to increase traffic and save valuable time. Effortlessly generate unique, captivating, and top-notch copy, from extensive blog posts to landing pages to digital advertisements, all in mere seconds.')}</p>
                    <div className="d-flex align-items-center mt-5">
                        <a
                            onClick={(e) => {
                                linkTo(`/sign-up`);
                                e.preventDefault();
                            }}
                            href={`sign-up`}
                            className="btn btn-lg btn-primary">{t('Start Writing For Free')}</a>
                        <span className="ms-4 text-secondary fw-light d-lg-block d-none">{t('No credit card required')}</span>
                    </div>
                </div>
                <div className="col-lg-6 col-12 mt-lg-0 mt-5 px-3">
                    <div className="d-flex justify-content-center align-items-center overflow-hidden">
                        <img src="/assets/images/landing-1.png" alt="" className="w-100 rounded-5"/>
                    </div>
                </div>
            </div>
            {/* How its work */}
            <div id="hiw" className="my-5 py-lg-5">
                <div className="mt-5 mb-5 text-center">
                    <small className="text-uppercase text-primary mb-0 fw-bold">{t('Start writing in 3 easy steps')}</small>
                    <h1 className="fw-bolder">{t('How does it work?')}</h1>
                </div>
                <div className="row hiw-cards">
                    <div className="col-md-6 col-lg-4 column">
                        <div className="card gr-1">
                            <div className="txt">
                                <h1 dangerouslySetInnerHTML={{__html:t('Select <br />a writing tool')}}/>
                                <p className="fw-light">{t('Select from many AI writing tools.')}</p>
                            </div>
                            <div className="ico-card">
                                <Icon icon="tabler:tools-off" width="80"/>
                            </div>
                            <span>Step 1</span>
                        </div>
                    </div>
                    <div className="col-md-6 col-lg-4 column">
                        <div className="card gr-2">
                            <div className="txt">
                                <h1 dangerouslySetInnerHTML={{__html:t('Fill in your <br />product details')}}/>
                                <p className="fw-light">{t('Fully detail topic for AI writing.')}</p>
                            </div>
                            <div className="ico-card">
                                <Icon icon="material-symbols:info-outline" width="80"/>
                            </div>
                            <span>Step 2</span>
                        </div>
                    </div>
                    <div className="col-md-6 col-lg-4 column">
                        <div className="card gr-3">
                            <div className="txt">
                                <h1 dangerouslySetInnerHTML={{__html:t('Generate <br />AI content')}}/>
                                <p className="fw-light">{t('Get unique, human-like content.')}</p>
                            </div>
                            <div className="ico-card">
                                <Icon icon="ic:outline-save-as" width="80"/>
                            </div>
                            <span>Step 3</span>
                        </div>
                    </div>
                </div>
            </div>
            {/* Suggestion */}
            <div id="us" className="row mt-5 mb-5 py-5">
                <div className="col-lg-5 col-12">
                    <div className="h-100 d-flex align-items-center px-lg-5 px-2">
                        <div>
                            <h1 className="fw-bolder">{t('What can you generate?')}</h1>
                            <p className="fs-5 fw-light">{t('Our AI has been trained by knowledgeable content writers and conversion specialists, ensuring top-notch performance when generating content for your website or social media.')}</p>
                            <a
                                onClick={(e) => {
                                    linkTo(`/sign-up`);
                                    e.preventDefault();
                                }}
                                href={`sign-up`}
                                className="btn btn-lg btn-primary mt-4">{t('Start Free Trial')}</a>
                        </div>
                    </div>
                </div>
                <div className="col-lg-7 col-12 mt-lg-0 mt-5">
                    <div className="section_our_solution">
                        <div className="row">
                            <div className="col-lg-12 col-md-12 col-sm-12">
                                <div className="our_solution_category">
                                    <div className="solution_cards_box">
                                        <div className="solution_card p-4">
                                            <div className="d-flex align-items-center gap-2 mb-4">
                                                <Icon icon="ic:outline-article" width="40"/>
                                                <Icon icon="icon-park-outline:paragraph-round" width="40"/>
                                            </div>
                                            <div className="solu_title">
                                                <h3>{t('Blog Content')}</h3>
                                            </div>
                                            <div className="solu_description">
                                                <p className="mb-0 fs-5 fw-light">{t('Blog articles are an important part of any website when it comes to generate organic traffic for your business.')}</p>
                                                <button type="button" className="btn btn-link p-0 my-3">
                                                    <Icon icon="material-symbols:arrow-forward-rounded" width="32" className="text-white"/>
                                                </button>
                                            </div>
                                        </div>
                                        <div className="solution_card p-4">
                                            <div className="d-flex align-items-center gap-2 mb-4">
                                                <Icon icon="lucide:instagram" width="40"/>
                                                <Icon icon="jam:facebook-square" width="40"/>
                                                <Icon icon="ri:youtube-line" width="40"/>
                                            </div>
                                            <div className="solu_title">
                                                <h3>{t('Social Media & Ads')}</h3>
                                            </div>
                                            <div className="solu_description">
                                                <p className="mb-0 fs-5 fw-light">{t('Write Facebook or Google ads, Youtube video descriptions or titles')}</p>
                                                <button type="button" className="btn btn-link p-0 my-3">
                                                    <Icon icon="material-symbols:arrow-forward-rounded" width="32" className="text-white"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="solution_cards_box sol_card_top_3">
                                        <div className="solution_card p-4">
                                            <div className="d-flex align-items-center gap-2 mb-4">
                                                <Icon icon="icon-park-outline:seo" width="40"/>
                                                <Icon icon="mdi:link-box-outline" width="40"/>
                                                <Icon icon="material-symbols:screen-search-desktop-outline" width="40"/>
                                            </div>
                                            <div className="solu_title">
                                                <h3>{t('Website Copy & SEO')}</h3>
                                            </div>
                                            <div className="solu_description">
                                                <p className="mb-0 fs-5 fw-light">{t('Missing inspiration for your Landing Page? Generate headlines, subheadlines or meta tags.')}</p>
                                                <button type="button" className="btn btn-link p-0 my-3">
                                                    <Icon icon="material-symbols:arrow-forward-rounded" width="32" className="text-white"/>
                                                </button>
                                            </div>
                                        </div>
                                        <div className="solution_card p-4">
                                            <div className="d-flex align-items-center gap-2 mb-4">
                                                <Icon icon="uil:shop" width="40"/>
                                            </div>
                                            <div className="solu_title">
                                                <h3>{t('eCommerce Copy')}</h3>
                                            </div>
                                            <div className="solu_description">
                                                <p className="mb-0 fs-5 fw-light">{t('Finding Product Names or Product Descriptions can be very time consuming. Leave it to Us so you can focus on your store.')}</p>
                                                <button type="button" className="btn btn-link p-0 my-3">
                                                    <Icon icon="material-symbols:arrow-forward-rounded" width="32" className="text-white"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {/* Write like human */}
            <div id="features" className="mt-5 mb-5 py-lg-5 py-0">
                <div className="text-center mt-5 mb-5">
                    <p className="text-uppercase text-primary fw-bold mb-0">{t('The pinnacle of AI language models')}</p>
                    <h1 className="fw-bolder">{t('Generate unique, human-like copy in a matter of seconds')}</h1>
                </div>
                <div className="row">
                    {[
                        {
                            iconName: 'fluent:brain-circuit-20-filled',
                            title: t('Powered by AI'),
                            description: t('GPT-3 sets a new standard in AI language models with its natural, one-of-a-kind, and imaginative output.')
                        },
                        {
                            iconName: 'ic:outline-display-settings',
                            title: t('Powerful settings'),
                            description: t('"Fine-tune the level of creativity and tone of voice to produce the ideal copy for your business needs.')
                        },
                        {
                            iconName: 'fluent:mobile-optimized-24-regular',
                            title: t('Optimized for conversions'),
                            description: t('Designed with a focus on conversions, writes content that grabs attention and drives results.')
                        },
                        {
                            iconName: 'tabler:tools-off',
                            title: t('50+ Available Tools'),
                            description: t('Generate all types of copy or content in seconds with the ultimate creative writing tool.')
                        },
                        {
                            iconName: 'fluent:text-grammar-wand-24-filled',
                            title: t('Grammar check'),
                            description: t('Don\'t let poor grammar hurt your visitor\'s trust, we can check and rewrite your content.')
                        },
                        {
                            iconName: 'carbon:character-sentence-case',
                            title: t('Sentence rewriter'),
                            description: t('AI understands your sentence and rewrites it in a completely unique and smart way.')
                        }
                    ].map((item, index) => (
                        <div
                            key={index}
                            className="col-lg-4 col-12 mb-4"
                        >
                            <div className="px-2">
                                <div className="card border-0 shadow h-100 p-3 d-flex justify-content-center text-center align-items-center">
                                    <div className="px-3 py-2 bg-light bg-gradient rounded-4 d-flex justify-content-center align-items-center mb-4">
                                        <Icon icon={item.iconName} width="40" className="text-primary"/>
                                    </div>
                                    <h3>{item.title}</h3>
                                    <p>{item.description}</p>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
            <div id="pricing" className="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 className="fw-bolder">{t('Pricing')}</h1>
            </div>
            <PlansPage/>
        </>
    )
}

export default connect(({auth}) => ({auth}))(IndexPage);
