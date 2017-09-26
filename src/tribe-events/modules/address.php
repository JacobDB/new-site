<?php
$venue_id = get_the_ID();
$full_region = tribe_get_full_region($venue_id);
?>

<?php if (tribe_get_address($venue_id)): ?>
    <?php echo tribe_get_address($venue_id); ?><?php if (tribe_get_city($venue_id) || tribe_get_state($venue_id)): ?>, <?php endif; ?>
<?php endif; ?>

<?php if (tribe_get_city($venue_id)): ?>
	<?php echo tribe_get_city($venue_id); ?><?php if (tribe_get_region($venue_id)): ?>, <?php endif; ?>
<?php endif; ?>

<?php if (tribe_get_region($venue_id)): ?>
	<span class="tribe-region tribe-events-abbr" title="<?php esc_attr_e($full_region); ?>" tabindex="0"><?php echo tribe_get_region($venue_id); ?></span>
<?php endif; ?>
