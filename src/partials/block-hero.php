<?php
$i = 0;
$slideshow = get_field("slideshow");
$featured_image = get_the_post_thumbnail($post->ID, "hero", array("class" => "swiper-image"));
$title = is_singular() ? get_the_title() : (is_archive() ? get_the_archive_title() : (is_404() ? __("404: Page Not Found", "@@namespace") : false));

if (is_home() && !$title) {
    $posts_page = get_post(get_option("page_for_posts"));
    $title = get_the_title($posts_page->ID) ? get_the_title($posts_page->ID) : __("Latest Posts", "@@namespace");
}
?>
<?php if ($slideshow || $featured_image): ?>
<div class="hero-block -fullbleed _nopadding" role="region">
    <div class="hero_inner -fullbleed">
        <div class="hero_swiper-container swiper-container -fullbleed">

            <div class="swiper-wrapper">
                <?php if ($slideshow): ?>

                    <?php while (have_rows("slideshow")): ?>
                        <?php
                        the_row();

                        $image = get_sub_field("image");
                        $link = get_sub_field("link");
                        ?>

                        <?php if ($image): ?>
                            <?php
                            $i++;

                            $link_href = $link["url"];
                            $link_target = $link["target"] ? " target='{$link["target"]}'" : "";
                            $link_title = $link["title"] ? " title='{$link["title"]}'" : "";

                            $img_alt = $image["alt"] ? " alt='{$image["alt"]}'" : "";
                            $img_src_phone = $image["sizes"]["hero"];
                            $img_src_tablet = $image["sizes"]["hero_medium"];
                            $img_src_notebook = $image["sizes"]["hero_large"];
                            $img_title = $image["title"];
                            $img_caption = $image["caption"];
                            ?>

                            <figure class="swiper-slide">

                                <?php if ($link_href): ?>
                                <a class="swiper-link link" href="<?php echo $link_href; ?>"<?php echo $link_target . $link_title; ?>>
                                <?php endif; ?>

                                <?php if ($img_src_phone): ?>
                                <picture class="swiper-picture">
                                    <?php if ($img_src_notebook): ?>
                                    <source srcset="<?php echo $img_src_notebook; ?>" media="(min-width: 64em)" />
                                    <?php endif; ?>
                                    <?php if ($img_src_tablet): ?>
                                    <source srcset="<?php echo $img_src_tablet; ?>" media="(min-width: 40em)" />
                                    <?php endif; ?>
                                    <img class="swiper-image"<?php echo $img_alt; ?> src="<?php echo $img_src_phone; ?>" />
                                </picture><!--/.swiper-picture-->
                                <?php endif; // if ($img_src_phone) ?>

                                <?php if ($img_title || $img_caption): ?>
                                <figcaption class="swiper-caption">
                                    <div class="swiper-caption-inner">
                                        <?php if ($img_title): ?>
                                        <h6 class="swiper-title title<?php echo !$img_caption ? " _nomargin" : ""; ?>"><?php echo $img_title; ?></h6>
                                        <?php endif; ?>
                                        <?php if ($img_caption): ?>
                                        <div class="swiper-user-content user-content -dark"><?php echo wpautop($img_caption); ?></div>
                                        <?php endif; ?>
                                    </div><!--/.swiper-caption-inner-->
                                </figcaption><!--/.swiper-caption-->
                                <?php endif; // if ($img_title || $img_caption) ?>

                                <?php if ($link_href): ?>
                                </a><!--/.swiper-link.link-->
                                <?php endif; ?>

                            </figure><!--/.swiper-slide-->
                        <?php endif; // if ($image) ?>
                    <?php endwhile; // while (have_rows("slideshow")) ?>
                <?php elseif ($featured_image): ?>
                    <?php
                    $img_src_tablet = wp_get_attachment_image_src(get_post_thumbnail_id(), "hero_medium");
                    $img_src_notebook = wp_get_attachment_image_src(get_post_thumbnail_id(), "hero_large");
                    ?>

                    <figure class="swiper-slide">

                        <picture class="swiper-picture">
                            <?php if ($img_src_notebook): ?>
                            <source srcset="<?php echo $img_src_notebook[0]; ?>" media="(min-width: 64em)" />
                            <?php endif; ?>
                            <?php if ($img_src_tablet): ?>
                            <source srcset="<?php echo $img_src_tablet[0]; ?>" media="(min-width: 40em)" />
                            <?php endif; ?>
                            <?php echo $featured_image; ?>
                        </picture><!--/.swiper-picture-->

                        <?php if ($title): ?>
                        <header class="swiper-caption">
                            <div class="swiper-caption-inner">
                                <h1 class="swiper-title title _nomargin" role="heading"><?php echo $title; ?></h1>
                            </div><!--/.swiper-caption-inner-->
                        </header>
                        <?php endif; // if ($title) ?>

                    </figure><!--/.swiper-slide-->
                <?php endif; // if ($slideshow) elseif ($featured_image) ?>
            </div> <!--/.swiper-wrapper-->

            <?php if ($slideshow && $i > 1): ?>
            <div class="swiper-pagination"></div>
            <button class="swiper-button -prev"><icon use="caret-left" class="swiper-button-icon" /><span class="_visuallyhidden"><?php _e("Previous Slide", "@@namespace"); ?></span></button>
            <button class="swiper-button -next"><icon use="caret-right" class="swiper-button-icon" /><span class="_visuallyhidden"><?php _e("Next Slide", "@@namespace"); ?></span></button>
            <?php endif; ?>

        </div><!--/.hero_swiper-container.swiper-container.-fullbleed-->
    </div><!--/.hero_inner.-fullbleed-->
</div><!--/.hero-block.-fullbleed._nopadding-->
<?php endif; // if ($slideshow || $featured_image) ?>
