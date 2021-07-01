<?php get_header(); ?>

<?php
get_extended_template_part("layout", "hero", [
    "post" => $post,
]);
?>

<div class="content-block">
    <div class="content__inner">
        <div class="content__row row row--padded">
            <div class="col-12 col-xs-8">
                <div class="content__post">
                    <?php do_action("__gulp_init_namespace___before_content"); ?>

                    <?php
                    if (have_posts()) {
                        while (have_posts()) { the_post();
                            get_extended_template_part("article", "post-full", [
                                "post"  => $post,
                                "class" => "content__article",
                            ]);
                        }
                    }
                    ?>

                    <?php do_action("__gulp_init_namespace___after_content"); ?>
                </div><!--/.content__post-->
            </div><!--/.col-12-->
            <?php get_sidebar(); ?>
        </div><!--/.content__row-->
    </div><!--/.content__inner-->
</div><!--/.content-block-->

<?php get_footer(); ?>
