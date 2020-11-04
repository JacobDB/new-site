            </main><!--/#content-->
            <footer class="footer-block" role="contentinfo">
                <div class="footer__inner">
                    <p class="footer__text text __textcenter __nomargin">&copy; <?php echo current_time("Y"); ?> <?php bloginfo("name"); ?></p>
                    <?php if (is_front_page()): ?>
                    <p class="footer__text text __textcenter __nomargin"><a class="footer__link link link--inherit" href="https://www.weblinxinc.com/" rel="noopener" target="_blank" title="Chicago Web Design">Chicago Web Design</a> | <a class="footer__link link link--inherit" href="https://www.weblinxinc.com/" rel="noopener" target="_blank" title="Weblinx, Inc.">Weblinx, Inc.</a></p>
                    <?php endif; ?>
                </div>
            </footer>
        </div><!--/.page__container-->
        <?php if (has_nav_menu("primary")): ?>
            <div class="navigation-block navigation-block--flyout __hidden-xs __noncritical" role="navigation" aria-hidden="true" id="mobile-menu" tabindex="0">
                <div class="navigation__inner">
                    <figure class="navigation__figure">
                        <?php echo __gulp_init_namespace___img(get_theme_file_uri("assets/media/navigation-banner.jpg"), ["alt" => "", "class" => "navigation__image"]); ?>
                    </figure>
                    <nav class="navigation__menu-list__container menu-list__container">
                        <?php
                        wp_nav_menu([
                            "container"      => false,
                            "depth"          => 3,
                            "items_wrap"     => "<ul class='menu-list menu-list--navigation menu-list--accordion menu-list--vertical'>%3\$s</ul>",
                            "theme_location" => "primary",
                            "walker"         => new __gulp_init_namespace___menu_walker([
                                "id_prefix" => "mobile-nav_",
                                "features"  => [
                                    "accordion",
                                    "touch",
                                ],
                            ]),
                        ]);
                        ?>
                    </nav><!--/.navigation__menu-list__container-->
                </div><!--/.navigation__inner-->
                <button class="navigation__overlay" id="mobile-overlay">
                    <span class="__visuallyhidden">
                        <?php _e("Close Menu", "__gulp_init_namespace__"); ?>
                    </span>
                </button>
            </div><!--/.navigation-block-->
        <?php endif; ?>
        <?php get_extended_template_part("vendor", "photoswipe"); ?>
        <?php get_extended_template_part("vendor", "pwa-install-prompt"); ?>
        <?php wp_footer(); ?>
    </body>
</html>
