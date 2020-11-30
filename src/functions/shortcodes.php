<?php
/* ------------------------------------------------------------------------ *\
 * Shortcodes
\* ------------------------------------------------------------------------ */

/**
 * Shortcode for users to add rows to the content region
 *
 * @example [row class="row--padded-tight"]
 *
 * @param  array<string>|string $atts
 * @param  string $content
 *
 * @return string
 */
function __gulp_init_namespace___row_shortcode($atts, string $content = ""): string {
    extract(shortcode_atts(
        [
            "class" => false,
        ],
        $atts
    ));

    $value = $class !== false ? " {$class}" : " row--padded";

    return "<div class='user-content__row row{$value}'>" . do_shortcode($content) . "</div>";
}
add_shortcode("row", "__gulp_init_namespace___row_shortcode");

/**
 * Shortcode for users to add columns to the content region
 *
 * @example [col mobile=12 tablet=6 notebook=4 desktop=auto class="col--grow-0 col--shrink-0"]
 *
 * @param  array<string>|string $atts
 * @param  string $content
 *
 * @return string
 */
function __gulp_init_namespace___col_shortcode($atts, string $content = ""): string {
    extract(shortcode_atts(
        [
            "mobile"   => "",
            "tablet"   => "",
            "notebook" => "",
            "desktop"  => "",
            "class"    => "",
        ], $atts
    ));

    $value =  $mobile   ? "col-{$mobile}"         : "col-auto";
    $value .= $tablet   ? " col-xs-{$tablet}"  : "";
    $value .= $notebook ? " col-l-{$notebook}" : "";
    $value .= $desktop  ? " col-xl-{$desktop}" : "";
    $value .= $class    ? " $class"            : "";

    return "<div class='{$value}'>" . do_shortcode($content) . "</div>";
}
add_shortcode("col", "__gulp_init_namespace___col_shortcode");

/**
 * Shortcode for users to set a number of CSS columns on tablet+ views
 *
 * @example [columns count=2]
 *
 * @param  array<string>|string $atts
 * @param  string $content
 *
 * @return string
 */
function __gulp_init_namespace___columns_shortcode($atts, string $content = ""): string {
    extract(shortcode_atts(
        [
            "count" => "1",
        ], $atts
    ));

    return "<div class='user-content__columns columns columns--{$count}'>" . do_shortcode($content) . "</div>";
}
add_shortcode("columns", "__gulp_init_namespace___columns_shortcode");

/**
 * Add [accordion] shortcode
 *
 * @param mixed $atts
 * @param string $content
 *
 * @return string
 */
function __gulp_init_namespace___accordion_shortcode($atts, string $content= ""): string {
    extract(shortcode_atts(
        [
            "title" => "",
        ], $atts
    ));

    return <<<EOF
<h3 class="handorgel__header">
    <button class="handorgel__header__button">
        $title
    </button>
</h3>
<div class="handorgel__content">
    <div class="handorgel__content__inner">
        $content
    </div>
</div>
EOF;
}
add_shortcode("accordion", "__gulp_init_namespace___accordion_shortcode");
