<?php
/* ------------------------------------------------------------------------ *\
 * Meta
\* ------------------------------------------------------------------------ */

/**
 * Add the favicon meta tags to the head
 *
 * @return void
 */
function __gulp_init_namespace___add_favicon_meta_to_head(): void {
    echo "<link href='" . get_theme_file_uri("assets/media/logo-favicon.png") . "' rel='shortcut icon' />\n";
}
add_action("admin_head", "__gulp_init_namespace___add_favicon_meta_to_head", 0);
add_action("login_head", "__gulp_init_namespace___add_favicon_meta_to_head", 0);
add_action("wp_head", "__gulp_init_namespace___add_favicon_meta_to_head", 0);

/**
 * Add the theme color meta tags to the head
 *
 * @return void
 */
function __gulp_init_namespace___add_theme_color_meta_to_head(): void {
    $theme_color = __gulp_init_namespace___get_field("theme_color", "pwa");
    $theme_color = $theme_color ? $theme_color : "<%= pwa_theme_color %>";

    // Chrome
    echo "<meta name='theme-color' content='{$theme_color}' />\n";

    // Safari
    echo "<link rel='mask-icon' href='" . get_theme_file_uri("assets/media/safari/mask-icon.svg") . "' color='{$theme_color}' />\n";

    // Internet Explorer
    if (__gulp_init_namespace___is_ie()) {
        echo "<meta name='msapplication-navbutton-color' content='{$theme_color}'>\n";
    }
}
add_action("admin_head", "__gulp_init_namespace___add_theme_color_meta_to_head", 0);
add_action("login_head", "__gulp_init_namespace___add_theme_color_meta_to_head", 0);
add_action("wp_head", "__gulp_init_namespace___add_theme_color_meta_to_head", 0);

/**
 * Add the settings meta tags to the head
 *
 * @return void
 */
function __gulp_init_namespace___add_settings_meta_to_head(): void {
    echo "<meta content='text/html;charset=utf-8' http-equiv='content-type' />\n";
    echo "<meta content='width=device-width, initial-scale=1' name='viewport' />\n";
}
add_action("wp_head", "__gulp_init_namespace___add_settings_meta_to_head", 0);
