<?php
$post           = isset($this->vars["post"]) ? $this->vars["post"] : false;
$class          = isset($this->vars["class"]) ? $this->vars["class"] : "";
$block_class    = gettype($class) === "array" && key_exists("block", $class) ? " {$class["block"]}" : (gettype($class) === "string" ? " {$class}" : "");
$inner_class    = gettype($class) === "array" && key_exists("inner", $class) ? " {$class["inner"]}" : "";
$swiper_class   = gettype($class) === "array" && key_exists("swiper", $class) ? " {$class["swiper"]}" : "";
$navigation     = isset($this->vars["navigation"]) ? $this->vars["navigation"] : false;
$pagination     = isset($this->vars["pagination"]) ? $this->vars["pagination"] : false;
$slideshow      = isset($this->vars["slideshow"]) ? $this->vars["slideshow"] : ($post ? __gulp_init_namespace___get_field("slideshow", $post->ID) : false);
$image_size     = isset($this->vars["image_size"]) ? $this->vars["image_size"] : "hero";
$featured_image = isset($this->vars["featured_image"]) ? $this->vars["featured_image"] : ($post && has_post_thumbnail($post->ID) ? ["alt" => get_post_meta(get_post_thumbnail_id($post->ID), "_wp_attachment_image_alt", true), "small" => wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "{$image_size}")[0], "medium" => wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "{$image_size}_medium")[0], "large" => wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "{$image_size}_large")[0]] : false);
$title          = isset($this->vars["title"]) ? $this->vars["title"] : false;

$slide_count = $slideshow ? count($slideshow) : 0;
?>
<?php if ($slideshow || $featured_image): ?>
    <div class="hero-block<?php echo $block_class; ?>" role="region">
        <div class="hero__inner<?php echo $inner_class; ?>">
            <div class="hero__swiper-container swiper-container swiper-container--hero<?php echo $swiper_class; ?>" data-slideout-ignore="true">

                <div class="swiper-wrapper">
                    <?php if ($slideshow): ?>
                        <?php foreach ($slideshow as $slide): ?>
                            <?php
                            $image = isset($slide["image"]) ? $slide["image"] : false;
                            $link  = isset($slide["link"]) ? $slide["link"] : false;
                            ?>

                            <?php if ($image): ?>
                                <figure class="swiper-slide">

                                    <?php if ($link && $link["url"]): ?>
                                        <a class="swiper__link link" href="<?php echo $link["url"]; ?>"<?php if ($link["title"]): ?> title="<?php echo $link["title"]; ?>"<?php endif; ?><?php if ($link["target"]): ?> rel="noopener" target="<?php echo $link["target"]; ?>"<?php endif; ?>>
                                    <?php endif; ?>

                                    <?php if ($image["sizes"]["{$image_size}"]): ?>
                                        <picture class="swiper__picture">

                                            <?php if ($image["sizes"]["{$image_size}_large"]): ?>
                                                <?php echo __gulp_init_namespace___img($image["sizes"]["{$image_size}_large"], ["media" => "(min-width: 64em)"], true, "source"); ?>
                                            <?php endif; ?>

                                            <?php if ($image["sizes"]["{$image_size}_medium"]): ?>
                                                <?php echo __gulp_init_namespace___img($image["sizes"]["{$image_size}_medium"], ["media" => "(min-width: 40em)"], true, "source"); ?>
                                            <?php endif; ?>

                                            <?php if ($image["sizes"]["{$image_size}"]): ?>
                                                <?php echo __gulp_init_namespace___img($image["sizes"]["{$image_size}"], ["alt" => $image["alt"], "class" => "swiper__image swiper-lazy"]); ?>
                                            <?php endif; ?>

                                        </picture><!--/.swiper__picture-->
                                    <?php endif; // ($image["sizes"]["{$image_size}"]) ?>

                                    <?php if ($image["title"] || $image["caption"]): ?>
                                        <figcaption class="swiper__caption">
                                            <div class="swiper__caption__inner">
                                                <?php if ($image["title"]): ?>
                                                    <h6 class="swiper__title title<?php echo ! $image["caption"] ? " __nomargin" : ""; ?>">
                                                        <?php echo $image["title"]; ?>
                                                    </h6>
                                                <?php endif; ?>

                                                <?php if ($image["caption"]): ?>
                                                    <div class="swiper__user-content user-content user-content--light">
                                                        <?php echo apply_filters("the_content", $image["caption"]); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div><!--/.swiper__caption__inner-->
                                        </figcaption><!--/.swiper__caption-->
                                    <?php endif; // ($image["title"] || $image["caption"]) ?>

                                    <?php if ($link && $link["url"]): ?>
                                        </a><!--/.swiper__link-->
                                    <?php endif; ?>

                                </figure><!--/.swiper-slide-->
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php elseif ($featured_image): ?>
                        <figure class="swiper-slide">

                            <picture class="swiper__picture">

                                <?php if ($featured_image["large"]): ?>
                                    <?php echo __gulp_init_namespace___img($featured_image["large"], ["media" => "(min-width: 64em)"], false, "source"); ?>
                                <?php endif; ?>

                                <?php if ($featured_image["medium"]): ?>
                                    <?php echo __gulp_init_namespace___img($featured_image["medium"], ["media" => "(min-width: 40em)"], false, "source"); ?>
                                <?php endif; ?>

                                <?php if ($featured_image["small"]): ?>
                                    <?php echo __gulp_init_namespace___img($featured_image["small"], ["alt" => $featured_image["alt"], "class" => "swiper__image swiper-lazy"]); ?>
                                <?php endif; ?>

                            </picture><!--/.swiper-picture-->

                            <?php if ($title): ?>
                                <header class="swiper__caption">
                                    <div class="swiper__caption__inner">
                                        <h1 class="swiper__title title __nomargin" role="heading">
                                            <?php echo $title; ?>
                                        </h1>
                                    </div>
                                </header>
                            <?php endif; ?>

                        </figure><!--/.swiper-slide-->
                    <?php endif; ?>
                </div> <!--/.swiper-wrapper-->

                <?php if ($slideshow && ($navigation || $pagination) && $slide_count > 1): ?>
                    <?php if ($navigation): ?>
                        <div class="swiper-pagination"></div>
                    <?php endif; ?>

                    <?php if ($pagination): ?>
                        <button class="swiper-button swiper-button--prev">
                            <i class="swiper-button__icon fas fa-caret-left"></i>
                            <span class="__visuallyhidden"><?php _e("Previous Slide", "__gulp_init_namespace__"); ?></span>
                        </button>

                        <button class="swiper-button swiper-button--next">
                            <i class="swiper-button__icon fas fa-caret-right"></i>
                            <span class="__visuallyhidden"><?php _e("Next Slide", "__gulp_init_namespace__"); ?></span>
                        </button>
                    <?php endif; ?>
                <?php endif; ?>

            </div><!--/.hero__swiper-container-->
        </div><!--/.hero__inner-->
    </div><!--/.hero-block-->
<?php endif; ?>
