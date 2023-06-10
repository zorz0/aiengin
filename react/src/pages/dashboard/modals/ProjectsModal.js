import React, {forwardRef, useEffect, useImperativeHandle, useRef, useState} from "react";
import {connect} from "react-redux";
import {Icon} from "@iconify/react";
import {Dropdown, Modal} from "react-bootstrap";
import {store} from "../../../store/configureStore";
import API from "../../../helpers/Axios";
import Button from "react-bootstrap/Button";
import {useNavigate} from "react-router-dom";

const ProjectModal = React.forwardRef(({...props }, ref) => {
    const linkTo = useNavigate();
    const [showProjects, setShowProject] = useState(false);
    const [showAddProjectForm, setShowAddProjectForm] = useState(false);
    const [isSubmitting, setIsSubmitting] = useState( false);
    const [projects, setProjects] = useState( []);
    const [projectName, setProjectName] = useState( '');
    const [currentProjectId, setCurrentProjectId] = useState(store.getState().common.currentProject ? store.getState().common.currentProject.id : null);

    useEffect(() => {
        setCurrentProjectId(store.getState().common.currentProject ? store.getState().common.currentProject.id : null);
    }, [store.getState().common.currentProject])

    const createProject = () => {
        if(isSubmitting || !projectName.length) {
            return;
        }
        setProjectName('');
        setShowAddProjectForm(false);
        const data = new FormData();
        data.append('name', projectName)
        API.post('auth/project/create', data)
            .then(res => {
                setIsSubmitting(false);
                fetchProjects();
            }).catch (error => {
            console.log(error.response);
            setIsSubmitting(false);
        });
    }

    const fetchProjects = () => {
        API.post('auth/projects')
            .then(res => {
                setProjects(res.data)
            }).catch (error => {
            console.log(error.response);
        });
    }

    const deleteProject = (projectId, arrayIndex) => {
        var result = window.confirm("Are you sure you want to delete this project? This action will also delete all the work you created within the project.");
        if (result) {
            API.post('auth/project/delete', {
                id: projectId
            }).then(res => {
                setProjects(data => {
                    data.splice(arrayIndex, 1);
                    return [...data];
                });
                setTimeout(() => {
                    if(currentProjectId === projectId) {
                        setCurrentProjectId(null)
                    }
                }, 100)
            });
        }
    }

    useImperativeHandle(ref, () => ({
        setShowProject
    }));

    useEffect(() => {
        fetchProjects();
    }, [])

    return (
        <>
            <Modal
                dialogClassName="modal-projects"
                show={showProjects}
                onHide={() => setShowProject(false)}
                backdrop="static"
                keyboard={true}
                animation={false}
            >
                <Modal.Header closeButton>
                    <div className="d-flex flex-column">
                        <h5 className="mb-1">My Projects</h5>
                        <small className="text-muted">Organize your generated content</small>
                    </div>
                </Modal.Header>
                <Modal.Body
                    className="bg-light"
                >
                    <div className="d-flex align-items-center justify-content-between border-bottom">
                        <button
                            onClick={() => {
                                store.dispatch({type: 'CURRENT_PROJECT_CHANGE', project: null});
                            }}
                            className="p-0 bg-transparent border-0 d-flex align-items-center flex-grow-1 py-3"
                        >
                            <div className="bg-success bg-gradient rounded-circle w-40px d-flex align-items-center justify-content-center">
                                {(!currentProjectId) && (
                                    <Icon icon="material-symbols:check" width="24" className="text-white"/>
                                )}
                                {currentProjectId && (
                                    <Icon icon="material-symbols:home-storage-outline" width="24" className="text-white"/>
                                )}
                            </div>
                            <div className="ms-3 d-flex flex-column align-items-start">
                                <span className="fw-bold">Personal Folder</span>
                                <small className="text-muted">Default Project</small>
                            </div>
                        </button>
                    </div>
                    {projects.map((item, index) => (
                        <div
                            key={index}
                            className="d-flex align-items-center justify-content-between border-bottom show-on-hover-parent">
                            <button
                                onClick={() => {
                                    store.dispatch({type: 'CURRENT_PROJECT_CHANGE', project: item});
                                }}
                                className="p-0 bg-transparent border-0 d-flex align-items-center flex-grow-1 py-3"
                            >
                                <div className="bg-info bg-gradient rounded-circle w-40px d-flex align-items-center justify-content-center">
                                    {(!currentProjectId || currentProjectId !== item.id) && (
                                        <span className="text-white fw-bold">{item.name.charAt(0).toUpperCase()}</span>
                                    )}
                                    {currentProjectId && currentProjectId === item.id && (
                                        <Icon icon="material-symbols:check" width="24" className="text-white"/>
                                    )}
                                </div>
                                <div className="ms-3 d-grid">
                                    <span className="fw-bold">{item.name}</span>
                                </div>
                            </button>
                            <button
                                onClick={() => deleteProject(item.id, index)}
                                className="btn btn-link p-0 rounded-circle bg-white w-24px d-flex align-items-center justify-content-center show-on-hover-child">
                                <Icon icon="ri:close-line" width="16" className=""/>
                            </button>
                        </div>
                    ))}
                </Modal.Body>

                <div className="m-3">
                    {showAddProjectForm && (
                        <div className="input-group">
                            <input
                                onChange={e => setProjectName(e.target.value)}
                                type="text" className="form-control form-control-lg" placeholder="Project name" aria-label="Project name" aria-describedby="button-addon2"/>
                            <button
                                onClick={createProject}
                                className="btn btn-lg btn-primary" type="button" id="button-addon2">Create</button>
                        </div>
                    )}
                    {!showAddProjectForm && (
                        <button
                            onClick={() => setShowAddProjectForm(true)}
                            className="btn btn-primary btn-lg d-flex align-items-center justify-content-center w-100">
                            <Icon icon="mdi:plus-circle-outline" />
                            <span className="ms-2">Create Project</span>
                        </button>
                    )}
                </div>
            </Modal>
        </>
    )
});

export default ProjectModal;
