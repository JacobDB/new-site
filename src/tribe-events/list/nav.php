<?php
global $wp_query;
$events_label_plural = tribe_get_event_label_plural();
?>

<?php if (tribe_has_previous_event() || tribe_has_next_event()): ?>
    <h3 class="_visuallyhidden" tabindex="0"><?php echo esc_html(sprintf(esc_html__("%s List Navigation", "the-events-calendar"), $events_label_plural)); ?></h3>

    <nav class="content_menu-list_container menu-list_container">
        <ul class="menu-list -pagination -between">
            <!-- Left Navigation -->
            <li class="<?php echo esc_attr(tribe_left_navigation_classes()); ?> menu-list_item" aria-label="previous events link">
                <?php if (tribe_has_previous_event()): ?>
                    <a class="menu-list_link link" href="<?php echo esc_url(tribe_get_listview_prev_link()); ?>" rel="prev"><?php printf("<span>&laquo;</span> " . esc_html__("Previous %s", "the-events-calendar"), $events_label_plural); ?></a>
                <?php endif; // (tribe_has_previous_event()) ?>
            </li><!--/.tribe-events-nav-left-->

            <!-- Right Navigation -->
            <li class="<?php echo esc_attr(tribe_right_navigation_classes()); ?> menu-list_item" aria-label="next events link">
                <?php if (tribe_has_next_event()): ?>
                    <a class="menu-list_link link" href="<?php echo esc_url(tribe_get_listview_next_link()); ?>" rel="next"><?php printf(esc_html__("Next %s", "the-events-calendar"), $events_label_plural . " <span>&raquo;</span>"); ?></a>
                <?php endif; // (tribe_has_next_event()) ?>
            </li><!--/.tribe-events-nav-right-->
        </ul><!--/.menu-list.-pagination.-center-->
    </nav><!--/.content_menu-list_container.menu-list_container-->
<?php endif; // (tribe_has_previous_event() || tribe_has_next_event()) ?>
