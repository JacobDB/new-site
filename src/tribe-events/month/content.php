<div id="tribe-events-content" class="tribe-events-month">
	<!-- Month Title -->
	<?php do_action("tribe_events_before_the_title"); ?>
	<h2 class="tribe-events-page-title tribe_title title _textcenter"><?php tribe_events_title(); ?></h2>
	<?php do_action("tribe_events_after_the_title"); ?>

	<!-- Notices -->
	<?php tribe_the_notices(); ?>

	<!-- Month Header -->
	<?php do_action("tribe_events_before_header"); ?>
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes(); ?>>
		<?php tribe_get_template_part("month/nav"); ?><br />
	</div><!--/#tribe-events-header-->
	<?php do_action("tribe_events_after_header"); ?>

	<!-- Month Grid -->
	<?php tribe_get_template_part("month/loop", "grid"); ?>

	<!-- Month Footer -->
	<?php do_action("tribe_events_before_footer"); ?>
	<div id="tribe-events-footer">
		<?php do_action("tribe_events_before_footer_nav"); ?>
		<?php tribe_get_template_part("month/nav"); ?>
		<?php do_action("tribe_events_after_footer_nav"); ?>
	</div><!--/#tribe-events-footer-->
	<?php do_action("tribe_events_after_footer"); ?>

    <div class="_mobile">
       <?php tribe_get_template_part("month/mobile"); ?>
   </div><!--/._mobile-->

	<?php tribe_get_template_part("month/tooltip"); ?>
</div><!--/#tribe-events-content-->
