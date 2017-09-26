<?php
$organizer_ids = tribe_get_organizer_ids();
$multiple      = count($organizer_ids) > 1;

$phone   = tribe_get_organizer_phone();
$email   = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h3 class="tribe-events-single-section-title article_title title -sub"><?php echo tribe_get_organizer_label(!$multiple); ?></h3>
	<ul class="article_text text -list">
		<?php do_action("tribe_events_single_meta_organizer_section_start"); ?>

		<?php foreach ($organizer_ids as $organizer): ?>
			<?php if (!$organizer) continue; ?>
			<li class="tribe-organizer text_list-item">
				<?php echo tribe_get_organizer_link($organizer); ?>
			</li><!--/.text_list-item-->
		<?php endforeach; // ($organizer_ids as $organizer) ?>

		<?php if (!$multiple): ?>
			<?php if (!empty($phone)): ?>
                <li class="text_list-item">
    				<strong class="_bold"><?php esc_html_e("Phone:", "the-events-calendar"); ?></strong>
    				<span class="tribe-organizer-tel">
    					<?php echo esc_html( $phone ); ?>
    				</span>
                </li><!--/.text_list-item-->
            <?php endif; // (!empty($phone)) ?>

			<?php if (!empty($email)): ?>
                <li class="text_list-item">
    				<strong class="_bold"><?php esc_html_e("Email:", "the-events-calendar"); ?></strong>
    				<span class="tribe-organizer-email">
    					<?php echo esc_html($email); ?>
    				</span>
                </li><!--/.text_list-item-->
			<?php endif; // (!empty($email)) ?>

			<?php if (!empty($website)): ?>
                <li class="text_list-item">
    				<strong class="_bold"><?php esc_html_e( 'Website:', "the-events-calendar"); ?></strong>
    				<span class="tribe-organizer-url">
    					<?php echo preg_replace("/<a /im", "<a class='text_link link' ", $website); ?>
    				</span>
                </li><!--/.text_list-item-->
            <?php endif; // (!empty($website)) ?>
		<?php endif; // (!$multiple) ?>

		<?php do_action("tribe_events_single_meta_organizer_section_end"); ?>
	</ul><!--/.article_text.text.-list-->
</div>
