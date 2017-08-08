// JavaScript Document

// Scripts written by @@author_name @ @@author_name

module.exports = {
    // config task, generate configuration file for uploads & BrowserSync and prompt dev for input
    config(gulp, plugins, requested = "") {
        // generate config.json and start other functions
        const generate_config = (file_name, mode = "ftp", callback) => {
            const data_source = {
                bs:   "https://gist.githubusercontent.com/JacobDB/63852a9ad21207ed195aa1fd75bfeeb8/raw/7d011d22bef966f06d0c8b84d50891419738ac8b/.bsconfig",
                ftp:  "https://gist.githubusercontent.com/JacobDB/b41b59c11f10e6b5e4fe5bc4ab40d805/raw/0f408964b8f3c77ed0ae452ab3d2ba2c130e1acd/.ftpconfig",
                sftp: "https://gist.githubusercontent.com/JacobDB/cad97b5c4e947b40e3b54c6022fec887/raw/4829ebdc5d45cea7dce8cc3109a05501b159f992/.ftpconfig",
            };

            if (typeof file_name !== "undefined") {
                return plugins.fs.stat(file_name, (err) => {
                    if (err !== null) {
                        let gist_url  = "";

                        if (file_name === ".bsconfig") {
                            gist_url = data_source.bs;
                        } else if (file_name === ".ftpconfig") {
                            if (mode === "sftp") {
                                gist_url = data_source.sftp;
                            } else {
                                gist_url = data_source.ftp;
                            }
                        }

                        if (gist_url !== "") {
                            plugins.request.get(gist_url, function (error, response, body) {
                                if (!error && response.statusCode == 200) {
                                    const json_data = body;

                                    plugins.fs.writeFile(file_name, json_data, "utf8", () => {
                                        if (typeof callback === "function") {
                                            return callback();
                                        }
                                    });
                                } else if (typeof callback === "function") {
                                    return callback();
                                }
                            });
                        } else if (typeof callback === "function") {
                            return callback();
                        }
                    } else if (typeof callback === "function") {
                        return callback();
                    }
                });
            } else if (typeof callback === "function") {
                return callback();
            }
        };

        // configue JSON data
        const configure_json = (file_name, namespace, options, callback) => {
            const prompts    = [];
            const configured = plugins.json.readFileSync(file_name).configured;

            // construct the prompts
            Object.keys(options).forEach(option => {
                const properties = options[option];

                // construct the prompt
                const prompt     = {
                    name:    option,
                    message: namespace + " " + option + ": ",
                };

                // construct the prompt
                Object.keys(properties).forEach(property => {
                    prompt[property] = properties[property];
                });

                // check if the setting has no value or is explicitly requested
                if ((requested !== "" && requested === namespace && (global.settings[namespace][option] === "" || configured === false)) || gulp.seq.indexOf("config") >= 0 && (global.settings[namespace][option] === "" || plugins.argv[namespace] || configured === false)) {
                    prompts.push(prompt);
                }
            });

            if (prompts.length > 0) {
                // prompt the user
                gulp.src(file_name)
                    .pipe(plugins.prompt.prompt(prompts, (res) => {
                        // read the file to retrieve the JSON data
                        const json_data = plugins.json.readFileSync(file_name);

                        // update options in JSON data
                        Object.keys(options).forEach(key => {
                            // turn stringy true/false values in to booleans
                            const value = res[key] === "true" ? true : (res[key] === "false" ? false : res[key]);

                            // update the data
                            json_data[key] = value;

                            // store the updated data in the global settings
                            global.settings[namespace][key] = value;
                        });

                        // update file with new JSON data
                        plugins.json.writeFileSync(file_name, json_data);
                    })).on("end", () => {
                        // read the file to retrieve the JSON data
                        const json_data = plugins.json.readFileSync(file_name);

                        // mark as configured
                        json_data["configured"] = true;

                        // update file with new JSON data
                        plugins.json.writeFileSync(file_name, json_data);

                        if (typeof callback === "function") {
                            return callback();
                        }
                    });
            } else if (typeof callback === "function") {
                return callback();
            }
        };

        return new Promise ((resolve) => {
            // generate .bsconfig
            generate_config(".bsconfig", "", () => {
                const browsersync_config = plugins.json.readFileSync(".bsconfig");

                // read browsersync settings from config.json
                global.settings.browsersync.proxy  = browsersync_config.proxy;
                global.settings.browsersync.port   = browsersync_config.port;
                global.settings.browsersync.open   = browsersync_config.open;
                global.settings.browsersync.notify = browsersync_config.notify;

                configure_json(".bsconfig", "browsersync", {
                    proxy: {
                        default: global.settings.browsersync.proxy === "" ? "localhost" : global.settings.browsersync.proxy,
                        type:    "input",
                    },
                    port: {
                        default: global.settings.browsersync.port === "" ? "8080" : global.settings.browsersync.port,
                        type:    "input",
                    },
                    open: {
                        default: global.settings.browsersync.open === "local" ? 1 : (global.settings.browsersync.open === "external" ? 2 : (global.settings.browsersync.open === "ui" ? 3 : (global.settings.browsersync.open === "ui-external" ? 4 : (global.settings.browsersync.open === "tunnel" ? 5 : (global.settings.browsersync.open === "false" ? 6 : 0))))),
                        type:    "list",
                        choices: ["true", "local", "external", "ui", "ui-external", "tunnel", "false"],
                    },
                    notify: {
                        default: global.settings.browsersync.notify === true ? 0 : 1,
                        type:    "list",
                        choices: ["true", "false"],
                    },
                }, () => {
                    generate_config(".ftpconfig", (plugins.argv["sftp"] ? "sftp" : (plugins.argv["ftps"] ? "ftps" : "ftp")), () => {
                        const ftp_config = plugins.json.readFileSync(".ftpconfig");

                        // read browsersync settings from config.json
                        global.settings.ftp.protocol = ftp_config.protocol !== "sftp" && ftp_config.secure === true ? "ftps" : ftp_config.protocol;
                        global.settings.ftp.host     = ftp_config.host;
                        global.settings.ftp.port     = ftp_config.port;
                        global.settings.ftp.user     = ftp_config.user;
                        global.settings.ftp.pass     = ftp_config.pass;
                        global.settings.ftp.remote   = ftp_config.remote;

                        configure_json(".ftpconfig", "ftp", {
                            protocol: {
                                default: global.settings.ftp.protocol === "sftp" ? 1 : 0,
                                type:    "list",
                                choices: ["ftp", "sftp"],
                            },
                            host: {
                                default: global.settings.ftp.host === "" ? "" : global.settings.ftp.host,
                                type:    "input",
                            },
                            port: {
                                default: global.settings.ftp.port === "" ? "" : global.settings.ftp.port,
                                type:    "input",
                            },
                            user: {
                                default: global.settings.ftp.user === "" ? "" : global.settings.ftp.user,
                                type:    "input",
                            },
                            pass: {
                                default: global.settings.ftp.pass === "" ? "" : global.settings.ftp.pass,
                                type:    "password",
                            },
                            remote: {
                                default: global.settings.ftp.remote === "" ? "" : global.settings.ftp.remote,
                                type:    "input",
                            }
                        }, () => {
                            // resolve the promise
                            return resolve();
                        });
                    });
                });
            });
        });
    }
};
