<?php
$term = get_queried_object();
$post_type = get_post_type() ? get_post_type() : __("post", "@@namespace");
$error_message = is_archive() ? __("Sorry, no {$post_type}s could be found in this {$term->taxonomy}.", "@@namespace") : (is_search() ? (get_search_query() ? __("Sorry, no {$post_type} could be found for the search phrase &ldquo;" . get_search_query() . "&rdquo;.", "@@namespace") : __("No search query was entered.", "@@namespace")) : __("Sorry, no {$post_type}s could be found matching this criteria.", "@@namespace"));
?>

<article class="content_article article -full">
    <div class="article_content">
        <p class="article_text text"><?php echo $error_message; ?></p>
    </div><!--/.article_content-->
</article><!--/.content_article.article.-full-->
