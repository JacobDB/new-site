<?php get_header(); ?>
<?php include(locate_template("partials/block-hero.php")); ?>
<div class="content-block">
    <div class="content_inner">
        <div class="content_post">
            <?php do_action("@@init_namespace_before_content"); ?>

            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <?php $post_varaint = "content_article"; ?>
                    <?php include(locate_template("partials/content-full.php")); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <?php $post_varaint = "content_article"; ?>
                <?php include(locate_template("partials/content-none.php")); ?>
            <?php endif; ?>

            <?php do_action("@@init_namespace_after_content"); ?>
        </div><!--/.content_post-->
    </div><!--/.content_inner-->
</div><!--/.content-block-->
<?php get_footer(); ?>
