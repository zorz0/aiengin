import React from "react";
import {connect} from "react-redux";
import ToolCard from "../../components/ToolCard";
import {useNavigate} from "react-router-dom";
import {useTranslation} from "react-i18next";
import tools from "../../helpers/tools.json";

const popularTools = [
    tools[0].tools[0],
    tools[0].tools[1],
    tools[0].tools[2],
    tools[0].tools[3],
    tools[0].tools[4],
    tools[1].tools[0],
    tools[1].tools[1],
    tools[1].tools[2],
    tools[1].tools[3],
    tools[2].tools[0],
    tools[2].tools[1],
    tools[2].tools[2],
    tools[3].tools[0],
    tools[3].tools[1],
    tools[3].tools[2],
    tools[3].tools[3],
]

const DashboardPage = ({auth}) => {
    const linkTo = useNavigate();
    const { t, i18n } = useTranslation();

    return (
        <>
            <div className="">
                <h2><span className="fw-bolder">{auth.user.name}</span> <span className="text-secondary"> — Let's make something remarkable today!</span></h2>
            </div>
            <div className="row mt-4 g-lg-4 g-2">
                {[
                    {
                        title: t('Words Generated'),
                        description: `${auth.user.words_generated} words`
                    },
                    {
                        title: t('Items Generated'),
                        description: `${auth.user.items_generated} items`
                    },
                    {
                        title: t('Time Saved'),
                        description: `${(auth.user.words_generated/500).toFixed(0)} hours`
                    },
                    {
                        title: t('Tools Used'),
                        description: `${auth.user.tools_used}/56`
                    }
                ].map((item, index) => (
                    <div key={index} className="col-lg-3 col-6">
                        <div className="h-100 card p-3">
                            <p className="text-muted mb-1 fw-bold">{item.description}</p>
                            <p className="fw-bold mb-0">{item.title}</p>
                        </div>
                    </div>
                ))}
            </div>
            <div className="mt-4 d-flex justify-content-between align-items-center">
                <div>
                    <h2 className="fw-bolder">{t('Most Popular Tools')}</h2>
                    <p className="mb-0">{t('These are the widely used and highly regarded tools. Give them a shot and see for yourself!')}</p>
                </div>
                <button
                    onClick={(e) => {
                        linkTo('/dashboard/tools');
                        e.preventDefault();
                    }}
                    className="btn btn-outline-secondary">{t('All Tools')}</button>
            </div>
            <div className="row mt-4 tools-list g-lg-4 g-3">
                {popularTools.map((item, index) => <ToolCard item={item} key={index}/>)}
            </div>
        </>
    )
}

export default connect(({auth}) => ({auth}))(DashboardPage);
