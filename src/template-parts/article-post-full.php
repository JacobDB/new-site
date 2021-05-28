<?php
$post    = isset($this->vars["post"]) ? $this->vars["post"] : false;
$class   = isset($this->vars["class"]) ? " {$this->vars["class"]}" : "";
$light   = isset($this->vars["light"]) ? $this->vars["light"] : false;
$title   = isset($this->vars["title"]) ? $this->vars["title"] : ($post ? apply_filters("the_title", $post->post_title, $post->ID) : "");
$meta    = isset($this->vars["meta"]) ? $this->vars["meta"] : false;
$content = isset($this->vars["content"]) ? $this->vars["content"] : ($post ? apply_filters("the_content", $post->post_content) : "");
?>

<?php if ($title || $content): ?>
    <article class="article article--post-full<?php echo $class; ?>">

        <?php if ($title || $meta): ?>
            <header class="article__header">
                <?php if ($title): ?>
                    <h1 class="article__title title<?php if ($light): ?> __light<?php endif; ?>">
                        <?php echo $title; ?>
                    </h1>
                <?php endif; ?>

                <?php if ($meta): ?>
                    <?php
                    get_extended_template_part("menu-list", "meta", [
                        "post"  => $post,
                        "class" => "article__menu-list__container",
                        "light" => $light,
                    ]);
                    ?>
                <?php endif; ?>
            </header><!--/.article_header-->
        <?php endif; ?>

        <?php if ($content): ?>
            <div class="article__content">
                <div class="article__user-content user-content<?php if ($light): ?> user-content--light<?php endif; ?>">
                    <?php echo $content; ?>
                </div>
            </div>
        <?php endif; ?>

    </article><!--/.article-->
<?php endif; ?>
