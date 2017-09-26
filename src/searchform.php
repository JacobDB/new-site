<?php $search_query = is_search() ? get_search_query() : ""; ?>
<form class="search-form" action="<?php echo home_url(); ?>" method="get">
    <label class="search-form_label _visuallyhidden" for="s"><?php _e("Search for:", "@@namespace"); ?></label>
    <input class="search-form_input" name="s" title="<?php _e("Search for:", "@@namespace"); ?>" type="search" value="<?php echo $search_query; ?>" />
    <button class="search-form_button" type="submit"><icon use="search" /><span class="_visuallyhidden"><?php _e("Search", "@@namespace"); ?></span></button>
</form><!--/.search-form-->
