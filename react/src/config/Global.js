module.exports = {
    APP_NAME: 'AIEngine',
    API_URL:  (!process.env.NODE_ENV || process.env.NODE_ENV === 'development') ? 'http://content.test/api' : window.API_URL,
};
