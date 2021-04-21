<?php
/* ------------------------------------------------------------------------ *\
 * Progressive Web App
\* ------------------------------------------------------------------------ */

/**
 * Construct a manifest when the user visits /manifest.json
 *
 * @return void
 */
function __gulp_init_namespace___construct_manifest(): void {
    if (get_query_var("manifest")) {
        $name             = __gulp_init_namespace___get_field("full_name", "pwa");
        $short_name       = __gulp_init_namespace___get_field("short_name", "pwa");
        $background_color = __gulp_init_namespace___get_field("background_color", "pwa");
        $theme_color      = __gulp_init_namespace___get_field("theme_color", "pwa");

        $manifest = [
            "start_url"        => "/",
            "display"          => "standalone",
            "name"             => $name ? $name : "<%= pwa_name %>",
            "short_name"       => $short_name ? $short_name : "<%= pwa_short_name %>",
            "background_color" => $background_color ? $background_color : "<%= pwa_theme_color %>",
            "theme_color"      => $theme_color ? $theme_color : "<%= pwa_theme_color %>",
            "icons"            => [
                [
                    "src"      => get_theme_file_uri("assets/media/android/splash-icon-512x512.png"),
                    "type"     => "image/png",
                    "sizes"    => "512x512",
                    "platform" => "android",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/launcher-icon-192x192.png"),
                    "type"     => "image/png",
                    "sizes"    => "192x192",
                    "platform" => "android",
                    "purpose"  => "maskable",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/launcher-icon-144x144.png"),
                    "type"     => "image/png",
                    "sizes"    => "144x144",
                    "platform" => "android",
                    "purpose"  => "maskable",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/launcher-icon-96x96.png"),
                    "type"     => "image/png",
                    "sizes"    => "96x96",
                    "platform" => "android",
                    "purpose"  => "maskable",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/launcher-icon-72x72.png"),
                    "type"     => "image/png",
                    "sizes"    => "72x72",
                    "platform" => "android",
                    "purpose"  => "maskable",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/launcher-icon-48x48.png"),
                    "type"     => "image/png",
                    "sizes"    => "48x48",
                    "platform" => "android",
                    "purpose"  => "maskable",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/notification-icon-96x96.png"),
                    "type"     => "image/png",
                    "sizes"    => "96x96",
                    "platform" => "android",
                    "purpose"  => "monochrome",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/notification-icon-72x72.png"),
                    "type"     => "image/png",
                    "sizes"    => "72x72",
                    "platform" => "android",
                    "purpose"  => "monochrome",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/notification-icon-48x48.png"),
                    "type"     => "image/png",
                    "sizes"    => "48x48",
                    "platform" => "android",
                    "purpose"  => "monochrome",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/notification-icon-36x36.png"),
                    "type"     => "image/png",
                    "sizes"    => "36x36",
                    "platform" => "android",
                    "purpose"  => "monochrome",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/android/notification-icon-24x24.png"),
                    "type"     => "image/png",
                    "sizes"    => "24x24",
                    "platform" => "android",
                    "purpose"  => "monochrome",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/touch-icon-1024x1024.png"),
                    "type"     => "image/png",
                    "sizes"    => "1024x1024",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/touch-icon-180x180.png"),
                    "type"     => "image/png",
                    "sizes"    => "180x180",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/touch-icon-167x167.png"),
                    "type"     => "image/png",
                    "sizes"    => "167x167",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/touch-icon-152x152.png"),
                    "type"     => "image/png",
                    "sizes"    => "152x152",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/touch-icon-120x120.png"),
                    "type"     => "image/png",
                    "sizes"    => "120x120",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/touch-icon-76x76.png"),
                    "type"     => "image/png",
                    "sizes"    => "76x76",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/spotlight-icon-120x120.png"),
                    "type"     => "image/png",
                    "sizes"    => "120x120",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/spotlight-icon-80x80.png"),
                    "type"     => "image/png",
                    "sizes"    => "80x80",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/settings-icon-87x87.png"),
                    "type"     => "image/png",
                    "sizes"    => "87x87",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/settings-icon-58x58.png"),
                    "type"     => "image/png",
                    "sizes"    => "58x58",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/notification-icon-60x60.png"),
                    "type"     => "image/png",
                    "sizes"    => "60x60",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
                [
                    "src"      => get_theme_file_uri("assets/media/ios/notification-icon-40x40.png"),
                    "type"     => "image/png",
                    "sizes"    => "40x40",
                    "platform" => "ios",
                    "purpose"  => "any",
                ],
            ],
        ];

        wp_send_json($manifest);
    }
}
add_action("wp", "__gulp_init_namespace___construct_manifest");

/**
 * Add the PWA meta tags to the head
 *
 * @return void
 */
function __gulp_init_namespace___add_pwa_meta_to_head(): void {
    echo "<link href='" . home_url("manifest.json") . "' rel='manifest' />\n";
}
add_action("admin_head", "__gulp_init_namespace___add_pwa_meta_to_head", 0);
add_action("login_head", "__gulp_init_namespace___add_pwa_meta_to_head", 0);
add_action("wp_head", "__gulp_init_namespace___add_pwa_meta_to_head", 0);

/**
 * Add the iOS meta tags to the head
 *
 * @return void
 */
function __gulp_init_namespace___add_ios_meta_to_head(): void {
    // declare web app support
    echo "<meta name='apple-mobile-web-app-capable' content='yes' />\n";

    // set status bar color
    echo "<meta name='apple-mobile-web-app-status-bar-style' content='black-translucent' />\n";

    // set home screen icons
    echo "<link rel='apple-touch-icon' href='" . get_theme_file_uri("assets/media/ios/touch-icon-76x76.png") . "' sizes='76x76' />\n";
    echo "<link rel='apple-touch-icon' href='" . get_theme_file_uri("assets/media/ios/touch-icon-120x120.png") . "' sizes='120x120' />\n";
    echo "<link rel='apple-touch-icon' href='" . get_theme_file_uri("assets/media/ios/touch-icon-152x152.png") . "' sizes='152x152' />\n";
    echo "<link rel='apple-touch-icon' href='" . get_theme_file_uri("assets/media/ios/touch-icon-167x167.png") . "' sizes='167x167' />\n";
    echo "<link rel='apple-touch-icon' href='" . get_theme_file_uri("assets/media/ios/touch-icon-180x180.png") . "' sizes='180x180' />\n";
    echo "<link rel='apple-touch-icon' href='" . get_theme_file_uri("assets/media/ios/touch-icon-1024x1024.png") . "' sizes='1024x1024' />\n";

    // array of splash screen images for each iOS device
    $splash_screens = [
        "iPhone 4 (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-640x960.png"),
            "media" => "(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)",
        ],
        "iPhone 4 (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-960x640.png"),
            "media" => "(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)",
        ],
        "iPhone 5 (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-640x1136.png"),
            "media" => "(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)",
        ],
        "iPhone 5 (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1136x640.png"),
            "media" => "(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)",
        ],
        "iPhone 6, 6S, 7, 8 (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-750x1334.png"),
            "media" => "(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)",
        ],
        "iPhone 6, 6S, 7, 8 (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1334x750.png"),
            "media" => "(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)",
        ],
        "iPhone 6+, 6S+, 7+, 8+ (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1242x2208.png"),
            "media" => "(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)",
        ],
        "iPhone 6+, 6S+, 7+, 8+ (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-2208x1242.png"),
            "media" => "(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)",
        ],
        "iPhone X, XS (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1125x2436.png"),
            "media" => "(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)",
        ],
        "iPhone X, XS (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-2436x1125.png"),
            "media" => "(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)",
        ],
        "iPhone XR (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-828x1792.png"),
            "media" => "(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)",
        ],
        "iPhone XR (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1792x828.png"),
            "media" => "(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)",
        ],
        "iPhone XS Max (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1242x2688.png"),
            "media" => "(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)",
        ],
        "iPhone XS Max (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-2688x1242.png"),
            "media" => "(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)",
        ],
        "iPad 1, 2, Mini (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-768x1024.png"),
            "media" => "(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 1) and (orientation: portrait)",
        ],
        "iPad 1, 2, Mini (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1024x768.png"),
            "media" => "(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 1) and (orientation: landscape)",
        ],
        "iPad 3, 4, Air, Mini 2, Pro 9.7 (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1536x2048.png"),
            "media" => "(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)",
        ],
        "iPad 3, 4, Air, Mini 2, Pro 9.7 (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-2048x1536.png"),
            "media" => "(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)",
        ],
        "iPad Pro 10.5 (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1668x2224.png"),
            "media" => "(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)",
        ],
        "iPad Pro 10.5 (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-2224x1668.png"),
            "media" => "(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)",
        ],
        "iPad Pro 11 (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-1668x2388.png"),
            "media" => "(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)",
        ],
        "iPad Pro 11 (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-2388x1668.png"),
            "media" => "(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)",
        ],
        "iPad Pro 12.9 (portrait)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-2048x2732.png"),
            "media" => "(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)",
        ],
        "iPad Pro 12.9 (landscape)" => [
            "href"  => get_theme_file_uri("assets/media/ios/startup-image-2732x2048.png"),
            "media" => "(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)",
        ],
    ];

    foreach ($splash_screens as $splash_screen) {
        echo "<link rel='apple-touch-startup-image' href='{$splash_screen["href"]}' media='{$splash_screen["media"]}' />\n";
    }
}
add_action("admin_head", "__gulp_init_namespace___add_ios_meta_to_head", 0);
add_action("login_head", "__gulp_init_namespace___add_ios_meta_to_head", 0);
add_action("wp_head", "__gulp_init_namespace___add_ios_meta_to_head", 0);

/**
 * Load the "offline" template when the user visits /offline/
 *
 * @param  string $template
 *
 * @return string
 */
function __gulp_init_namespace___load_offline_template(string $template): string {
    if (get_query_var("offline")) {
        $template = get_theme_file_path("/offline.php");
    }

    return $template;
}
add_filter("template_include", "__gulp_init_namespace___load_offline_template");

/**
 * Fix page title on "offline" template
 *
 * @param  string $title
 *
 * @return string
 */
function __gulp_init_namespace___fix_offline_page_title(string $title): string {
    if (get_query_var("offline")) {
        $title = sprintf(__("No Internet Connection - %s", "__gulp_init_namespace__"), get_bloginfo("name"));
    }

    return $title;
}
add_filter("wpseo_title", "__gulp_init_namespace___fix_offline_page_title");
