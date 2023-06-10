import React from "react";
import {useNavigate} from "react-router-dom";
import {Icon} from "@iconify/react";
import {hexToRgbA} from "../helpers/Utils";
import {useTranslation} from "react-i18next";

const ToolCard = ({item}) => {
    const linkTo = useNavigate();
    const { t } = useTranslation();

    return (
        <div className="col-lg-3 col-12">
            <a className="text-decoration-none link-dark"
                onClick={(e) => {
                    linkTo(`/dashboard/tools/${item.alt_name}`);
                    e.preventDefault();
                }}
                href={`/dashboard/tools/${item.alt_name}`}
            >
                <div className="h-100 card p-3">
                    <div className="d-flex align-items-center justify-content-between mb-3">
                        <div className="card-tool-icon" style={{backgroundColor: hexToRgbA(item.icon_color)}}>
                            <Icon icon={item.icon_name} style={{color: item.icon_color}} width="24" />
                        </div>
                        <Icon icon="material-symbols:arrow-outward-rounded" className="text-muted" />
                    </div>
                    <p className="fw-bold mb-1">{t(item.title)}</p>
                    <p className="mb-0 text-secondary">{t(item.description)}</p>
                </div>
            </a>
        </div>
    )
}

export default ToolCard;
