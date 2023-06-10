const path = require('path');

module.exports = function override(config, env) {
    config.output.path = path.join(__dirname, './build');

    config.plugins = [
        ...config.plugins,
    ];

    return config;
};
