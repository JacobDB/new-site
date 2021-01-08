<?php get_header(); ?>

<div class="content-block">
    <div class="content__inner">
        <div class="content__row row row--padded">

            <div class="col-12 col-xs-8">
                <div class="content__post">
                    <div class="woocommerce">
                        <?php woocommerce_breadcrumb(); ?>
                        <?php woocommerce_content(); ?>
                    </div>
                </div><!--/.content__post-->
            </div><!--/.col-12-->

            <?php get_sidebar(); ?>

        </div><!--/.content__row-->
    </div><!--/.content__inner-->
</div><!--/.content-block-->

<?php get_footer(); ?>
