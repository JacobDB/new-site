<?php
/* ------------------------------------------------------------------------ *\
 * Menus
\* ------------------------------------------------------------------------ */

/**
 * Register the menus
 *
 * @return void
 */
function __gulp_init_namespace___register_nav_menus(): void {
    register_nav_menus([
        "primary" => __("Navigation", "__gulp_init_namespace__"),
    ]);
}
add_action("init", "__gulp_init_namespace___register_nav_menus");

/**
 * Custom menu walker that adds BEM classes and supports custom fields
 */
class __gulp_init_namespace___menu_walker extends Walker_Nav_Menu {
    /**
     * Set up a variable to hold the parameters passed to the walker
     */
    private $params;

    /**
     * Store parameters in a more accessible way
     *
     * @param  array<mixed> $params
     *
     * @return void
     */
    public function __construct(array $params = []) {
        $this->params = $params;
    }

    /**
     * Set up variables for a11y and mega menu features
     */
    private $is_mega      = false;
    private $column_limit = 3;
    private $column_count = 0;
    private $item_count   = 0;
    private $current_item = 0;

    /**
     * Check if the current item contains mega menu columns
     *
     * @param  object $element
     * @param  array<mixed> $children_elements
     * @param  int $max_depth
     * @param  int $depth
     * @param  array<mixed> $args
     * @param  string $output
     *
     * @return void
     */
    function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output): void {
        $features = isset($this->params["features"]) ? $this->params["features"] : [];

        if (in_array("mega", $features) && $depth === 0 && isset($children_elements[$element->ID]) && $children_elements[$element->ID]) { $i = 0;
            foreach ($children_elements[$element->ID] as $child) { $i++;
                /**
                 * Only check meta keys past the first item to (slightly) improve performance
                 */
                if ($i > 1) {
                    $has_columns = get_post_meta($child->ID, "_menu_item_column_start", true);
                    $parent_id   = get_post_meta($child->ID, "_menu_item_menu_item_parent", true);

                    if ($has_columns === "true" && intval($parent_id) === $element->ID) {
                        $this->is_mega = true;
                    }
                }
            }
        }

        /**
         * Pass on the element as is
         */
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    /**
     * Construct a menu item
     *
     * @param  string $output
     * @param  object $item
     * @param  int $depth
     * @param  array<mixed> $args
     * @param  int $id
     *
     * @return void
     */
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0): void {
        $id_prefix = isset($this->params["id_prefix"]) ? $this->params["id_prefix"] : "menu-item-";
        $features  = isset($this->params["features"]) ? $this->params["features"] : [];

        /**
         * Get the array of classes for the current menu item
         */
        $classes = $item->classes ? $item->classes : [];

        /**
         * Handle splitting drop downs for mega menus
         */
        if (in_array("mega", $features) && $this->is_mega) {
            /**
             * Reset the item counter if it's reached the top
             */
            if ($depth === 0) $this->item_count = 0;

            /**
             * Reset the column counter if it's the first li in a drop down
             */
            if ($depth === 1 && $this->item_count === 1) $this->column_count = 0;

            /**
             * Add the `menu-list__item--mega` class if it's the top
             */
            if ($depth === 0) $classes[] = "menu-list__item--mega";

            /**
             * Split the menu if it's a drop down, a split has been requested, it's
             * not the first li, and the column limit hasn't been reached
             */
            if ($depth === 1 && get_post_meta($item->ID, "_menu_item_column_start", true) && $this->item_count > 1 && $this->column_count < $this->column_limit) {
                $output .= "</ul><ul class='menu-list menu-list--vertical menu-list--child menu-list--depth-1 menu-list--mega'>";

                /**
                 * Increment the column counter
                 */
                $this->column_count++;
            }

            /**
             * Increment the item counter
             */
            $this->item_count++;
        }

        /**
         * Set up custom classes for "transpiling"
         */
        $custom_classes = [
            [
                "original" => "menu-item",
                "custom"   => "menu-list__item",
            ],
            [
                "original" => "current_page_item",
                "custom"   => "is-viewed",
            ],
            [
                "original" => "menu-item-has-children",
                "custom"   => "menu-list__item--parent",
            ],
        ];

        /**
         * "Transpile" WordPress classes to custom classes
         */
        foreach ($custom_classes as $class) {
            if (in_array($class["original"], $classes) && ! in_array($class["custom"], $classes)) {
                $classes[] = $class["custom"];
            }
        }

        /**
         * Construct a class attribute
         */
        $class_names = " class='" . esc_attr(join(" ", apply_filters("nav_menu_css_class", array_filter($classes), $item))) . "'";

        /**
         * Set up the ID in such as way as to prevent conflicts
         */
        $item_id = "{$id_prefix}{$item->ID}";

        /**
         * Construct a title attribute if specified
         */
        $attr_title = $item->attr_title ? " title='" . esc_attr($item->attr_title) . "'" : "";

        /**
         * Construct a target attribute if specified
         */
        $target = $item->target ? " target='{$item->target}'" : "";

        /**
         * If no rel is set, and URL is external, set rel to `noopener`
         */
        if (__gulp_init_namespace___is_external_url($item->url)) {
            $item->xfn = ! $item->xfn ? "noopener" : "{$item->xfn} noopener";
        }

        /**
         * Construct a rel attribute if specified
         */
        $xfn = $item->xfn ? " rel='" . esc_attr($item->xfn) . "'" : "";

        /**
         * Construct an aria-description attribute if enabled and specified
         */
        $aria = [
            "describedby" => in_array("description", $features) && $item->description ? " aria-describedby='{$item_id}_description'" : "",
            "description" => in_array("description", $features) && $item->description ? " <span class='menu-item__description' id='{$item_id}_description'>{$item->description}</span>" : "",
        ];

        /**
         * Update the current item
         */
        $this->current_item = $item_id;

        /**
         * Construct the menu item
         */
        $output .= sprintf(
            "<li%s id='%s'><a class='menu-list__link link' href='%s'%s%s%s%s>%s</a>%s",
            $class_names,
            $item_id,
            $item->url,
            $attr_title,
            $target,
            $xfn,
            $aria["describedby"],
            $item->title,
            $aria["description"]
        );
    }

    /**
     * Construct the sub-menu ul
     *
     * @param  string $output
     * @param  int $depth
     * @param  array<mixed> $args
     *
     * @return void
     */
    public function start_lvl(&$output, $depth = 0, $args = []): void {
        $features = isset($this->params["features"]) ? $this->params["features"] : [];

        /**
         * Set up a variable to contain a toggle button
         */
        $toggle = "";

        if (in_array("accordion", $features) || in_array("hover", $features) || in_array("touch", $features)) {
            $toggle_class = "";

            /**
             * Add the __visuallyhidden class if it's a hover-based menu
             */
            if (in_array("hover", $features) && ! in_array("accordion", $features)) {
                $toggle_class .= " __visuallyhidden";
            }

            /**
             * Construct a toggle
             */
            $toggle .= "<button class='menu-list__toggle{$toggle_class}' id='{$this->current_item}_toggle' aria-controls='{$this->current_item}_child'><i class='toggle__icon fas fa-caret-down' aria-hidden='true'></i><span class='__visuallyhidden' data-alt='" . esc_attr__("Close Child Menu", "__gulp_init_namespace__") . "'>" . __("Open Child Menu", "__gulp_init_namespace__") . "</span></button>";
        }

        /**
         * Add a class based on depth
         */
        $variant = " menu-list--depth-" . ($depth + 1);

        /**
         * Add classes based on features
         */
        if ($this->is_mega) {
            $variant .= " menu-list--mega";
        } else {
            if (in_array("accordion", $features)) {
                $variant .= " menu-list--accordion";
            } elseif (in_array("hover", $features) || in_array("touch", $features)) {
                $variant .= " menu-list--overlay" . ($depth >= 1 ? " menu-list--flyout" : "");
            }
        }

        /**
         * Set up a variable to contain custom attributes
         */
        $attr = "";

        /**
         * Construct data attributes for the menu script to read
         */
        if (in_array("accordion", $features)) $attr .= " data-accordion='true'";
        if (in_array("hover", $features)) $attr .= " data-hover='true'";
        if (in_array("touch", $features)) $attr .= " data-touch='true'";

        /**
         * Construct an aria-hidden if appropriate
         */
        $attr .= in_array("hover", $features) || in_array("touch", $features) ? " aria-hidden='true' aria-controlledby='{$this->current_item}_toggle' aria-live='polite'" : "";

        /**
         * Construct a container for mega menus at depth 0
         */
        if (in_array("mega", $features) && $this->is_mega && $depth === 0) {
            /**
             * Append the container to the toggle
             */
            $toggle .= "<div class='menu-list__container menu-list__container--mega'{$attr}>";

            /**
             * Reset data and aria as they should not be applied to lists within a mega menu
             */
            $attr = "";
        }

        /**
         * Construct the ul
         */
        $output .= "{$toggle}<ul id='{$this->current_item}_child' class='menu-list menu-list--vertical menu-list--child{$variant}'{$attr}>";
    }

    /**
     * Construct the closing sub-menu ul
     *
     * @param  string $output
     * @param  int $depth
     * @param  array<mixed> $args
     *
     * @return void
     */
    public function end_lvl(&$output, $depth = 0, $args = []): void {
        $features = isset($this->params["features"]) ? $this->params["features"] : [];

        /**
         * Close the list
         */
        $output .= "</ul>";

        /**
         * Close the container for mega menus
         */
        if (in_array("mega", $features) && $this->is_mega && $depth === 0) {
            $output .= "</div>";

            /**
             * Reset mega menu status
             */
            $this->is_mega = false;
        }
    }

    /**
     * Construct the closing li
     *
     * @param  string $output
     * @param  object $item
     * @param  int $depth
     * @param  array<mixed> $args
     *
     * @return void
     */
    public function end_el(&$output, $item, $depth = 0, $args = []): void {
        /**
         * Close the menu item
         */
        $output .= "</li>";
    }
}

/**
 * Add custom fields to the menu editor
 */
if (is_admin() && $pagenow === "nav-menus.php") {
    // include this so we can access Walker_Nav_Menu_Edit
    require_once ABSPATH . "wp-admin/includes/nav-menu.php";

    /**
     * Add the WordPress color picker styles & scripts
     *
     * @return void
     */
    function __gulp_init_namespace___nav_menu_color_picker(): void {
        wp_enqueue_style("wp-color-picker");
        wp_enqueue_script("wp-color-picker");
    }
    add_action("admin_enqueue_scripts", "__gulp_init_namespace___nav_menu_color_picker");

    class __gulp_init_namespace___create_custom_menu_options extends Walker_Nav_Menu_Edit {
        private static $displayed_fields = [];

        /**
         * Create an array with all the new fields
         *
         * @return array<array<array<string>|string>>
         */
        static function get_custom_fields(): array {
            return [
                [
                    "locations"   => ["primary"],
                    "type"        => "checkbox",
                    "name"        => "column_start",
                    "label"       => __("Start a new column here", "__gulp_init_namespace__"),
                    "description" => "",
                    "scripts"     => "",
                    "styles"      => ".menu-item:not(.menu-item-depth-1) .field-column_start, .menu-item.menu-item-depth-0 + .menu-item.menu-item-depth-1 .field-column_start {display:none;}",
                    "value"       => "true",
                ],
            ];
        }

        /**
         * Get a specific custom field template
         *
         * @param  array<mixed> $field
         * @param  object|null $item
         *
         * @return string
         */
        static function get_custom_field(array $field, ?object $item = null): string {
            $templates = [
                "label"         => "<p class='field-{{ field_name }} description description-wide hidden-field' data-locations='{{ field_locations }}'>
                                    <label for='edit-menu-item-{{ field_name }}-{{ item_id }}'>
                                    {{ field_markup }}
                                    </label>
                                    </p>",
                "description"   => "<span class='description'>{{ field_description }}</span>",
                "checkbox"      => "<input id='edit-menu-item-{{ field_name }}-{{ item_id }}' name='menu-item-{{ field_name }}[{{ item_id }}]' value='{{ field_value }}' type='checkbox'{{ item_checked }} />
                                    {{ field_label }}",
                "color"         => "{{ field_label }}<br>
                                    <span><input id='edit-menu-item-{{ field_name }}-{{ item_id }}' class='widefat edit-menu-item-{{ field_name }} __gulp_init_namespace__-color-picker' name='menu-item-{{ field_name }}[{{ item_id }}]' value='{{ item_value }}' type='text' /></span>",
                "radio"         => "{{ field_options }}",
                "radio_option"  => "<label for='edit-menu-item-{{ field_name }}-{{ item_id }}-{{ option_value_sanitized }}'>
                                    <input id='edit-menu-item-{{ field_name }}-{{ item_id }}-{{ option_value_sanitized }}' name='menu-item-{{ field_name }}[{{ item_id }}]' value='{{ option_value }}' type='radio'{{ option_checked }} />
                                    {{ option_label }}
                                    </label>&nbsp;&nbsp;",
                "select"        => "{{ field_label }}<br>
                                    <select id='edit-menu-item-{{ field_name }}-{{ item_id }}' class='widefat edit-menu-item-{{ field_name }}' rows='3' col='20' name='menu-item-{{ field_name }}[{{ item_id }}]'{{ field_multiple }}>
                                    {{ field_options }}
                                    </select>",
                "select_option" => "<option value='{{ option_value }}'{{ option_selected }}>{{ option_label }}</option>",
                "text"          => "{{ field_label }}<br>
                                    <input id='edit-menu-item-{{ field_name }}-{{ item_id }}' class='widefat edit-menu-item-{{ field_name }}' name='menu-item-{{ field_name }}[{{ item_id }}]' value='{{ item_value }}' type='text' />",
                "textarea"      => "{{ field_label }}<br>
                                    <textarea id='edit-menu-item-{{ field_name }}-{{ item_id }}' class='widefat edit-menu-item-{{ field_name }}' rows='3' col='20' name='menu-item-{{ field_name }}[{{ item_id }}]'>{{ item_value }}</textarea>",
            ];

            // retrieve the existing value from the database
            $item_value = $item !== null ? get_post_meta($item->ID, "_menu_item_{$field["name"]}", true) : null;

            // duplicate the template
            $markup = $templates[$field["type"]];

            // replace shared placeholders
            if ($item !== null) {
                $markup = str_replace("{{ item_id }}", $item->ID, $markup);
                $markup = str_replace("{{ item_value }}", $item_value, $markup);
                $markup = str_replace("{{ item_checked }}", checked($item_value, isset($field["value"]) ? $field["value"] : false, false), $markup);
            }

            $markup = str_replace("{{ field_label }}", $field["label"], $markup);
            $markup = str_replace("{{ field_name }}", $field["name"], $markup);
            $markup = str_replace("{{ field_multiple }}", (isset($field["multiple"]) && $field["multiple"] === "true" ? "multiple" : ""), $markup);
            $markup = str_replace("{{ field_value }}", isset($field["value"]) ? $field["value"] : null, $markup);

            // apply special replacements for `radio` and `select` fields
            if ($field["type"] === "radio" || $field["type"] === "select") {
                $template_option = $templates["{$field["type"]}_option"];

                $field_options = "";

                foreach ($field["options"] as $value => $label) {
                    // duplicate the template
                    $markup_option = $template_option;

                    // replace placeholders with actual values
                    $markup_option = $item !== null ? str_replace("{{ item_id }}", $item->ID, $markup_option) : $markup_option;
                    $markup_option = str_replace("{{ field_name }}", $field["name"], $markup_option);
                    $markup_option = str_replace("{{ option_label }}", $label, $markup_option);
                    $markup_option = str_replace("{{ option_value }}", $value, $markup_option);
                    $markup_option = str_replace("{{ option_value_sanitized }}", sanitize_title($value), $markup_option);
                    $markup_option = str_replace("{{ option_checked }}", checked($item_value, $value, false), $markup_option);
                    $markup_option = str_replace("{{ option_selected }}", ($item_value === $value ? " selected" : ""), $markup_option);

                    // append the option
                    $field_options .= $markup_option;
                }

                // replace the {{ field_options }} placeholder with `<option>` elements
                $markup = str_replace("{{ field_options }}", $field_options, $markup);
            }

            // apply special replacements for fields with `description` values
            if ($field["description"]) {
                // retrieve the template for descriptions
                $template_description = $templates["description"];

                // add a line break after radio or checkbox fields
                if (in_array($field["type"], ["radio", "checkbox"])) {
                    $markup .= "<br>";
                }

                // duplicate the template
                $markup_description = $template_description;

                // replace the placeholder
                $markup_description = str_replace("{{ field_description }}", $field["description"], $markup_description);

                // append to the markup
                $markup .= $markup_description;
            }

            // duplicate the label template
            $markup_label = $templates["label"];

            // replace the placeholders
            $markup_label = str_replace("{{ field_name }}", $field["name"], $markup_label);
            $markup_label = str_replace("{{ field_locations }}", json_encode($field["locations"]), $markup_label);
            $markup_label = $item !== null ? str_replace("{{ item_id }}", $item->ID, $markup_label) : $markup_label;

            // replace the final placeholder and return the value
            return str_replace("{{ field_markup }}", $markup, $markup_label);
        }

        /**
         * Append the new fields to the menu system
         *
         * @param  string $output
         * @param  object $item
         * @param  int $depth
         * @param  array<mixed> $args
         * @param  int $id
         *
         * @return void
         */
        function start_el(&$output, $item, $depth = 0, $args = [], $id = 0): void {
            $all_menus      = get_nav_menu_locations();
            $assigned_menus = get_the_terms($item->ID, "nav_menu");

            $custom_fields = self::get_custom_fields();

            $fields_markup = "";

            // get the menu item
            parent::start_el($item_output, $item, $depth, $args);

            // set up each new custom field
            foreach ($custom_fields as $field) {
                // if fixed locations are set, see if the menu is assigned to that location, and if not, skip the field
                if ($field["locations"]) {
                    $hidden = " hidden-field";

                    if ($all_menus) {
                        foreach ($field["locations"] as $location) {
                            if (isset($all_menus[$location])) {
                                foreach ($assigned_menus as $assigned_menu) {
                                    if ($assigned_menu->term_id === $all_menus[$location]) {
                                        $hidden = "";
                                        break;
                                    }
                                }
                            }

                            if ($hidden === "") break;
                        }
                    }
                }

                // store the displayed fields for later use
                if ($hidden === "" && ! in_array($field["name"], self::$displayed_fields)) {
                    self::$displayed_fields[] = $field["name"];
                }

                // append to the fields markup
                $fields_markup .= str_replace(" hidden-field", $hidden, self::get_custom_field($field, $item));
            }

            // insert the new markup before the fieldset tag
            $item_output = preg_replace("/(<fieldset)/", "<div class='custom-fields-container'>{$fields_markup}</div>$1", $item_output);

            // update the output
            $output .= $item_output;
        }

        /**
         * Save the new fields
         *
         * @param  int $post_id
         *
         * @return void
         */
        static function save_field_data(int $post_id): void {
            if (get_post_type($post_id) !== "nav_menu_item") return;

            $post_object   = get_post($post_id);
            $custom_fields = self::get_custom_fields();

            foreach ($custom_fields as $field) {
                $POST_key = "menu-item-{$field["name"]}";
                $meta_key = "_menu_item_{$field["name"]}";

                $field["value"] = isset($_POST[$POST_key][$post_id]) ? sanitize_text_field($_POST[$POST_key][$post_id]) : "";

                // validate the color picker
                if ($field["type"] === "color" && $field["value"] !== "" && ! preg_match("/^#[a-f0-9]{6}$/i", $field["value"])) {
                    $field["value"] = "";

                    add_action("admin_notices", static function () use ($post_object) {
                        echo "<div class='notice notice-error'><p>" . sprintf(__("Invalid HEX color code entered for '%s' [%s].", "__gulp_init_namespace__"), $post_object->post_title, $post_object->ID) . "</p></div>";
                    });
                }

                update_post_meta($post_id, $meta_key, $field["value"]);
            }
        }

        /**
         * Add the save function to the save_post action
         *
         * @return void
         */
        static function setup_custom_fields(): void {
            add_action("save_post", ["__gulp_init_namespace___create_custom_menu_options", "save_field_data"]);
        }

        /**
         * Localize the custom fields to wp-admin.js
         *
         * @return void
         */
        static function localize_custom_fields(): void {
            $all_custom_fields = self::get_custom_fields();

            $l10n = [
                "custom_fields" => [],
            ];

            foreach ($all_custom_fields as $field) {
                $l10n["custom_fields"][] = self::get_custom_field($field);
            }

            wp_localize_script("__gulp_init_namespace__-scripts-wp-admin", "l10n", $l10n);
        }

        /**
         * Insert field custom scripts in to the admin footer
         *
         * @return void
         */
        static function insert_custom_scripts(): void {
            $custom_fields = self::get_custom_fields();

            foreach ($custom_fields as $field) {
                if ($field["scripts"]) {
                    echo "<script>{$field["scripts"]}</script>";
                }
            }
        }

        /**
         * Insert field custom styles in to the admin header
         *
         * @return void
         */
        static function insert_custom_styles(): void {
            $custom_fields = self::get_custom_fields();

            foreach ($custom_fields as $field) {
                if ($field["styles"]) {
                    echo "<style>{$field["styles"]}</style>";
                }
            }
        }

        /**
         * Insert the screen options
         *
         * @param  array<string> $args
         *
         * @return array<string>
         */
        static function insert_custom_screen_options(array $args): array {
            $custom_fields = self::get_custom_fields();

            foreach ($custom_fields as $field) {
                if (in_array($field["name"], self::$displayed_fields)) {
                    $args[$field["name"]] = $field["label"];
                }
            }

            return $args;
        }
    }
    add_action("init", ["__gulp_init_namespace___create_custom_menu_options", "setup_custom_fields"]);
    add_action("admin_footer", ["__gulp_init_namespace___create_custom_menu_options", "localize_custom_fields"]);
    add_action("admin_footer", ["__gulp_init_namespace___create_custom_menu_options", "insert_custom_scripts"]);
    add_action("admin_head", ["__gulp_init_namespace___create_custom_menu_options", "insert_custom_styles"]);
    add_filter("manage_nav-menus_columns", ["__gulp_init_namespace___create_custom_menu_options", "insert_custom_screen_options"], 20);
    add_filter("wp_edit_nav_menu_walker", static function () {
        return "__gulp_init_namespace___create_custom_menu_options";
    });
}

/**
 * Add sub_menu options to wp_nav_menu
 *
 * @param  array<object> $menu_items
 * @param  object $args
 *
 * @return array<object>
 */
function __gulp_init_namespace___nav_menu_sub_menu(array $menu_items, object $args): array {
    /**
     * Return unmodified if `sub_menu` is not set or is falsey
     */
    if (!isset($args->sub_menu) || $args->sub_menu == false) {
        return $menu_items;
    }

    /**
     * Convert `sub_menu` argument in to an array if it's not already
     */
    $sub_menu = is_array($args->sub_menu) ? $args->sub_menu : [];

    /**
     * Set required values
     */
    $sub_menu["fallback"]  = isset($sub_menu["fallback"])  ? $sub_menu["fallback"]  : "root";
    $sub_menu["viewed_id"] = isset($sub_menu["viewed_id"]) ? $sub_menu["viewed_id"] : null;

    /**
     * Store the original array for fallback purposes
     */
    $menu_items_orig = $menu_items;

    /**
     * Store the viewed and root items for reference
     */
    $viewed_item = null;
    $root_item   = null;

    /**
     * Find the viewed item
     */
    foreach ($menu_items as $menu_item) {
        $is_viewed = false;

        /**
         * If no viewed ID is set, find the currently viewed menu item
         */
        if ($sub_menu["viewed_id"] === null && $menu_item->current === true) {
            $is_viewed = true;
        }

        /**
         * If a viewed ID is set, convert it from a post ID to a menu item
         */
        if ($sub_menu["viewed_id"] && intval($menu_item->object_id) === $sub_menu["viewed_id"]) {
            $is_viewed = true;
        }

        /**
         * Store the viewed item
         */
        if ($is_viewed) {
            $menu_item->current = 1;
            $viewed_item = $menu_item;
            $root_item   = $menu_item;
            break;
        }
    }

    /**
     * Ensure a viewed item was found to prevent infinite loops
     */
    if ($viewed_item) {
        /**
         * Find the root item
         */
        while (intval($root_item->menu_item_parent) !== 0) {
            foreach ($menu_items as $menu_item) {
                if ($menu_item->ID === intval($root_item->menu_item_parent)) {
                    $root_item = $menu_item; break;
                }
            }
        }

        /**
         * Mark each menu item with `current_item_descendant` and `current_item_child`
         */
        foreach ($menu_items as $menu_item) {
            /**
             * Add the values to the item
             */
            $menu_item->current_item_descendant = null;
            $menu_item->current_item_child      = intval($menu_item->menu_item_parent) === $viewed_item->ID;

            /**
             * Determine whether the item is a descendant of the viewed item
             */
            $parent_item = $menu_item;

            while (intval($parent_item->menu_item_parent) !== 0) {
                foreach ($menu_items as $menu_item_2) {
                    if ($menu_item_2->ID === intval($parent_item->menu_item_parent)) {
                        $parent_item = $menu_item_2;

                        if (! $menu_item->current_item_ancestor && $parent_item->current) {
                            $menu_item->current_item_descendant = 1; break;
                        }
                    }
                }
            }
        }

        /**
         * Remove menu items
         */
        foreach ($menu_items as $key => $menu_item) {
            $remove = false;

            /**
             * Remove all root menu items, except if the item is part of the viewed tree
             */
            if ($menu_item->ID !== $viewed_item->ID && ! $menu_item->current_item_ancestor && intval($menu_item->menu_item_parent) === 0) {
                $remove = true;
            }

            /**
             * Only if not viewing the root item, remove items which:
             * - Are not children of the root item
             * - Are not children of the viewed items parent
             * - Are not within the currently viewed tree
             */
            if ($menu_item->ID !== $viewed_item->ID && ! in_array(intval($menu_item->menu_item_parent), [$root_item->ID, intval($viewed_item->menu_item_parent)]) && ! ($menu_item->current || $menu_item->current_item_ancestor || $menu_item->current_item_descendant)) {
                $remove = true;
            }

            /**
             * Remove the item if it has been marked
             */
            if ($remove) {
                unset($menu_items[$key]);
            }
        }
    }

    /**
     * If no items remain, use a fallback strategy
     */
    if ($sub_menu["fallback"] !== false && (! $viewed_item || count($menu_items) === 0)) {
        if ($sub_menu["fallback"] === "root") {
            $menu_items = $menu_items_orig;
        }
    }

    /**
     * Return the sorted menu items
     */
    return $menu_items;
}
add_filter("wp_nav_menu_objects", "__gulp_init_namespace___nav_menu_sub_menu", 10, 2);
