import React, {useEffect, useRef, useState} from "react";
import {connect} from "react-redux";
import {Route, Routes, useNavigate} from "react-router-dom";
import AllToolsPage from "./AllToolsPage";
import CommonToolPage from "./CommonToolPage";
import DashboardPage from "./DashboardPage";
import ArticleGeneratorPage from "./ArticleGeneratorPage";
import BlogWriterPage from "./BlogWriterPage";
import BlogWriterContentPage from "./BlogWriterContentPage";
import {Icon} from "@iconify/react";
import ContentReframerPage from "./ContentReframerPage";
import {Dropdown} from "react-bootstrap";
import {store} from "../../store/configureStore";
import ProjectModals from "./modals/ProjectsModal";
import BillingPage from "./BillingPage";
import SettingsPage from "./SettingsPage";
import PlansPage from "./PlansPage";
import MyContentPage from "./MyContentPage";
import {hexToRgbA} from "../../helpers/Utils";
import {useTranslation} from "react-i18next";
import MyContentEditPage from "./MyContentEditPage";
import tools from "../../helpers/tools.json";
import UserAvatar from "../../components/UserAvatar";
import SubscribeBar from "../../components/SubscribeBar";
import ImageGeneratorPage from "./ImageGeneratorPage";

const AccountToggle = React.forwardRef(({ children, onClick }, ref) => (
    <button
        ref={ref}
        onClick={(e) => {
            e.preventDefault();
            onClick(e);
        }}
        className="btn border-0 p-0 d-flex align-items-center bg-link"
    >
        {children}
    </button>
));

const CreateContentToggle = React.forwardRef(({ children, onClick }, ref) => (
    <button
        ref={ref}
        onClick={(e) => {
            e.preventDefault();
            onClick(e);
        }}
        className="btn btn-outline-primary d-flex align-items-center"
    >
        {children}
    </button>
));

const UserIndexPage = ({auth, display, common}) => {
    const { t } = useTranslation();
    const linkTo = useNavigate();
    const projectModalRef = useRef(null);
    const [isSideBarShown, setIsSideBarShown] = useState(false);
    const [engineTools, setEngineTools] = useState(tools);

    function searchArrayByToolTitle(array, searchTerm) {
        return array.map(item => ({
            ...item,
            tools: item.tools.filter(tool => tool.title.toLowerCase().includes(searchTerm.toLowerCase()))
        })).filter(item => item.tools.length > 0);
    }

    const sidebarMenu = (title, iconString, link) => {
        return (
            <li className="nav-item">
                <a
                    onClick={(e) => {
                        linkTo(`${link}`);
                        e.preventDefault();
                    }}
                    href={`${link}`}
                    className={`d-flex align-items-center ${pathName === link && 'active'}`} aria-current="page">
                    <Icon icon={iconString} width="24"/>
                    <span className="ms-2">{title}</span>
                </a>
            </li>
        )
    }

    const [pathName, setPathName] = useState('');

    useEffect(() => {
        setIsSideBarShown(false);
        setPathName(window.location.pathname);
    }, [window.location.pathname])

    return (
        <>
            <ProjectModals
                ref={projectModalRef}
            />
            <div className="w-100 min-vh-100 bg-light">
                <header className="dashboard-header w-100 position-sticky border-bottom bg-light">
                    <SubscribeBar/>
                    <div className="w-100 px-lg-5 px-3 py-3">
                        <div className="d-flex flex-md-row align-items-center justify-content-between">
                            <button
                                onClick={() => {
                                    setIsSideBarShown(true)
                                }}
                                className="d-lg-none d-block border-0 bg-transparent">
                                <Icon icon="charm:menu-hamburger" width="32" className="text-secondary"/>
                            </button>
                            <div className="d-lg-flex d-none align-items-center">
                                <a
                                    onClick={(e) => {
                                        linkTo(`/dashboard`);
                                        e.preventDefault();
                                    }}
                                    href={`/dashboard`}
                                    className="d-flex align-items-center text-decoration-none text-dark"
                                >
                                    <img width="32" height="32" src="/assets/images/logo.png" alt={t('AI Engine')}/>
                                    <span className="d-lg-block d-none fw-bolder ms-2">AI Engine</span>
                                </a>
                                <nav className="d-lg-inline-flex d-none ms-5 gap-4">
                                    <a
                                        onClick={(e) => {
                                            linkTo(`/dashboard/plans`);
                                            e.preventDefault();
                                        }}
                                        href={`/dashboard/plans`}
                                        className="me-3 py-2 text-dark text-decoration-none">{t('Plans & Pricing')}</a>
                                </nav>
                            </div>
                            <nav className="d-flex align-content-center gap-3">
                                <Dropdown align="end">
                                    <Dropdown.Toggle as={CreateContentToggle}>
                                        <Icon icon="mdi:plus-box-outline" width="24"/>
                                        <span className="ms-2 d-lg-block d-none">{t('Create Content')}</span>
                                    </Dropdown.Toggle>
                                    <Dropdown.Menu className="dropdown-menu-tools">
                                        <div className="search-wrapper">
                                            <input
                                                className="form-control"
                                                placeholder="Search..."
                                                onChange={(e) => {
                                                    const newArray = searchArrayByToolTitle(tools, e.target.value);
                                                    setEngineTools(prev => ([...newArray]));

                                                }}
                                            />
                                        </div>
                                        {engineTools.map((e) => e.tools.map((item, index) => (
                                            <Dropdown.Item
                                                key={index}
                                                onClick={(e) => {
                                                    linkTo(`/dashboard/tools/${item.alt_name}`);
                                                    e.preventDefault();
                                                }}
                                                href={`/dashboard/tools/${item.alt_name}`}
                                            >
                                                <div key={index} className="d-flex justify-content-between align-items-center">
                                                    <div style={{backgroundColor: hexToRgbA(item.icon_color)}} className="w-36px d-flex justify-content-center align-items-center rounded">
                                                        <Icon icon={item.icon_name} style={{color: item.icon_color}} width="16" />
                                                    </div>
                                                    <small className="flex-grow-1 ms-2 text-wrap">{item.title}</small>
                                                </div>
                                            </Dropdown.Item>
                                        )))}
                                    </Dropdown.Menu>
                                </Dropdown>
                                <Dropdown>
                                    <Dropdown.Toggle as={AccountToggle}>
                                        <div className="rounded-circle overflow-hidden">
                                            <UserAvatar
                                                name={auth.user.name}
                                                url={auth.user.artwork_url}
                                                width="38"
                                            />
                                        </div>
                                    </Dropdown.Toggle>
                                    <Dropdown.Menu>
                                        <div className="d-flex align-items-center px-3 py-2">
                                            <div className="me-2 rounded-circle overflow-hidden">
                                                <UserAvatar
                                                    name={auth.user.name}
                                                    url={auth.user.artwork_url}
                                                    width="38"
                                                />
                                            </div>
                                            <div className="d-flex flex-column">
                                                <small className="text-dark fw-bold">{auth.user.name}</small>
                                                <div className="d-flex align-items-center">
                                                    <Icon icon="material-symbols:token-outline" width="20" className="text-warning"/>
                                                    <span className="text-secondary fw-bold ms-1">{common.tokens}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr className="my-1"/>
                                        {[
                                            {
                                                iconName: 'eos-icons:package-upgrade-outlined',
                                                title: t('Upgrade Account'),
                                                link: '/dashboard/plans'
                                            },
                                            {
                                                iconName: 'material-symbols:credit-card-outline',
                                                title: t('Billing & Plan'),
                                                link: '/dashboard/billing'
                                            },
                                            {
                                                iconName: 'carbon:settings',
                                                title:  t('Settings'),
                                                link: '/dashboard/settings'
                                            },
                                        ].map((item, index) => (
                                            <Dropdown.Item
                                                key={index}
                                                onClick={(e) => {
                                                    linkTo(item.link);
                                                    e.preventDefault();
                                                }}
                                                href={item.link}
                                            >
                                                <div className="d-flex align-items-center my-1">
                                                    <Icon icon={item.iconName} width="24"/>
                                                    <span className="ms-3">{item.title}</span>
                                                </div>
                                            </Dropdown.Item>
                                        ))}
                                        <hr className="my-1"/>
                                        <Dropdown.Item
                                            onClick={(e) => {
                                                linkTo(`/`);
                                                store.dispatch({type: 'UPDATE_ACCESS_TOKEN', accessToken: ''});
                                                store.dispatch({type: 'TOGGLE_AUTH', user: {}});
                                                e.preventDefault();
                                            }}
                                            href="/sign-out"
                                        >
                                            <div className="d-flex align-items-center my-1">
                                                <Icon icon="uil:signout" width="24"/>
                                                <span className="ms-3">{t('Sign out')}</span>
                                            </div>
                                        </Dropdown.Item>
                                    </Dropdown.Menu>
                                </Dropdown>
                            </nav>
                        </div>
                    </div>
                </header>
                <main className="dashboard-main px-lg-5 px-3 pb-5">
                    <div className="d-flex flex-nowrap">
                        <div className={`dashboard-main-sidebar pt-lg-4 ${isSideBarShown && 'm-shown'}`}>
                            <div className="h-100 d-flex flex-column justify-content-between">
                                <div className="d-lg-none d-flex align-items-center justify-content-between mb-4">
                                    <a
                                        onClick={(e) => {
                                            linkTo(`/dashboard`);
                                            e.preventDefault();
                                        }}
                                        href={`/dashboard`}
                                        className="d-flex align-items-center text-decoration-none text-dark">
                                        <svg width="32" height="32" viewBox="0 0 76 76" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink" version="1.1" baseProfile="full" enableBackground="new 0 0 76.00 76.00" xmlSpace="preserve"><g id="SVGRepo_bgCarrier" strokeWidth={0} /><g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round" /><g id="SVGRepo_iconCarrier"> <path fill="#666CFF" fillOpacity={1} strokeWidth="0.2" strokeLinejoin="round" d="M 38,3.16666C 57.2379,3.16666 72.8333,18.7621 72.8333,38C 72.8333,57.2379 57.2379,72.8333 38,72.8333C 18.7621,72.8333 3.16667,57.2379 3.16667,38C 3.16667,18.7621 18.7621,3.16666 38,3.16666 Z M 49.0853,18.9974L 33.2498,18.9974L 20.5833,39.5833L 31.6667,39.5833L 22.1649,60.1667L 47.5,34.8333L 34.8333,34.8333L 49.0853,18.9974 Z M 50.9386,49.6388L 52.1499,53.8188L 55.9926,53.8188L 51.1017,38.289L 46.4428,38.289L 41.6674,53.8188L 45.3246,53.8188L 46.4428,49.6388L 50.9386,49.6388 Z M 46.9552,47.1134L 47.887,43.8527L 48.2568,42.3274L 48.6091,40.8144L 48.6557,40.8144L 49.0343,42.3139L 49.4478,43.8137L 50.4261,47.1134L 46.9552,47.1134 Z " /> </g></svg>
                                        <span className="fw-bolder ms-2">AI Engine</span>
                                    </a>
                                    <button
                                        className="border-0 bg-transparent"
                                        onClick={() => setIsSideBarShown(false)}
                                    >
                                        <Icon icon="ion:close" className="text-secondary" width="28"/>
                                    </button>
                                </div>
                                <div className="d-flex flex-column align-items-center align-items-sm-start pt-2 flex-grow-1">
                                    <div className="d-flex align-items-center justify-content-between w-100 mb-2">
                                        <a
                                            onClick={(e) => {
                                                linkTo(`/dashboard/billing`);
                                                e.preventDefault();
                                            }}
                                            href={`/dashboard/billing`}
                                            className="fw-bold text-decoration-none text-secondary"
                                        >{auth.user.subscription ? auth.user.subscription.service.title : t('Free trial')}</a>
                                        <small><span className="fw-bold">{common.tokens}</span> {t('words left')}</small>
                                    </div>
                                    <div className="progress w-100 progress-sm">
                                        <div className={`progress-bar ${(common.tokens/1500)*100 > 20 ? 'bg-success' : 'bg-danger'}`} role="progressbar" style={{width: `${(common.tokens/1500)*100}%`}} aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    {!auth.user.subscription && (
                                        <a
                                            onClick={(e) => {
                                                linkTo(`/dashboard/plans`);
                                                e.preventDefault();
                                            }}
                                            href={`/dashboard/plans`}
                                            className="w-100 btn btn-outline-primary mt-3"
                                        >
                                            <Icon icon="mingcute:lightning-line" />
                                            <span>{t('Upgrade')}</span>
                                        </a>
                                    )}
                                    <hr />
                                    <ul className="nav nav-pills nav-sidebar flex-column mb-auto w-100">
                                        {sidebarMenu(t('Dashboard'), 'mingcute:dashboard-3-line', '/dashboard')}
                                        {sidebarMenu(t('All tools'), 'tabler:tools', '/dashboard/tools')}
                                        {sidebarMenu(t('My content'), 'material-symbols:folder-copy-outline', '/dashboard/my-content')}
                                        <hr />
                                        {sidebarMenu(t('Article Composer'), 'majesticons:article-line', '/dashboard/tools/article-composer')}
                                        {sidebarMenu(t('Content Rewrite'), 'majesticons:repeat-circle-line', '/dashboard/tools/content-rewrite')}
                                        {sidebarMenu(t('Image Generator'), 'ph:image-square-fill', '/dashboard/tools/image-generator')}
                                        <li className="nav-item">
                                            <a
                                                style={{
                                                    cursor: "pointer"
                                                }}
                                                onClick={() => {
                                                    store.dispatch({type: 'TOGGLE_DARK_MODE'})
                                                }}
                                                className={`d-flex align-items-center`}>
                                                <Icon icon={display.darkMode ? 'ic:outline-light-mode' : 'ic:outline-dark-mode'} width="24"/>
                                                <span className="ms-2">{display.darkMode ? t('Light Mode') : t('Dark Mode')}</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <hr />
                                </div>
                                <div className="card m-lg-3 mb-0">
                                    <button
                                        onClick={() => projectModalRef.current?.setShowProject(true)}
                                        className="p-0 px-3 my-2 border-0 bg-transparent d-flex align-items-center justify-content-between">
                                        <div className="d-flex flex-column align-items-start">
                                            <small className="text-muted text-uppercase smaller">Project</small>
                                            <small className="fw-bold">{common.currentProject ? common.currentProject.name : 'Personal Folder'}</small>
                                        </div>
                                        <Icon icon="uil:sort" width="24" className="text-muted"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div className="dashboard-main-routes pt-4 w-100">
                            <Routes>
                                <Route exact path="/" element={<DashboardPage/>}/>
                                <Route exact path="/billing" element={<BillingPage/>}/>
                                <Route exact path="/settings" element={<SettingsPage/>}/>
                                <Route exact path="/plans" element={<PlansPage/>}/>
                                <Route exact path="/my-content" element={<MyContentPage/>}/>
                                <Route exact path="/my-content/:slug/:id" element={<MyContentEditPage/>}/>
                                <Route exact path="/tools" element={<AllToolsPage/>}/>
                                <Route exact path="/tools/article-composer/:id?" element={<ArticleGeneratorPage/>}/>
                                <Route exact path="/tools/blog-writing-assistant" element={<BlogWriterPage/>}/>
                                <Route exact path="/tools/blog-writing-assistant/content" element={<BlogWriterContentPage/>}/>
                                <Route exact path="/tools/content-rewrite" element={<ContentReframerPage/>}/>
                                <Route exact path="/tools/image-generator" element={<ImageGeneratorPage/>}/>
                                <Route exact path="/tools/:slug" element={<CommonToolPage/>}/>
                            </Routes>
                        </div>
                    </div>
                </main>
            </div>
        </>
    )
}

export default connect(({auth, display, common}) => ({auth, display, common}))(UserIndexPage);
