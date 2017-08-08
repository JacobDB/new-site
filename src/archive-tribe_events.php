<!--removeIf(tribe_html)--><?php get_header(); ?>
<?php get_template_part("partials/block", "hero"); ?>
<div class="content-block">
    <div class="content_inner">
        <div class="content_post">
            <?php do_action("@@namespace_before_content"); ?>

            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    the_content();
                }
            }
            ?>

            <?php do_action("@@namespace_after_content"); ?>
        </div><!--/.content_post-->
    </div><!--/.content_inner-->
</div><!--/.content-block-->
<?php get_footer(); ?><!--endRemoveIf(tribe_html)-->
