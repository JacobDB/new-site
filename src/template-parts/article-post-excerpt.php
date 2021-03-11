<?php
$post      = isset($this->vars["post"]) ? $this->vars["post"] : false;
$class     = isset($this->vars["class"]) ? " {$this->vars["class"]}" : "";
$light     = isset($this->vars["light"]) ? $this->vars["light"] : false;
$permalink = isset($this->vars["permalink"]) ? $this->vars["permalink"] : ($post ? get_the_permalink($post->ID) : false);
$title     = isset($this->vars["title"]) ? $this->vars["title"] : ($post ? $post->post_title : false);
$meta      = isset($this->vars["meta"]) ? $this->vars["meta"] : false;
$excerpt   = isset($this->vars["excerpt"]) ? $this->vars["excerpt"] : ($post ? __gulp_init_namespace___get_the_excerpt($post->ID, ["truncate" => ["count" => 55], "suffix" => ["value" => "&hellip;", "optional" => true]]) : false);
?>

<?php if ($title || $permalink): ?>
    <article class="article article--excerpt<?php echo $class; ?>">

        <?php if ($title || $meta): ?>
            <header class="article__header">
                <?php if ($title): ?>
                    <h3 class="article__title title<?php if ($light): ?> __light<?php endif; ?>">
                        <?php if ($permalink): ?>
                            <a class="title__link link<?php if ($light): ?> link--inherit<?php endif; ?>" href="<?php echo esc_url($permalink); ?>">
                        <?php endif; ?>

                        <?php echo $title; ?>

                        <?php if ($permalink): ?>
                            </a>
                        <?php endif; ?>
                    </h3><!--/.article__title-->
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
            </header><!--/.article__header-->
        <?php endif; ?>

        <?php if ($excerpt): ?>
            <div class="article__content">
                <div class="article__user-content user-content">
                    <p class="article__text text<?php if ($light): ?> __light<?php endif; ?>">
                        <?php echo $excerpt; ?>
                        <?php if ($permalink): ?>
                            <a class="text__link link<?php if ($light): ?> link--inherit<?php endif; ?>" href="<?php echo esc_url($permalink); ?>">
                                <?php _e("Read More", "__gulp_init_namespace__"); ?>
                            </a>
                        <?php endif; ?>
                    </p>
                </div>
            </div><!--/.article__content-->
        <?php endif; ?>

    </article><!--/.article-->
<?php endif; ?>
