<?php require_once("{$_SERVER["DOCUMENT_ROOT"]}/wp-blog-header.php"); ?>
<?php http_response_code(200); ?>
<?php
add_filter("wpseo_title", function($title) {
    return $title = sprintf(__("408: Request Timeout - %s", "@@init_namespace"), get_bloginfo("name"));
});
?>
<?php get_header(); ?>
<div class="content-block">
    <div class="content_inner">
        <div class="content_post">
            <?php do_action("@@init_namespace_before_content"); ?>

            <article class="content_article article">
                <header class="article_header">
                    <h1 class="article_title title"><?php _e("408: Request Timeout", "@@init_namespace"); ?></h1>
                </header><!--/.article_header-->
                <div class="article_content">
                    <p class="article_text text"><?php _e("You may be seeing this error because you are offline. You can continue to browse to pages you have previously visited, but some features may not work as expected; to visit new pages, please verify your connection.", "@@init_namespace"); ?></p>
                </div><!--/.article_content-->
            </article><!--/.content_article.article-->

            <?php do_action("@@init_namespace_after_content"); ?>
        </div><!--/.content_post-->
    </div><!--/.content_inner-->
</div><!--/.content-block-->
<?php get_footer(); ?>
