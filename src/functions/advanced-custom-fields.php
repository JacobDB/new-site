<?php
/* ------------------------------------------------------------------------ *\
 * Advanced Custom Fields
\* ------------------------------------------------------------------------ */

/* FUNCTIONS */

/**
 * Wrapper around ACF's `get_field` to ensure errors don't occur if ACF isn't active
 *
 * @param string $name  ACF field name
 * @param mixed $post_id  An ID for a post
 *
 * @return mixed  The field value
 */
function __gulp_init_namespace___get_field(string $name, $post_id = null) {
    if (function_exists("get_field")) {
        return apply_filters("__gulp_init_namespace___acf_format_value", get_field($name, $post_id));
    } else {
        return false;
    }
}

/* FILTERS */

/**
 * Convert phone numbers from objects to arrays
 *
 * @param mixed $value
 * @return mixed
 */
function __gulp_init_namespace___acf_format_phone_number_value($value) {
    if ($value instanceof Log1x\AcfPhoneNumber\PhoneNumber) {
        $value = $value->toArray();
    }

    return $value;
}
add_filter("__gulp_init_namespace___acf_format_value", "__gulp_init_namespace___acf_format_phone_number_value", 10, 1);

/**
 * Filter out badly encoded characters from strings
 *
 * @param  mixed $value
 * @return mixed
 */
function __gulp_init_namespace___acf_remove_broken_characters($value) {
    if (is_string($value)) {
        $value = __gulp_init_namespace___remove_broken_characters($value);
    } elseif (is_array($value) && isset($value["title"]) && is_string($value["title"])) {
        $value["title"] = __gulp_init_namespace___remove_broken_characters($value["title"]);
    }

    return $value;
}
add_filter("acf/format_value", "__gulp_init_namespace___acf_remove_broken_characters", 10);

/**
 * Delay when shortcodes get expanded
 *
 * @param  string $value
 *
 * @return string
 */
function __gulp_init_namespace___acf_delay_shortcode_expansion(): void {
    remove_filter("acf_the_content", "do_shortcode", 11);
    add_filter("acf_the_content", "do_shortcode", 25);
}
add_action("wp", "__gulp_init_namespace___acf_delay_shortcode_expansion");

// add classes to elements
add_filter("acf_the_content", "__gulp_init_namespace___add_user_content_classes", 20);

// wrap handorgel accordions
add_filter("acf_the_content", "__gulp_init_namespace___wrap_handorgel_shortcodes", 30);

// enable responsive iframes
add_filter("acf_the_content", "__gulp_init_namespace___responsive_iframes", 20);

// enable responsive tables
add_filter("acf_the_content", "__gulp_init_namespace___responsive_tables", 20);

// lazy load images
add_filter("acf_the_content", "__gulp_init_namespace___lazy_load_images", 30);

/* REGISTRATIONS */

// Start Alert Bar Options
if( function_exists('acf_add_options_page') && function_exists('acf_add_local_field_group') ):

acf_add_options_page(array(
    'page_title' => __('Alert Bar', '__gulp_init_namespace__'),
    'menu_slug' => 'alert',
    'post_id' => 'alert',
    'icon_url' => 'dashicons-warning',
    'position' => 40,
));

acf_add_local_field_group(array(
    'key' => 'group_6046984bae3d8',
    'title' => 'Alert Bar',
    'fields' => array(
        array(
            'key' => 'field_604698529b3bb',
            'label' => '',
            'name' => 'content',
            'type' => 'wysiwyg',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'alert',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));

endif;
// End Alert Bar Options

// Start Progressive Web App
if( function_exists('acf_add_options_page') && function_exists('acf_add_local_field_group') ):

$blog_name = get_bloginfo('name');

acf_add_options_page(array(
    'page_title' => __('Progressive Web App', '__gulp_init_namespace__'),
    'menu_slug' => 'pwa',
    'parent_slug' => 'options-general.php',
    'post_id' => 'pwa',
));

acf_add_local_field_group(array(
    'key' => 'group_5bdb3c08793a1',
    'title' => 'Settings: Progressive Web App',
    'fields' => array(
        array(
            'key' => 'field_5bdb3c129bb39',
            'label' => __('Name', '__gulp_init_namespace__'),
            'name' => 'full_name',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => $blog_name ? $blog_name : '<%= pwa_name %>',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_5bdb3c199bb3a',
            'label' => __('Short Name', '__gulp_init_namespace__'),
            'name' => 'short_name',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => $blog_name ? $blog_name : '<%= pwa_short_name %>',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_5bdb3c1f9bb3b',
            'label' => __('Theme Color', '__gulp_init_namespace__'),
            'name' => 'theme_color',
            'type' => 'color_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '<%= pwa_theme_color %>',
        ),
        array(
            'key' => 'field_5bdb3c299bb3c',
            'label' => __('Background Color', '__gulp_init_namespace__'),
            'name' => 'background_color',
            'type' => 'color_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '<%= pwa_theme_color %>',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'pwa',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));

endif;
// End Progressive Web App

// Start Theme Options
if( function_exists('acf_add_options_page') ):

acf_add_options_page(array(
    'page_title' => __('Theme Options', '__gulp_init_namespace__'),
    'menu_slug' => 'theme',
    'parent_slug' => 'options-general.php',
    'post_id' => 'theme',
));

endif;
// End Theme Options
