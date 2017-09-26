<?php
/* ------------------------------------------------------------------------ *\
 * Functions: Shortcodes
\* ------------------------------------------------------------------------ */

// add row shortcode
function @@namespace_row_shortcode($atts, $content = null) {
    // return the tab wrapper with the menu
    return "<div class='user-content_row row -padded'>" . do_shortcode(@@namespace_fix_shortcodes($content)) . "</div>";
}
add_shortcode("row", "@@namespace_row_shortcode");

// add col shortcode
function @@namespace_col_shortcode($atts , $content = null) {
    extract(shortcode_atts(
		array(
			"default_width"  => "",
			"tablet_width"   => "",
            "notebook_width" => "",
			"desktop_width"  => "",
            "variant"        => "",
		), $atts)
	);

    $class =  $default_width  ? "-{$default_width}"        : "-auto";
    $class .= $tablet_width   ? " col-xs-{$tablet_width}"  : "";
    $class .= $notebook_width ? " col-l-{$notebook_width}" : "";
    $class .= $desktop_width  ? " col-xl-{$desktop_width}" : "";
    $class .= $variant ? " $variant" : "";

    // return the tab wrapper with the menu
    return "<div class='col{$class}'>" . do_shortcode(@@namespace_fix_shortcodes($content)) . "</div>";
}
add_shortcode("col", "@@namespace_col_shortcode");
