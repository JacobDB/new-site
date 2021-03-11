<?php
/* ------------------------------------------------------------------------ *\
 * WooCommerce
\* ------------------------------------------------------------------------ */

/**
 * Stop if WooCommerce isn't installed
 */
if (! class_exists("woocommerce")) {
    return;
}

/**
 * Add support for WooCommerce to the theme
 *
 * @return void
 */
function __gulp_init_namespace___woocommerce_add_theme_support(): void {
    add_theme_support("woocommerce");
    add_theme_support("wc-product-gallery-zoom");
    add_theme_support("wc-product-gallery-lightbox");
    add_theme_support("wc-product-gallery-slider");
}
add_action("after_setup_theme", "__gulp_init_namespace___woocommerce_add_theme_support");

/**
 * Set the email color upon activation
 *
 * @return void
 */
function __gulp_init_namespace___woocommerce_email_color_upon_activation(): void {
    update_option("woocommerce_email_header_image", get_theme_file_uri("assets/media/logo.svg"));

    if (function_exists("__gulp_init_namespace___get_field")) {
        $theme_color = __gulp_init_namespace___get_field("theme_color", "pwa");
        $theme_color = $theme_color ? $theme_color : "<%= pwa_theme_color %>";

        update_option("woocommerce_email_base_color", $theme_color);
    }
}
add_action("after_switch_theme", "__gulp_init_namespace___woocommerce_email_color_upon_activation");

/**
 * Ensure email logo is a reasonable size
 *
 * @param string $css
 * @param WC_Email $email
 *
 * @return string
 */
function __gulp_init_namespace___woocommerce_email_styles(string $css, WC_Email $email): string {
    return "{$css} #template_header_image img { width: 300px; }";
}
add_filter("woocommerce_email_styles", "__gulp_init_namespace___woocommerce_email_styles", 10, 2);

/**
 * Remove `woocommerce` from body classes
 *
 * @param  array<string> $wp_classes
 * @param  array<string> $extra_classes
 *
 * @return array
 */
function __gulp_init_namespace___woocommerce_body_class(array $wp_classes, array $extra_classes): array {
    if (($key = array_search("woocommerce", $wp_classes)) !== false) {
        unset($wp_classes[$key]);
    }

    return $wp_classes;
}
add_filter("body_class", "__gulp_init_namespace___woocommerce_body_class", 10, 2);

/**
 * Add `the_content` to `woocommerce_short_description`
 *
 * @param  string $post_excerpt
 *
 * @return string
 */
function __gulp_init_namespace___woocommerce_short_description_the_content(string $post_excerpt): string {
    return apply_filters("the_content", $post_excerpt);
}
add_filter("woocommerce_short_description", "__gulp_init_namespace___woocommerce_short_description_the_content");

/**
 * Wrap `the_content` in a `user-content` div on WooCommerce pages
 *
 * @param  string $content
 *
 * @return string
 */
function __gulp_init_namespace___woocommerce_the_content_wrapper(string $content): string {
    if (is_woocommerce()) {
        $content = "<div class='woocommerce__user-content user-content'>{$content}</div>";
    }

    return $content;
}
add_filter("the_content", "__gulp_init_namespace___woocommerce_the_content_wrapper");

/**
 * Remove `text` class from quantity fields
 *
 * @param array $classes
 * @param WC_Product $product
 *
 * @return array
 */
function __gulp_init_namespace___woocommerce_quantity_input_classes(array $classes, WC_Product $product): array {
    if (($key = array_search("text", $classes)) !== false) {
        unset($classes[$key]);
    }

    return $classes;
}
add_action("woocommerce_quantity_input_classes", "__gulp_init_namespace___woocommerce_quantity_input_classes", 10, 2);

/**
 * Add `:` after product attribute titles
 *
 * @param array $product_attributes
 * @param WC_Product $product
 *
 * @return array
 */
function __gulp_init_namespace___woocommerce_display_product_attributes(array $product_attributes, WC_Product $product): array {
    if ($product_attributes) {
        foreach ($product_attributes as $key => $attribute) {
            $product_attributes[$key]["label"] = "{$product_attributes[$key]["label"]}:";
            $product_attributes[$key]["value"] = wp_strip_all_tags($product_attributes[$key]["value"], false);
        }
    }

    return $product_attributes;
}
add_filter("woocommerce_display_product_attributes", "__gulp_init_namespace___woocommerce_display_product_attributes", 10, 2);

/**
 * Add `:` to review form label
 *
 * @param array $comment_form
 *
 * @return array
 */
function __gulp_init_namespace___woocommerce_product_review_comment_form_args(array $comment_form): array {
    $comment_form["comment_field"] = str_replace("</label>", ":</label>", $comment_form["comment_field"]);

    return $comment_form;
}
add_filter("woocommerce_product_review_comment_form_args", "__gulp_init_namespace___woocommerce_product_review_comment_form_args");

/**
 * Add `button` class to WooCommerce review submit fields
 *
 * @param string $submit_field
 * @param array $args
 * @return string
 */
function __gulp_init_namespace___woocommerce_comment_form_submit_field(string $submit_field, array $args = array()): string {
    if (is_woocommerce()) {
        $submit_field = str_replace("class=\"submit\"", "class=\"submit button\"", $submit_field);
    }

    return $submit_field;
}
add_filter("comment_form_submit_field", "__gulp_init_namespace___woocommerce_comment_form_submit_field");

/**
 * Wrap archive results in a div
 *
 * @return void
 */
function __gulp_init_namespace___woocommerce_before_shop_loop_row_start(): void {
    echo "<div class='woocommerce__archive-results'>";
}
add_action("woocommerce_before_shop_loop", "__gulp_init_namespace___woocommerce_before_shop_loop_row_start", 15);

/**
 * Wrap archive results in a div
 *
 * @return void
 */
function __gulp_init_namespace___woocommerce_before_shop_loop_row_end(): void {
    echo "</div>";
}
add_action("woocommerce_before_shop_loop", "__gulp_init_namespace___woocommerce_before_shop_loop_row_end", 35);

/**
 * Dequeue select2 scripts so the inputs function normally
 *
 * @return void
 */
function __gulp_init_namespace___woocommerce_dequeue_select2(): void {
    wp_dequeue_style("select2");
    wp_deregister_style("select2");
    wp_dequeue_script("selectWoo");
    wp_deregister_script("selectWoo");
}
add_action("wp_enqueue_scripts", "__gulp_init_namespace___woocommerce_dequeue_select2", 100);
