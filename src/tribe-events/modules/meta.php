<?php do_action("tribe_events_single_meta_before"); ?>

<?php do_action("tribe_events_single_event_meta_primary_section_start"); ?>

<?php
$set_venue_apart = apply_filters("tribe_events_single_event_the_meta_group_venue", (tribe_has_organizer() ? true : false), get_the_ID());
$tablet_columns = !$set_venue_apart && tribe_embed_google_map() ? "4" : "6";
?>

<div class="article_row row -padded">
    <div class="col-12 col-xs-0">
        <?php tribe_get_template_part("modules/meta/details"); ?>
    </div><!--/.col-12.cl-xs-0-->

    <?php if (tribe_has_organizer()): ?>
        <div class="col-12 col-xs-<?php echo $tablet_columns; ?> -nogrow -noshrink">
            <?php tribe_get_template_part("modules/meta/organizer"); ?>
        </div><!--/.col-12.col-xs-0-->
    <?php elseif (!$set_venue_apart && tribe_has_venue()): // (tribe_has_organizer()) ?>
        <div class="col-12 col-xs-<?php echo $tablet_columns; ?> -nogrow -noshrink">
            <?php tribe_get_template_part("modules/meta/venue"); ?>
        </div><!--/.col-12.col-xs-{0}-->

        <?php if (tribe_embed_google_map()): ?>
            <div class="col-12 col-xs-4 -nogrow -noshrink">
                <?php tribe_get_template_part("modules/meta/map"); ?>
            </div><!--/.col-12.col-xs-4.-nogrow.-noshrink-->
        <?php endif; // (tribe_embed_google_map())?>
    <?php endif; // (!$set_venue_apart && tribe_has_venue()) ?>
</div><!--/.article_row.row.-padded-->

<?php do_action("tribe_events_single_event_meta_primary_section_end"); ?>

<?php if ($set_venue_apart && tribe_has_venue()): ?>

    <?php do_action("tribe_events_single_event_meta_secondary_section_start"); ?>

    <div class="article_row row -padded">

        <div class="col-12 col-xs-0">
            <?php tribe_get_template_part("modules/meta/venue"); ?>
        </div><!--/.col-12.col-xs-0-->

        <?php if (tribe_embed_google_map()): ?>
            <div class="col-12 col-xs-6 -nogrow -noshrink">
                <?php tribe_get_template_part("modules/meta/map"); ?>
            </div><!--/.col-12.col-xs-6.-nogrow.-noshrink-->
        <?php endif; // (tribe_embed_google_map()) ?>

    </div><!--/.article_row.row.-padded-->

    <?php do_action("tribe_events_single_event_meta_secondary_section_end"); ?>

<?php endif; // ($set_venue_apart && tribe_has_venue()) ?>

<?php do_action("tribe_events_single_meta_after"); ?>
