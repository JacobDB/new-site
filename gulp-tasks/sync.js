// JavaScript Document

// Scripts written by @@author_name @ @@author_company

module.exports = {
    // sync task, set up a browser_sync server, depends on config
    sync(plugins, browsersync) {
        return plugins.browser_sync({
            proxy:  browsersync.proxy,
            port:   browsersync.port,
            open:   browsersync.open,
            notify: browsersync.notify,
        });
    }
};
