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
 * Enable "Formats" button in TinyMCE
 *
 * @param array $buttons
 * @return array
 */
function __gulp_init_namespace___tinymce_enable_format_button(array $buttons): array {
    array_unshift($buttons, "styleselect");

    return $buttons;
}
add_filter("mce_buttons_2", "__gulp_init_namespace___tinymce_enable_format_button", 10, 1);

/**
 * Add 'Button' format to TinyMCE
 *
 * @param array $init_array
 * @return array
 */
function __gulp_init_namespace___tinymce_button_format(array $init_array): array {
    $init_array["style_formats"] = wp_json_encode([
        [
            "title"    => esc_html__("Button", "__gulp_init_namespace__"),
            "classes"  => "button",
            "selector" => "a",
        ],
    ]);

    return $init_array;
}
add_filter("tiny_mce_before_init", "__gulp_init_namespace___tinymce_button_format", 10, 1);

/**
 * Disallow file editing
 */
if (! defined("DISALLOW_FILE_EDIT")) {
    define("DISALLOW_FILE_EDIT", true);
}
