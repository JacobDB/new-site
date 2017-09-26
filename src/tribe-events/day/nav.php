<h3 class="_visuallyhidden" tabindex="0"><?php esc_html_e("Day Navigation", "the-events-calendar"); ?></h3>

<nav class="content_menu-list_container menu-list_container">
    <ul class="tribe-events-sub-nav menu-list -pagination -between">

    	<!-- Previous Page Navigation -->
    	<li class="tribe-events-nav-previous menu-list_item" aria-label="previous day link">
            <?php tribe_the_day_link("previous day"); ?>
        </li><!--/.tribe-events-nav-next.menu-list_item-->

    	<!-- Next Page Navigation -->
    	<li class="tribe-events-nav-next menu-list_item" aria-label="next day link">
            <?php tribe_the_day_link("next day"); ?>
        </li><!--/.tribe-events-nav-next.menu-list_item-->

    </ul><!--/.tribe-events-sub-nav.menu-list.-pagination.-center-->
</nav><!--/.content_menu-list_container.menu-list_container-->
