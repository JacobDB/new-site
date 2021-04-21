<?php
/* ------------------------------------------------------------------------ *\
 * Progressive Web App
\* ------------------------------------------------------------------------ */

/**
 * Get various PWA sizes by platform
 *
 * @param string $platform
 * @param string $purpose
 * @return array
 */
function __gulp_init_namespace___get_pwa_sizes(string $platform, string $purpose = "any"): array {
    $data = [];

    switch ($platform) {
        case "android": {
            switch ($purpose) {
                case "launcher": {
                    /**
                     * @link https://pixplicity.com/dp-px-converter (48px @ mdpi)
                     */
                    $data = [
                        "ldpi" => [
                            "dimensions" => [36, 36],
                            "ratio" => 1,
                        ],
                        "mdpi" => [
                            "dimensions" => [48, 48],
                            "ratio" => 1,
                        ],
                        "hdpi" => [
                            "dimensions" => [72, 72],
                            "ratio" => 1,
                        ],
                        "xhdpi" => [
                            "dimensions" => [96, 96],
                            "ratio" => 1,
                        ],
                        "xxhdpi" => [
                            "dimensions" => [144, 144],
                            "ratio" => 1,
                        ],
                        "xxxhdpi" => [
                            "dimensions" => [192, 192],
                            "ratio" => 1,
                        ],
                    ];
                    break;
                }
                case "notification": {
                    /**
                     * @link https://pixplicity.com/dp-px-converter (24px @ mdpi)
                     */
                    $data = [
                        "ldpi" => [
                            "dimensions" => [18, 18],
                            "ratio" => 1,
                        ],
                        "mdpi" => [
                            "dimensions" => [24, 24],
                            "ratio" => 1,
                        ],
                        "hdpi" => [
                            "dimensions" => [36, 36],
                            "ratio" => 1,
                        ],
                        "xhdpi" => [
                            "dimensions" => [48, 48],
                            "ratio" => 1,
                        ],
                        "xxhdpi" => [
                            "dimensions" => [72, 72],
                            "ratio" => 1,
                        ],
                        "xxxhdpi" => [
                            "dimensions" => [96, 96],
                            "ratio" => 1,
                        ],
                    ];
                    break;
                }
                case "splash": {
                    /**
                     * @link https://web.dev/splash-screen/
                     */
                    $data = [
                        "Launcher" => [
                            "dimensions" => [512, 512],
                            "ratio" => 1,
                        ],
                    ];
                    break;
                }
            }
            break;
        }
        case "ios": {
            switch ($purpose) {
                case "notification": {
                    /**
                     * @link https://developer.apple.com/design/human-interface-guidelines/ios/icons-and-images/app-icon/#spotlight-and-settings-icons
                     */
                    $data = [
                        "iPhone" => [
                            "dimensions" => [60, 60],
                            "ratio" => 3,
                        ],
                        "iPad Pro, iPad, iPad mini" => [
                            "dimensions" => [40, 40],
                            "ratio" => 2,
                        ],
                    ];
                    break;
                }
                case "settings": {
                    /**
                     * @link https://developer.apple.com/design/human-interface-guidelines/ios/icons-and-images/app-icon/#spotlight-and-settings-icons
                     */
                    $data = [
                        "iPhone" => [
                            "dimensions" => [87, 87],
                            "ratio" => 3,
                        ],
                        "iPad Pro, iPad, iPad mini" => [
                            "dimensions" => [58, 58],
                            "ratio" => 2,
                        ],
                    ];
                    break;
                }
                case "splash": {
                    /**
                     * @link https://developer.apple.com/design/human-interface-guidelines/ios/visual-design/adaptivity-and-layout/#device-screen-sizes-and-orientations
                     */
                    $data = [
                        '12.9" iPad Pro' => [
                            "dimensions" => [2048, 2732],
                            "ratio" => 2,
                        ],
                        '11" iPad Pro, 10.5" iPad Pro' => [
                            "dimensions" => [1668, 2388],
                            "ratio" => 2,
                        ],
                        '9.7" iPad Pro, 7.9" iPad mini, 9.7" iPad Air, 9.7" iPad' => [
                            "dimensions" => [1536, 2048],
                            "ratio" => 2,
                        ],
                        '10.5" iPad Air' => [
                            "dimensions" => [1668, 2224],
                            "ratio" => 2,
                        ],
                        '10.2" iPad' => [
                            "dimensions" => [1620, 2160],
                            "ratio" => 2,
                        ],
                        "iPhone 12 Pro Max" => [
                            "dimensions" => [1284, 2778],
                            "ratio" => 3,
                        ],
                        "iPhone 12 Pro, iPhone 12" => [
                            "dimensions" => [1170, 2532],
                            "ratio" => 3,
                        ],
                        "iPhone 12 mini, iPhone 11 Pro, iPhone XS, iPhone X" => [
                            "dimensions" => [1125, 2436],
                            "ratio" => 3,
                        ],
                        "iPhone 11 Pro Max, iPhone XS Max" => [
                            "dimensions" => [1242, 2688],
                            "ratio" => 3,
                        ],
                        "iPhone 11, iPhone XR" => [
                            "dimensions" => [828, 1792],
                            "ratio" => 2,
                        ],
                        "iPhone 8 Plus, iPhone 7 Plus, iPhone 6s Plus, iPhone 6 Plus" => [
                            "dimensions" => [1080, 1920],
                            "ratio" => 3,
                        ],
                        'iPhone 8, iPhone 7, iPhone 6s, iPhone 6, 4.7" iPhone SE' => [
                            "dimensions" => [750, 1334],
                            "ratio" => 2,
                        ],
                        '4" iPhone SE, iPod touch 5th generation and later' => [
                            "dimensions" => [640, 1136],
                            "ratio" => 2,
                        ],
                    ];
                    break;
                }
                case "spotlight": {
                    /**
                     * @link https://developer.apple.com/design/human-interface-guidelines/ios/icons-and-images/app-icon/#spotlight-and-settings-icons
                     */
                    $data = [
                        "iPhone" => [
                            "dimensions" => [120, 120],
                            "ratio" => 3,
                        ],
                        "iPad Pro, iPad, iPad mini" => [
                            "dimensions" => [80, 80],
                            "ratio" => 2,
                        ],
                    ];
                    break;
                }
                case "touch": {
                    /**
                     * @link https://developer.apple.com/design/human-interface-guidelines/ios/icons-and-images/app-icon/#app-icon-sizes
                     */
                    $data = [
                        "iPhone (3x)" => [
                            "dimensions" => [180, 180],
                            "ratio" => 3,
                        ],
                        "iPhone (2x)" => [
                            "dimensions" => [120, 120],
                            "ratio" => 2,
                        ],
                        "iPad Pro" => [
                            "dimensions" => [167, 167],
                            "ratio" => 2,
                        ],
                        "iPad, iPad mini" => [
                            "dimensions" => [152, 152],
                            "ratio" => 2,
                        ],
                        "App Store" => [
                            "dimensions" => [1024, 1024],
                            "ratio" => 1,
                        ],
                    ];
                    break;
                }
            }
            break;
        }
    }

    return $data;
}

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

        $icons = [];

        $icon_sizes = [
            "android" => [
                "any"        => [
                    "splash",
                ],
                "maskable"   => [
                    "launcher",
                ],
                "monochrome" => [
                    "notification",
                ],
            ],
            "ios" => [
                "any" =>  [
                    "notification",
                    "settings",
                    "spotlight",
                    "touch",
                ],
            ],
        ];

        foreach ($icon_sizes as $platform => $size) {
            foreach ($size as $purpose => $names) {
                foreach ($names as $name) {
                    $data = __gulp_init_namespace___get_pwa_sizes($platform, $name);

                    foreach ($data as $details) {
                        $icons[] = [
                            "src"      => get_theme_file_uri("assets/media/{$platform}/{$name}-icon-{$details["dimensions"][0]}x{$details["dimensions"][1]}.png"),
                            "type"     => "image/png",
                            "sizes"    => "{$details["dimensions"][0]}x{$details["dimensions"][1]}",
                            "platform" => $platform,
                            "purpose"  => $purpose,
                        ];
                    }
                }
            }
        }

        $manifest = [
            "start_url"        => "/",
            "display"          => "standalone",
            "name"             => $name ? $name : "<%= pwa_name %>",
            "short_name"       => $short_name ? $short_name : "<%= pwa_short_name %>",
            "background_color" => $background_color ? $background_color : "<%= pwa_theme_color %>",
            "theme_color"      => $theme_color ? $theme_color : "<%= pwa_theme_color %>",
            "icons"            => $icons,
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
    /**
     * Declare web app support
     */
    echo "<meta name='apple-mobile-web-app-capable' content='yes' />\n";

    /**
     * Set status bar color
     */
    echo "<meta name='apple-mobile-web-app-status-bar-style' content='black-translucent' />\n";

    /**
     * Add icons
     */
    foreach (__gulp_init_namespace___get_pwa_sizes("ios", "touch") as $data) {
        echo "<link rel='apple-touch-icon' href='" . get_theme_file_uri("assets/media/ios/touch-icon-{$data["dimensions"][0]}x{$data["dimensions"][1]}.png") . "' sizes='{$data["dimensions"][0]}x{$data["dimensions"][1]}' />\n";
    }

    /**
     * Add splash screens
     */
    foreach (__gulp_init_namespace___get_pwa_sizes("ios", "splash") as $name => $data) {
        $media_query_x = round($data["dimensions"][0] / $data["ratio"]);
        $media_query_y = round($data["dimensions"][1] / $data["ratio"]);

        echo "<link rel='apple-touch-startup-image' href='" . get_theme_file_uri("assets/media/ios/startup-image-{$data["dimensions"][0]}x{$data["dimensions"][1]}.png") . "' media='(device-width: {$media_query_x}px) and (device-height: {$media_query_y}px) and (-webkit-device-pixel-ratio: {$data["ratio"]}) and (orientation: portrait)' />\n";
        echo "<link rel='apple-touch-startup-image' href='" . get_theme_file_uri("assets/media/ios/startup-image-{$data["dimensions"][1]}x{$data["dimensions"][0]}.png") . "' media='(device-width: {$media_query_y}px) and (device-height: {$media_query_x}px) and (-webkit-device-pixel-ratio: {$data["ratio"]}) and (orientation: landscape)' />\n";
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
