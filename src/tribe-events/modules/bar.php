<?php
$filters = tribe_events_get_filters();
$views   = tribe_events_get_views();
$current_url = tribe_events_get_current_filter_url();
?>

<?php do_action("tribe_events_bar_before_template"); ?>
<form class="tribe-events-bar" id="tribe-bar-form" name="tribe-bar-form" method="post" action="<?php echo esc_attr( $current_url ); ?>">

	<!-- Mobile Filters Toggle -->
    <button class="tribe-events-bar_toggle _phone" id="tribe-bar-collapse-toggle">
        <?php printf(esc_html__("Find %s", "the-events-calendar"), tribe_get_event_label_plural()); ?>
    </button><!--/.tribe-events-bar_toggle._phone-->

	<!-- Views -->
	<?php if (count($views) > 1): ?>
	<div class="tribe-events-bar_views" id="tribe-bar-views">
		<h3 class="_visuallyhidden"><?php esc_html_e("Event Views Navigation", "the-events-calendar"); ?></h3>
		<label class="tribe-events-bar_text text -label" for="tribe-bar-view"><?php esc_html_e("View As", "the-events-calendar"); ?></label>
		<select class="tribe-events-bar_input input -select -arrow _visuallyhidden" id="tribe-bar-view" name="tribe-bar-view">
			<?php foreach ($views as $view) : ?>
			<option <?php echo tribe_is_view($view["displaying"]) ? "selected" : "tribe-inactive"; ?> value="<?php echo esc_attr($view["url"]); ?>" data-view="<?php echo esc_attr($view["displaying"]); ?>">
				<?php echo $view["anchor"]; ?>
			</option>
			<?php endforeach; ?>
		</select><!--/.tribe-events-bar_input.input.-select.-arrow._visuallyhidden-->
	</div><!--/.tribe-events-bar_views-->
    <?php endif; // if (count($views) > 1) ?>

    <!-- Filters -->
	<?php if (!empty($filters)): ?>
	<div class="tribe-events-bar_filters tribe-bar-filters">
        <div class="tribe-events-bar_row row -bottom -padded">
            <?php foreach ($filters as $filter): ?>
            <div class="col-12 col-xs-4 <?php echo esc_attr($filter["name"]); ?>-filter">
                <label class="tribe-events-bar_text text -label" for="<?php echo esc_attr($filter["name"]); ?>"><?php echo $filter["caption"]; ?></label>
                <?php echo preg_replace("/<input type=\"text\"/", "<input class=\"tribe-events-bar_input input\" type=\"text\"", $filter["html"]); ?>
            </div><!--/.col-12.col-xs-4-->
            <?php endforeach; // foreach ($filters as $filter) ?>
            <div class="col-12 col-xs-auto -nogrow -noshrink">
                <div class="tribe-events-bar_text text -label _tablet _notebook">&nbsp;</div>
                <input class="tribe-events-bar_button button" type="submit" name="submit-bar" value="<?php printf(esc_attr__("Find %s", "the-events-calendar"), tribe_get_event_label_plural()); ?>" />
            </div><!--/.col-12.col-xs-auto.-nogrow.-noshrink-->
        </div><!--/.tribe-events-bar_row.row.-padded-->
	</div><!--/.tribe-events-bar_filters-->
	<?php endif; // if (!empty($filters)) ?>

</form><!--/.tribe-events-bar-->
<?php do_action("tribe_events_bar_after_template"); ?>
