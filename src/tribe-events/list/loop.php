<?php global $post; ?>

<div class="tribe-events-loop">

	<?php while (have_posts()): the_post(); ?>
		<?php do_action("tribe_events_inside_before_loop"); ?>

		<!-- Month / Year Headers -->
		<?php tribe_events_list_the_date_headers(); ?>

		<!-- Event  -->
		<?php $event_type = apply_filters("tribe_events_list_view_event_type", tribe("tec.featured_events")->is_featured($post->ID) ? "featured" : "event"); ?>
        <?php tribe_get_template_part("list/single", $event_type); ?>

		<?php do_action("tribe_events_inside_after_loop"); ?>
	<?php endwhile; // (have_posts()) ?>

</div><!--/.tribe-events-loop-->
