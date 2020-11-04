<?php
/* ------------------------------------------------------------------------ *\
 * Functions: Styles & Scripts
\* ------------------------------------------------------------------------ */

/**
 * Enqueue styles & scripts
 *
 * @return void
 */
function __gulp_init_namespace___enqueue_scripts(): void {
    /* styles */

    // Google fonts
    wp_register_style("__gulp_init_namespace__-google-fonts", "https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic&display=swap");

    // modern styles
    wp_register_style("__gulp_init_namespace__-styles-modern", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/styles/modern.*.css", true)), ["__gulp_init_namespace__-google-fonts"], "<%= version %>");

    // legacy styles
    wp_register_style("__gulp_init_namespace__-styles-legacy", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/styles/legacy.*.css", true)), ["__gulp_init_namespace__-styles-modern"], "<%= version %>");

    // print styles
    wp_register_style("__gulp_init_namespace__-styles-print", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/styles/print.*.css", true)), ["__gulp_init_namespace__-styles-modern"], "<%= version %>", "print");

    /* scripts */

    // FontAwesome scripts
    wp_register_script("__gulp_init_namespace__-scripts-fontawesome", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/scripts/fontawesome.*.js", true)), [], "<%= version %>");

    // modern scripts
    wp_register_script("__gulp_init_namespace__-scripts-modern", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/scripts/modern.*.js", true)), [], "<%= version %>", true);

    // legacy scripts
    wp_register_script("__gulp_init_namespace__-scripts-legacy", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/scripts/legacy.*.js", true)), [], "<%= version %>", true);

    // dummy hook for inline scripts in the footer
    wp_register_script("__gulp_init_namespace__-scripts-footer-hook", "", [], "", true);

    // Service Worker
    $service_worker_uri = get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/scripts/service-worker.js", true));
    wp_add_inline_script("__gulp_init_namespace__-scripts-modern", "
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('{$service_worker_uri}', { scope: '/' }).then(function (registration) {
                    // attempt to update the service worker
                    registration.update();
                });
            });
        }
    ");

    /* localize scripts */

    $l10n = [
        "noty" => [
            "offline" => [
                "text" => __("You appear to be offline right now. Some parts of this site may be unavailable until you come back online.", "__gulp_init_namespace__"),
            ],
        ],
    ];

    wp_localize_script("__gulp_init_namespace__-scripts-modern", "l10n", $l10n);
    wp_localize_script("__gulp_init_namespace__-scripts-legacy", "l10n", $l10n);

    /* enqueue everything */

    wp_enqueue_style("__gulp_init_namespace__-styles-modern");
    wp_enqueue_style("__gulp_init_namespace__-styles-print");

    wp_enqueue_script("__gulp_init_namespace__-scripts-footer-hook");
    wp_enqueue_script("__gulp_init_namespace__-scripts-fontawesome");
    wp_enqueue_script("__gulp_init_namespace__-scripts-modern");

    /* only load legacy stuff in IE */

    if (__gulp_init_namespace___is_ie()) {
        wp_enqueue_style("__gulp_init_namespace__-styles-legacy");
        wp_enqueue_script("__gulp_init_namespace__-scripts-legacy");
    }
}
add_action("wp_enqueue_scripts", "__gulp_init_namespace___enqueue_scripts");

/**
 * Add noscript tag to the head to hide elements with the .__js class if script isn't enabled
 *
 * @return void
 */
function __gulp_init_namespace___noscript_hide_js_elements(): void {
    echo "<noscript><style>.__js {display: none !important;}</style></noscript>\n";
}
add_action("wp_footer", "__gulp_init_namespace___noscript_hide_js_elements");

/**
 * Adjust WordPress login screen styles
 *
 * @return void
 */
function __gulp_init_namespace___enqueue_scripts_login(): void {
    wp_enqueue_style("__gulp_init_namespace__-styles-login", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/styles/wp-login.*.css", true)), [], "<%= version %>");
}
add_action("login_enqueue_scripts", "__gulp_init_namespace___enqueue_scripts_login");

/**
 * Add wp-admin styles & scripts
 *
 * @return void
 */
function __gulp_init_namespace___enqueue_scripts_admin(): void {
    wp_enqueue_style("__gulp_init_namespace__-styles-wp-admin", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/styles/wp-admin.*.css", true)), [], "<%= version %>");
    wp_enqueue_script("__gulp_init_namespace__-scripts-wp-admin", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/scripts/wp-admin.*.js", true)), [], "<%= version %>", true);
}
add_action("admin_enqueue_scripts", "__gulp_init_namespace___enqueue_scripts_admin");

/**
 * Add BrowserSync script to the footer when active
 *
 * @return void
 */
function __gulp_init_namespace___simplify_browsersync(): void {
    $browsersync_port    = isset($_SERVER["HTTP_X_BROWSERSYNC_PORT"]) ? $_SERVER["HTTP_X_BROWSERSYNC_PORT"] : false;
    $browsersync_version = isset($_SERVER["HTTP_X_BROWSERSYNC_VERSION"]) ? $_SERVER["HTTP_X_BROWSERSYNC_VERSION"] : false;

    if ($browsersync_port && $browsersync_version) {
        $server_protocol = stripos($_SERVER["SERVER_PROTOCOL"], "https") === true ? "https://" : "http://"; ?>
        <script id="__bs_script__">
            //<![CDATA[
                document.write("<script async src='<?php echo $server_protocol; ?>HOST:<?php echo $browsersync_port; ?>/browser-sync/browser-sync-client.js?v=<?php echo $browsersync_version; ?>'><\/script>".replace("HOST", location.hostname));
            //]]>
        </script>
    <?php }
}
add_action("wp_footer", "__gulp_init_namespace___simplify_browsersync", 999);

/**
 * Add editor styles to Gutenberg
 *
 * @return void
 */
function __gulp_init_namespace___gutenberg_styles(): void {
    wp_enqueue_style("__gulp_init_namespace__-styles-editor", get_theme_file_uri(__gulp_init_namespace___get_theme_file_path("assets/styles/editor.*.css", true)), false, "<%= version %>");
}
add_action("enqueue_block_editor_assets", "__gulp_init_namespace___gutenberg_styles");

/**
 * Add editor styles to Classic Editor
 *
 * @return void
 */
function __gulp_init_namespace___editor_styles(): void {
    add_editor_style(__gulp_init_namespace___get_theme_file_path("assets/styles/editor.*.css", true));
}
add_action("init", "__gulp_init_namespace___editor_styles");
