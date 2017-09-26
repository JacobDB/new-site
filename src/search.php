<?php get_header(); ?>
<div class="content-block">
    <div class="content_inner">
        <div class="content_post">
            <?php do_action("@@namespace_before_content"); ?>

            <div class="content_search-form_container search-form_container">
                <?php get_search_form(); ?>
            </div><!--/.content_search-form_container.search-form_container-->

            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <?php $post_variant = "content_article"; ?>
                    <?php include(locate_template("partials/content-excerpt.php")); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <?php $post_variant = "content_article"; ?>
                <?php include(locate_template("partials/content-none.php")); ?>
            <?php endif; ?>

            <?php include(locate_template("partials/list-pagination.php")); ?>

            <?php do_action("@@namespace_after_content"); ?>
        </div><!--/.content_post-->
    </div><!--/.content_inner-->
</div><!--/.content-block-->
<?php get_footer(); ?>
