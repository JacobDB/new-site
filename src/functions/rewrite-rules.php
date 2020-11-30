<?php
/* ------------------------------------------------------------------------ *\
 * Rewrite Rules
\* ------------------------------------------------------------------------ */

/**
 * Add various rewrite rules
 *
 * @return void
 */
function __gulp_init_namespace___rewrite_rules(): void {
    /**
     * Point to manifest generator at /manifest.json
     */
    add_rewrite_endpoint("manifest", EP_NONE);
    add_rewrite_rule("manifest\.json$", "index.php?manifest=true", "top");

    /**
     * Load offline template at /offline/
     */
    add_rewrite_endpoint("offline", EP_NONE);
    add_rewrite_rule("offline/?$", "index.php?offline=true", "top");

    /**
     * Rewrite requests to /media/ to /wp-content/themes/__gulp_init_npm_name__/assets/media/
     * to ensure no 404s occur when critical CSS is included
     */
    add_rewrite_rule("media/(.*)$", str_replace(ABSPATH, "", get_stylesheet_directory()) . "/assets/media/$1", "top");
}
add_action("init", "__gulp_init_namespace___rewrite_rules");
