<?php
$pwa_name = __gulp_init_namespace___get_field("full_name", "pwa", false);
$pwa_name = $pwa_name ? $pwa_name : "<%= pwa_name %>";
?>
<div class="pwa-install-prompt__container">
    <button class="pwa-install-prompt__overlay"><?php _e("Close", "__gulp_init_namespace__"); ?></button>
    <div class="pwa-install-prompt">
        <div class="pwa-install-prompt__icon__container">
            <?php echo __gulp_init_namespace___img(get_theme_file_uri("assets/media/ios/touch-icon-180x180.png"), ["alt" => get_bloginfo("name"), "class" => "pwa-install-prompt__icon"]); ?>
        </div>
        <div class="pwa-install-prompt__content">
            <h3 class="pwa-install-prompt__title"><?php echo sprintf(__("Install %s", "__gulp_init_namespace__"), $pwa_name); ?></h3>
            <p class="pwa-install-prompt__text"><?php _e("Install this application on your home screen for quick and easy access when you’re on the go.", "__gulp_init_namespace__"); ?></p>
            <p class="pwa-install-prompt__guide"><?php echo sprintf(__("Just tap %s then “Add to Home Screen”", "__gulp_init_namespace__"), "<svg class='pwa-install-prompt__guide__icon' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1000 1000'><path fill='#1A84FF' d='M381.9,181l95.8-95.8v525.9c0,13.4,8.9,22.3,22.3,22.3c13.4,0,22.3-8.9,22.3-22.3V85.2l95.8,95.8c4.5,4.5,8.9,6.7,15.6,6.7c6.7,0,11.1-2.2,15.6-6.7c8.9-8.9,8.9-22.3,0-31.2L515.6,16.1c-2.2-2.2-4.5-4.5-6.7-4.5c-4.5-2.2-11.1-2.2-17.8,0c-2.2,2.2-4.5,2.2-6.7,4.5L350.7,149.8c-8.9,8.9-8.9,22.3,0,31.2C359.6,190,373,190,381.9,181z M812,276.9H633.7v44.6H812v624H188v-624h178.3v-44.6H188c-24.5,0-44.6,20.1-44.6,44.6v624c0,24.5,20.1,44.6,44.6,44.6h624c24.5,0,44.6-20.1,44.6-44.6v-624C856.6,296.9,836.5,276.9,812,276.9z' /></svg>"); ?></p>
        </div>
    </div>
</div><!--/.pwa-install-prompt__container-->
