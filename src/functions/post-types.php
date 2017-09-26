<?php
/* ------------------------------------------------------------------------ *\
 * Functions: Post Types
\* ------------------------------------------------------------------------ */
/*removeIf(resources_css_js_php)*/
// register project post type
function @@namespace_create_resource_post_type() {
    register_post_type("resource", array(
        "has_archive" 	     => true,
        "hierarchical" 	     => false,
        "labels" 		     => array(
            "add_new" 			 => __("Add New", "@@namespace"),
            "add_new_item" 		 => __("Add New Resource", "@@namespace"),
            "all_items" 		 => __("All Resources", "@@namespace"),
            "edit_item" 		 => __("Edit Resource", "@@namespace"),
            "menu_name" 		 => __("Resources", "@@namespace"),
            "name" 				 => __("Resources", "@@namespace"),
            "new_item" 			 => __("New", "@@namespace"),
            "not_found" 		 => __("No resources found", "@@namespace"),
            "not_found_in_trash" => __("No resources found in Trash", "@@namespace"),
            "search_items" 		 => __("Search resources", "@@namespace"),
            "singular_name" 	 => __("Resource", "@@namespace"),
            "view_item" 		 => __("View Resource", "@@namespace"),
	    ),
		"menu_icon" 	     => "dashicons-admin-links",
		"menu_position"      => 20,
        // "public" 		     => false,
        // "publicly_queryable" => true,
        "rewrite"            => array(
            "slug" => "resources",
        ),
        "show_ui"            => true,
        "supports" 		     => array(
			"title",
			"editor",
			"author",
			"thumbnail",
			"excerpt",
			"trackbacks",
			"custom-fields",
			"comments",
			"revisions",
			"post-formats",
        ),
    ));

    register_taxonomy(
		"resource_tag",
		"resource",
		array(
			"capabilities" 	=> array("edit_terms" => "manage_categories"),
			"hierarchical" 	=> false,
			"labels" 		=> array(
                "name"                       => _x("Resource Tags", "taxonomy general name", "@@namespace"),
        		"singular_name"              => _x("Tag", "taxonomy singular name", "@@namespace"),
        		"search_items"               => __("Search Tags", "@@namespace"),
        		"popular_items"              => __("Popular Tags", "@@namespace"),
        		"all_items"                  => __("All Tags", "@@namespace"),
        		"edit_item"                  => __("Edit Tag", "@@namespace"),
        		"update_item"                => __("Update Tag", "@@namespace"),
        		"add_new_item"               => __("Add New Tag", "@@namespace"),
        		"new_item_name"              => __("New Tag Name", "@@namespace"),
        		"separate_items_with_commas" => __("Separate tags with commas", "@@namespace"),
        		"add_or_remove_items"        => __("Add or remove tags", "@@namespace"),
        		"choose_from_most_used"      => __("Choose from the most used tags", "@@namespace"),
        		"not_found"                  => __("No tags found.", "@@namespace"),
        		"menu_name"                  => __("Tags", "@@namespace"),
			),
			"rewrite" 		=> array(
                "slug" => "resource-tag",
            ),
		)
	);
}
add_action("init", "@@namespace_create_resource_post_type");/*endRemoveIf(resources_css_js_php)*/
