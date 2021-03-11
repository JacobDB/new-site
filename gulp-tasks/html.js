// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

module.exports = {
    html(gulp, plugins, custom_notifier, ran_tasks, on_error) {
        // task-specific plugins
        const MKDIRP   = require("mkdirp");
        const MOMENT   = require("moment");
        const TEMPLATE = require("gulp-template");
        const WP_POT   = require("wp-pot");

        // copy binaries
        const COPY_BINARIES = (html_directory, source = [`${global.settings.paths.src}/**/*`, `!${global.settings.paths.src}{/assets,/assets/**}`, `!${global.settings.paths.src}/**/*.{jpg,png,svg}`]) => {
            return gulp.src(source)
                // prevent breaking on error
                .pipe(plugins.plumber({ errorHandler: on_error }))
                // check if source is newer than destination
                .pipe(plugins.gulpif(!plugins.argv.dist, plugins.newer(html_directory)))
                // check if a file is a binary
                .pipe(plugins.is_binary())
                // skip file if it's not a binary
                .pipe(plugins.through.obj((file, enc, next) => {
                    if (!file.isBinary()) {
                        next();
                        return;
                    }

                    // go to next file
                    next(null, file);
                }))
                // output to compiled directory
                .pipe(gulp.dest(html_directory));
        };

        // copy composer
        const COPY_COMPOSER = (html_directory, source = [`${global.settings.paths.vendor}/**/*`]) => {
            return gulp.src(source)
                // prevent breaking on error
                .pipe(plugins.plumber({ errorHandler: on_error }))
                // check if source is newer than destination
                .pipe(plugins.gulpif(!plugins.argv.dist, plugins.newer(`${html_directory}/functions`)))
                // output to compiled directory
                .pipe(gulp.dest(`${html_directory}/functions`));
        };

        // process HTML
        const PROCESS_HTML = (html_directory, source = [`${global.settings.paths.src}/**/*`, `!${global.settings.paths.src}{/assets,/assets/**}`, `!${global.settings.paths.src}/**/*.{jpg,png,svg}`]) => {
            // read data from package.json
            const JSON_DATA = plugins.json.readFileSync("package.json");

            return gulp.src(source)
                // prevent breaking on error
                .pipe(plugins.plumber({ errorHandler: on_error }))
                // check if source is newer than destination
                .pipe(plugins.gulpif(!plugins.argv.dist, plugins.newer(html_directory)))
                // check if file is a binary
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
                // replace variables
                .pipe(TEMPLATE({
                    name: JSON_DATA.name,
                    pwa_name: JSON_DATA.progressiveWebApp.name,
                    pwa_short_name: JSON_DATA.progressiveWebApp.short_name,
                    pwa_theme_color: JSON_DATA.progressiveWebApp.theme_color,
                    description: JSON_DATA.description,
                    version: JSON_DATA.version,
                    repository: JSON_DATA.repository.url,
                    license: JSON_DATA.license,
                }))
                // output to compiled directory
                .pipe(gulp.dest(html_directory));
        };

        // generate translation file
        const GENERATE_POT = (html_directory, source = `${global.settings.paths.src}/**/*.php`) => {
            const PACKAGE_DATA = plugins.json.readFileSync("package.json");

            MKDIRP(`${html_directory}/languages`).then(() => {
                try {
                    WP_POT({
                        bugReport: PACKAGE_DATA.bugs.url,
                        destFile: `${html_directory}/languages/__gulp_init_namespace__.pot`,
                        domain: "__gulp_init_namespace__",
                        lastTranslator: `${PACKAGE_DATA.author.name} <${PACKAGE_DATA.author.email}>`,
                        package: PACKAGE_DATA.progressiveWebApp.name,
                        relativeTo: global.settings.paths.src,
                        src: source,
                        headers: {
                            "POT-Creation-Date": PACKAGE_DATA.creationDate,
                            "PO-Revision-Date": MOMENT().format("Y-MM-DD HH:mmZ"),
                        },
                    });
                } catch (error) {
                    console.log(error);
                }
            });
        };

        // html task, copies binaries, converts includes & variables in HTML
        return new Promise ((resolve) => {
            // set HTML directory
            const HTML_DIRECTORY = plugins.argv.dist ? global.settings.paths.dist : global.settings.paths.dev;

            // process all non-asset files
            const BINARIES = COPY_BINARIES(HTML_DIRECTORY);
            const COMPOSER = COPY_COMPOSER(HTML_DIRECTORY);
            const HTML     = PROCESS_HTML(HTML_DIRECTORY);

            // merge both steams back in to one
            plugins.merge(BINARIES, COMPOSER, HTML)
                // prevent breaking on error
                .pipe(plugins.plumber({ errorHandler: on_error }))
                // notify that task is complete, if not part of default or watch
                .pipe(plugins.gulpif(plugins.argv._.includes("html"), plugins.notify({
                    appIcon:  plugins.path.resolve("./src/assets/media/logo-favicon.png"),
                    title:    "Success!",
                    message:  "HTML task complete!",
                    notifier: process.env.BURNTTOAST === "true" ? custom_notifier : false,
                    onLast:   true,
                })))
                // push task to ran_tasks array
                .on("data", () => {
                    // generate translation file
                    GENERATE_POT(HTML_DIRECTORY);

                    // mark the task as ran
                    if (!ran_tasks.includes("html")) {
                        ran_tasks.push("html");
                    }
                })
                .on("end", () => {
                    resolve();
                });
        });
    }
};
