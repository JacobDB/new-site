<?php get_header(); ?>
<div class="content-block content-block--fullbleed">
    <div class="content__inner">
        <div class="content__post">
            <?php do_action("__gulp_init_namespace___before_content"); ?>

            <?php
            $queried_object  = get_queried_object();
            $archive_title   = is_post_type_archive() && isset($queried_object->label) && $queried_object->label ? $queried_object->label : (single_term_title("", false) ? single_term_title("", false) : get_the_archive_title());
            $archive_content = isset($queried_object->description) && $queried_object->description ? $queried_object->description : get_the_archive_description();
            ?>

            <?php if ($archive_title || $archive_content): ?>
                <article class="content__article article article--introduction">
                    <?php if ($archive_title): ?>
                        <header class="article__header">
                            <h1 class="article__title title"><?php echo $archive_title; ?></h1>
                        </header>
                    <?php endif; ?>

                    <?php if ($archive_content): ?>
                        <div class="article__content">
                            <div class="article__user-content user-content">
                                <?php echo apply_filters("the_content", $archive_content); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </article><!--/.content__article.article-->
            <?php endif; ?>

            <?php
            if (have_posts()) {
                while (have_posts()) { the_post();
                    __gulp_init_namespace___get_template_part("partials/articles/post-excerpt.php", array(
                        "post"  => $post,
                        "class" => "content__article",
                    ));
                }
            } else {
                __gulp_init_namespace___get_template_part("partials/articles/post-none.php", array(
                    "class" => "content__article",
                    "error" => __gulp_init_namespace___get_no_posts_message(get_queried_object()),
                ));
            }
            ?>

            <?php __gulp_init_namespace___get_template_part("partials/modules/menu-list-pagination.php"); ?>

            <?php do_action("__gulp_init_namespace___after_content"); ?>
        </div><!--/.content__post-->
    </div><!--/.content__inner-->
</div><!--/.content-block-->
<?php get_footer(); ?>
