<?php
/* ------------------------------------------------------------------------ *\
 * Functions: Page Speed
\* ------------------------------------------------------------------------ */

// remove version strings
function α__init_namespace_remove_script_version($src) {
    $parts = explode("?ver", $src);
    return $parts[0];
}
add_filter("script_loader_src", "α__init_namespace_remove_script_version", 15, 1);
add_filter("style_loader_src", "α__init_namespace_remove_script_version", 15, 1);

// disable oEmbed
function α__init_namespace_stop_loading_wp_embed() {
    if (!is_admin()) {
        wp_deregister_script("wp-embed");
    }
}
add_action("init", "α__init_namespace_stop_loading_wp_embed");

// disable Emoji
remove_action("wp_head", "print_emoji_detection_script", 7);
remove_action("wp_print_styles", "print_emoji_styles");

// load scripts asynchronously
function α__init_namespace_make_scripts_async($tag, $handle, $src) {
    if (!is_admin()) {
        return str_replace("<script", "<script defer='defer'", $tag);
        exit;
    }

    return $tag;
}
add_filter("script_loader_tag", "α__init_namespace_make_scripts_async", 10, 3);

// load styles asynchronously
function α__init_namespace_make_styles_async($tag, $handle, $src) {
    if (!is_admin()) {
        return str_replace("rel='stylesheet'", "rel='preload' as='style' onload=\"this.rel='stylesheet'\"", $tag) . "<noscript>{$tag}</noscript>";
        exit;
    }

    return $tag;
}
add_filter("style_loader_tag", "α__init_namespace_make_styles_async", 10, 3);
