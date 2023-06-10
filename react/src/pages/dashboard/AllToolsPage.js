import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import ToolCard from "../../components/ToolCard";
import tools from "../../helpers/tools.json";
import {useTranslation} from "react-i18next";

const AllToolsPage = () => {
    const { t } = useTranslation();
    const [tabIndex, setTabIndex] = useState(
        JSON.parse(localStorage.getItem("toolsTabIndex")) || 0
    );

    useEffect(() => {
        localStorage.setItem("toolsTabIndex", JSON.stringify(tabIndex));
    }, [tabIndex]);

    return (
        <>
            <div className="d-flex align-items-center">
                <h1>All tools</h1>
            </div>
            <ul className="nav nav-tabs nav-tabs-none-bg mt-3">
                {tools.map((item, index) => (
                    <li
                        key={index}
                        className="nav-item"
                    >
                        <button
                            onClick={() => setTabIndex(index)}
                            className={`nav-link text-dark d-flex align-items-center ${tabIndex === index && 'active'}`}
                            aria-current="page"
                        >
                            <span>{item.title} </span>
                            <span className="ms-2 badge rounded-pill fw-light">{item.tools.length}</span></button>
                    </li>
                ))}
            </ul>
            <div className="row mt-4 tools-list g-lg-4 g-3">
                {tools[tabIndex].tools.map((item, index) => <ToolCard item={item} key={index}/>)}
            </div>
        </>
    )
}

export default connect(({auth}) => ({auth}))(React.memo(AllToolsPage));

