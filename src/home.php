<?php get_header(); ?>
<?php get_template_part("partials/block", "hero"); ?>
<div class="content-block">
    <div class="content_inner">
        <div class="content_post">
            <?php do_action("@@namespace_before_content"); ?>

            <?php
            $posts_page = get_post(get_option("page_for_posts"));
            $title = get_the_title($posts_page->ID) ? get_the_title($posts_page->ID) : __("Latest Posts", "@@namespace");
            ?>

            <?php if ($title): ?>
                <article class="content_article article -introduction">
                    <header class="article_header">
                        <h1 class="article_title title"><?php echo $title; ?></h1>
                    </header><!--/.article_header-->
                </article><!--/.content_article.article.-introduction-->
            <?php endif; ?>

            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <?php get_template_part("partials/content", "excerpt"); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <?php get_template_part("partials/content", "none"); ?>
            <?php endif; ?>

            <?php get_template_part("partials/list", "pagination"); ?>

            <?php do_action("@@namespace_after_content"); ?>
        </div><!--/.content_post-->
    </div><!--/.content_inner-->
</div><!--/.content-block-->
<?php get_footer(); ?>
