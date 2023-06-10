import React, {useEffect} from "react";
import {BrowserRouter, Route, Routes, useNavigate} from 'react-router-dom'
import {connect} from "react-redux";
import IndexPage from "../pages/IndexPage";
import UserIndexPage from "../pages/dashboard/UserIndexPage";
import SignUpPage from "../pages/auth/SignUpPage";
import ForgotPasswordPage from "../pages/auth/ForgotPasswordPage";
import SignInPage from "../pages/auth/SignInPage";
import NotFoundPage from "../pages/NotFoundPage";
import API from "../helpers/Axios";
import {store} from "../store/configureStore";
import SubscribePage from "../pages/common/SubscribePage";
import {addWindowClass, removeWindowClass} from "../helpers/Utils";
import ScrollToTop from "../components/ScrollToTop";

const AppNavigator = ({ auth, display }) => {
    useEffect(() => {
        if(auth.isLogged) {
            API.post('auth/user')
                .then(res => {
                    store.dispatch({type: 'UPDATE_USER_INFO', user: res.data});
                    store.dispatch({type: 'UPDATE_TOKENS', tokens: res.data.tokens});
                }).catch (error => {
                store.dispatch({type: 'TOGGLE_AUTH'});
                store.dispatch({type: 'UPDATE_TOKENS', tokens: {}});
                store.dispatch({type: 'UPDATE_ACCESS_TOKEN', accessToken: {}});
                window.location.href = '/';
                console.log(error);
            });
        }
    }, [auth.isLogged]);

    useEffect(() => {
        if(display.darkMode) {
            addWindowClass('dark-theme');
        } else {
            removeWindowClass('dark-theme')
        }
    }, [display.darkMode]);

    return (
        <BrowserRouter>
            <ScrollToTop/>
            <Routes>
                <Route exact path="/*?" element={<IndexPage/>}/>
                <Route exact path="/sign-up" element={<SignUpPage/>}/>
                <Route exact path="/sign-in" element={<SignInPage/>}/>
                <Route exact path="/forgot-password" element={<ForgotPasswordPage/>}/>
                <Route exact path="/subscribe/:id" element={<SubscribePage/>}/>
                {auth.isLogged && (
                    <Route exact path="/dashboard/*" element={<UserIndexPage/>}/>
                )}
                <Route path="*" element={<NotFoundPage />} />
            </Routes>
        </BrowserRouter>
    );
};

export default connect(({auth, display, common}) => ({auth, display, common}))(AppNavigator);
