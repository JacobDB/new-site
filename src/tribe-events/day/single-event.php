<?php
global $post;
$venue_details     = tribe_get_venue_details();
$has_venue_address = (!empty($venue_details["address"])) ? " location" : "";
$organizer         = tribe_get_organizer();
?>

<article id="post-<?php the_ID(); ?>" class="<?php tribe_events_event_classes(); ?> tribe-events-day_article article -eventexcerpt" <?php if ($post->post_parent): ?> data-parent-post-id="<?php echo absint($post->post_parent); ?>"<?php endif; ?>>
    <div class="article_row row -padded">
        <!-- Event Image -->
        <?php if (has_post_thumbnail()): ?>
            <div class="col-12 col-xs-3 -nogrow -noshrink">
                <figure class="article_figure">
                    <?php the_post_thumbnail("excerpt_large", array("class" => "article_image")); ?>
                </figure><!--/.article_figure-->
            </div><!--/.col-12.col-xs-3.-nogrow.-noshrink-->
        <?php endif; ?>

        <div class="col-12 col-xs-0">
            <header class="article_header">
                <!-- Event Title -->
                <?php do_action("tribe_events_before_the_event_title"); ?>
                <h2 class="tribe-events-list-event-title article_title title -sub">
                    <a class="tribe-event-url article_link link" href="<?php echo esc_url(tribe_get_event_link()); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                        <?php the_title(); ?>
                    </a><!--/.tribe-event-url.article_link.link-->
                </h2><!--/.tribe-events-list-event-title.article_title.title.-sub-->
                <?php do_action("tribe_events_after_the_event_title"); ?>

                <!-- Event Meta -->
                <?php do_action("tribe_events_before_the_meta"); ?>
                <nav class="tribe-events-event-meta article_menu-list_container menu-list_container">
                    <ul class="author <?php echo esc_attr($has_venue_address); ?> menu-list -meta">

                        <!-- Schedule & Recurrence Details -->
                        <li class="tribe-event-schedule-details menu-list_item">
                            <icon use="clock" class="menu-list_icon" />
                            <?php echo tribe_events_event_schedule_details(); ?>
                        </li><!--/.tribe-event-schedule-details.menu-list_item-->

                        <!-- Event Cost -->
                        <?php if (tribe_get_cost()): ?>
                            <li class="tribe-events-event-cost menu-list_item">
                                <icon use="money" class="menu-list_icon" />
                                <span class="ticket-cost"><?php echo tribe_get_cost(null, true); ?></span>
                                <?php do_action("tribe_events_inside_cost"); ?>
                            </li><!--/.tribe-events-event-cost.menu-list_item-->
                        <?php endif; // (tribe_get_cost()) ?>

                        <?php if ($venue_details): ?>
                            <!-- Venue Display Info -->
                            <li class="tribe-events-venue-details menu-list_item" style="clear:left;">
                                <icon use="map-marker" class="menu-list_icon" />
                                <?php echo implode(", ", $venue_details); ?>
                                <?php
                                if (tribe_get_map_link()) {
                                    echo preg_replace("/(tribe-events-gmap)/im", "$1 menu-list_link link", tribe_get_map_link_html());
                                }
                                ?>
                            </li> <!--/.tribe-events-venue-details.menu-list_item-->
                        <?php endif; // ($venue_details) ?>

                    </ul><!--/.author.menu-list.-meta-->
                </nav><!--/.tribe-events-event-meta.article_menu-list_container.menu-list_container-->

                <?php do_action("tribe_events_after_the_meta"); ?>
            </header><!--/.article_header-->

            <!-- Event Content -->
            <?php do_action("tribe_events_before_the_content"); ?>
            <div class="tribe-events-list-event-description tribe-events-content description entry-summary article_content">
                <div class="article_user-content user-content">
                    <?php echo tribe_events_get_the_excerpt(null, wp_kses_allowed_html("post")); ?>
                </div><!--/.article_user-content.user-content-->

            	<a href="<?php echo esc_url(tribe_get_event_link()); ?>" class="tribe-events-read-more article_button button" rel="bookmark"><?php esc_html_e("Find out more", "the-events-calendar"); ?> &raquo;</a>
            </div><!--/tribe-events-list-event-description.tribe-events-content.description.entry-summary.article_content-->
            <?php do_action("tribe_events_after_the_content"); ?>
        </div><!--/.col-12.col-xs-0-->
    </div><!--/.article_row.row.-padded-->
</article><!--/.tribe-events-day_article.article.-eventexcerpt-->
