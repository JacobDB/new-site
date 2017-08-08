// JavaScript Document

// Scripts written by YOURNAME @ YOURCOMPANY

module.exports = {
    init(gulp, plugins, on_error) {
        let project_data = {};

        // gather project data
        const get_project_data = (callback) => {
            return gulp.src("./gulpfile.js")
                // prevent breaking on error
                .pipe(plugins.plumber({errorHandler: on_error}))
                // prompt for project data
                .pipe(plugins.prompt.prompt([
                    {
                        name:    "name",
                        message: "Project Name",
                        type:    "input",
                    },
                    {
                        name:    "homepage",
                        message: "Project URL",
                        type:    "input",
                    },
                    {
                        name: "repository",
                        message: "Project Repository",
                        type:    "input",
                    },
                    {
                        name: "author_name",
                        message: "Author Name",
                        type:    "input",
                    },
                    {
                        name: "author_company",
                        message: "Author Company",
                        type:    "input",
                    },
                    {
                        name: "author_email",
                        message: "Author Email",
                        type:    "input",
                    },
                    {
                        name: "author_url",
                        message: "Author URL",
                        type:    "input",
                    },
                ], (res) => {
                    // store the project data
                    project_data = res;
                })).on("end", () => {
                    // return the callback
                    if (typeof callback === "function") {
                        return callback();
                    }
                });
        };

        // write project data
        const write_project_data = (callback) => {
            return gulp.src("./package.json")
                // replace variables with project data
                .pipe(plugins.file_include({
                    prefix:   "@@",
                    basepath: "@file",
                    context: {
                        name:           project_data.name,
                        homepage:       project_data.homepage,
                        repository:     project_data.repository,
                        author_name:    project_data.author_name,
                        author_company: project_data.author_company,
                        author_email:   project_data.author_email,
                        author_url:     project_data.author_url,
                    }
                }))
                // write the file
                .pipe(gulp.dest("./")).on("end", () => {
                    // return the callback
                    if (typeof callback === "function") {
                        return callback();
                    }
                });
        };

        return new Promise ((resolve) => {
            get_project_data(() => {
                write_project_data(() => {
                    return resolve();
                });
            });
        });
    }
};
