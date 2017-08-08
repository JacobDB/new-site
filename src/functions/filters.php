<?php
/* ------------------------------------------------------------------------ *\
 * Functions: Filters
\* ------------------------------------------------------------------------ */

// push the CSS & JS over HTTP2
function @@namespace_http2_push() {
    header("Link: <" . get_bloginfo("template_directory") . "/assets/styles/modern.css>; rel=preload; as=style, <https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic>; rel=preload; as=style; crossorigin");
}
add_action("init", "@@namespace_http2_push", 10);

// set cookie when a query string gets passed
function @@namespace_set_cookie() {
    $cookie     = isset($_GET["cookie"]) ? $_GET["cookie"] : false;
    $expiration = isset($_GET["expiration"]) ? time() + $_GET["expiration"] : time() + 604800;

    if ($cookie) {
        setcookie($cookie, "true", $expiration); // expires in 1 week by default
        exit;
    }
}
add_action("init", "@@namespace_set_cookie", 10);

// adjust WordPress login screen styles
function @@namespace_login_styles() {
    echo "<link href='" . get_bloginfo("template_directory") . "/assets/styles/wp-login.css' rel='stylesheet' />";
}
add_action("login_enqueue_scripts", "@@namespace_login_styles");

// change login logo URL
function @@namespace_login_logo_url() {
    return get_bloginfo("url");
}
add_filter("login_headerurl", "@@namespace_login_logo_url");

// change login logo title
function @@namespace_login_logo_title() {
    return get_bloginfo("name");
}
add_filter("login_headertitle", "@@namespace_login_logo_title");

// add user-content class to TinyMCE body
function @@namespace_tinymce_settings($settings) {
    $settings["body_class"] .= " user-content";
	return $settings;
}
add_filter("tiny_mce_before_init", "@@namespace_tinymce_settings");

// fix shortcode formatting
function @@namespace_fix_shortcodes($content) {
	$array = array (
		"<p>["         => "[",
		"]</p>"        => "]",
		"]<br />"      => "]",
        "<p>&#91;"     => "[",
        "&#93;</p>"    => "]",
        "&#93;<br />"  => "]",
	);
	$content = strtr($content, $array);

    return $content;
}
add_filter("the_content", "@@namespace_fix_shortcodes");
add_filter("acf_the_content", "@@namespace_fix_shortcodes", 12);

// wrap tables in a div
function @@namespace_wrap_tables($content) {
    $content = preg_replace("/(<table(?:.|\n)*?<\/table>)/im", "<div class='table_container'>$1</div>", $content);

    return $content;
}
add_filter("the_content", "@@namespace_wrap_tables");
add_filter("acf_the_content", "@@namespace_wrap_tables");

// remove dimensions from thumbnails
function @@namespace_remove_thumbnail_dimensions($html, $post_id, $post_image_id) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/im', "", $html);
    return $html;
}
add_filter("post_thumbnail_html", "@@namespace_remove_thumbnail_dimensions", 10, 3);

// add rel="noopener" to external links
function @@namespace_rel_noopener($content) {
    $content = preg_replace("/(<a )(?!.*(?<= )rel=(?:'|\"))(.[^>]*>)/im", "$1 rel=\"noopener\"$2", $content);

    return $content;
}
add_filter("the_content", "@@namespace_rel_noopener");
add_filter("acf_the_content", "@@namespace_rel_noopener", 12);

// add "Download Adobe Reader" link on all pages that link to PDFs
function @@namespace_acrobat_link() {
    global $post;

    $has_pdf = false;
    $content = get_the_content();
    $fields  = get_fields();
    $output  = "";

    if ($content) {
        preg_match("/\.pdf(?:\'|\")/im", $content, $matches);

        if ($matches) {
            $has_pdf = true;
        }
    }

    if ($fields && !$has_pdf) {
        foreach ($fields as $field) {
            preg_match("/\.pdf(?:\'|\"|$)/im", json_encode($field), $matches);

            if ($matches) {
                $has_pdf = true;
                break;
            }
        }
    }

    if ($has_pdf === true) {
        $output .= "<hr class='divider' />";
        $output .= "<p class='content_text text _small'>" . sprintf(__("Having trouble opening PDFs? %sDownload Adobe Reader here.%s", "@@namespace"), "<a class='text_link link' href='https://get.adobe.com/reader/' target='_blank' rel='noopener'>", "</a>") . "</p>";
    }

    echo $output;
}
add_filter("@@namespace_after_content", "@@namespace_acrobat_link");

// disable Ninja Forms styles
function @@namespace_dequeue_nf_display() {
    wp_dequeue_style("nf-display");
}
add_action("ninja_forms_enqueue_scripts", "@@namespace_dequeue_nf_display", 999);
/*removeIf(tribe_css_js_php)*/
// dequeue Tribe styles
function @@namespace_tribe_events_dequeue_styles() {
    wp_dequeue_style("tribe-events-calendar-style", 999);
}
add_filter("wp_enqueue_scripts", "@@namespace_tribe_events_dequeue_styles");

// disable Tribe Events ical links (since I can't re-style them)
function @@namespace_tribe_events_list_show_ical_link() {
    return false;
}
add_filter("tribe_events_list_show_ical_link", "@@namespace_tribe_events_list_show_ical_link");

// add class to event list date headers
function @@namespace_tribe_events_list_the_date_headers($html, $event_month, $event_year) {
    $event_month = DateTime::createFromFormat("Ymd", "{$event_year}{$event_month}01");
    return "<h3 class='content_title title -divider'>{$event_month->format("F")} {$event_year}</h3>";
}
add_filter("tribe_events_list_the_date_headers", "@@namespace_tribe_events_list_the_date_headers", 10, 3);

// add class to event list navigation links
function @@namespace_tribe_the_nav_link($html) {
    return preg_replace("/<a/", "<a class='menu-list_link link'", $html);
}
add_filter("tribe_events_the_previous_month_link", "@@namespace_tribe_the_nav_link", 10, 1);
add_filter("tribe_events_the_next_month_link", "@@namespace_tribe_the_nav_link", 10, 1);
add_filter("tribe_the_prev_event_link", "@@namespace_tribe_the_nav_link", 10, 1);
add_filter("tribe_the_next_event_link", "@@namespace_tribe_the_nav_link", 10, 1);
add_filter("tribe_the_day_link", "@@namespace_tribe_the_nav_link", 10, 1);/*endRemoveIf(tribe_css_js_php)*/

// enable lazy loading on images
function @@namespace_lazy_load_images($content) {
    if (!((function_exists("tribe_is_month") && tribe_is_month()) && !is_tax())) {
        // add `<noscript>` fallback for all imges
        $content = preg_replace("/(<img[^>]+?>)/", "$1<noscript>$1</noscript>", $content);

        // replace all `src` attributes in images with `data-nomral`
        $content = preg_replace("/(<img.*?)(src=)([^>]+?><noscript)/im", "$1data-normal=$3", $content);

        // replace all `srcset` attributes in images with `data-srcset`
        $content = preg_replace("/(<img.*?)(srcset=)([^>]+?><noscript)/im", "$1data-srcset=$3", $content);

        // add ` _js ` to all `class` attributes in images
        $content = preg_replace("/(<img[^>]+class=(?:\'|\"))([^\'|\"\>]+)([^>]+?><noscript)/im", "$1_js $2$3", $content);
    }

    return $content;
}
add_filter("the_content", "@@namespace_lazy_load_images", 999, 1);
add_filter("acf_the_content", "@@namespace_lazy_load_images", 999, 1);
add_filter("post_thumbnail_html", "@@namespace_lazy_load_images", 999, 1);
