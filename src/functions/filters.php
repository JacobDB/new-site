<?php
/* ------------------------------------------------------------------------ *\
 * Filters
\* ------------------------------------------------------------------------ */

/**
 * Enable force HTTPS and HSTS if the site is served over HTTPS
 *
 * @return bool
 */
function __gulp_init_namespace___enable_https_directives(): bool {
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on") {
        return true;
    }

    return false;
}
add_action("__gulp_init_namespace___htaccess_rewrites_forcing-https_is_enabled", "__gulp_init_namespace___enable_https_directives");
add_action("__gulp_init_namespace___htaccess_security_http-strict-transport-security-hsts_is_enabled", "__gulp_init_namespace___enable_https_directives");

/**
 * Disable xmlrpc.php
 *
 * @return void
 */
function __gulp_init_namespace___disable_xmlrpc(): void {
    add_filter("xmlrpc_enabled", "__return_false");
}
add_action("init", "__gulp_init_namespace___disable_xmlrpc");

/**
 * Set a cookie after the first load to mark returning visitors
 *
 * @return void
 */
function __gulp_init_namespace___set_return_visitor_cookie(): void {
    if (! isset($_COOKIE["return_visitor"])) setcookie("return_visitor", "true", time() + 604800);
}
add_action("wp", "__gulp_init_namespace___set_return_visitor_cookie", 10);

/**
 * Change login logo URL
 *
 * @return string
 */
function __gulp_init_namespace___login_logo_url(): string {
    return get_bloginfo("url");
}
add_filter("login_headerurl", "__gulp_init_namespace___login_logo_url");

/**
 * Change login logo title
 *
 * @return string
 */
function __gulp_init_namespace___login_logo_title(): string {
    return get_bloginfo("name");
}
add_filter("login_headertext", "__gulp_init_namespace___login_logo_title");

/**
 * Replace content with a password form if a post is password protected
 *
 * @param  object $post_object
 *
 * @return void
 */
function __gulp_init_namespace___enable_post_password_protection(object $post_object): void {
    if (post_password_required($post_object->ID)) {
        $post_object->post_content = get_the_password_form();
    }
}
add_action("the_post", "__gulp_init_namespace___enable_post_password_protection");

/**
 * Delay when shortcodes get expanded
 *
 * @return void
 */
function __gulp_init_namespace___delay_shortcode_expansion(): void {
    remove_filter("the_content", "do_shortcode", 11);
    add_filter("the_content", "do_shortcode", 25);
}
add_action("wp", "__gulp_init_namespace___delay_shortcode_expansion");

/**
 * Filter out badly encoded characters from the_content
 *
 * @link https://lonewolfonline.net/html-entity-conversion-calculator/
 * @param string $content
 * @return string
 */
function __gulp_init_namespace___remove_broken_characters(string $content): string {
    return preg_replace("/(\u{2028}|\u{2029}|\u{009D})/", "", $content);
}
add_filter("the_content", "__gulp_init_namespace___remove_broken_characters");

/**
 * Remove wpautop stuff from shortcodes
 *
 * @param  string $content
 *
 * @return string
 */
function __gulp_init_namespace___fix_shortcodes(string $content): string {
    global $shortcode_tags;

    if (! (is_admin() && ! wp_doing_ajax()) && $content && $shortcode_tags) {
        $shortcodes = [];

        foreach ($shortcode_tags as $tag => $data) {
            $shortcodes[] = $tag;
        }

        $block = join("|", $shortcodes);

        $content = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);
        $content = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $content);
    }

    return $content;
}
add_filter("the_content", "__gulp_init_namespace___fix_shortcodes", 15);

/**
 * Add classes to elements
 *
 * @param  string $content
 *
 * @return string
 */
function __gulp_init_namespace___add_user_content_classes(string $content): string {
    if (! (is_admin() && ! wp_doing_ajax()) && $content) {
        $DOM = new DOMDocument();

        // disable errors to get around HTML5 warnings...
        libxml_use_internal_errors(true);

        // load in content
        $DOM->loadHTML("<?xml encoding='utf-8' ?><html><body>{$content}</body></html>", LIBXML_HTML_NODEFDTD);

        // reset errors to get around HTML5 warnings...
        libxml_clear_errors();

        $anchors = $DOM->getElementsByTagName("a");

        foreach ($anchors as $anchor) {
            $existing_classes = $anchor->getAttribute("class") ? $anchor->getAttribute("class") : "";
            $existing_href    = $anchor->getAttribute("href");
            $existing_rel     = $anchor->getAttribute("rel");

            $new_classes = "";

            if (preg_match("/button/i", $existing_classes)) {
                $new_classes = "user-content__button {$existing_classes}";
            } else {
                $new_classes = "user-content__link link {$existing_classes}";
            }

            if (preg_match("/(jpg|jpeg|png|gif)$/i", $existing_href)) {
                $document_root = $_SERVER["DOCUMENT_ROOT"];

                $img_path = realpath($document_root . parse_url($existing_href, PHP_URL_PATH));

                if (file_exists($img_path)) {
                    $img_size = getimagesize($img_path);

                    if ($img_size) {
                        $anchor->setAttribute("data-size", "{$img_size[0]}x{$img_size[1]}");

                        $new_classes = "photoswipe {$new_classes}";
                    }
                }
            }

            if ($new_classes) {
                $anchor->setAttribute("class", $new_classes);
            }

            if (! $existing_rel) {
                $anchor->setAttribute("rel", "noopener");
            }
        }

        $heading1s = $DOM->getElementsByTagName("h1");

        foreach ($heading1s as $heading1) {
            $heading1->setAttribute("class", "user-content__title title title--h1 {$heading1->getAttribute("class")}");
        }

        $heading2s = $DOM->getElementsByTagName("h2");

        foreach ($heading2s as $heading2) {
            $heading2->setAttribute("class", "user-content__title title title--h2 {$heading2->getAttribute("class")}");
        }

        $heading3s = $DOM->getElementsByTagName("h3");

        foreach ($heading3s as $heading3) {
            $heading3->setAttribute("class", "user-content__title title title--h3 {$heading3->getAttribute("class")}");
        }

        $heading4s = $DOM->getElementsByTagName("h4");

        foreach ($heading4s as $heading4) {
            $heading4->setAttribute("class", "user-content__title title title--h4 {$heading4->getAttribute("class")}");
        }

        $heading5s = $DOM->getElementsByTagName("h5");

        foreach ($heading5s as $heading5) {
            $heading5->setAttribute("class", "user-content__title title title--h5 {$heading5->getAttribute("class")}");
        }

        $heading6s = $DOM->getElementsByTagName("h6");

        foreach ($heading6s as $heading6) {
            $heading6->setAttribute("class", "user-content__title title title--h6 {$heading6->getAttribute("class")}");
        }

        $paragraphs = $DOM->getElementsByTagName("p");

        foreach ($paragraphs as $paragraph) {
            $paragraph->setAttribute("class", "user-content__text text {$paragraph->getAttribute("class")}");
        }

        $ordered_lists = $DOM->getElementsByTagName("ol");

        foreach ($ordered_lists as $ordered_list) {
            $ordered_list->setAttribute("class", "user-content__text text text--list text--ordered {$ordered_list->getAttribute("class")}");
        }

        $unordered_lists = $DOM->getElementsByTagName("ul");

        foreach ($unordered_lists as $unordered_list) {
            $unordered_list->setAttribute("class", "user-content__text text text--list text--unordered {$unordered_list->getAttribute("class")}");
        }

        $list_items = $DOM->getElementsByTagName("li");

        foreach ($list_items as $list_item) {
            $list_item->setAttribute("class", "text__list-item {$list_item->getAttribute("class")}");
        }

        $tables = $DOM->getElementsByTagName("table");

        foreach ($tables as $table) {
            $table->setAttribute("class", "user-content__text text text--table {$table->getAttribute("class")}");
        }

        $table_headers = $DOM->getElementsByTagName("thead");

        foreach ($table_headers as $table_header) {
            $table_header->setAttribute("class", "text__header {$table_header->getAttribute("class")}");
        }

        $table_bodies = $DOM->getElementsByTagName("tbody");

        foreach ($table_bodies as $tbody) {
            $tbody->setAttribute("class", "text__body {$tbody->getAttribute("class")}");
        }

        $table_footers = $DOM->getElementsByTagName("tfoot");

        foreach ($table_footers as $table_footer) {
            $table_footer->setAttribute("class", "text__footer {$table_footer->getAttribute("class")}");
        }

        $table_rows = $DOM->getElementsByTagName("tr");

        foreach ($table_rows as $table_row) {
            $table_row->setAttribute("class", "text__row {$table_row->getAttribute("class")}");
        }

        $table_cell_headers = $DOM->getElementsByTagName("th");

        foreach ($table_cell_headers as $table_cell_header) {
            $table_cell_header->setAttribute("class", "text__cell text__cell--header {$table_cell_header->getAttribute("class")}");
        }

        $table_cells = $DOM->getElementsByTagName("td");

        foreach ($table_cells as $table_cell) {
            $table_cell->setAttribute("class", "text__cell {$table_cell->getAttribute("class")}");
        }

        $blockquotes = $DOM->getElementsByTagName("blockquote");

        foreach ($blockquotes as $blockquote) {
            $blockquote->setAttribute("class", "user-content__blockquote blockquote {$blockquote->getAttribute("class")}");
        }

        $horizontal_rules = $DOM->getElementsByTagName("hr");

        foreach ($horizontal_rules as $horizontal_rule) {
            $horizontal_rule->setAttribute("class", "user-content__divider divider {$horizontal_rule->getAttribute("class")}");
        }

        $figures = $DOM->getElementsByTagName("figure");

        foreach ($figures as $figure) {
            $figure->setAttribute("class", "user-content__figure figure {$figure->getAttribute("class")}");
        }

        $figcaptions = $DOM->getElementsByTagName("figcaption");

        foreach ($figcaptions as $figcaption) {
            $figcaption->setAttribute("class", "user-content__text text {$figcaption->getAttribute("class")}");
        }

        // remove unneeded tags (inserted for parsing reasons)
        $content = $DOM->saveHTML($DOM->documentElement);
    }

    return $content;
}
add_filter("the_content", "__gulp_init_namespace___add_user_content_classes", 20);

/**
 * Wrap handorgel shortcodes in appropriate containers
 *
 * @param string $content
 *
 * @return string
 */
function __gulp_init_namespace___wrap_handorgel_shortcodes(string $content): string {
    if (! (is_admin() && ! wp_doing_ajax()) && $content) {
        $DOM = new DOMDocument();

        /**
         * Disable errors to get around HTML5 warnings...
         */
        libxml_use_internal_errors(true);

        /**
         * Load in content
         */
        $DOM->loadHTML("<?xml encoding='utf-8' ?><html><body>{$content}</body></html>", LIBXML_HTML_NODEFDTD);

        /**
         * Reset errors to get around HTML5 warnings...
         */
        libxml_clear_errors();

        /**
         * Set up array to track handorgel groups
         */
        $handorgels = [];

        /**
         * Track the previous class to facilitate locating handorgel groups
         */
        $prev_class = "";

        /**
         * Loop through all elements that are directly within the body
         */
        foreach ($DOM->getElementsByTagName("body")[0]->childNodes as $element) {
            /**
             * Ensure that only HTML nodes get checked/modified
             */
            if ($element->nodeType == 1) {
                $current_class = $element->getAttribute("class");

                /**
                 * Find any handorgel elements
                 */
                if (preg_match("/handorgel__/", $current_class)) {
                    $group = array_key_last($handorgels);

                    /**
                     * If the previous class didn't include `handorgel__`, create a new handorgel group
                     */
                    if (! preg_match("/handorgel__/", $prev_class)) {
                        $handorgels[] = [
                            "container" => $DOM->createElement("div"),
                            "elements"  => [],
                        ];

                        /**
                         * Update `$group` to match the new container
                         */
                        $group = array_key_last($handorgels);
                    }

                    /**
                     * Append the current element to the group to be moved after all sequential handorgel
                     * elements are located for its group
                     */
                    $handorgels[$group]["elements"][] = $element;
                }

                /**
                 * Update `$prev_class` to track where handorgel groups should begin and end
                 */
                $prev_class = $current_class;
            }
        }

        /**
         * Construct the handorgel groups
         */
        if ($handorgels) {
            foreach ($handorgels as $group => $handorgel) {
                /**
                 * Add the `handorgel` class to teh container
                 */
                $handorgel["container"]->setAttribute("class", "handorgel");

                /**
                 * Loop through all elements within the group
                 */
                foreach ($handorgel["elements"] as $key => $element) {
                    /**
                     * Insert the container in the starting position for the group
                     */
                    if ($key === 0) {
                        $element->parentNode->insertBefore($handorgels[$group]["container"], $element);
                    }

                    /**
                     * Append the current element to the group
                     */
                    $handorgel["container"]->appendChild($element);
                }
            }
        }

        /**
         * Remove unneeded tags (inserted for parsing reasons)
         */
        $content = $DOM->saveHTML($DOM->documentElement);
    }

    return $content;
}
add_filter("the_content", "__gulp_init_namespace___wrap_handorgel_shortcodes", 30);

/**
 * Enable responsive iframes
 *
 * @param  string $content
 *
 * @return string
 */
function __gulp_init_namespace___responsive_iframes(string $content): string {
    if (! (is_admin() && ! wp_doing_ajax()) && $content) {
        $DOM = new DOMDocument();

        // disable errors to get around HTML5 warnings...
        libxml_use_internal_errors(true);

        // load in content
        $DOM->loadHTML("<?xml encoding='utf-8' ?><html><body>{$content}</body></html>", LIBXML_HTML_NODEFDTD);

        // reset errors to get around HTML5 warnings...
        libxml_clear_errors();

        $iframes = $DOM->getElementsByTagName("iframe");

        $iframe_container = $DOM->createElement("div");
        $iframe_container->setAttribute("class", "user-content__iframe__container iframe__container");

        foreach ($iframes as $iframe) {
            $iframe->setAttribute("class", "iframe {$iframe->getAttribute("class")}");

            $aspect_ratio = "56.25%";

            $height = $iframe->getAttribute("height");
            $width  = $iframe->getAttribute("width");

            $iframe->removeAttribute("height");
            $iframe->removeAttribute("width");

            if ($height && $width) {
                $height = (int) preg_replace("/[^0-9]/", "", $height);
                $width  = (int) preg_replace("/[^0-9]/", "", $width);

                $aspect_ratio = ($height / $width * 100) . "%";
            }

            $iframe_container_clone = $iframe_container->cloneNode();

            $iframe_container_clone->setAttribute("style", "padding-bottom:{$aspect_ratio};");

            $iframe_parent_node = $iframe->parentNode;

            if ($iframe_parent_node->tagName === "p") {
                $iframe_parent_node->parentNode->replaceChild($iframe_container_clone, $iframe_parent_node);
            } else {
                $iframe->parentNode->replaceChild($iframe_container_clone, $iframe);
            }

            $iframe_container_clone->appendChild($iframe);
        }

        // remove unneeded tags (inserted for parsing reasons)
        $content = $DOM->saveHTML($DOM->documentElement);
    }

    return $content;
}
add_filter("the_content", "__gulp_init_namespace___responsive_iframes", 20);

/**
 * Enable responsive tables
 *
 * @param  string $content
 *
 * @return string
 */
function __gulp_init_namespace___responsive_tables(string $content): string {
    if (! (is_admin() && ! wp_doing_ajax()) && $content) {
        $DOM = new DOMDocument();

        // disable errors to get around HTML5 warnings...
        libxml_use_internal_errors(true);

        // load in content
        $DOM->loadHTML("<?xml encoding='utf-8' ?><html><body>{$content}</body></html>", LIBXML_HTML_NODEFDTD);

        // reset errors to get around HTML5 warnings...
        libxml_clear_errors();

        $tables = $DOM->getElementsByTagName("table");

        $table_container = $DOM->createElement("div");
        $table_container->setAttribute("class", "user-content__text__table__container text__table__container");

        foreach ($tables as $table) {
            $table_container_clone = $table_container->cloneNode();
            $table->parentNode->replaceChild($table_container_clone, $table);
            $table_container_clone->appendChild($table);
        }

        // remove unneeded tags (inserted for parsing reasons)
        $content = $DOM->saveHTML($DOM->documentElement);
    }

    return $content;
}
add_filter("the_content", "__gulp_init_namespace___responsive_tables", 20);

/**
 * Lazy load images
 *
 * @param  string $content
 *
 * @return string
 */
function __gulp_init_namespace___lazy_load_images(string $content): string {
    if (! (is_admin() && ! wp_doing_ajax()) && $content) {
        $DOM = new DOMDocument();

        // disable errors to get around HTML5 warnings...
        libxml_use_internal_errors(true);

        // load in content
        $DOM->loadHTML("<?xml encoding='utf-8' ?><html><body>{$content}</body></html>", LIBXML_HTML_NODEFDTD);

        // reset errors to get around HTML5 warnings...
        libxml_clear_errors();

        // XPath required otherwise an infinite loop occurs
        $XPath = new DOMXPath($DOM);

        $images = $XPath->query("//*[self::img or self::source]");

        foreach ($images as $image) {
            if ($image->parentNode->nodeName !== "noscript" && ! $image->getAttribute("data-orig-file")) {
                $existing_src    = $image->getAttribute("src");
                $existing_srcset = $image->getAttribute("srcset");

                $height = $image->getAttribute("height");
                $width  = $image->getAttribute("width");
                $size   = $image->getAttribute("intrinsicsize");

                // try to determine height and width programmatically
                if (! ($height && $width) && ($existing_src || $existing_srcset)) {
                    $src  = $existing_src ? $existing_src : explode(" ", $existing_srcset)[0];

                    if ($data = getimagesize($_SERVER["DOCUMENT_ROOT"] . parse_url($src, PHP_URL_PATH))) {
                        $height = $data[1];
                        $width  = $data[0];
                    }
                }

                // add noscript before images
                $noscript = $DOM->createElement("noscript");
                $noscript->appendChild($image->cloneNode());
                $image->parentNode->insertBefore($noscript, $image);

                // change src to data-src
                if ($existing_src) {
                    $image->removeAttribute("src");
                    $image->setAttribute("data-src", $existing_src);
                }

                // change srcset to data-srcset
                if ($existing_srcset) {
                    $image->removeAttribute("srcset");
                    $image->setAttribute("data-srcset", $existing_srcset);
                }

                if ($height && $width) {
                    $image->setAttribute("data-aspectratio", "{$width}/{$height}");
                }

                if ($image->nodeName !== "source") {
                    // set the height attribute
                    if ($height) {
                        $image->setAttribute("height", $height);
                    }

                    // set the width attribute
                    if ($width) {
                        $image->setAttribute("width", $width);
                    }

                    // add loading="lazy"
                    $image->setAttribute("loading", "lazy");

                    // add lazyload and __js classes
                    $image->setAttribute("class", "lazyload __js {$image->getAttribute("class")}");
                }
            }
        }

        // remove unneeded tags (inserted for parsing reasons)
        $content = $DOM->saveHTML($DOM->documentElement);
    }

    return $content;
}
add_filter("the_content", "__gulp_init_namespace___lazy_load_images", 30, 1);
add_filter("post_thumbnail_html", "__gulp_init_namespace___lazy_load_images", 20, 1);
add_filter("__gulp_init_namespace___lazy_load_images", "__gulp_init_namespace___lazy_load_images", 20, 1);

/**
 * Add a class to images within the caption shortcode
 *
 * @param  string $shcode
 *
 * @return string
 */
function __gulp_init_namespace___wp_caption_shortcode_add_image_class(string $shcode): string {
    return preg_replace("/(<img[^>]+class=(?:\"|'))/", "$1wp-caption-image ", $shcode);
}
add_filter("image_add_caption_shortcode", "__gulp_init_namespace___wp_caption_shortcode_add_image_class", 10);

/**
 * Remove dimensions from thumbnails
 *
 * @param  string $html
 *
 * @return string
 */
function __gulp_init_namespace___remove_thumbnail_dimensions(string $html): string {
    if (! (is_admin() && ! wp_doing_ajax()) && $html) {
        $DOM = new DOMDocument();

        // disable errors to get around HTML5 warnings...
        libxml_use_internal_errors(true);

        // load in content
        $DOM->loadHTML("<?xml encoding='utf-8' ?><html><body>{$html}</body></html>", LIBXML_HTML_NODEFDTD);

        // reset errors to get around HTML5 warnings...
        libxml_clear_errors();

        $images = $DOM->getElementsByTagName("img");

        foreach ($images as $image) {
            $image->removeAttribute("height");
            $image->removeAttribute("width");
        }

        // remove unneeded tags (inserted for parsing reasons)
        $html = $DOM->saveHTML($DOM->documentElement);
    }

    return $html;
}
add_filter("post_thumbnail_html", "__gulp_init_namespace___remove_thumbnail_dimensions", 40);

/**
 * Add link classes to __gulp_init_namespace___menu_list_link filtered content
 *
 * @param  string $links
 *
 * @return string
 */
function __gulp_init_namespace___menu_list_link_classes(string $links): string {
    if ($links) {
        $DOM = new DOMDocument();

        // disable errors to get around HTML5 warnings...
        libxml_use_internal_errors(true);

        // load in content
        $DOM->loadHTML("<?xml encoding='utf-8' ?><html><body>{$links}</body></html>", LIBXML_HTML_NODEFDTD);

        // reset errors to get around HTML5 warnings...
        libxml_clear_errors();

        $anchors = $DOM->getElementsByTagName("a");

        foreach ($anchors as $anchor) {
            $anchor->setAttribute("class", "menu-list__link link {$anchor->getAttribute("class")}");
        }

        // remove unneeded tags (inserted for parsing reasons)
        $links = $DOM->saveHTML($DOM->documentElement);
    }

    return $links;
}
add_filter("__gulp_init_namespace___menu_list_link", "__gulp_init_namespace___menu_list_link_classes");

/**
 * Redirect to the home template if no front page is set
 *
 * @param  string $template
 *
 * @return string
 */
function __gulp_init_namespace___home_template_redirect(string $template): string {
    if (is_front_page() && get_option("show_on_front") !== "page") {
        $template = locate_template(["home.php", "page.php", "index.php"]);
    }

    return $template;
}
add_filter("template_include", "__gulp_init_namespace___home_template_redirect");

/**
 * Decode HTML entities in `bloginfo("description")`
 *
 * @param  string $value
 * @param  string $field
 *
 * @return string
 */
function __gulp_init_namespace___decode_html_entities_in_blog_description(string $value, string $field): string {
    if ($field === "description") {
        $value = html_entity_decode($value);
    }

    return $value;
}
add_filter("bloginfo", "__gulp_init_namespace___decode_html_entities_in_blog_description", 10, 2);

/**
 * Add "Download Adobe Reader" link on all pages that link to PDFs
 *
 * @return void
 */
function __gulp_init_namespace___acrobat_link(): void {
    global $post;

    if (! is_singular()) return;

    if ($post) {
        $has_pdf = false;
        $content = get_the_content();
        $fields  = function_exists("get_fields") ? get_fields() : false;
        $output  = "";

        if ($content) {
            preg_match("/\.pdf(?:\'|\")/im", $content, $matches);

            if ($matches) {
                $has_pdf = true;
            }
        }

        if ($fields && ! $has_pdf) {
            foreach ($fields as $field) {
                preg_match("/\.pdf(?:\'|\"|$)/im", json_encode($field), $matches);

                if ($matches) {
                    $has_pdf = true;
                    break;
                }
            }
        }

        if ($has_pdf === true) {
            $output .= "<hr class='acrobat__divider divider' />";
            $output .= "<p class='acrobat__text text'>" . sprintf(__("Having trouble opening PDFs? %sDownload Adobe Reader here.%s", "__gulp_init_namespace__"), "<a class='text__link link' href='https://get.adobe.com/reader/' target='_blank' rel='noopener'>", "</a>") . "</p>";
        }

        echo $output;
    }
}
add_filter("__gulp_init_namespace___after_content", "__gulp_init_namespace___acrobat_link");

/**
 * Generate default meta description if none is set
 *
 * @param  string $html
 *
 * @return string
 */
function __gulp_init_namespace___default_wpseo_metadesc(string $html): string {
    global $post;

    if (! $html && is_singular() && $content = wp_strip_all_tags($post->post_content)) {
        return wp_trim_words(str_replace(["\n", "\r"], " ", preg_replace("~(?:\[/?)[^/\]]+/?\]~s", "", $content)), 20, "…");
    }

    return $html;
}
add_filter("wpseo_metadesc", "__gulp_init_namespace___default_wpseo_metadesc");

/**
 * Add (Page %s) to meta descriptions on archives which are paged
 *
 * @param string $html
 * @return string
 */
function __gulp_init_namespace___wpseo_metadesc_archive_pagination(string $html): string {
    global $wp_query;

    if ((is_home() || is_archive()) && is_paged() && $page = get_query_var("paged")) {
        $html .= ($html ? " - " : "") . sprintf(__("Page %s of %s", "__gulp_init_namespace__"), $page, $wp_query->max_num_pages);
    }

    return $html;
}
add_filter("wpseo_metadesc", "__gulp_init_namespace___wpseo_metadesc_archive_pagination");

/**
 * Add `MSIE` and `Trident` to rejected user agents for caching
 *
 * @return void
 */
function __gulp_init_namespace___wp_super_cache_disable_ie_setting(): void {
    global $cache_rejected_user_agent;

    if ($cache_rejected_user_agent) {
        $cache_rejected_user_agent[] = "MSIE";
        $cache_rejected_user_agent[] = "Trident";
    }
}
add_action("init", "__gulp_init_namespace___wp_super_cache_disable_ie_setting");

/**
 * Ensure IE never loads the cached version of the site
 *
 * @param  string $line
 *
 * @return string
 */
function __gulp_init_namespace___wp_super_cache_disable_ie_wp_config($line): string {
    return "if (preg_match('/(Trident|MSIE)/', \$_SERVER['HTTP_USER_AGENT'])) { {$line} }";
}
add_filter("supercache_wp_config_line", "__gulp_init_namespace___wp_super_cache_disable_ie_wp_config");

/**
 * Add `the_content` filters to `comment_text`
 *
 * @param string $comment_text
 * @param object|null $comment
 * @return string
 */
function __gulp_init_namespace___comment_text_the_content(string $comment_text, ?object $comment = null): string {
    return apply_filters("the_content", $comment_text);
}
add_filter("comment_text", "__gulp_init_namespace___comment_text_the_content");

/**
 * Display "missing alt tag" message when editing posts
 *
 * @return void
 */
function __gulp_init_namespace___alt_tag_notice(): void {
    global $pagenow;
    global $post;

    /**
     * Fail out if it's not the post edit page, or a post object does not exit
     */
    if (! ($pagenow === "post.php" && $post)) {
        return;
    }

    $missing_alt = false;

    /**
     * Check if the featured image has an alt tag
     */
    if (has_post_thumbnail($post->ID) && ! get_post_meta(get_post_thumbnail_id($post->ID), "_wp_attachment_image_alt", true)) {
        $missing_alt = true;
    }

    /**
     * Check if ACF images have alt tags
     */
    if (! $missing_alt && function_exists("get_fields") && $acf_fields = get_fields($post->ID)) {
        foreach ($acf_fields as $field) {
            if (is_array($field) && isset($field["alt"]) && trim($field["alt"]) === "") {
                $missing_alt = true; break;
            } elseif (is_string($field) && ! __gulp_init_namespace___imgs_have_alts($field)) {
                $missing_alt = true; break;
            } elseif (is_array($field)) {
                // need to figure out a way to identify nested fields (i.e. repeaters)
            }
        }
    }

    /**
     * Check if post content have alt tags
     */
    if (! $missing_alt && $post && $post->post_content && ! __gulp_init_namespace___imgs_have_alts($post->post_content)) {
        $missing_alt = true;
    }

    /**
     * Display the notice, if necessary
     */
    if ($missing_alt) {
        ?>
        <div class="notice notice-error">
            <p><?php _e("One or more images are missing alternative text; the affected images are outlined in red.", "__gulp_init_namespace__"); ?></p>
        </div>
        <?php
    }

}
add_action("admin_notices", "__gulp_init_namespace___alt_tag_notice");
