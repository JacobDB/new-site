// JavaScript Document

// Scripts written by @@init_author_name @ @@init_author_company

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
                        name:    "repository",
                        message: "Project Repository",
                        type:    "input",
                    },
                    {
                        name:    "author_name",
                        message: "Author Name",
                        type:    "input",
                    },
                    {
                        name:    "author_company",
                        message: "Author Company",
                        type:    "input",
                    },
                    {
                        name:    "author_email",
                        message: "Author Email",
                        type:    "input",
                    },
                    {
                        name:    "author_url",
                        message: "Author URL",
                        type:    "input",
                    },
                    {
                        name:    "theme_color",
                        message: "Theme Color",
                        type:    "input",
                        default: "#17AAEC",
                    },
                    {
                        name:    "primary_color",
                        message: "Primary Color",
                        type:    "input",
                        default: "#17AAEC",
                    },
                    {
                        name:    "primary_alt_color",
                        message: "Primary Alt Color",
                        type:    "input",
                        default: "#57CAFF",
                    },
                    {
                        name:    "secondary_color",
                        message: "Secondary Color",
                        type:    "input",
                        default: "#BA3626",
                    },
                    {
                        name:    "secondary_alt_color",
                        message: "Secondary Alt Color",
                        type:    "input",
                        default: "#FF9486",
                    },
                    {
                        name:    "tertiary_color",
                        message: "Tertiary Color",
                        type:    "input",
                        default: "#84B2AA",
                    },
                    {
                        name:    "tertiary_alt_color",
                        message: "Tertiary Alt Color",
                        type:    "input",
                        default: "#CDFBF3",
                    },
                    {
                        name:    "quaternary_color",
                        message: "Quaternary Color",
                        type:    "input",
                        default: "#ECBF4F",
                    },
                    {
                        name:    "quaternary_alt_color",
                        message: "Quaternary Alt Color",
                        type:    "input",
                        default: "#A17300",
                    },
                    {
                        name:    "quinary_color",
                        message: "Quinary Color",
                        type:    "input",
                        default: "#966790",
                    },
                    {
                        name:    "quinary_alt_color",
                        message: "Quinary Alt Color",
                        type:    "input",
                        default: "#7D5678",
                    },
                    {
                        name:    "senary_color",
                        message: "Senary Color",
                        type:    "input",
                        default: "#D2732A",
                    },
                    {
                        name:    "senary_alt_color",
                        message: "Senary Alt Color",
                        type:    "input",
                        default: "#B86425",
                    },
                    {
                        name:    "accent_color",
                        message: "Accent Color",
                        type:    "input",
                        default: "#17AAEC",
                    },
                    {
                        name:    "accent_alt_color",
                        message: "Accent Alt Color",
                        type:    "input",
                        default: "#57CAFF",
                    },
                    {
                        name:    "light_color",
                        message: "Light Color",
                        type:    "input",
                        default: "#FFFFFF",
                    },
                    {
                        name:    "light_alt_color",
                        message: "Light Alt Color",
                        type:    "input",
                        default: "#EEEEEE",
                    },
                    {
                        name:    "dark_color",
                        message: "Dark Color",
                        type:    "input",
                        default: "#000000",
                    },
                    {
                        name:    "dark_alt_color",
                        message: "Dark Alt Color",
                        type:    "input",
                        default: "#111111",
                    },
                    {
                        name:    "foreground_color",
                        message: "Foreground Color",
                        type:    "input",
                        default: "#111111",
                    },
                    {
                        name:    "foreground_alt_color",
                        message: "Foreground Alt Color",
                        type:    "input",
                        default: "#000000",
                    },
                    {
                        name:    "background_color",
                        message: "Background Color",
                        type:    "input",
                        default: "#FFFFFF",
                    },
                    {
                        name:    "background_alt_color",
                        message: "Background Alt Color",
                        type:    "input",
                        default: "#EEEEEE",
                    },
                    {
                        name:    "page_background_color",
                        message: "Page Background Color",
                        type:    "input",
                        default: "#EEEEEE",
                    },
                    {
                        name:    "page_background_alt_color",
                        message: "Page Background Alt Color",
                        type:    "input",
                        default: "#FFFFFF",
                    },
                    {
                        name:    "warning_color",
                        message: "Warning Color",
                        type:    "input",
                        default: "#9F0000",
                    },
                    {
                        name:    "warning_alt_color",
                        message: "Warning Alt Color",
                        type:    "input",
                        default: "#F83636",
                    },
                    {
                        name: "heading_font",
                        message: "Heading Font",
                        type: "input",
                        default: "\"Open Sans\", \"Arial\", \"Helvetica\", sans-serif",
                    },
                    {
                        name: "body_font",
                        message: "Body Font",
                        type: "input",
                        default: "\"Open Sans\", \"Arial\", \"Helvetica\", sans-serif",
                    },
                    {
                        name: "site_width",
                        message: "Site Width",
                        type: "number",
                        default: 1500,
                    },
                    {
                        name: "column_gap",
                        message: "Column Gap",
                        type: "number",
                        default: 30,
                    },
                    {
                        name: "content_padding",
                        message: "Content Padding",
                        type: "number",
                        default: 50,
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
            return gulp.src(["./*", "./gulp-tasks/*", "./src/**/*"], {base: "./"})
                // prevent breaking on error
                .pipe(plugins.plumber({errorHandler: on_error}))
                // check if a file is a binary
                .pipe(plugins.is_binary())
                // skip file if it's a binary
                .pipe(plugins.through.obj((file, enc, next) => {
                    if (file.isBinary()) {
                        next();
                        return;
                    }

                    // go to next file
                    next(null, file);
                }))
                // replace variables with project data
                .pipe(plugins.file_include({
                    prefix:   "@@init_",
                    basepath: "@file",
                    context: {
                        name:                      project_data.name,
                        npm_name:                  project_data.name.toLowerCase().replace(/[^A-Za-z ]/, "").replace(/ /g, "-"),
                        namespace:                 project_data.name.toLowerCase().replace(/[^A-Za-z ]/, "").replace(/ /g, "_"),
                        homepage:                  project_data.homepage,
                        repository:                project_data.repository.replace(/(\.git$)|(\/$)/, ""),
                        author_name:               project_data.author_name,
                        author_company:            project_data.author_company,
                        author_email:              project_data.author_email,
                        author_url:                project_data.author_url,
                        theme_color:               project_data.theme_color,
                        primary_color:             project_data.primary_color,
                        primary_alt_color:         project_data.primary_alt_color,
                        secondary_color:           project_data.secondary_color,
                        secondary_alt_color:       project_data.secondary_alt_color,
                        tertiary_color:            project_data.tertiary_color,
                        tertiary_alt_color:        project_data.tertiary_alt_color,
                        quaternary_color:          project_data.quaternary_color,
                        quaternary_alt_color:      project_data.quaternary_alt_color,
                        quinary_color:             project_data.quinary_color,
                        quinary_alt_color:         project_data.quinary_alt_color,
                        senary_color:              project_data.senary_color,
                        senary_alt_color:          project_data.senary_alt_color,
                        accent_color:              project_data.accent_color,
                        accent_alt_color:          project_data.accent_alt_color,
                        light_color:               project_data.light_color,
                        light_alt_color:           project_data.light_alt_color,
                        dark_color:                project_data.dark_color,
                        dark_alt_color:            project_data.dark_alt_color,
                        foreground_color:          project_data.foreground_color,
                        foreground_alt_color:      project_data.foreground_alt_color,
                        background_color:          project_data.background_color,
                        background_alt_color:      project_data.background_alt_color,
                        page_background_color:     project_data.page_background_color,
                        page_background_alt_color: project_data.page_background_alt_color,
                        warning_color:             project_data.warning_color,
                        warning_alt_color:         project_data.warning_alt_color,
                        heading_font:              project_data.heading_font,
                        body_font:                 project_data.body_font,
                        site_width:                project_data.site_width,
                        column_gap:                project_data.column_gap,
                        content_padding:           project_data.content_padding,
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
