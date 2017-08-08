<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
        <!-- settings -->
        <meta content="text/html;charset=utf-8" http-equiv="content-type" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />

        <!-- SEO -->
        <title><?php wp_title("|", true, "right"); ?></title>

		<!-- WordPress -->
		<?php wp_head(); ?>

        <!-- Android -->
        <link href="<?php bloginfo("template_directory"); ?>/assets/media/logo-favicon.png" rel="shortcut icon" />
        <meta name="theme-color" content="@@theme_color">

        <!-- iOS -->
        <link href="<?php bloginfo("template_directory"); ?>/assets/media/logo-ios.png" rel="apple-touch-icon" />
        <meta name="apple-mobile-web-app-status-bar-style" content="@@theme_color">

        <!-- Windows -->
        <meta content="no" name="msapplication-tap-highlight" />
        <meta name="msapplication-navbutton-color" content="@@theme_color">
        <meta content="@@theme_color" name="msapplication-TileColor" />
        <meta content="<?php bloginfo("name"); ?>" name="application-name" />
        <meta content="<?php bloginfo("template_directory"); ?>/assets/media/logo-windows-tiny.png" name="msapplication-square70x70logo" />
        <meta content="<?php bloginfo("template_directory"); ?>/assets/media/logo-windows-square.png" name="msapplication-square150x150logo" />
        <meta content="<?php bloginfo("template_directory"); ?>/assets/media/logo-windows-wide.png" name="msapplication-wide310x150logo" />
        <meta content="<?php bloginfo("template_directory"); ?>/assets/media/logo-windows-large.png" name="msapplication-square310x310logo" />
        <meta content="frequency=30;polling-uri=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>/&id=1;polling-uri2=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>&id=2;polling-uri3=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>&id=3;polling-uri4=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>&id=4;polling-uri5=http://notifications.buildmypinnedsite.com/?feed=<?php bloginfo("rss2_url"); ?>&id=5; cycle=1" name="msapplication-notification" />

        <!-- styles -->
        <?php if (enable_critical_css()): ?>

            <style><?php the_critical_css(); ?></style>

            <?php if (!(isset($_GET["debug"]) && $_GET["debug"] === "critical_css")): ?>
                <link as="style" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic" onload="this.rel='stylesheet'" rel="preload" />
        		<link as="style" href="<?php bloginfo("template_directory"); ?>/assets/styles/modern.css" onload="this.rel='stylesheet'" rel="preload" />
        		<link as="style" href="<?php bloginfo("template_directory"); ?>/assets/styles/print.css" onload="this.rel='stylesheet'" rel="preload" media="print" />
            <?php endif; // !(isset($_GET["debug"]) && $_GET["debug"] === "critical_css") ?>

        <?php endif; // enable_critical_css() ?>

        <?php if (enable_critical_css()): ?>
            <noscript>
        <?php endif; // enable_critical_css() ?>

            <link href="<?php bloginfo("template_directory"); ?>/assets/styles/modern.css" rel="stylesheet" />

            <?php if (!(isset($_GET["generating"]) && $_GET["generating"] === "critical_css")): ?>
                <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic" rel="stylesheet" />
                <link href="<?php bloginfo("template_directory"); ?>/assets/styles/print.css" rel="stylesheet" media="print" />
            <?php endif; // !(isset($_GET["debug"]) && $_GET["debug"] === "critical_css") ?>

        <?php if (enable_critical_css()): ?>
            </noscript>
        <?php endif; // enable_critical_css() ?>

        <noscript>
            <style>._js {display: none !important;}</style>
        </noscript>

        <!-- fallback -->
		<!--[if lte IE 9]>
		<link href="<?php bloginfo("template_directory"); ?>/assets/styles/legacy.css" rel="stylesheet" />
        <script src="<?php bloginfo("template_directory"); ?>/assets/scripts/legacy.js"></script>
		<![endif]-->

        <!-- PWA -->
        <link href="<?php bloginfo("template_directory"); ?>/manifest.json" rel="manifest" />

        <script>
            if ("serviceWorker" in navigator) {
                window.addEventListener("load", () => {
                    navigator.serviceWorker.register("/service-worker.js").then((registration) => {
                        console.log("Success: Service worker successfully registered!");
                    }).catch((error) => {
                        console.log("Error: ", error);
                    });
                });
            }
        </script>
	</head>
    <body <?php body_class(); ?>>
        <div style="display:none;"><?php include_once(get_template_directory() . "/assets/media/spritesheet.svg"); ?></div>
        <div class="page_container">
            <?php get_template_part("partials/login", "overlay"); ?>
            <?php if (has_nav_menu("primary")): ?>
                <div class="navigation-block -flyout _phone _noncritical" role="navigation" aria-hidden="true">
                    <button class="navigation_background"><span class="_visuallyhidden"><?php _e("Close Menu", "@@namespace"); ?></span></button>
                    <div class="navigation_inner">
                        <div class="navigation_search-form_container search-form_container _nomargin">
                            <?php get_search_form(); ?>
                        </div><!--/.navigation_search-form_container.-search-form_container._nomargin-->
                        <?php
                        $menu = wp_nav_menu(array(
                            "container"		 => false,
                            "depth"          => 3,
                            "items_wrap"	 => "<nav class='navigation_menu-list_container menu-list_container'><ul class='menu-list -navigation -accordion -vertical'>%3\$s</ul></nav>",
                            "theme_location" => "primary",
                            "walker"         => new @@namespace_menu_walker("accordion"),
                        ));
                        ?>
                    </div><!--/.navigation_inner-->
                </div><!--/.navigation-block.-flyout._phone._noncritical-->
            <?php endif; // has_nav_menu("primary") ?>
            <div class="header-block" role="banner">
                <div class="header_inner">
                    <div class="header_row row -between -vcenter">
                        <div class="col-auto">
                            <a class="header_logo logo" href="<?php echo home_url(); ?>">
    							<img class="logo_image" alt="<?php bloginfo("name"); ?>" src="<?php bloginfo("template_directory"); ?>/assets/media/logo.svg" />
                            </a><!--/.header_logo.logo-->
                        </div><!--/.col-auto-->
                        <div class="col-auto -nogrow -noshrink _noprint">
                            <?php if (has_nav_menu("primary")): ?>
                                <button class="header_menu-toggle menu-toggle -rounded _phone">
                                    <?php _e("View Menu", "@@namespace"); ?>
                                </button><!--/.header_menu-toggle.menu-toggle.-rounded._phone-->
                            <?php endif; // has_nav_menu("primary") ?>
                            <div class="header_search_container search-form_container _nomargin _tablet _notebook _desktop" role="search">
                                <?php get_search_form(); ?>
                            </div><!--/.header_search_container.search-form_container._nomargin._tablet._notebook._desktop-->
                        </div><!--/.col-auto.-nogrow.-noshrink._noprint-->
                    </div><!--/.header_row.row.-between.-vcenter-->
                </div><!--/.header_inner-->
            </div><!--/.header-block-->
            <?php if (has_nav_menu("primary")): ?>
                <div class="navigation-block _tablet _notebook _desktop _noprint" role="navigation">
                    <div class="navigation_inner">
                        <?php
                        wp_nav_menu(array(
                            "container"		 => false,
                            "depth"          => 3,
                            "items_wrap"	 => "<nav class='navigation_menu-list_container menu-list_container'><ul class='menu-list -navigation' data-hover='true' data-touch='true'>%3\$s</ul></nav>",
                            "theme_location" => "primary",
                            "walker"         => new @@namespace_menu_walker("mega hover touch"),
                        ));
                        ?>
                    </div><!--/.navigation_inner-->
                </div><!--/.navigation-block._tablet._notebook._desktop._noprint-->
            <?php endif; // has_nav_menu("primary") ?>
