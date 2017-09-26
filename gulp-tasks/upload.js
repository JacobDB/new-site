// JavaScript Document

// Scripts written by @@init_author_name @ @@init_author_company

module.exports = {
    // upload changed files
    upload(gulp, plugins, ran_tasks, on_error) {
        // set upload directory
        const upload_directory = plugins.argv.dist ? global.settings.paths.dist : global.settings.paths.dev;

        // create SFTP connection
        const sftp_conn = plugins.sftp({
            host:       global.settings.ftp.host,
            port:       global.settings.ftp.port,
            username:   global.settings.ftp.user,
            password:   global.settings.ftp.pass,
            remotePath: global.settings.ftp.remote,
        });

        // create FTP connection
        const ftp_conn = plugins.ftp.create({
            host:   global.settings.ftp.host,
            port:   global.settings.ftp.port,
            secure: global.settings.ftp.protocol === "ftps" ? true : false,
            user:   global.settings.ftp.user,
            pass:   global.settings.ftp.pass,
            path:   global.settings.ftp.remote,
        });

        return gulp.src(upload_directory + "/**/*")
            // prevent breaking on error
            .pipe(plugins.plumber({errorHandler: on_error}))
            // check if files are newer
            .pipe(plugins.gulpif(!plugins.argv.dist, plugins.newer({dest: global.settings.paths.src, extra: [upload_directory + "/**/*"]})))
            // check if files are newer
            .pipe(plugins.gulpif(global.settings.ftp.protocol !== "sftp", ftp_conn.newer(global.settings.ftp.remote)))
            // upload changed files
            .pipe(plugins.gulpif(global.settings.ftp.protocol !== "sftp", ftp_conn.dest(global.settings.ftp.remote), sftp_conn))
            // prevent breaking on error
            .pipe(plugins.plumber({errorHandler: on_error}))
            // reload files
            .pipe(plugins.browser_sync.reload({stream: true}))
            // notify that task is complete, if not part of default or watch
            .pipe(plugins.notify({title: "Success!", message: "Upload task complete!", onLast: true}));
    }
};
