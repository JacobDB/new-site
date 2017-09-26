<?php
/* ------------------------------------------------------------------------ *\
 * Functions: Filters
\* ------------------------------------------------------------------------ */

// push the CSS & JS over HTTP2
function @@init_namespace_http2_push() {
    header("Link: <" . get_bloginfo("template_directory") . "/assets/styles/modern.css>; rel=preload; as=style, <https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic>; rel=preload; as=style; crossorigin");
}
add_action("init", "@@init_namespace_http2_push", 10);

// set cookie when a query string gets passed
function @@init_namespace_set_cookie() {
    $cookie     = isset($_GET["cookie"]) ? $_GET["cookie"] : false;
    $expiration = isset($_GET["expiration"]) ? time() + $_GET["expiration"] : time() + 604800;

    if ($cookie) {
        setcookie($cookie, "true", $expiration); // expires in 1 week by default
        exit;
    }
}
add_action("init", "@@init_namespace_set_cookie", 10);

// adjust WordPress login screen styles
function @@init_namespace_login_styles() {
    echo "<link href='" . get_bloginfo("template_directory") . "/assets/styles/wp-login.css' rel='stylesheet' />";
}
add_action("login_enqueue_scripts", "@@init_namespace_login_styles");

// change login logo URL
function @@init_namespace_login_logo_url() {
    return get_bloginfo("url");
}
add_filter("login_headerurl", "@@init_namespace_login_logo_url");

// change login logo title
function @@init_namespace_login_logo_title() {
    return get_bloginfo("name");
}
add_filter("login_headertitle", "@@init_namespace_login_logo_title");

// add user-content class to TinyMCE body
function @@init_namespace_tinymce_settings($settings) {
    $settings["body_class"] .= " user-content";
	return $settings;
}
add_filter("tiny_mce_before_init", "@@init_namespace_tinymce_settings");

// fix shortcode formatting
function @@init_namespace_fix_shortcodes($content) {
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
add_filter("the_content", "@@init_namespace_fix_shortcodes");
add_filter("acf_the_content", "@@init_namespace_fix_shortcodes", 12);

// wrap tables in a div
function @@init_namespace_wrap_tables($content) {
    $content = preg_replace("/(<table(?:.|\n)*?<\/table>)/im", "<div class='table_container'>$1</div>", $content);

    return $content;
}
add_filter("the_content", "@@init_namespace_wrap_tables");
add_filter("acf_the_content", "@@init_namespace_wrap_tables");

// wrap frames in a div
function new_site_wrap_frames($content) {
    $content = preg_replace("/(<iframe(?![^>]* class=))((?:.|\n)*?<\/iframe>)/im", "<div class='iframe_container'>$1 class='iframe'$2</div>", $content);

    return $content;
}
add_filter("the_content", "new_site_wrap_frames");
add_filter("acf_the_content", "new_site_wrap_frames");

// remove dimensions from thumbnails
function @@init_namespace_remove_thumbnail_dimensions($html, $post_id, $post_image_id) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/im', "", $html);
    return $html;
}
add_filter("post_thumbnail_html", "@@init_namespace_remove_thumbnail_dimensions", 10, 3);

// add rel="noopener" to external links
function @@init_namespace_rel_noopener($content) {
    $content = preg_replace("/(<a )(?!.*(?<= )rel=(?:'|\"))(.[^>]*>)/im", "$1 rel=\"noopener\"$2", $content);

    return $content;
}
add_filter("the_content", "@@init_namespace_rel_noopener");
add_filter("acf_the_content", "@@init_namespace_rel_noopener", 12);

// add "Download Adobe Reader" link on all pages that link to PDFs
function @@init_namespace_acrobat_link() {
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
        $output .= "<p class='content_text text _small'>" . sprintf(__("Having trouble opening PDFs? %sDownload Adobe Reader here.%s", "@@init_namespace"), "<a class='text_link link' href='https://get.adobe.com/reader/' target='_blank' rel='noopener'>", "</a>") . "</p>";
    }

    echo $output;
}
add_filter("@@init_namespace_after_content", "@@init_namespace_acrobat_link");

// disable Ninja Forms styles
function @@init_namespace_dequeue_nf_display() {
    wp_dequeue_style("nf-display");
}
add_action("ninja_forms_enqueue_scripts", "@@init_namespace_dequeue_nf_display", 999);
/*removeIf(tribe_css_js_php)*/
// force redirect 'cause tribe is stupid
function new_site_tribe_redirect($template) {
    if (is_post_type_archive("tribe_events")) {
        return TEMPLATEPATH . "/archive-tribe_events.php";
    } elseif (get_post_type() == "tribe_events") {
        return TEMPLATEPATH . "/single-tribe_events.php";
    } else {
        return $template;
    }
}
add_action("template_include", "new_site_tribe_redirect");

// dequeue Tribe styles
function @@init_namespace_tribe_events_dequeue_styles() {
    wp_dequeue_style("tribe-events-calendar-style", 999);
}
add_filter("wp_enqueue_scripts", "@@init_namespace_tribe_events_dequeue_styles");

// disable Tribe Events ical links (since I can't re-style them)
function @@init_namespace_tribe_events_list_show_ical_link() {
    return false;
}
add_filter("tribe_events_list_show_ical_link", "@@init_namespace_tribe_events_list_show_ical_link");

// add class to event list date headers
function @@init_namespace_tribe_events_list_the_date_headers($html, $event_month, $event_year) {
    $event_month = DateTime::createFromFormat("Ymd", "{$event_year}{$event_month}01");
    return "<h3 class='content_title title -divider'>{$event_month->format("F")} {$event_year}</h3>";
}
add_filter("tribe_events_list_the_date_headers", "@@init_namespace_tribe_events_list_the_date_headers", 10, 3);

// add class to event list navigation links
function @@init_namespace_tribe_the_nav_link($html) {
    return preg_replace("/<a/", "<a class='menu-list_link link'", $html);
}
add_filter("tribe_events_the_previous_month_link", "@@init_namespace_tribe_the_nav_link", 10, 1);
add_filter("tribe_events_the_next_month_link", "@@init_namespace_tribe_the_nav_link", 10, 1);
add_filter("tribe_the_prev_event_link", "@@init_namespace_tribe_the_nav_link", 10, 1);
add_filter("tribe_the_next_event_link", "@@init_namespace_tribe_the_nav_link", 10, 1);
add_filter("tribe_the_day_link", "@@init_namespace_tribe_the_nav_link", 10, 1);/*endRemoveIf(tribe_css_js_php)*/

// enable lazy loading on images
function @@init_namespace_lazy_load_images($content) {
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
add_filter("the_content", "@@init_namespace_lazy_load_images", 999, 1);
add_filter("acf_the_content", "@@init_namespace_lazy_load_images", 999, 1);
add_filter("post_thumbnail_html", "@@init_namespace_lazy_load_images", 999, 1);

// redirect to the home template if no front page is set
function new_site_home_template_redirect($template) {
    if (is_front_page() && get_option("show_on_front") != "page") {
        return TEMPLATEPATH . "/home.php";
    } else {
        return $template;
    }
}
add_action("template_include", "new_site_home_template_redirect");
