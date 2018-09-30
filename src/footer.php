            <div class="footer-block --fullbleed" role="contentinfo">
                <div class="footer__inner">
                    <p class="footer__text text __textcenter __nomargin">&copy; <?php echo date("Y"); ?> <?php bloginfo("name"); ?></p>
                    <?php if (is_front_page()): ?>
                    <p class="footer__text text __textcenter __nomargin"><a class="footer__link link --inherit" href="https://www.weblinxinc.com/" rel="noopener" target="_blank" title="Chicago Web Design">Chicago Web Design</a> | <a class="footer__link link --inherit" href="https://www.weblinxinc.com/" rel="noopener" target="_blank" title="Weblinx, Inc.">Weblinx, Inc.</a></p>
                    <?php endif; ?>
                </div><!--/.footer__inner-->
            </div><!--/.footer-block.--fullbleed-->
        </div><!--/.page__container-->
        <?php if (has_nav_menu("primary")): ?>
            <div class="navigation-block --flyout __hidden-xs __noncritical" role="navigation" aria-hidden="true" id="mobile-menu" tabindex="0">
                <div class="navigation_inner">
                    <div class="navigation__search-form__container search-form__container __nomargin">
                        <?php get_search_form(); ?>
                    </div><!--/.navigation__search-form__container.search-form__container.__nomargin-->
                    <nav class="navigation__menu-list__container menu-list_container">
                        <?php
                        wp_nav_menu(array(
                            "container"      => false,
                            "depth"          => 3,
                            "items_wrap"     => "<ul class='menu-list --navigation --accordion --vertical'>%3\$s</ul>",
                            "theme_location" => "primary",
                            "walker"         => new __gulp_init_namespace___menu_walker("accordion"),
                        ));
                        ?>
                    </nav><!--/.navigation__menu-list_container.menu-list__container-->
                </div><!--/.navigation__inner-->
            </div><!--/.navigation-block.--flyout.__hidden-xs.__noncritical-->
        <?php endif; ?>
        <?php wp_footer(); ?>
    </body>
</html>
