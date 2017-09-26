// JavaScript Document

// Scripts written by @@init_author_name @ @@init_author_company

module.exports = {
    media(gulp, plugins, ran_tasks, on_error) {
        // compress images, copy other media
        const process_media = (media_directory, source = global.settings.paths.src + "/assets/media/**/*") => {
            return gulp.src(source)
                // prevent breaking on error
                .pipe(plugins.plumber({errorHandler: on_error}))
                // check if source is newer than destination
                .pipe(plugins.gulpif(!plugins.argv.dist, plugins.newer(media_directory)))
                // compress images
                .pipe(plugins.imagemin({
                    progressive: true,
                    svgoPlugins: [{cleanupIDs: false, removeViewBox: false}],
                    use:         [plugins.pngquant()]
                }))
                // output to compiled directory
                .pipe(gulp.dest(media_directory));
        };

        // media task, compresses images, copies other media
        return new Promise ((resolve) => {
            // set media directory
            const media_directory = plugins.argv.dist ? global.settings.paths.dist + "/assets/media" : global.settings.paths.dev + "/assets/media";

            // set screenshot directory
            const screenshot_directory = plugins.argv.dist ? global.settings.paths.dist : global.settings.paths.dev;

            // clean directories if --dist is passed
            if (plugins.argv.dist) {
                plugins.del(media_directory + "/**/*");
                plugins.del(screenshot_directory + "/screenshot.png");
            }

            // process all media
            const media      = process_media(media_directory, global.settings.paths.src + "/assets/media/**/*");
            const screenshot = process_media(screenshot_directory, global.settings.paths.src + "/screenshot.png");

            // merge both steams back in to one
            return plugins.merge(media, screenshot)
                // prevent breaking on error
                .pipe(plugins.plumber({errorHandler: on_error}))
                // reload files
                .pipe(plugins.browser_sync.reload({stream: true}))
                // notify that task is complete, if not part of default or watch
                .pipe(plugins.gulpif(gulp.seq.indexOf("media") > gulp.seq.indexOf("default"), plugins.notify({title: "Success!", message: "Media task complete!", onLast: true})))
                // push task to ran_tasks array
                .on("data", () => {
                    if (ran_tasks.indexOf("media") < 0) {
                        ran_tasks.push("media");
                    }
                })
                .on("end", () => {
                    return resolve();
                });
        });
    }
};
