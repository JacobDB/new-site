<?php
/* ------------------------------------------------------------------------ *\
 * Post Types
\* ------------------------------------------------------------------------ */

/**
 * Register resource post type
 *
 * @return void
 */
function __gulp_init_namespace___create_resource_post_type(): void {
    register_extended_post_type("resource", [
        "menu_icon" => "dashicons-admin-links",
    ],
    [
        "plural"   => __("Resources", "__gulp_init_namespace__"),
        "singular" => __("Resource", "__gulp_init_namespace__"),
        "slug"     => "resource",
    ]);

    register_extended_taxonomy("resource_tag", "resource", [
        "hierarchical" => false,
    ],
    [
        "plural"   => __("Resource Tags", "__gulp_init_namespace__"),
        "singular" => __("Resource Tag", "__gulp_init_namespace__"),
        "slug"     => "",
    ]);
}
add_action("init", "__gulp_init_namespace___create_resource_post_type");
