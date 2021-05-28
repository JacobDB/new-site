<?php
/* ------------------------------------------------------------------------ *\
 * Ninja Forms
\* ------------------------------------------------------------------------ */

/**
 * Delay when shortcodes get expanded
 *
 * @param  string $value
 *
 * @return string
 */
function __gulp_init_namespace___nf_delay_shortcode_expansion(): void {
    remove_filter("nf_the_content", "do_shortcode", 11);
    add_filter("nf_the_content", "do_shortcode", 26);
}
add_action("wp", "__gulp_init_namespace___nf_delay_shortcode_expansion");

// add classes to elements
add_filter("nf_the_content", "__gulp_init_namespace___add_user_content_classes", 20, 1);

// wrap handorgel accordions
add_filter("nf_the_content", "__gulp_init_namespace___wrap_handorgel_shortcodes", 30, 1);

// enable responsive iframes
add_filter("nf_the_content", "__gulp_init_namespace___responsive_iframes", 20, 1);

// enable responsive tables
add_filter("nf_the_content", "__gulp_init_namespace___responsive_tables", 20, 1);

// lazy load images
add_filter("nf_the_content", "__gulp_init_namespace___lazy_load_images", 30, 1);

/**
 * Disable display styles
 *
 * @return void
 */
function __gulp_init_namespace___ninja_forms_dequeue_display_styles(): void {
    wp_dequeue_style("nf-display");
}
add_action("ninja_forms_enqueue_scripts", "__gulp_init_namespace___ninja_forms_dequeue_display_styles", 999);

/**
 * Change order of scripts so that `nf-front-end` always comes after all dependencies
 *
 * @return void
 */
function __gulp_init_namespace___ninja_forms_fix_scripts_order(): void {
    global $wp_scripts;

    /**
     * - Add all `nf-` prefixed scripts as dependencies of `nf-front-end`
     * - Change `nf-front-end` dependencies to `nf-front-end-deps`
     */
    foreach ($wp_scripts->registered as $script) {
        if (! preg_match("/^nf-(?!front-end(?:-deps)?$)/", $script->handle)) {
            continue;
        }

        // add the script to the dependencies for `nf-front-end`
        $wp_scripts->registered["nf-front-end"]->deps[] = $script->handle;

        if (($key = array_search("nf-front-end", $script->deps)) && $key === false) {
            continue;
        }

        // change the dependency to `nf-front-end-deps`
        $script->deps[$key] = "nf-front-end-deps";
    }
}
add_action("nf_display_enqueue_scripts", "__gulp_init_namespace___ninja_forms_fix_scripts_order");

/**
 * Fix page title on "ninja forms" pages
 *
 * @param  string $title
 *
 * @return string
 */
function __gulp_init_namespace___ninja_forms_fix_wpseo_title(string $title): string {
    global $wpdb;

    $form_id = 0;

    if ($public_link_key = get_query_var("nf_public_link")) {
        $query      = $wpdb->prepare("SELECT `parent_id` FROM {$wpdb->prefix}nf3_form_meta WHERE `key` = 'public_link_key' AND `value` = %s", $public_link_key);
        $results    = $wpdb->get_col($query);
        $form_id    = reset($results);
    } elseif (current_user_can(apply_filters("ninja_forms_admin_all_forms_capabilities", "manage_options")) && isset($_GET["nf_preview_form"])) {
        $form_id = sanitize_text_field($_GET["nf_preview_form"]);
    }

    if ($form_id) {
        $query      = $wpdb->prepare("SELECT `title` FROM {$wpdb->prefix}nf3_forms WHERE `id` = %s", $form_id);
        $results    = $wpdb->get_col($query);
        $form_title = reset($results);

        $title = sanitize_text_field($form_title) . " - " . get_bloginfo("name");
    }

    return $title;
}
add_filter("wpseo_title", "__gulp_init_namespace___ninja_forms_fix_wpseo_title");

/**
 * Redirect to the page template if a ninja form is being viewed
 *
 * @param  string $template
 *
 * @return string
 */
function __gulp_init_namespace___ninja_forms_fix_template(string $template): string {
    if (get_query_var("nf_public_link")) {
        $template = locate_template(["page.php", "index.php"]);
    }

    return $template;
}
add_filter("template_include", "__gulp_init_namespace___ninja_forms_fix_template");

/**
 * Fix various HTML field formatting
 *
 * @param  array<array<mixed>> $fields
 *
 * @return array<array<mixed>>
 */
function __gulp_init_namespace___ninja_forms_format_html(array $fields): array {
    if (is_admin()) return $fields;

    foreach ($fields as $key => $field) {
        if (isset($field["desc_text"]) && trim($field["desc_text"])) {
            $fields[$key]["desc_text"] = apply_filters("nf_the_content", stripslashes($field["desc_text"]));
        }

        if (isset($field["help_text"]) && trim($field["help_text"])) {
            $fields[$key]["help_text"] = apply_filters("nf_the_content", stripslashes($field["help_text"]));
        }

        if (isset($field["type"]) && $field["type"] === "html" && isset($field["value"]) && trim($field["value"])) {
            $fields[$key]["value"] = apply_filters("nf_the_content", stripslashes($field["value"]));
        }
    }

    return $fields;
}
add_filter("ninja_forms_display_fields", "__gulp_init_namespace___ninja_forms_format_html", 10, 1);

/**
 * Fix success message formatting
 *
 * @param  array<mixed> $action_settings
 *
 * @return array<mixed>
 */
function __gulp_init_namespace___ninja_forms_format_success_message(array $action_settings): array {
    if ($action_settings["type"] === "successmessage") {
        $action_settings["success_msg"] = apply_filters("nf_the_content", $action_settings["success_msg"]);
    }

    return $action_settings;
}
add_filter("ninja_forms_run_action_settings", "__gulp_init_namespace___ninja_forms_format_success_message", 10, 1);

/**
 * Disable the "Append a Ninja Form" button, to prevent conflicts with `the_content`
 *
 * @return void
 */
function __gulp_init_namespace___ninja_forms_disable_append_metabox(): void {
    remove_meta_box("nf_admin_metaboxes_appendaform", ["page", "post"], "side");
}
add_action("add_meta_boxes", "__gulp_init_namespace___ninja_forms_disable_append_metabox");

/**
 * Add missing formHoneypot label
 *
 * @param  array<string> $nfi18n
 *
 * @return array<string>
 */
function __gulp_init_namespace___ninja_forms_honeypot_label(array $nfi18n): array {
    if (! isset($nfi18n["formHoneypot"])) {
        $nfi18n["formHoneypot"] = __("If you are a human seeing this field, please leave it empty.", "__gulp_init_namespace__");
    }

    return $nfi18n;
}
add_filter("ninja_forms_i18n_front_end", "__gulp_init_namespace___ninja_forms_honeypot_label");

/**
 * Adjust Ninja Forms modal styles to fix conflict with ACF
 *
 * @param  string $context
 *
 * @return string
 */
function __gulp_init_namespace___ninja_forms_acf_fix_styles(string $context): string {
    global $wp_styles;

    wp_add_inline_style("jBox", "#nf-insert-form-modal .ui-icon { display: inline-block; text-indent: 0; }");

    return $context;
}
add_filter("media_buttons_context", "__gulp_init_namespace___ninja_forms_acf_fix_styles", 20);
