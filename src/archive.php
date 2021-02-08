<?php
$queried_object  = get_queried_object();
$archive_title   = is_post_type_archive() && isset($queried_object->label) && $queried_object->label ? $queried_object->label : (single_term_title("", false) ? single_term_title("", false) : get_the_archive_title());
$archive_content = isset($queried_object->description) && $queried_object->description ? $queried_object->description : get_the_archive_description();

if (is_paged() && $page = get_query_var("paged")) {
    $archive_title = sprintf("{$archive_title} - " . __("Page %s of %s", "__gulp_init_namespace__"), $page, $wp_query->max_num_pages);
}
?>

<?php get_header(); ?>

<div class="content-block">
    <div class="content__inner">
        <div class="content__post">
            <?php do_action("__gulp_init_namespace___before_content"); ?>

            <?php if ($archive_title || $archive_content): ?>
                <article class="content__article article article--introduction">

                    <?php if ($archive_title): ?>
                        <header class="article__header">
                            <h1 class="article__title title">
                                <?php echo $archive_title; ?>
                            </h1>
                        </header>
                    <?php endif; ?>

                    <?php if ($archive_content): ?>
                        <div class="article__content">
                            <div class="article__user-content user-content">
                                <?php echo apply_filters("the_content", $archive_content); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </article><!--/.content__article-->
            <?php endif; ?>

            <?php
            if (have_posts()) {
                while (have_posts()) { the_post();
                    get_extended_template_part("article", "post-excerpt", [
                        "post"  => $post,
                        "class" => "content__article",
                        "meta"  => $post->post_type === "post" ? true : false,
                    ]);
                }
            } else {
                get_extended_template_part("article", "post-none", [
                    "class" => "content__article",
                    "error" => __gulp_init_namespace___get_no_posts_message(get_queried_object()),
                ]);
            }
            ?>

            <?php get_extended_template_part("menu-list", "pagination"); ?>

            <?php do_action("__gulp_init_namespace___after_content"); ?>
        </div><!--/.content__post-->
    </div><!--/.content__inner-->
</div><!--/.content-block-->

<?php get_footer(); ?>
