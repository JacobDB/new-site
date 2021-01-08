<?php get_header(); ?>

<div class="content-block">
    <div class="content__inner">
        <div class="content__post">
            <?php do_action("__gulp_init_namespace___before_content"); ?>

            <div class="content_search-form__container search-form__container" id="mobile-search">
                <?php get_search_form(); ?>
            </div>

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
                    "error" => ! get_search_query() ? __("No search phrase was entered.", "__gulp_init_namespace__") : __gulp_init_namespace___get_no_posts_message(get_queried_object()),
                ]);
            }
            ?>

            <?php get_extended_template_part("menu-list", "pagination"); ?>

            <?php do_action("__gulp_init_namespace___after_content"); ?>
        </div><!--/.content__post-->
    </div><!--/.content__inner-->
</div><!--/.content-block-->

<?php get_footer(); ?>
