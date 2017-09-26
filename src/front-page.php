<?php get_header(); ?>
<?php $block_variant = "_nopadding"; ?>
<?php include(locate_template("partials/block-hero.php")); ?>
<div class="content-block">
    <div class="content_inner">
        <div class="content_post">
            <?php do_action("@@namespace_before_content"); ?>

            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <?php
                    $post_variant = "content_article";
                    $post_title   = "";
                    ?>
                    <?php include(locate_template("partials/content-full.php")); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <?php include(locate_template("partials/content-none.php")); ?>
            <?php endif; ?>

            <?php include(locate_template("partials/grid-callout.php")); ?>

            <?php do_action("@@namespace_after_content"); ?>
        </div><!--/.content_post-->
    </div><!--/.content_inner-->
</div><!--/.content-block-->
<?php get_footer(); ?>
