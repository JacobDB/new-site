<?php
/* ------------------------------------------------------------------------ *\
 * Functions: Post Types
\* ------------------------------------------------------------------------ */

// register project post type
function @@init_namespace_create_resource_post_type() {
    register_post_type("resource", array(
        "has_archive" 	     => true,
        "hierarchical" 	     => false,
        "labels" 		     => array(
            "add_new" 			 => __("Add New", "@@init_namespace"),
            "add_new_item" 		 => __("Add New Resource", "@@init_namespace"),
            "all_items" 		 => __("All Resources", "@@init_namespace"),
            "edit_item" 		 => __("Edit Resource", "@@init_namespace"),
            "menu_name" 		 => __("Resources", "@@init_namespace"),
            "name" 				 => __("Resources", "@@init_namespace"),
            "new_item" 			 => __("New", "@@init_namespace"),
            "not_found" 		 => __("No resources found", "@@init_namespace"),
            "not_found_in_trash" => __("No resources found in Trash", "@@init_namespace"),
            "search_items" 		 => __("Search resources", "@@init_namespace"),
            "singular_name" 	 => __("Resource", "@@init_namespace"),
            "view_item" 		 => __("View Resource", "@@init_namespace"),
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
                "name"                       => _x("Resource Tags", "taxonomy general name", "@@init_namespace"),
        		"singular_name"              => _x("Tag", "taxonomy singular name", "@@init_namespace"),
        		"search_items"               => __("Search Tags", "@@init_namespace"),
        		"popular_items"              => __("Popular Tags", "@@init_namespace"),
        		"all_items"                  => __("All Tags", "@@init_namespace"),
        		"edit_item"                  => __("Edit Tag", "@@init_namespace"),
        		"update_item"                => __("Update Tag", "@@init_namespace"),
        		"add_new_item"               => __("Add New Tag", "@@init_namespace"),
        		"new_item_name"              => __("New Tag Name", "@@init_namespace"),
        		"separate_items_with_commas" => __("Separate tags with commas", "@@init_namespace"),
        		"add_or_remove_items"        => __("Add or remove tags", "@@init_namespace"),
        		"choose_from_most_used"      => __("Choose from the most used tags", "@@init_namespace"),
        		"not_found"                  => __("No tags found.", "@@init_namespace"),
        		"menu_name"                  => __("Tags", "@@init_namespace"),
			),
			"rewrite" 		=> array(
                "slug" => "resource-tag",
            ),
		)
	);
}
add_action("init", "@@init_namespace_create_resource_post_type");
