<!--removeIf(tribe_html)--><?php
// force redirect 'cause tribe is stupid
if (is_post_type_archive("tribe_events")) {
    include(TEMPLATEPATH . "/archive-tribe_events.php");
    return;
} elseif (get_post_type() == "tribe_events") {
    include(TEMPLATEPATH . "/single-tribe_events.php");
    return;
}
?>
<!--endRemoveIf(tribe_html)--><?php get_header(); ?>
<?php get_template_part("partials/block", "hero"); ?>
<div class="content-block">
    <div class="content_inner">
        <div class="content_post">
            <?php do_action("new_site_before_content"); ?>

            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <?php get_template_part("partials/content", "full"); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <?php get_template_part("partials/content", "none"); ?>
            <?php endif; ?>

            <?php do_action("new_site_after_content"); ?>
        </div><!--/.content_post-->
    </div><!--/.content_inner-->
</div><!--/.content-block-->
<?php get_footer(); ?>
