            <div class="footer-block -fullbleed" role="contentinfo">
                <div class="footer_inner">
                    <p class="footer_text text _textcenter _nomargin">&copy; <?php echo date("Y"); ?> <?php bloginfo("name"); ?></p>
                    <?php if (is_front_page()): ?>
                    <p class="footer_text text _textcenter _nomargin"><a class="footer_link link" href="https://www.weblinxinc.com/" rel="noopener" target="_blank" title="Chicago Web Design">Chicago Web Design</a> | <a class="footer_link link" href="https://www.weblinxinc.com/" rel="noopener" target="_blank" title="Weblinx, Inc.">Weblinx, Inc.</a></p>
                    <?php endif; ?>
                </div><!--/.footer_inner-->
            </div><!--/.footer-block.-fullbleed-->
        </div><!--/.page_container-->
        <?php if (has_nav_menu("primary")): ?>
            <div class="navigation-block -flyout _hidden-xs _noncritical" role="navigation" aria-hidden="true" id="mobile-menu">
                <div class="navigation_inner">
                    <div class="navigation_search-form_container search-form_container _nomargin">
                        <?php get_search_form(); ?>
                    </div><!--/.navigation_search-form_container.-search-form_container._nomargin-->
                    <?php
                    wp_nav_menu(array(
                        "container"      => false,
                        "depth"          => 3,
                        "items_wrap"     => "<nav class='navigation_menu-list_container menu-list_container'><ul class='menu-list -navigation -accordion -vertical'>%3\$s</ul></nav>",
                        "theme_location" => "primary",
                        "walker"         => new __gulp_init__namespace_menu_walker("accordion"),
                    ));
                    ?>
                </div><!--/.navigation_inner-->
            </div><!--/.navigation-block.-flyout._hidden-xs._noncritical-->
        <?php endif; ?>
        <?php __gulp_init__namespace_get_template_part("partials/modules/pswp-element.php"); ?>
        <?php wp_footer(); ?>
    </body>
</html>
