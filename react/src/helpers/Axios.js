import axios from 'axios';
import {store, persistor} from '../store/configureStore';

const GLOBAL = require('../config/Global');

const fetchClient = () => {
    const defaultOptions = {
        baseURL: GLOBAL.API_URL,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            crossdomain: true
        }
    };

    let instance = axios.create(defaultOptions);

    instance.interceptors.request.use(
        async (config) => {
            const token = await store.getState().auth.accessToken;
            config.headers.Authorization =  token ? `Bearer ${token}` : '';
            config.headers['Content-Language'] =  store.getState().common.contentLanguage;
            config.headers['Current-Project'] =  store.getState().common.currentProject ? store.getState().common.currentProject.id : null;
            (!process.env.NODE_ENV || process.env.NODE_ENV === 'development') && console.log('fetching', config.baseURL + '/' + instance.getUri(config));
            return config;
        },function (error) {
            (!process.env.NODE_ENV || process.env.NODE_ENV === 'development') && console.log(error);
            return Promise.reject(error);
        }
    );

    return instance;
};

export default fetchClient();
