<?php get_header(); ?>

<div class="content-block">
    <div class="content__inner">
        <div class="content__post">
            <?php do_action("__gulp_init_namespace___before_content"); ?>

            <article class="content__article article">
                <header class="article__header">
                    <h1 class="article__title title"><?php _e("No Internet Connection", "__gulp_init_namespace__"); ?></h1>
                </header>
                <div class="article__content">
                    <p class="article__text text"><?php _e("This page could not be accessed because you are not connected to the internet. Please try again once you've regained a connection.", "__gulp_init_namespace__"); ?></p>
                </div>
            </article>

            <?php do_action("__gulp_init_namespace___after_content"); ?>
        </div><!--/.content__post-->
    </div><!--/.content__inner-->
</div><!--/.content-block-->

<?php get_footer(); ?>
