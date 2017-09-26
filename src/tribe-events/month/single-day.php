<?php
$day = tribe_events_get_current_month_day();
$events_label = (1 === $day["total_events"]) ? tribe_get_event_label_singular() : tribe_get_event_label_plural();
?>

<!-- Day Header -->
<div class="tribe-events-calendar_date tribe-events-calendar_text text _bold _nomargin _textright" id="tribe-events-daynum-<?php echo $day['daynum-id'] ?>">
	<?php if ($day["total_events"] > 0 && tribe_events_is_view_enabled("day")): ?>
		<a class="tribe-events-calendar_link link" href="<?php echo esc_url(tribe_get_day_link($day["date"])); ?>"><?php echo $day["daynum"]; ?></a>
	<?php else: ?>
		<?php echo $day["daynum"]; ?>
	<?php endif; ?>
</div><!--/.tribe-events-calendar_date.tribe-events-calendar_text.text._bold._nomargin._textright-->

<!-- Events List -->
<?php if ($day["events"]->have_posts()): ?>
    <?php while ($day["events"]->have_posts()) : $day["events"]->the_post(); ?>
        <div class="_tablet _notebook _desktop">
           <?php tribe_get_template_part("month/single", "event"); ?>
       </div><!--/._tablet._notebook._desktop-->
    <?php endwhile; ?>

    <div class="tribe-events-calendar_mobile-event-indicator _phone"><span class="_visuallyhidden"><?php _e("Click to view events on this day.", "the-events-calendar"); ?></span></div>
<?php endif; ?>

<!-- View More -->
<?php if ($day["view_more"]): ?>
	<div class="tribe-events-viewmore">
		<?php
		$view_all_label = sprintf(
			_n(
				'View %1$s %2$s',
				'View All %1$s %2$s',
				$day['total_events'],
				'the-events-calendar'
			),
			$day['total_events'],
			$events_label
		);
		?>
		<a class="tribe-events-calendar_link link" href="<?php echo esc_url($day["view_more"]); ?>"><?php echo $view_all_label; ?> &raquo;</a>
	</div>
<?php endif; ?>
