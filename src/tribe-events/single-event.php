<?php
$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();
$event_id = get_the_ID();
?>

<div id="tribe-events-content" class="tribe-events-single">

    <?php if (tribe_get_prev_event_link() || !(tribe_get_prev_event_link() || tribe_get_next_event_link())): ?>
    	<p class="tribe-events-back tribe-events-single_text text">
    		<a class="tribe-events-single_link link" href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', "the-events-calendar"), $events_label_plural ); ?></a>
    	</p>
    <?php endif; ?>

    <!-- Event header -->
    <?php if (tribe_get_prev_event_link() || tribe_get_next_event_link()): ?>
        <nav class="tribe-events-single_menu-list_container menu-list_container" id="tribe-events-header" <?php tribe_events_the_header_attributes(); ?>>
            <!-- Navigation -->
            <h3 class="_visuallyhidden"><?php printf(esc_html__("%s Navigation", "the-events-calendar"), $events_label_singular); ?></h3>
            <ul class="tribe-events-sub-nav menu-list -pagination -between">
                <li class="tribe-events-nav-previous menu-list_item">
                    <?php if (tribe_get_prev_event_link()): ?>
                        <?php tribe_the_prev_event_link("&laquo; %title%"); ?>
                    <?php else: ?>
                        <a class="menu-list_link link" href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', "the-events-calendar"), $events_label_plural ); ?></a>
                    <?php endif; ?>
                </li><!--/.menu-list_item-->

                <li class="tribe-events-nav-next menu-list_item">
                    <?php tribe_the_next_event_link("%title% &raquo;"); ?>
                </li><!--/.menu-list_item-->
            </ul><!--/.menu-list.-pagination.-between-->
        </div><!--/.tribe-events-single_menu-list_container.menu-list_container-->

        <br />
    <?php endif; // (tribe_get_prev_event_link() || tribe_get_next_event_link()) ?>

	<!-- Notices -->
	<?php tribe_the_notices(); ?>

	<?php while (have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        	<?php the_title("<h1 class='tribe-events-single-event-title tribe-events-single_title title'>", "</h1>"); ?>

        	<nav class="tribe-events-schedule tribe-clearfix tribe-events-single_menu-list_container menu-list_container">
                <ul class="menu-list -meta">
                    <li class="menu-list_item">
                        <icon use="clock" class="menu-list_icon" />
                        <?php echo strip_tags(tribe_events_event_schedule_details($event_id)); ?>
                    </li><!--/.menu-list_item-->
                    <?php if (tribe_get_cost()): ?>
                        <li class="menu-list_item">
                            <icon use="money" class="menu-list_icon" />
                            <span class="tribe-events-cost"><?php echo tribe_get_cost(null, true); ?></span>
                        </li><!--/.menu-list_item-->
                    <?php endif; ?>
                </ul><!--/.menu-list.-meta-->
        	</nav><!--/.tribe-events-single_menu-list_container.menu-list_container-->

			<!-- Event featured image, but exclude link -->
            <?php if (has_post_thumbnail()): ?>
                <br />

                <figure class="article_figure">
                    <?php the_post_thumbnail("hero_large", array("class" => "article_image")); ?>
                </figure><!--/.article_figure-->
            <?php endif; ?>

			<!-- Event content -->
			<?php do_action("tribe_events_single_event_before_the_content"); ?>
			<div class="tribe-events-single-event-description tribe-events-content article_content">
                <div class="article_user-content user-content">
                    <?php the_content(); ?>
                </div><!--/.article_user-content.user-content-->
			</div><!--/.article_content-->
			<?php
            ob_start();
            do_action("tribe_events_single_event_after_the_content");
            $tribe_events_single_event_after_the_content = ob_get_contents();
            ob_end_clean();

            echo preg_replace("/(\/a>)(<a )/im", "$1&nbsp;&nbsp;$2", (preg_replace("/tribe-events-button/im", "tribe-events-button article_button button", $tribe_events_single_event_after_the_content)));
            ?>

			<!-- Event meta -->
			<?php do_action("tribe_events_single_event_before_the_meta"); ?>
			<?php tribe_get_template_part("modules/meta"); ?>
			<?php do_action("tribe_events_single_event_after_the_meta"); ?>
		</div><!--/#post-x-->
		<?php if (get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option("showComments", false )) comments_template(); ?>
	<?php endwhile; ?>

	<!-- Event footer -->
    <?php if (tribe_get_prev_event_link() || tribe_get_next_event_link()): ?>
    	<nav class="tribe-events-single_menu-list_container menu-list_container" id="tribe-events-footer">
    		<!-- Navigation -->
    		<h3 class="_visuallyhidden"><?php printf( esc_html__( '%s Navigation', "the-events-calendar"), $events_label_singular ); ?></h3>
    		<ul class="tribe-events-sub-nav menu-list -pagination -between">
    			<li class="tribe-events-nav-previous menu-list_item">
                    <?php tribe_the_prev_event_link("<span>&laquo;</span> %title%"); ?>
                </li><!--/.menu-list_item-->

    			<li class="tribe-events-nav-next menu-list_item">
                    <?php tribe_the_next_event_link("%title% <span>&raquo;</span>"); ?>
                </li><!--/.menu-list_item-->
    		</ul><!--/.menu-list.-pagination.-between-->
    	</nav><!--/.tribe-events-single_menu-list_container.menu-list_container-->
    <?php endif; // (tribe_get_prev_event_link() || tribe_get_next_event_link()) ?>

</div><!--/#tribe-events-content-->
