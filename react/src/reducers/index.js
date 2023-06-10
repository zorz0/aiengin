import {combineReducers} from 'redux';
import auth from './auth';
import display from './display';
import common from './common';

export default combineReducers({
    auth,
    display,
    common,
});
