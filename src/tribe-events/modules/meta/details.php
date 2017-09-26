<?php
$time_format          = get_option("time_format", Tribe__Date_Utils::TIMEFORMAT);
$time_range_separator = tribe_get_option("timeRangeSeparator", " - ");

$start_datetime = tribe_get_start_date();
$start_date     = tribe_get_start_date(null, false);
$start_time     = tribe_get_start_date(null, false, $time_format);
$start_ts       = tribe_get_start_date(null, false, Tribe__Date_Utils::DBDATEFORMAT);

$end_datetime = tribe_get_end_date();
$end_date     = tribe_get_display_end_date(null, false);
$end_time     = tribe_get_end_date(null, false, $time_format);
$end_ts       = tribe_get_end_date(null, false, Tribe__Date_Utils::DBDATEFORMAT);

$time_formatted = $start_time == $end_time ? esc_html($start_time) : esc_html($start_time . $time_range_separator . $end_time);

$event_id = Tribe__Main::post_id_helper();

$time_formatted = apply_filters("tribe_events_single_event_time_formatted", $time_formatted, $event_id);

$time_title = apply_filters("tribe_events_single_event_time_title", __("Time:", "the-events-calendar"), $event_id);

$cost       = tribe_get_formatted_cost();
$categories = get_the_terms(get_the_id(), "tribe_events_cat");
$tags       = get_the_terms(get_the_id(), "post_tag");
$website    = tribe_get_event_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-details">
	<h3 class="tribe-events-single-section-title article_title title -sub"><?php esc_html_e("Details", "the-events-calendar"); ?></h3>
	<ul class="article_text text -list">

		<?php do_action("tribe_events_single_meta_details_section_start"); ?>

        <?php if (tribe_event_is_all_day() && tribe_event_is_multiday()): ?>

			<li class="text_list-item">
                <strong class="_bold"><?php esc_html_e("Start:", "the-events-calendar"); ?></strong>
				<span class="tribe-events-abbr tribe-events-start-datetime published dtstart" title="<?php esc_attr_e($start_ts); ?>"><?php esc_html_e($start_date); ?></span>
            </li><!--/.text_list-item-->

            <li class="text_list-item">
    			<strong class="_bold"><?php esc_html_e("End:", "the-events-calendar"); ?></strong>
    			<span class="tribe-events-abbr dtend" title="<?php esc_attr_e($end_ts); ?>"><?php esc_html_e($end_date); ?></span>
            </li><!--/.text_list-item-->

		<?php elseif (tribe_event_is_all_day()): ?>

            <li class="text_list-item">
    			<strong class="_bold"><?php esc_html_e("Date:", "the-events-calendar"); ?></strong>
    			<span class="tribe-events-abbr tribe-events-start-datetime published dtstart" title="<?php esc_attr_e($start_ts); ?>"><?php esc_html_e($start_date); ?></span>
            </li><!--/.text_list-item-->

		<?php elseif (tribe_event_is_multiday()): ?>

            <li class="text_list-item">
    			<strong class="_bold"><?php esc_html_e("Start:", "the-events-calendar"); ?></strong>
    			<span class="tribe-events-abbr updated published dtstart" title="<?php esc_attr_e($start_ts); ?>"><?php esc_html_e($start_datetime); ?></span>
            </li><!--/.text_list-item-->

            <li class="text_list-item">
    			<strong class="_bold"><?php esc_html_e("End:", "the-events-calendar"); ?></strong>
				<span class="tribe-events-abbr dtend" title="<?php esc_attr_e($end_ts); ?>"><?php esc_html_e($end_datetime); ?></span>
            </li><!--/.text_list-item-->

		<?php else: ?>

            <li class="text_list-item">
    			<strong class="_bold"><?php esc_html_e("Date:", "the-events-calendar"); ?></strong>
    			<span class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php esc_attr_e($start_ts); ?>"><?php esc_html_e($start_date); ?></span>
            </li><!--/.text_list-item-->

            <li class="text_list-item">
        		<strong class="_bold"><?php echo esc_html($time_title); ?></strong>
    			<span class="tribe-events-abbr tribe-events-start-time published dtstart" title="<?php esc_attr_e($end_ts); ?>">
    				<?php echo $time_formatted; ?>
    			</span>
            </li><!--/.text_list-item-->

		<?php endif; ?>

		<?php if (!empty($cost)): ?>
            <li class="text_list-item">
    			<strong class="_bold"><?php esc_html_e("Cost:", "the-events-calendar"); ?></strong>
    			<?php esc_html_e($cost); ?>
            </li><!--/.text_list-item-->
		<?php endif ?>

        <?php if ($categories): $i = 0; ?>
            <li class="text_list-item">
                <strong class="_bold"><?php echo sprintf(esc_html__("%s Categories:", "the-events-calendar"), tribe_get_event_label_singular()); ?></strong>
                <?php foreach ($categories as $category): $i++; ?>
                    <a class="text_link link" href="<?php echo get_term_link($category->term_id, $category->taxonomy); ?>"><?php echo $category->name; ?></a><?php if ($i < count($categories)) { ?>, <?php } ?>
                <?php endforeach;?>
            </li><!--/.text_list-item-->
        <?php endif; ?>

        <?php if ($tags): $i = 0; ?>
            <li class="text_list-item">
                <strong class="_bold"><?php echo sprintf(esc_html__("%s Tags:", "the-events-calendar"), tribe_get_event_label_singular()); ?></strong>
                <?php foreach ($tags as $tag): $i++; ?>
                    <a class="text_link link" href="<?php echo get_term_link($tag->term_id, $tag->taxonomy); ?>"><?php echo $tag->name; ?></a><?php if ($i < count($tags)) { ?>, <?php } ?>
                <?php endforeach;?>
            </li><!--/.text_list-item-->
        <?php endif; ?>

		<?php if (!empty($website)): ?>
            <li class="text_list-item">
    			<strong class="_bold"><?php esc_html_e("Website:", "the-events-calendar"); ?></strong>
    			<span class="tribe-events-event-url"><?php echo preg_replace("/<a /im", "<a class='text_link link' ", $website); ?></span>
            </li><!--/.text_list-item-->
		<?php endif; ?>

		<?php do_action("tribe_events_single_meta_details_section_end"); ?>
	</ul>
</div>
