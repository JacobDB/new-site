<?php
/* ------------------------------------------------------------------------ *\
 * Custom Functions
\* ------------------------------------------------------------------------ */

function enable_critical_css($template_css_file = false) {
    global $template;
    $template_css_file   = $template_css_file === false ? get_template_directory() . "/assets/styles/critical_" . preg_replace("/.php$/i", "", basename($template)) . ".css" : $template_css_file;
    $enable_critical_css = false;

    if (file_exists($template_css_file) && !(isset($_GET["generating"]) && $_GET["generating"] === "critical_css")) {
        if (isset($_GET["debug"]) && $_GET["debug"] === "critical_css") {
            $enable_critical_css = true;
        } elseif (!isset($_COOKIE["previously_visited"]) || (isset($_COOKIE["previously_visited"]) && $_COOKIE["previously_visited"] !== "true")) {
            $enable_critical_css = true;
        }
    }

    return $enable_critical_css;
}

function get_critical_css($template_css_file) {
    global $template;
    $template_css_file = isset($template_css_file) ? $template_css_file : get_template_directory() . "/assets/styles/critical_" . preg_replace("/.php$/i", "", basename($template)) . ".css";
    $template_css      = "";

    if (file_exists($template_css_file)) {
        ob_start();
        include($template_css_file);
        $template_css = ob_get_clean();
    }

    return $template_css;
}

function the_critical_css($template_css_file) {
    echo get_critical_css($template_css_file);
}

// get a nicer excerpt based on post ID
function get_better_excerpt($id = 0, $length = 55, $more = " [...]") {
    global $post;

    $post_id = $id ? $id : $post->ID;
    $post_object = get_post($post_id);
    $excerpt = $post_object->post_excerpt ? $post_object->post_excerpt : wp_trim_words(strip_shortcodes($post_object->post_content), $length, $more);

    return $excerpt;
}

// format an address
function format_address($address_1, $address_2, $city, $state, $zip_code, $break_mode = 1) {
    $address = "";

    if ($address_1 || $address_2 || $city || $state || $zip_code) {
        if ($address_1) {
            $address .= $address_1;

            if ($address_2 || $city || $state || $zip_code) {
                if ($break_mode !== 1 && !($address_2 && $break_mode === 2)) {
                    $address .= "<br />";
                } else {
                    $address .= ", ";
                }
            }
        }

        if ($address_2) {
            $address .= $address_2;

            if ($city || $state || $zip_code) {
                if ($break_mode !== 1) {
                    $address .= "<br />";
                } else {
                    $address .= ", ";
                }
            }
        }

        if ($city) {
            $address .= $city;

            if ($state) {
                $address .= ", ";
            } elseif ($zip_code) {
                $address .= " ";
            }
        }

        if ($state) {
            $address .= $state;

            if ($zip_code) {
                $address .= " ";
            }
        }

        if ($zip_code) {
            $address .= $zip_code;
        }
    }

    return $address;
}

// get a map link
function get_map_link($address, $embed = false) {
    $address_url = "";

    if ($address) {
        $apple_url = "http://maps.apple.com/?q=";
        $google_url = "https://maps.google.com/?q=";

        $address_url = preg_match("/iPod|iPhone|iPad/", $_SERVER["HTTP_USER_AGENT"]) && $embed !== true ? $apple_url . urlencode($address) : $google_url . urlencode($address);

        if ($embed === true) $address_url .= "&output=embed";
    }

    return $address_url;
}

// echo the map link;
function the_map_link($address) {
    echo get_map_link($address);
}

// function to remove the root element (see https://stackoverflow.com/a/29499398)
function remove_root_tag($DOM, $tag = "html") {
    $container = $DOM->getElementsByTagName($tag)->item(0);
    $container = $container->parentNode->removeChild($container);

    while ($DOM->firstChild) {
        $DOM->removeChild($doc->firstChild);
    }

    while ($container->firstChild ) {
        $DOM->appendChild($container->firstChild);
    }

    return $DOM;
}
