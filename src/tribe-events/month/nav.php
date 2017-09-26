<?php do_action("tribe_events_before_nav"); ?>

<h3 class="_visuallyhidden" tabindex="0"><?php esc_html_e("Calendar Month Navigation", "the-events-calendar"); ?></h3>

<nav class="content_menu-list_container menu-list_container">
    <ul class="menu-list -pagination -between">
        <li class="menu-list_item" aria-label="<?php _e("previous month link", "the-events-calendar"); ?>">
            <?php tribe_events_the_previous_month_link(); ?>
        </li><!--/.menu-list_item-->

        <li class="menu-list_item" aria-label="<?php _e("next month link", "the-events-calendar"); ?>">
            <?php tribe_events_the_next_month_link(); ?>
        </li><!--/.menu-list_item-->
    </ul><!--/.menu-list.-pagination.-center-->
</nav><!--/.content_menu-list_container.menu-list_container-->

<?php do_action("tribe_events_after_nav"); ?>
