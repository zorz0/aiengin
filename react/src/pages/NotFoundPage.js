import React from "react";
import {connect} from "react-redux";
import {useNavigate} from "react-router-dom";
import HomePage from "./HomePage";

const IndexPage = ({auth}) => {
    const linkTo = useNavigate();

    return (
        <div className="w-100 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h1>404 Not Found</h1>
            <p className="mb-0">We are not sure what you are looking for.</p>
        </div>
    )
}

export default connect(({auth}) => ({auth}))(IndexPage);
