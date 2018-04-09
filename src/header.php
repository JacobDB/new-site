<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <!-- settings -->
        <meta content="text/html;charset=utf-8" http-equiv="content-type" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />

        <!-- WordPress -->
        <?php wp_head(); ?>

        <!-- Android -->
        <link href="<?php bloginfo("template_directory"); ?>/assets/media/logo-favicon.png" rel="shortcut icon" />
        <meta name="theme-color" content="@@pwa_theme_color">

        <!-- iOS -->
        <link href="<?php bloginfo("template_directory"); ?>/assets/media/logo-ios.png" rel="apple-touch-icon" />
        <meta name="apple-mobile-web-app-status-bar-style" content="@@pwa_theme_color">

        <!-- Windows -->
        <meta content="no" name="msapplication-tap-highlight" />
        <meta name="msapplication-navbutton-color" content="@@pwa_theme_color">
        <meta content="@@pwa_theme_color" name="msapplication-TileColor" />
        <meta content="<?php bloginfo("name"); ?>" name="application-name" />
        <meta content="<?php bloginfo("template_directory"); ?>/assets/media/logo-windows-tiny.png" name="msapplication-square70x70logo" />
        <meta content="<?php bloginfo("template_directory"); ?>/assets/media/logo-windows-square.png" name="msapplication-square150x150logo" />
        <meta content="<?php bloginfo("template_directory"); ?>/assets/media/logo-windows-wide.png" name="msapplication-wide310x150logo" />
        <meta content="<?php bloginfo("template_directory"); ?>/assets/media/logo-windows-large.png" name="msapplication-square310x310logo" />
        <meta content="frequency=30;polling-uri=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>/&id=1;polling-uri2=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>&id=2;polling-uri3=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>&id=3;polling-uri4=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>&id=4;polling-uri5=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>&id=5; cycle=1" name="msapplication-notification" />

        <!-- PWA -->
        <link href="<?php bloginfo("template_directory"); ?>/manifest.json" rel="manifest" />

        <!-- fallback -->
        <noscript>
            <style>._js {display: none !important;}</style>
        </noscript>
    </head>
    <body <?php body_class(); ?>>
        <div class="page_container">
            <div class="header-block -fullbleed" role="banner">
                <div class="header_inner">
                    <div class="header_row row -between -vcenter">
                        <div class="col-auto">
                            <a class="header_logo logo" href="<?php echo home_url(); ?>">
                                <img class="logo_image" alt="<?php bloginfo("name"); ?>" src="<?php bloginfo("template_directory"); ?>/assets/media/logo.svg" />
                            </a><!--/.header_logo.logo-->
                        </div><!--/.col-auto-->
                        <div class="col-auto -nogrow -noshrink _noprint">
                            <?php if (has_nav_menu("primary")): ?>
                                <button class="header_menu-toggle menu-toggle -rounded _hidden-xs">
                                    <?php _e("View Menu", "__gulp_init__namespace"); ?>
                                </button><!--/.header_menu-toggle.menu-toggle.-rounded._hidden-xs-->
                            <?php endif; // has_nav_menu("primary") ?>
                            <div class="header_search-form_container search-form_container _nomargin _visible-xs" role="search">
                                <?php get_search_form(); ?>
                            </div><!--/.header_search-form_container.search-form_container._nomargin._visible-xs-->
                        </div><!--/.col-auto.-nogrow.-noshrink._noprint-->
                    </div><!--/.header_row.row.-between.-vcenter-->
                </div><!--/.header_inner-->
            </div><!--/.header-block.-fullbleed-->
            <?php if (has_nav_menu("primary")): ?>
                <div class="navigation-block -fullbleed _visible-xs _noprint" role="navigation">
                    <div class="navigation_inner">
                        <?php
                        wp_nav_menu(array(
                            "container"         => false,
                            "depth"          => 3,
                            "items_wrap"     => "<nav class='navigation_menu-list_container menu-list_container'><ul class='menu-list -navigation' data-hover='true' data-touch='true'>%3\$s</ul></nav>",
                            "theme_location" => "primary",
                            "walker"         => new __gulp_init__namespace_menu_walker("mega hover touch"),
                        ));
                        ?>
                    </div><!--/.navigation_inner-->
                </div><!--/.navigation-block.-fullbleed._visible-xs._noprint-->
            <?php endif; // has_nav_menu("primary") ?>
