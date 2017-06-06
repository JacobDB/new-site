<!--removeIf(tribe_html)--><?php do_action("tribe_events_before_nav"); ?>

<h3 class="_visuallyhidden" tabindex="0"><?php esc_html_e("Calendar Month Navigation", "the-events-calendar"); ?></h3>

<div class="tribe-events_row row -between">
    <div class="col-0 -nogrow -noshrink" aria-label="<?php _e("previous month link", "the-events-calendar"); ?>">
        <?php tribe_events_the_previous_month_link(); ?>
    </div><!--/.col-0.-nogrow.-noshrink-->

    <div class="col-0 -nogrow -noshrink" aria-label="<?php _e("next month link", "the-events-calendar"); ?>">
        <?php tribe_events_the_next_month_link(); ?>
    </div><!--/.col-0.-nogrow.-noshrink-->
</div><!--/.tribe-events_row.row.-between-->

<?php do_action("tribe_events_after_nav"); ?><!--endRemoveIf(tribe_html)-->
