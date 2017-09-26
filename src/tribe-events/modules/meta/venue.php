<?php
$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-venue">
	<h3 class="tribe-events-single-section-title article_title title -sub"> <?php esc_html_e(tribe_get_venue_label_singular(), "the-events-calendar"); ?></h3>
	<ul class="article_text text -list">
		<?php do_action("tribe_events_single_meta_venue_section_start"); ?>

        <li class="text_list-item">
            <span class="tribe-venue"><?php echo tribe_get_venue(); ?></span>
        </li><!--/.text_list-item-->

		<?php if ( tribe_address_exists() ) : ?>
            <li class="text_list-item">
    			<span class="tribe-venue-location">
    				<address class="tribe-events-address">
    					<?php echo tribe_get_full_address(); ?>

    					<?php if ( tribe_show_google_map_link() ) : ?>
    						<?php echo preg_replace("/<a /im", "<a class='text_link link' ", tribe_get_map_link_html()); ?>
    					<?php endif; ?>
    				</address>
    			</span>
            </li><!--/.text_list-item-->
		<?php endif; ?>

		<?php if (!empty($phone)): ?>
            <li class="text_list-item">
    			<strong class="_bold"><?php esc_html_e("Phone:", "the-events-calendar"); ?></strong>
    			<span class="tribe-venue-tel"><?php echo $phone ?></span>
            </li><!--/.text_list-item-->
		<?php endif; ?>

		<?php if (!empty($website)): ?>
            <li class="text_list-item">
    			<strong class="_bold"><?php esc_html_e("Website:", "the-events-calendar"); ?></strong>
    			<span class="url"><?php echo preg_replace("/<a /im", "<a class='text_link link' ", $website); ?></span>
            </li><!--/.text_list-item-->
		<?php endif; ?>

		<?php do_action("tribe_events_single_meta_venue_section_end"); ?>
	</ul><!--/.article_text.text.-list-->
</div>
