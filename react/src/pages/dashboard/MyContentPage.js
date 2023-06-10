import React, {useEffect, useState} from "react";
import {connect} from "react-redux";
import moment from 'moment';
import {Icon} from "@iconify/react/dist/iconify";
import {hexToRgbA} from "../../helpers/Utils";
import API from "../../helpers/Axios";
import {Dropdown} from "react-bootstrap";
import {useTranslation} from "react-i18next";
import {useNavigate} from "react-router-dom";
import tools from "../../helpers/tools.json";
import {type} from "@testing-library/user-event/dist/type";

const MyContentPage = ({common}) => {
    const linkTo = useNavigate();
    const { t } = useTranslation();
    const [tabIndex, setTabIndex] = useState(
        JSON.parse(localStorage.getItem("tabIndex")) || 0
    );

    const [contentWithTools, setContentWithTools] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        localStorage.setItem("tabIndex", JSON.stringify(tabIndex));
    }, [tabIndex]);

    const getContents = () => {
        API.post('auth/contents').then(res => {

            const filteredResponse = res.data.data.filter(item => {
                return tools.some(toolItem => toolItem.tools.some(tool => tool.alt_name === item.type));
            });

            const resultArray = filteredResponse.map(item => {
                const type = item.type;
                const matchingToolItem = tools.find(toolItem => toolItem.tools.some(tool => tool.alt_name === item.type));
                const groupTitle = matchingToolItem.title;
                const tool = matchingToolItem.tools.find(tool => tool.alt_name === item.type);
                const toolIcon = tool.icon_name;
                const toolTitle = tool.title;
                const toolColor = tool.icon_color;
                const content = item.content;
                const id = item.id;
                const created_at = item.created_at;
                const updated_at = item.updated_at;
                return { id, groupTitle, toolIcon, toolTitle, toolColor, type, content, created_at, updated_at };
            });

            const grouped = resultArray.reduce((acc, cur) => {
                const groupKey = cur.groupTitle;
                const group = acc.find(group => group.groupTitle === groupKey);
                if (group) {
                    group.items.push(cur);
                } else {
                    acc.push({ groupTitle: groupKey, items: [cur] });
                }
                return acc;
            }, []);

            setContentWithTools(grouped);
            setIsLoading(false);
        }).catch (error => {

        });
    }

    useEffect(() => {
        setIsLoading(true);
        setTabIndex(0);
        getContents();
    }, [common.currentProject]);

    const deleteContentById = (id) => {
        if (window.confirm(t('Are you sure you want to delete this content?'))) {
            API.post('auth/content/delete', {
                id: id
            }).then(res => {
                getContents()
            }).catch(error => {

            });
        }
    }

    const contentToggle = React.forwardRef(({ children, onClick }, ref) => (
        <button
            ref={ref}
            onClick={(e) => {
                e.preventDefault();
                onClick(e);
            }}
            className="btn btn-outline-secondary d-flex align-items-center justify-content-center p-0 w-40px"
        >
            {children}
        </button>
    ));

    const buildLink = (item) => {
        if(item.type === 'article-composer') {
            return (`/dashboard/tools/article-composer/${item.id}`);
        } else {
            return  `/dashboard/my-content/${item.type}/${item.id}`
        }
    }

    const renderItem = ((item, index) => (
        <div key={index} className="d-flex justify-content-between align-items-center bg-white mb-1 py-3 rounded">
            <div style={{backgroundColor: hexToRgbA(item.toolColor)}} className="w-40px d-flex justify-content-center align-items-center rounded">
                <Icon icon={item.toolIcon} style={{color: item.toolColor}} width="24" />
            </div>
            <div className="flex-grow-1 mx-3 d-flex justify-content-between align-items-center">
                <a
                    onClick={(e) => {
                        linkTo(buildLink(item));
                        e.preventDefault();
                    }}
                    href={buildLink(item)}
                    className="d-flex flex-column flex-grow-1 text-dark text-decoration-none"
                >
                    <span className="fw-bold">{item.content.replace(/(<([^>]+)>)/gi, "").slice(0, 48)}{item.content.replace(/(<([^>]+)>)/gi, "").length > 48 && '...'}</span>
                    <small className="smaller text-muted">{item.toolTitle}</small>
                </a>
                <span className="px-5 content-sub-width d-lg-block d-none">{moment(item.created_at).format('ll')}</span>
                <span className="px-5 content-sub-width d-lg-block d-none">{item.content.split(' ').length} words</span>
            </div>
            <Dropdown align="end" className="fixed-bottom-dropdown">
                <Dropdown.Toggle as={contentToggle}>
                    <Icon icon="ic:outline-more-horiz" width="24"/>
                </Dropdown.Toggle>
                <Dropdown.Menu className="dropdown-menu-tools">
                    <Dropdown.Item
                        className="d-flex align-items-center"
                        onClick={(e) => {
                            linkTo(`/dashboard/my-content/${item.type}/${item.id}`);
                            e.preventDefault();
                        }}
                        href={`/dashboard/my-content/${item.type}/${item.id}`}
                    >
                        <Icon icon="material-symbols:edit-outline" />
                        <span className="ms-2">Edit</span>
                    </Dropdown.Item>
                    <Dropdown.Item
                        className="d-flex align-items-center"
                        onClick={() => {
                            deleteContentById(item.id);
                        }}
                    >
                        <Icon icon="mdi:delete-outline" width="20"/>
                        <span className="ms-2">Delete</span>
                    </Dropdown.Item>
                </Dropdown.Menu>
            </Dropdown>
        </div>
    ));

    return isLoading ? (<div style={{flex: 1, justifyContent: 'center', alignItems: 'center'}} >Loading...</div>) : (
        <>
            <div className="">
                <h1>My Content</h1>
                <p className="text-muted">{t('Find all your articles and any saved content below.')}</p>
            </div>
            {(!contentWithTools || !contentWithTools.length) ? (
                <div className="p-5 text-center">
                    <p>{t('You haven\'t created any automated content yet. Head to the Tools page to start the miracle.')}</p>
                    <a
                        onClick={(e) => {
                            linkTo(`/dashboard/tools`);
                            e.preventDefault();
                        }}
                        href={`/dashboard/tools`}
                        className="btn btn-outline-primary">{t('All tools')}</a>
                </div>
            ): (
                <>
                    <ul className="nav nav-tabs nav-tabs-none-bg mt-3">
                        <li
                            className="nav-item"
                        >
                            <button
                                onClick={() => setTabIndex(0)}
                                className={`nav-link text-dark d-flex align-items-center ${tabIndex === 0 && 'active'}`}
                                aria-current="page"
                            >
                                <span>All</span>
                            </button>
                        </li>
                        {contentWithTools.map((item, index) => (
                            <li
                                key={index+1}
                                className="nav-item"
                            >
                                <button
                                    onClick={() => setTabIndex(index+1)}
                                    className={`nav-link text-dark d-flex align-items-center ${tabIndex === (index+1) && 'active'}`}
                                    aria-current="page"
                                >
                                    <span>{item.groupTitle} ({item.items.length})</span>
                                </button>
                            </li>
                        ))}
                    </ul>
                    <div className="row mt-3 mx-lg-0 mx-1">
                        <div className="d-flex justify-content-between align-items-center">
                            <div className="w-40px"></div>
                            <div className="flex-grow-1 mx-2 d-flex justify-content-between align-items-center">
                                <span className="fw-bold flex-grow-1 text-muted">Name</span>
                                <span className="px-5 content-sub-width text-muted d-lg-block d-none">Created at</span>
                                <span className="px-5 content-sub-width text-muted d-lg-block d-none">Tokens</span>
                            </div>
                            <button className="w-40px btn btn-link"></button>
                        </div>
                        {tabIndex === 0 && contentWithTools.map((group, index) => group.items.map((item, index) => renderItem(item, index)))}
                        {tabIndex !== 0 && typeof contentWithTools[tabIndex-1] !== undefined && contentWithTools[tabIndex-1].items.map((item, index) => renderItem(item, index))}
                    </div>
                </>
            )}
        </>
    )
}

export default connect(({auth, common}) => ({auth, common}))(React.memo(MyContentPage));

