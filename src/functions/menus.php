<?php
/* ------------------------------------------------------------------------ *\
 * Functions: Menus
\* ------------------------------------------------------------------------ */

// register the menus
register_nav_menus(array(
	"primary" => "Navigation",
));

// menu walker
class new_site_menu_walker extends Walker_Nav_Menu {
    // set up a variable to hold the parameters passed to the walker
    private $params;

    // store the paramters in an accessible way
    public function __construct($params = "") {
        $this->params = $params;
    }

    // set up mega menu variables
	private $column_limit = 3;
	private $column_count = 0;
    static $li_count = 0;
    private $is_mega = false;

    function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        // convert the params in to an array
        $params = explode(" ", $this->params);

        if (in_array("mega", $params) && isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID])) {
            $i = 0;

            foreach ($children_elements[$element->ID] as $child) {
                $has_columns = get_post_meta($child->ID, "_menu_item_column");
                $parent_id = get_post_meta($child->ID, "_menu_item_menu_item_parent");

                $i++;

                if ($i > 1) {
                    if (intval($has_columns[0]) === 1 && intval($parent_id[0]) === $element->ID) {
                        array_push($element->classes, "-mega");
                        break;
                    }
                }
            }

        }

        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        // convert the params in to an array
        $params = explode(" ", $this->params);

        // get the current classes
        $classes = $item->classes ? $item->classes : array();

        // add the menu-list_item class if the classes array contains menu-item
        if (in_array("menu-item", $classes))
            array_push($classes, "menu-list_item");

        // add the is-viewed class if the page is currently be viewed
        if (in_array("current_page_item", $classes))
            array_push($classes, "is-viewed");

        // add the is-viewed class if the page is currently be viewed
        if (in_array("current_page_item", $classes))
            array_push($classes, "is-viewed");

        // add a the -parent class if the page has children
        if (in_array("menu-item-has-children", $classes))
            array_push($classes, "-parent");

        // convert the clean_classes array in to usable string
        $class_names = " class='" . esc_attr(join(" ", apply_filters("nav_menu_css_class", array_filter($classes), $item))) . "'";

        // retrieve the URL
        $url = $item->url;

        // retrieve and sanitize the title attribute
        $attr_title = $item->attr_title ? " title='" . htmlentities($item->attr_title, ENT_QUOTES) . "'" : "";

        // retrieve the target
        $target = $item->target ? " target='{$item->target}'" : "";

        // retrieve and sanitize the rel attribute
        $xfn = $item->xfn ? " rel='" . htmlentities($item->xfn, ENT_QUOTES) . "'" : "";

        // retrieve the title
        $title = $item->title;

        // retrieve and sanitize the description
        $description = $item->description ? " <span class='menu-item_description'>" . htmlentities($item->description, ENT_QUOTES) . "</span>" : "";

        /* mega menu stuff */

        if (in_array("mega", $params)) {
            if ($depth === 0) {
    			self::$li_count = 0;
    		}

    		if ($depth === 1 && self::$li_count === 1) {
    			$this->column_count++;
    		}

            if ($depth === 1 && get_post_meta($item->ID, "_menu_item_column", true) && self::$li_count !== 1 && $this->column_count < $this->column_limit) {
                $output .= "</ul><ul class='menu-list -vertical -child -tier1'>";
    			$this->column_count++;
            }

            self::$li_count++;
        }

        // construct the menu item
        $output .= sprintf(
            "<li%s><a class='menu-list_link link' href='%s'%s%s%s>%s</a>",
            $class_names,
            $url,
            $attr_title,
            $target,
            $xfn,
            $title,
            $description
        );

        /* mega menu stuff */

        if (in_array("mega", $params)) {
            if (in_array("-mega", $classes)) {
                $this->is_mega = true;

                $output .= "<button class='menu-list_toggle _visuallyhidden'>" . __("Click to toggle children", "new_site") . "</button>";
                $output .= "<div class='menu-list_container -mega' aria-hidden='true'>";
            }
        }
    }

    public function start_lvl(&$output, $depth = 0, $args = array()) {
        // convert the params in to an array
        $params = explode(" ", $this->params);

        // add a toggle button if the buttons paramater is passed
        $toggle = in_array("accordion", $params) ? "<button class='menu-list_toggle'><icon:angle-down><span class='_visuallyhidden'>" . __("Toggle children", "daviess_county") . "</span></button>" : (in_array("hover", $params) || in_array("touch", $params) && !($this->is_mega && $depth > 0) ? "<button class='menu-list_toggle _visuallyhidden'>" . __("Toggle children", "daviess_county") . "</button>" : "");

        // add a -tier class indicting the depth
        $variant = "-tier1";

        if ($depth > 0) {
            if ($depth > 1) {
                $variant = "-tier2 -tier" . ($depth + 1);
            } else {
                $variant = "-tier2";
            }
        }

        // add a -accordion class if the accordion parameter is passed
        $variant .= in_array("accordion", $params) ? " -accordion" : ((in_array("hover", $params) || in_array("touch", $params)) && !$this->is_mega ? " -overlay" : "");

        // add data properties for the menu script to interact with
        $data = "";
        if (in_array("hover", $params)) $data .= " data-click='true'";
        if (in_array("touch", $params)) $data .= " data-touch='true'";

        // add aria attribute if the mega parameter is not passed
        $aria = $this->is_mega ? "" : " aria-hidden='true'";

        // construct the menu list
        $output .= "{$toggle}<ul class='menu-list -vertical -child {$variant}'{$data}{$aria}>";
    }

    public function end_lvl(&$output, $depth = 0, $args = array()) {
        // close the menu list
        $output .= "</ul>";
    }

    public function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        // convert the params in to an array
        $params = explode(" ", $this->params);

        // reset the column counter
        $this->column_count = 0;

        /* mega menu stuff */

        if (in_array("mega", $params)) {
            // get the current classes
            $classes = $item->classes ? $item->classes : array();

            if (in_array("-mega", $classes)) {
                $this->is_mega = false;

                $output .= "</div>";
            }
        }

        // close the menu item
        $output .= "</li>";
    }
}

// add "Start New Column" checkboxes to the editor for a mega menu
if (is_admin()) {
    // @TODO figure out how to only do this on the menu editor page
    // require nav-menu.php so we can hook Walker_Nav_Menu_Edit
    require_once ABSPATH . "wp-admin/includes/nav-menu.php";

    class new_site_mega_menu_column_checkbox_setup extends Walker_Nav_Menu_Edit {
        static $field = array("name" => "column");

        // add a new checkbox to each menu item
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            $item_output = "";

            // get the parent item
            parent::start_el($item_output, $item, $depth, $args);

            self::$field["value"] = get_post_meta($item->ID, "_menu_item_" . self::$field["name"], true);
            self::$field["checked"] = "value='1' " . checked(self::$field["value"], 1, false);

            $new_field = "<p class='field-" . self::$field["name"] . " description'><label for='edit-menu-item-" . self::$field["name"] . "-{$item->ID}'>";
            $new_field .= "<input type='checkbox' id='edit-menu-item-" . self::$field["name"] . "-{$item->ID}' class='widefat code edit-menu-item-" . self::$field["name"] . "' name='menu-item-" . self::$field["name"] . "[{$item->ID}]'" . self::$field["checked"] . " />";
            $new_field .= __("Start new column here", "new_site");
            $new_field .= "</label></p>";

            $output .= preg_replace("/(?=<p[^>]+class=\"[^\"]*field-css-classes)/", $new_field, $item_output);
        }

        // function to save the new field
        static function _save_post($post_id) {
            if (get_post_type($post_id) !== "nav_menu_item") {
                return;
            }

            $form_field_name = "menu-item-" . self::$field["name"];
            $key = "_menu_item_" . self::$field["name"];
            $value = isset($_POST[$form_field_name][$post_id]) ? stripslashes($_POST[$form_field_name][$post_id]) : "";

            update_post_meta($post_id, $key, $value);
        }

        // add the save function to the save_post action
        static function setup() {
            add_action("save_post", array(__CLASS__, "_save_post"));
        }
    }
    add_action("init", array("new_site_mega_menu_column_checkbox_setup", "setup"));
    add_filter("wp_edit_nav_menu_walker", function () {
        return "new_site_mega_menu_column_checkbox_setup";
    });

    // hide the checkbox except on depth 1
    function new_site_hide_column_checkbox_except_on_depth_1() {
        $current_screen = get_current_screen();

        if ($current_screen->base === "nav-menus") {
            echo "<style>.menu-item:not(.menu-item-depth-1) .field-column, .menu-item.menu-item-depth-0 + .menu-item.menu-item-depth-1 .field-column {display:none;}</style>";
        }
    }
    add_action("admin_head", "new_site_hide_column_checkbox_except_on_depth_1");
}

// add sub_menu options to wp_nav_menu
// @param  {Boolean}  sub_menu - Make a menu behave as a sub menu
// @param  {Boolean}  direct_parent - Only show the parent of the currently viewed page, not any further ancestors
// @param  {Number}   parent_id - Post ID to use as the parent
function new_site_nav_menu_sub_menu($menu_items, $args) {
    $root_id = 0;
    $menu_item_parents = array();

    // check if the submenu argument is set
    if (isset($args->sub_menu)) {
        // if a parent exists, store the current item's parent as the root id, otherwise, store the current menu item instead
        foreach ($menu_items as $menu_item) {
            if ($menu_item->current) {
            $root_id = ($menu_item->menu_item_parent) ? $menu_item->menu_item_parent : $menu_item->ID;
            break;
        }
    }

    // if direct_parent is set, show all links from the top level down, otherwise only display the closest parent
    if (!isset($args->direct_parent)) {
        $prev_root_id = $root_id;

        while ($prev_root_id != 0) {
            foreach ($menu_items as $menu_item) {
                if ($menu_item->ID == $prev_root_id) {
                    $prev_root_id = $menu_item->menu_item_parent;

                    // change the root id if the top of the menu has not been reached
                    $root_id = $prev_root_id != 0 ? $prev_root_id : $root_id;

                    break;
                } // if ($menu_item->ID == $prev_root_id)
            } // foreach ($menu_items as $menu_item)
        } // while ($prev_root_id != 0)
    } // if (!isset($args->direct_parent))

    // display a specific section of links if parent_id is set
    if (isset($args->parent_id)) {
        $parent_id = 0;
        $menu_items_copy = $menu_items;

        // find the matching menu item
        foreach ($menu_items_copy as $key => $item) {
            if ($item->object_id == $args->parent_id) {
                $parent_id = $item->ID;
                break;
            }
        }

        // check each menu item
        foreach ($menu_items_copy as $key => $item) {
            // store the current menu item parents
            $current_menu_item_parent = $item->menu_item_parent;
            $current_menu_item_parents = array($current_menu_item_parent);

            while ($current_menu_item_parent != $parent_id && $current_menu_item_parent != 0) {
                // loop through menu items (not menu items copy, because stuff gets removed from copy before the loop finishes!)
                foreach ($menu_items as $key2 => $item2) {
                    // update the current menu item parents
                    if ($current_menu_item_parent == $item2->ID) {
                        $current_menu_item_parent = $item2->menu_item_parent;
                        array_push($current_menu_item_parents, $current_menu_item_parent);
                        // stop the loop when we reach the top level
                    } elseif ($current_menu_item_parent == $parent_id || $current_menu_item_parent == 0) {
                        break;
                    }
                } // foreach ($menu_items as $key2 => $item2)
            } // while ($current_menu_item_parent != $parent_id && $current_menu_item_parent != 0)

            // remove menu items that aren't children of the specified parent
            if (!in_array($parent_id, $current_menu_item_parents) && !(isset($args->show_parent) && $parent_id == $item->ID)) {
                unset($menu_items_copy[$key]);
            }
        } // foreach ($menu_items_copy as $key => $item)

        $menu_items = $menu_items_copy;
    } else { // if (isset($args->parent_id))
        foreach ($menu_items as $key => $item) {
            // store the top level menu item in the array
            if ($item->ID == $root_id) array_push($menu_item_parents, $item->ID);
                // store each subsequent level of menu items in the array
                if (in_array($item->menu_item_parent, $menu_item_parents)) {
                    array_push($menu_item_parents, $item->ID);
                    // remove the menu item if it's not a child
                } else if (!(isset($args->show_parent) && in_array($item->ID, $menu_item_parents))) {
                    unset($menu_items[$key]);
                }
            }
        } // if (isset($args->parent_id)) else
    } // if (isset($args->sub_menu))

    return $menu_items;
}
add_filter("wp_nav_menu_objects", "new_site_nav_menu_sub_menu", 10, 2);
