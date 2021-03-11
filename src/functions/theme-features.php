<?php
/* ------------------------------------------------------------------------ *\
 * Theme Features
\* ------------------------------------------------------------------------ */

add_theme_support("html5", [
    "comment-list",
    "comment-form",
    "search-form",
    "gallery",
    "caption",
]);

add_theme_support("title-tag");

add_theme_support("automatic-feed-links");

add_theme_support("post-thumbnails");

/**
 * Disable "Additional CSS" in the Customizer screen
 *
 * @param WP_Customize_Manager $wp_customize
 * @return void
 */
function __gulp_init_namespace___disable_additional_css(WP_Customize_Manager $wp_customize): void {
    $wp_customize->remove_control("custom_css");
}
add_action("customize_register", "__gulp_init_namespace___disable_additional_css");

/**
 * Disallow file editing
 */
if (! defined("DISALLOW_FILE_EDIT")) {
    define("DISALLOW_FILE_EDIT", true);
}
