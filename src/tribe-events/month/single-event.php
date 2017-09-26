<?php
global $post;

$day      = tribe_events_get_current_month_day();
$event_id = "{$post->ID}-{$day["daynum"]}";
$link     = tribe_get_event_link($post);
$title    = get_the_title($post);
?>

<div class="<?php tribe_events_event_classes(); ?> tribe-events-calendar_event" id="tribe-events-event-<?php echo esc_attr($event_id); ?>" data-tribejson='<?php echo esc_attr(tribe_events_template_data($post)); ?>'>
	<h3 class="tribe-events-month-event-title tribe-events_text text _nomargin"><a class="url tribe-events-calendar_link link" href="<?php echo esc_url($link); ?>"><?php echo $title; ?></a></h3>
</div><!-- #tribe-events-event-->
