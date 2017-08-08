<article class="content_article article">

    <header class="article_header">
        <?php if (!is_front_page() && !has_post_thumbnail()) the_title("<h1 class='article_title title'>", "</h1>"); ?>

        <?php if (get_post_type() === "post"): ?>
            <?php
            $categories = get_the_terms($post->ID, "category");
            $tags = get_the_terms($post->ID, "post_tag");
            $comments = get_comments_number();
            ?>

            <nav class="menu-list_container">
                <ul class="menu-list -meta">

                    <li class="menu-list_item">
                        <a class="menu-list_link link" href="<?php the_permalink(); ?>"><icon use="clock" /> <time datetime="<?php echo get_the_date("c"); ?>"><?php the_date(); ?></time></a>
                    </li>

                    <?php if ($categories): ?>
                        <?php $i = 0; ?>
                        <li class="menu-list_item">
                            <icon use="folder" />

                            <?php foreach ($categories as $category): ?>
                                <?php $i++; ?>

                                <a class="menu-list_link link" href="<?php echo get_term_link($category); ?>"><?php echo $category->name; ?></a>

                                <?php if ($i < count($categories)): ?>, <?php endif;?>
                            <?php endforeach; // foreach ($categories as $category) ?>

                        </li><!--/.menu-list_item-->
                    <?php endif; // if ($categories) ?>

                    <?php if ($tags): ?>
                        <?php $i = 0; ?>
                        <li class="menu-list_item">
                            <icon use="tag" />

                            <?php foreach ($tags as $tag): ?>
                                <?php $i++; ?>

                                <a class="menu-list_link link" href="<?php echo get_term_link($tag); ?>"><?php echo $tag->name; ?></a>

                                <?php if ($i < count($tags)): ?>, <?php endif; ?>
                            <?php endforeach; // foreach ($tags as $tag) ?>

                        </li><!--/.menu-list_item-->
                    <?php endif; // if ($tags) ?>

                    <?php if ($comments): ?>
                        <li class="menu-list_item">
                            <a class="menu-list_link link" href="#comments">
                                <icon use="comment" /> <?php echo $comments; ?> <?php _e("Comments", "@@namespace"); ?>
                            </a><!--/.menu-list_link.link-->
                        </li><!--/.menu-list_item-->
                    <?php endif; ?>

                </ul><!--/.menu-list.-meta-->
            </nav><!--/.menu-list_container-->
        <?php endif; // if (get_post_type() === "post") ?>

    </header><!--/.article_header-->

    <div class="article_content">
        <div class="article_user-content user-content">
            <?php the_content(); ?>
        </div><!--/.article_user-content.user-content-->
    </div><!--/.article_content-->

</article><!--/.content_article.article.-full-->
