<?php
/* ------------------------------------------------------------------------ *\
 * Image Sizes
\* ------------------------------------------------------------------------ */

add_image_size("hero", 640, 400, true);
add_image_size("hero_medium", 1024, 400, true);
add_image_size("hero_large", 2000, 400, true);

add_image_size("excerpt", 350, 200, true);
add_image_size("excerpt_medium", 525, 300, true);
add_image_size("excerpt_large", 700, 400, true);

/**
 * Display a notice explaining what size a featured image should be.
 *
 * @param string $content
 * @param integer $post_id
 * @param integer|string $thumbnail_id
 * @return string
 */
function __gulp_init_namespace___admin_post_thumbnail_html(string $content, int $post_id, $thumbnail_id): string {
    $width  = 2000;
    $height = 400;

    $notice = sprintf(__("The featured image should be at least %s by %s pixels to fill the available space.", "__gulp_init_namespace__"), $width, $height);

    if ($thumbnail_id && $meta = wp_get_attachment_metadata($thumbnail_id)) {
        if ($meta && ($meta["width"] < $width || $meta["height"] < $height)) {
            $content = "<style type='text/css'>#__gulp_init_namespace___featured_image_warning ~ * #set-post-thumbnail > img { box-shadow: 0 0 0 2px #fff,0 0 0 5px #dc3232; }</style><div id='__gulp_init_namespace___featured_image_warning' class='notice notice-error notice-alt'><p>" . sprintf(__("Display issue: %s"), $notice) . "</p></div>" . $content;
        }
    } else {
        $content = "<p class='hide-if-no-js howto'>{$notice}</p>" . $content;
    }

    return $content;
}
add_filter("admin_post_thumbnail_html", "__gulp_init_namespace___admin_post_thumbnail_html", 10, 3);
