<!doctype html>
<html class="no-javascript" <?php language_attributes(); ?>>
    <head>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div class="page__container" id="page-container">
            <a class="skip-links" href="#content">
                <?php _e("Skip to content", "__gulp_init_namespace__"); ?>
            </a>
            <header class="header-block">
                <div class="header__inner">
                    <div class="header__row row row--padded-tight row--align-center">
                        <div class="col-auto col--grow-0 col--shrink-0 __hidden-xs">
                            <button class="header__panel-toggle panel-toggle" data-toggle="mobile-menu"<?php if (! has_nav_menu("primary")): ?> style="pointer-events:none;visibility:hidden;"<?php endif; ?>>
                                <i class="panel-toggle__icon fas fa-fw fa-bars"></i>
                                <span class="__visuallyhidden"><?php _e("View Menu", "__gulp_init_namespace__"); ?></span>
                            </button>
                        </div>
                        <div class="col-0">
                            <a class="header__logo logo" href="<?php echo home_url(); ?>">
                                <?php echo __gulp_init_namespace___img(get_theme_file_uri("assets/media/logo.svg"), ["alt" => get_bloginfo("name"), "class" => "logo__image", "height" => "69", "width" => "300"], false); ?>
                            </a>
                        </div>
                        <div class="col-auto col--grow-0 col--shrink-0 __hidden-xs">
                            <button class="header__panel-toggle panel-toggle" data-toggle="mobile-search">
                                <i class="panel-toggle__icon fas fa-fw fa-search"></i>
                                <span class="__visuallyhidden"><?php _e("View Search", "__gulp_init_namespace__"); ?></span>
                            </button>
                            <?php if (! is_search()): ?>
                                <div class="header__search-form__container search-form__container search-form__container--expandable __nomargin __hidden-xs" role="search" id="mobile-search">
                                    <?php
                                    get_search_form([
                                        "id" => "mobile-search",
                                    ]);
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div><!--/.col-auto-->
                        <div class="col-xs-auto col--grow-0 col--shrink-0 __visible-xs">
                            <div class="header__search-form__container search-form__container __nomargin __visible-xs" role="search">
                                <?php
                                get_search_form([
                                    "id" => "desktop-search",
                                ]);
                                ?>
                            </div>
                        </div>
                    </div><!--/.header__row-->
                </div><!--/.header__inner-->
            </header><!--/.header-block-->
            <?php if (has_nav_menu("primary")): ?>
                <div class="navigation-block __visible-xs __noprint">
                    <div class="navigation__inner">
                        <nav class="navigation__menu-list__container menu-list__container">
                            <?php
                            wp_nav_menu([
                                "container"      => false,
                                "depth"          => 3,
                                "items_wrap"     => "<ul class='menu-list menu-list--navigation'>%3\$s</ul>",
                                "theme_location" => "primary",
                                "walker"         => new __gulp_init_namespace___menu_walker([
                                    "id_prefix" => "desktop-nav_",
                                    "features"  => [
                                        "mega",
                                        "hover",
                                        "touch",
                                    ],
                                ]),
                            ]);
                            ?>
                        </nav><!--/.navigation__menu-list__container-->
                    </div><!--/.navigation__inner-->
                </div><!--/.navigation-block-->
            <?php endif; ?>
            <main id="content" tabindex="0">
