// JavaScript Document

// Scripts written by YOURNAME @ YOURCOMPANY

module.exports = function (gulp, plugins, ran_tasks, on_error) {
    // read data from package.json
    const name           = plugins.json.read("./package.json").get("name");
    const pwa_name       = plugins.json.read("./package.json").get("progressive-web-app.name");
    const pwa_short_name = plugins.json.read("./package.json").get("progressive-web-app.short_name");
    const theme_color    = plugins.json.read("./package.json").get("progressive-web-app.theme_color");
    const description    = plugins.json.read("./package.json").get("description");
    const version        = plugins.json.read("./package.json").get("version");
    const repository     = plugins.json.read("./package.json").get("repository");
    const license        = plugins.json.read("./package.json").get("license");

    // copy binaries
    const copy_binaries = function (html_directory, source = [global.settings.paths.src + "/**/*", "!" + global.settings.paths.src + "{/assets,/assets/**}"]) {
        return gulp.src(source)
            // prevent breaking on error
            .pipe(plugins.plumber({errorHandler: on_error}))
            // check if source is newer than destination
            .pipe(plugins.gulpif(!plugins.argv.dist, plugins.newer(html_directory)))
            // check if a file is a binary
            .pipe(plugins.is_binary())
            // skip file if it's not a binary
            .pipe(plugins.through.obj(function (file, enc, next) {
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

    // process HTML
    const process_html = function (html_directory, source = [global.settings.paths.src + "/**/*", "!" + global.settings.paths.src + "{/assets,/assets/**}"]) {
        return gulp.src(source)
            // prevent breaking on error
            .pipe(plugins.plumber({errorHandler: on_error}))
            // check if source is newer than destination
            .pipe(plugins.gulpif(!plugins.argv.dist, plugins.newer(html_directory)))
            // check if file is a binary
            .pipe(plugins.is_binary())
            // skip file if it's a binary
            .pipe(plugins.through.obj(function (file, enc, next) {
                if (file.isBinary()) {
                    next();
                    return;
                }

                // go to next file
                next(null, file);
            }))
            // replace variables
            .pipe(plugins.file_include({
                prefix:   "@@",
                basepath: "@file",
                context: {
                    name,
                    pwa_name,
                    pwa_short_name,
                    theme_color,
                    description,
                    version,
                    repository,
                    license,
                }
            }))
            // replace icon placeholders
            .pipe(plugins.replace(/(?:<icon )(?=(?:.*?(?:use=(?:"|')(.*?)(?:"|')))?)(?=(?:.*?(?:class=(?:"|')(.*?)(?:"|')))?)(?:.*?)(?: \/)?(?:>)/g, "<i class='icon $2'><svg class='icon_svg' aria-hidden='true'><use xlink:href='#$1' \/><\/svg></i>"))
            // output to compiled directory
            .pipe(gulp.dest(html_directory));
    };

    // html task, copies binaries, converts includes & variables in HTML
    return function () {
        // set HTML directory
        const html_directory = plugins.argv.dist ? global.settings.paths.dist : global.settings.paths.dev;

        // clean directory if --dist is passed
        if (plugins.argv.dist) {
            plugins.del([html_directory + "/**/*", "!" + html_directory + "{/assets,/assets/**}"]);
        }

        // process all non-asset files
        const binaries = copy_binaries(html_directory, [global.settings.paths.src + "/**/*", "!" + global.settings.paths.src + "{/assets,/assets/**}"]);
        const html     = process_html(html_directory, [global.settings.paths.src + "/**/*", "!" + global.settings.paths.src + "{/assets,/assets/**}"]);

        // merge both steams back in to one
        return plugins.merge(binaries, html)
            // prevent breaking on error
            .pipe(plugins.plumber({errorHandler: on_error}))
            // reload files
            .pipe(plugins.browser_sync.reload({stream: true}))
            // notify that task is complete, if not part of default or watch
            .pipe(plugins.gulpif(gulp.seq.indexOf("html") > gulp.seq.indexOf("default"), plugins.notify({title: "Success!", message: "HTML task complete!", onLast: true})))
            // push task to ran_tasks array
            .on("data", function () {
                if (ran_tasks.indexOf("html") < 0) {
                    ran_tasks.push("html");
                }
            });
    };
};
