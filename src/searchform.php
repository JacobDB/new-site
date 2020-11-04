<?php
$search_query = is_search() ? get_search_query() : "";
$id_prefix    = isset($args["id"]) ? esc_attr($args["id"]) : "";
?>
<form class="search-form" action="<?php echo home_url(); ?>" method="get" role="search">
    <label class="search-form__label __visuallyhidden"<?php if ($id_prefix): ?> for="<?php echo $id_prefix; ?>__search-input"<?php endif; ?>><?php _e("Search for:", "__gulp_init_namespace__"); ?></label>
    <input class="search-form__input input"<?php if ($id_prefix): ?> id="<?php echo $id_prefix; ?>__search-input"<?php endif; ?> name="s" title="<?php _e("Search for:", "__gulp_init_namespace__"); ?>" type="search" value="<?php echo $search_query; ?>" />
    <button class="search-form__button button" type="submit"><i class="button__icon fas fa-search"></i><span class="__visuallyhidden"><?php _e("Search", "__gulp_init_namespace__"); ?></span></button>
</form>
