<?php
$post_variant    = isset($post_variant) ? " {$post_variant}" : "";
$post_title      = isset($post_title) ? $post_title : (isset($post) ? $post->post_title : "");
$post_permalink  = isset($post_permalink) ? $post_permalink : (isset($post) ? get_the_permalink($post->ID) : "");
$post_categories = isset($post_categories) ? $post_categories : (isset($post) ? get_the_terms($post->ID, "category") : "");
$post_tags       = isset($post_tags) ? $post_tags : (isset($post) ? get_the_terms($post->ID, "post_tag") : "");
$post_comments   = isset($post_comments) ? $post_comments : (isset($post) ? get_comments_number($post->ID) : "");
$post_content    = isset($post_content) ? $post_content : (isset($post) ? $post->post_content : "");
?>

<?php if ($post_title || (((isset($post_show_meta) && $post_show_meta === true) || (get_post_type() === "post" && !(isset($post_show_meta) && $post_show_meta === false))) && ($post_permalink || $post_categories || $post_tags || $post_comments)) || $post_content): ?>
    <article class="article<?php echo $post_variant; ?>">

        <?php if ($post_title || (((isset($post_show_meta) && $post_show_meta === true) || (get_post_type() === "post" && !(isset($post_show_meta) && $post_show_meta === false))) && ($post_permalink || $post_categories || $post_tags || $post_comments))): ?>
            <header class="article_header">
                <?php if ($post_title): ?>
                    <h1 class="article_title title">
                        <?php echo apply_filters("the_title", $post_title); ?>
                    </h1><!--/.article_title.title-->
                <?php endif; ?>

                <?php if (((isset($post_show_meta) && $post_show_meta === true) || (get_post_type() === "post" && !(isset($post_show_meta) && $post_show_meta === false))) && ($post_permalink || $post_categories || $post_tags || $post_comments)): ?>
                    <nav class="menu-list_container">
                        <ul class="menu-list -meta">

                            <?php if ($post_permalink): ?>
                                <li class="menu-list_item">
                                    <a class="menu-list_link link" href="<?php echo apply_filters("the_permalink", $post_permalink); ?>"><icon use="clock" /> <time datetime="<?php echo get_the_date("c"); ?>"><?php the_date(); ?></time></a>
                                </li>
                            <?php endif; ?>

                            <?php if ($post_categories): ?>
                                <?php $i = 0; ?>
                                <li class="menu-list_item">
                                    <icon use="folder" />

                                    <?php foreach ($post_categories as $category): ?>
                                        <?php $i++; ?>

                                        <a class="menu-list_link link" href="<?php echo get_term_link($category); ?>"><?php echo $category->name; ?></a>

                                        <?php if ($i < count($post_categories)): ?>, <?php endif;?>
                                    <?php endforeach; // foreach ($post_categories as $category) ?>

                                </li><!--/.menu-list_item-->
                            <?php endif; // if ($post_categories) ?>

                            <?php if ($post_tags): ?>
                                <?php $i = 0; ?>
                                <li class="menu-list_item">
                                    <icon use="tag" />

                                    <?php foreach ($post_tags as $tag): ?>
                                        <?php $i++; ?>

                                        <a class="menu-list_link link" href="<?php echo get_term_link($tag); ?>"><?php echo $tag->name; ?></a>

                                        <?php if ($i < count($post_tags)): ?>, <?php endif; ?>
                                    <?php endforeach; // foreach ($post_tags as $tag) ?>

                                </li><!--/.menu-list_item-->
                            <?php endif; // if ($post_tags) ?>

                    <?php if ($comments): ?>
                        <li class="menu-list_item">
                            <a class="menu-list_link link" href="#comments">
                                <icon use="comment" /> <?php echo $comments; ?> <?php _e("Comments", "@@namespace"); ?>
                            </a><!--/.menu-list_link.link-->
                        </li><!--/.menu-list_item-->
                    <?php endif; ?>

                        </ul><!--/.menu-list.-meta-->
                    </nav><!--/.menu-list_container-->
                <?php endif; // if (((isset($post_show_meta) && $post_show_meta === true) || (get_post_type() === "post" && !(isset($post_show_meta) && $post_show_meta === false))) && ($post_permalink || $post_categories || $post_tags || $post_comments)) ?>

            </header><!--/.article_header-->
        <?php endif; // ($post_title || (((isset($post_show_meta) && $post_show_meta === true) || (get_post_type() === "post" && !(isset($post_show_meta) && $post_show_meta === false))) && ($post_permalink || $post_categories || $post_tags || $post_comments))) ?>

        <?php if ($post_content): ?>
            <div class="article_content">
                <div class="article_user-content user-content">
                    <?php echo apply_filters("the_content", $post_content); ?>
                </div><!--/.article_user-content.user-content-->
            </div><!--/.article_content-->
        <?php endif; ?>

    </article><!--/.article-->
<?php endif; // ($post_title || (((isset($post_show_meta) && $post_show_meta === true) || (get_post_type() === "post" && !(isset($post_show_meta) && $post_show_meta === false))) && ($post_permalink || $post_categories || $post_tags || $post_comments)) || $post_content) ?>

<?php
unset($post_variant);
unset($post_title);
unset($post_permalink);
unset($post_show_meta);
unset($post_categories);
unset($post_tags);
unset($post_comments);
unset($post_content);
?>
