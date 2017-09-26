<?php
global $post, $wp_query;
$current_timeslot = null;
?>

<div id="tribe-events-day" class="tribe-events-loop">
	<div class="tribe-events-day-time-slot">

    	<?php while (have_posts()): the_post(); ?>
    		<?php do_action("tribe_events_inside_before_loop"); ?>

    		<?php if ($current_timeslot != $post->timeslot): ?>
        		<?php $current_timeslot = $post->timeslot; ?>
            	</div>
            	<!-- .tribe-events-day-time-slot -->

            	<div class="tribe-events-day-time-slot">
            		<h5 class="tribe-events-day_title title -divider"><?php echo $current_timeslot; ?></h5>
        	<?php endif; // ($current_timeslot != $post->timeslot) ?>

    		<!-- Event  -->
			<?php
			$event_type = apply_filters("tribe_events_day_view_event_type", tribe("tec.featured_events")->is_featured($post->ID) ? "featured" : "event");
			tribe_get_template_part("day/single", $event_type);
			?>

    		<?php do_action("tribe_events_inside_after_loop"); ?>
    	<?php endwhile; ?>

    </div><!--/.tribe-events-day-time-slot-->
</div><!--/.tribe-events-loop-->
