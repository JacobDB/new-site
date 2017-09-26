<?php
$days_of_week = tribe_events_get_days_of_week();
$week = 0;
global $wp_locale;
?>

<?php do_action("tribe_events_before_the_grid"); ?>
<div class="tribe-events-calendar_container">
	<table class="tribe-events-calendar">
		<thead class="tribe-events-calendar_header">
    		<tr class="tribe-events-calendar_row">
    			<?php foreach ($days_of_week as $day): ?>
    				<th class="tribe-events-calendar_cell -header" id="tribe-events-<?php echo esc_attr(strtolower($day)); ?>" title="<?php echo esc_attr($day); ?>" data-day-abbr="<?php echo esc_attr($wp_locale->get_weekday_abbrev($day)); ?>"><span class="tribe-events-calendar_text text _bold _nomargin"><?php echo $day; ?></span></th>
    			<?php endforeach; ?>
    		</tr><!--/.tribe-events-calendar_row-->
		</thead><!--/.tribe-events-calendar_head-->
		<tbody class="tribe-events-calendar_body">
    		<tr class="tribe-events-calendar_row">
    			<?php while (tribe_events_have_month_days()): tribe_events_the_month_day(); ?>


                <?php if ($week != tribe_events_get_current_week()): $week++; ?>
    		</tr><!--/.tribe-events-calendar_row-->
    		<tr class="tribe-events-calendar_row">
    			<?php endif; ?>

                <?php $daydata = tribe_events_get_current_month_day(); ?>

    			<td class="tribe-events-calendar_cell <?php tribe_events_the_month_day_classes(); ?>" data-day="<?php echo esc_attr(isset($daydata["daynum"]) ? $daydata["date"] : ""); ?>" data-tribejson='<?php echo tribe_events_template_data(null, array("date_name" => tribe_format_date($daydata["date"], false))); ?>'>
    				<?php tribe_get_template_part("month/single", "day"); ?>
    			</td><!--/.tribe-events-calendar_cell-->

    			<?php endwhile; ?>
    		</tr><!--/.tribe-events-calendar_row-->
		</tbody><!--/.tribe-events-calendar_body-->
	</table><!--/.tribe-events-calendar-->
</div><!--/.tribe-events-calendar_container-->
<?php do_action("tribe_events_after_the_grid"); ?>
