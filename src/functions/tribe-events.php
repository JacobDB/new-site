<?php
/* ------------------------------------------------------------------------ *\
 * Tribe Events
\* ------------------------------------------------------------------------ */

// stop if Tribe isn't installed
if (! function_exists("tribe_get_events")) {
    return;
}

/* FUNCTIONS */

/**
 * Determine if the current page is a tribe page
 *
 * @return array<array<string>|int|string>
 */
function __gulp_init_namespace___is_tribe_page(): array {
    $queried_object = get_queried_object();

    $post_id = isset($post) ? $post->ID : (isset($queried_object->ID) ? $queried_object->ID : 0);
    $term_id = isset($queried_object->term_id) ? $queried_object->term_id : 0;

    if (function_exists("tribe_is_month") && tribe_is_month() && ! is_tax()) {
        $variant = ["month"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => 0,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_month") && tribe_is_month() && is_tax()) {
        $variant = ["month"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => $term_id,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_past") && tribe_is_past() && ! is_tax()) {
        $variant = ["list", "past"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => 0,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_upcoming") && tribe_is_upcoming() && ! is_tax()) {
        $variant = ["list", "future"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => 0,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_past") && tribe_is_past() && is_tax()) {
        $variant = ["list", "past"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => $term_id,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_upcoming") && tribe_is_upcoming() && is_tax()) {
        $variant = ["list", "future"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => $term_id,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_week") && tribe_is_week() && ! is_tax()) {
        $variant = ["week"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => 0,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_week") && tribe_is_week() && is_tax()) {
        $variant = ["week"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => $term_id,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_day") && tribe_is_day() && ! is_tax()) {
        $variant = ["day"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => 0,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_day") && tribe_is_day() && is_tax()) {
        $variant = ["day"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => $term_id,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_map") && tribe_is_map() && ! is_tax()) {
        $variant = ["map"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => 0,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_map") && tribe_is_map() && is_tax()) {
        $variant = ["map"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => $term_id,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_photo") && tribe_is_photo() && ! is_tax()) {
        $variant = ["photo"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => 0,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_photo") && tribe_is_photo() && is_tax()) {
        $variant = ["photo"];

        if (property_exists($queried_object, "taxonomy")) {
            $variant[] = $queried_object->taxonomy;
        }

        return [
            "object_id" => $term_id,
            "type"      => "archive",
            "variants"  => $variant,
        ];
    } elseif (function_exists("tribe_is_event") && tribe_is_event() && is_single()) {
        return [
            "object_id" => $post_id,
            "type"      => "single",
            "variants"  => ["tribe_events"],
        ];
    } elseif (function_exists("tribe_is_venue") && tribe_is_venue()) {
        return [
            "object_id" => $post_id,
            "type"      => "single",
            "variants"     => "tribe_venue",
        ];
    } elseif (get_post_type() === "tribe_organizer" && is_single()) {
        return [
            "object_id" => $post_id,
            "type"      => "single",
            "variants"  => ["tribe_organizer"],
        ];
    }

    return [];
}

/* FILTERS */


/**
 * Change order of Tribe Events dependencies so that they work better with async/defer
 *
 * @return void
 */
function __gulp_init_namespace___tribe_events_fix_scripts_order(): void {
    global $wp_scripts;

    /**
     * Array to store transposed dependencies
     */
    $deps = [];

    /**
     * Find all `tribe-events-views-v2-` dependencies of `tribe-events-views-v2-manager`, store them
     * in a variable for reference, and remove them.
     */
    if (isset($wp_scripts->registered["tribe-events-views-v2-manager"])) {
        foreach ($wp_scripts->registered["tribe-events-views-v2-manager"]->deps as $key => $handle) {
            if (preg_match("/^tribe-events-views-v2-.+$/", $handle)) {
                $deps[] = $handle;
                unset($wp_scripts->registered["tribe-events-views-v2-manager"]->deps[$key]);
            }
        }
    }

    /**
     * Add `tribe-events-views-v2-manager` as a dependency for all dependencies
     */
    foreach ($deps as $dep) {
        if (key_exists($dep, $wp_scripts->registered)) {
            if (! in_array("tribe-events-views-v2-manager", $wp_scripts->registered[$dep]->deps)) {
                $wp_scripts->registered[$dep]->deps[] = "tribe-events-views-v2-manager";
            }
        }
    }
}
add_action("wp_enqueue_scripts", "__gulp_init_namespace___tribe_events_fix_scripts_order");

/**
 * Use correct Tribe templates, if they exist
 *
 * @param  string $template
 *
 * @return string
 */
function __gulp_init_namespace___tribe_force_page_templates(string $template): string {
    $tribe_page = __gulp_init_namespace___is_tribe_page();

    if ($tribe_page && $tribe_page["type"] === "single") {
        if (in_array("tribe_events", $tribe_page["variants"])) {
            return locate_template(["single-tribe_events.php", "single.php", "page.php", "index.php"]);
        }

        if (in_array("tribe_venue", $tribe_page["variants"])) {
            return locate_template(["single-tribe_venue.php", "single-tribe_events.php", "single.php", "page.php", "index.php"]);
        }

        if (in_array("tribe_organizer", $tribe_page["variants"])) {
            return locate_template(["single-tribe_organizer.php", "single-tribe_events.php", "single.php", "page.php", "index.php"]);
        }
    }

    if ($tribe_page && $tribe_page["type"] === "archive") {
        if (in_array("tribe_events_cat", $tribe_page["variants"])) {
            return locate_template(["taxonomy-tribe_events_cat.php", "archive-tribe_events.php", "page.php", "index.php"]);
        } else {
            return locate_template(["archive-tribe_events.php", "page.php", "index.php"]);
        }
    }

    return $template;
}
add_filter("template_include", "__gulp_init_namespace___tribe_force_page_templates", 50);

/**
 * Remove recurring events duplicates from search results
 *
 * @see https://www.relevanssi.com/knowledge-base/showing-one-recurring-event/
 *
 * @param  array<array<mixed>> $hits Array of Relevnassi hits
 *
 * @return array<array<mixed>>
 */
function __gulp_init_namespace___relevanssi_cull_recurring_events(array $hits = []): array {
    $ok_results     = [];
    $posts_seen     = [];
    $index_by_title = [];
    $date_by_title  = [];

    $i = 0;

    foreach ($hits[0] as $hit) {
        if (! isset($posts_seen[$hit->post_title])) {
            $ok_results[]                     = $hit;
            $date_by_title[$hit->post_title]  = get_post_meta($hit->ID, "_EventStartDate", true);
            $index_by_title[$hit->post_title] = $i;
            $posts_seen[$hit->post_title]     = true;
            $i++;
        } elseif (get_post_meta($hit->ID, "_EventStartDate", true) < $date_by_title[$hit->post_title]) {
            if (strtotime(get_post_meta($hit->ID, "_EventStartDate", true)) < time()) continue;
            $date_by_title[$hit->post_title]               = get_post_meta($hit->ID, "_EventStartDate", true);
            $ok_results[$index_by_title[$hit->post_title]] = $hit;
        }
    }

    $hits[0] = $ok_results;

    return $hits;
}
add_filter("relevanssi_hits_filter", "__gulp_init_namespace___relevanssi_cull_recurring_events");
