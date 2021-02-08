<?php
$home_object = get_option("page_for_posts") ? get_post(get_option("page_for_posts")) : false;
$home_title  = $home_object && key_exists("post_title", $home_object) ? apply_filters("the_title", $home_object->post_title, $post->ID) : __("Latest Posts", "__gulp_init_namespace__");

if (is_paged() && $page = get_query_var("paged")) {
    $home_title = sprintf("{$home_title} - " . __("Page %s of %s", "__gulp_init_namespace__"), $page, $wp_query->max_num_pages);
}
?>
<?php get_header(); ?>

<?php
get_extended_template_part("layout", "hero", [
    "title" => $home_title,
]);
?>

<div class="content-block">
    <div class="content__inner">
        <div class="content__post">
            <?php do_action("__gulp_init_namespace___before_content"); ?>

            <?php if ($home_title): ?>
                <article class="content__article article article--introduction">
                    <header class="article__header">
                        <h1 class="article__title title">
                            <?php echo $home_title; ?>
                        </h1>
                    </header>
                </article>
            <?php endif; ?>

            <?php
            if (have_posts()) {
                while (have_posts()) { the_post();
                    get_extended_template_part("article", "post-excerpt", [
                        "post"  => $post,
                        "class" => "content__article",
                        "meta"  => true,
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
