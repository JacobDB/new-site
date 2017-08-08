<?php get_header(); ?>
<?php get_template_part("partials/block", "hero"); ?>
<div class="content-block">
    <div class="content_inner">
        <div class="content_post">
            <?php do_action("@@namespace_before_content"); ?>

            <?php $term = get_queried_object(); ?>
            <?php if (get_the_archive_title() || $term->description): ?>
                <article class="content_article article -introduction">

                    <?php if (get_the_archive_title()): ?>
                        <header class="article_header">
                            <?php the_archive_title("<h1 class='article_title title'>", "</h1>"); ?>
                        </header><!--/.article_header-->
                    <?php endif; // if (get_the_archive_title()) ?>

                    <?php if ($term->description): ?>
                        <div class="article_content">
                            <div class="article_user-content user-content">
                                <?php echo wpautop($term->description); ?>
                            </div><!--/.article_user-content.user-content-->
                        </div><!--/.article_content-->
                    <?php endif; ?>

                </article><!--/.content_article article.-introduction-->
            <?php endif; // if (get_the_archive_title() || $term->description) ?>

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
