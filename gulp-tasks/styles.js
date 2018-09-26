// JavaScript Document

// Scripts written by __gulp_init__author_name @ __gulp_init__author_company

module.exports = {
    styles(gulp, plugins, ran_tasks, on_error) {
        // task-specific plugins
        const eyeglass  = require("eyeglass");
        const postcss   = require("gulp-postcss");
        const sass      = require("gulp-sass");
        const stylelint = require("gulp-stylelint");

        // function to generate critical CSS
        const generate_critical_css = (css_directory, sitemap = plugins.json.readFileSync("./package.json").templates) => {
            const critical = require("critical");

            console.log("Genearting critical CSS, this may take up to " + ((Object.keys(sitemap).length * 30) / 60) + " minute" + (((Object.keys(sitemap).length * 30) / 60) !== 1 ? "s" : "") + ", go take a coffee break.");

            // create the "critical" directory
            plugins.mkdirp(css_directory + "/critical");

            // loop through all the links
            for (const template in sitemap) {
                // make sure the key isn't a prototype
                if (sitemap.hasOwnProperty(template)) {
                    // generate the critial CSS
                    critical.generate({
                        base:       css_directory + "/critical",
                        dest:       template + ".css",
                        dimensions: [1920, 1080],
                        minify:     true,
                        src:        sitemap[template] + "?disable=critical_css"
                    });
                }
            }
        };

        // lint custom styles
        const lint_styles = (css_directory, file_name = "modern.css", source = [global.settings.paths.src + "/assets/styles/**/*.scss", "!" + global.settings.paths.src + "/assets/styles/vendor/**/*"], extra = [global.settings.paths.src + "/assets/styles/**/*.scss"]) => {
            return gulp.src(source)
                // check if source is newer than destination
                .pipe(plugins.gulpif(!plugins.argv.dist, plugins.newer({dest: css_directory + "/" + file_name, extra})))
                // lint
                .pipe(stylelint({
                    failAfterError: true,
                    reporters: [
                        { formatter: "string", console: true }
                    ],
                    debug: true
                }));
        };

        // process all SCSS in root styles directory
        const process_styles = (css_directory, file_name = "modern.css", source = [global.settings.paths.src + "/assets/styles/*.scss"], extra = [global.settings.paths.src + "/assets/styles/**/*.scss"]) => {
            return gulp.src(source)
                // prevent breaking on error
                .pipe(plugins.plumber({errorHandler: on_error}))
                // check if source is newer than destination
                .pipe(plugins.gulpif(!plugins.argv.dist, plugins.newer({dest: css_directory + "/" + file_name, extra})))
                // initialize sourcemap
                .pipe(plugins.sourcemaps.init())
                // compile SCSS (compress if --dist is passed)
                .pipe(plugins.gulpif(plugins.argv.dist, sass(eyeglass({ includePaths: "./node_modules", outputStyle: "compressed" })), sass(eyeglass({ includePaths: "./node_modules" }))))
                // process post CSS stuff
                .pipe(postcss([require("pixrem"), require("postcss-clearfix"), require("postcss-easing-gradients"), require("postcss-flexibility"), require("postcss-responsive-type")]))
                // write sourcemap (if --dist isn't passed)
                .pipe(plugins.gulpif(!plugins.argv.dist, plugins.sourcemaps.write()))
                // output to compiled directory
                .pipe(gulp.dest(css_directory));
        };

        // styles task, compiles & prefixes SCSS
        return new Promise ((resolve) => {
            // set CSS directory
            const css_directory = plugins.argv.dist ? global.settings.paths.dist + "/assets/styles" : global.settings.paths.dev + "/assets/styles";

            // clean directory if --dist is passed
            if (plugins.argv.dist) {
                plugins.del(css_directory + "/**/*");
            }

            if (plugins.argv.experimental && plugins.argv.experimental.length > 0 && plugins.argv.experimental.includes("critical")) {
                generate_critical_css(css_directory);
            }

            // process all styles
            const linted    = lint_styles(css_directory);
            const processed = process_styles(css_directory);

            // merge both steams back in to one
            return plugins.merge(linted, processed)
                // prevent breaking on error
                .pipe(plugins.plumber({errorHandler: on_error}))
                // notify that task is complete, if not part of default or watch
                .pipe(plugins.gulpif(gulp.seq.indexOf("styles") > gulp.seq.indexOf("default"), plugins.notify({title: "Success!", message: "Styles task complete!", onLast: true})))
                // push task to ran_tasks array
                .on("data", () => {
                    if (ran_tasks.indexOf("styles") < 0) {
                        ran_tasks.push("styles");
                    }
                })
                .on("end", () => {
                    return resolve();
                });
        });
    }
};
