<?php $map = tribe_get_embedded_map(); ?>
<?php if (empty($map)) return; ?>

<div class="tribe-events-venue-map">
	<?php do_action("tribe_events_single_meta_map_section_start"); ?>
	<?php echo $map; ?>
	<?php do_action("tribe_events_single_meta_map_section_end"); ?>
</div>
