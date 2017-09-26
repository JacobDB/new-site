<?php
global $post;
$venue_details     = tribe_get_venue_details();
$has_venue_address = (!empty($venue_details["address"])) ? " location" : "";
$organizer         = tribe_get_organizer();
?>

<article id="post-<?php the_ID(); ?>" class="<?php tribe_events_event_classes(); ?> tribe-events-day_article article -eventexcerpt -featured" <?php if ($post->post_parent): ?> data-parent-post-id="<?php echo absint($post->post_parent); ?>"<?php endif; ?>>
    <?php tribe_get_template_part("day/single", "event"); ?>
</article><!--/.tribe-events-day_article.article.-eventexcerpt.-featured-->
