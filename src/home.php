<?php
$post_id    = get_post(get_option("page_for_posts"));
$post_title = get_the_title($post_id) ? get_the_title($post_id) : __("Latest Posts", "new_site");
?>
<?php get_header(); ?>
<?php
if ($posts_title) $block_title = $post_title;
include(locate_template("partials/block-hero.php"));
?>
<div class="content-block">
    <div class="content_inner">
        <div class="content_post">
            <?php do_action("@@namespace_before_content"); ?>

            <?php if ($title): ?>
                <article class="content_article article -introduction">
                    <header class="article_header">
                        <h1 class="article_title title"><?php echo $title; ?></h1>
                    </header><!--/.article_header-->
                </article><!--/.content_article.article.-introduction-->
            <?php endif; ?>

            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <?php $post_varaint = "content_article"; ?>
                    <?php include(locate_template("partials/content-excerpt.php")); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <?php $post_varaint = "content_article"; ?>
                <?php include(locate_template("partials/content-none.php")); ?>
            <?php endif; ?>

            <?php include(locate_template("partials/list-pagination.php")); ?>

            <?php do_action("@@namespace_after_content"); ?>
        </div><!--/.content_post-->
    </div><!--/.content_inner-->
</div><!--/.content-block-->
<?php get_footer(); ?>
