// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

import { clientsClaim, skipWaiting } from "workbox-core";
import { ExpirationPlugin } from "workbox-expiration";
import { precacheAndRoute } from "workbox-precaching";
import { setCatchHandler, registerRoute } from "workbox-routing";
import { CacheFirst, NetworkFirst } from "workbox-strategies";

skipWaiting();
clientsClaim();

/**
 * Precache "offline" page
 */
precacheAndRoute([
    {
        url: "/offline/",
        revision: __VERSION__,
    },
]);

/**
 * Return "offline" page when visiting pages offline that haven't been cached
 */
setCatchHandler(() => {
    return caches.match("/offline/");
});

/**
 * Cache WordPress content
 */
registerRoute(
    ({ url }) => {
        return (url.pathname && !url.pathname.match(/^\/(wp-admin|wp-content|wp-includes|wp-json|wp-login)/) && url.pathname.match(/\/$/));
    },
    new NetworkFirst({
        cacheName: "__gulp_init_namespace__-content-cache",
        plugins: [
            new ExpirationPlugin({
                maxAgeSeconds: 7 * 24 * 60 * 60,
            }),
        ],
    })
);

/**
 * Cache CSS files
 */
registerRoute(
    ({ url }) => {
        return (url.pathname && url.pathname.match(/\.css$/) && !url.pathname.match(/wp-admin|wp-includes|wp-json/));
    },
    new CacheFirst({
        cacheName: "__gulp_init_namespace__-css-cache",
        plugins: [
            new ExpirationPlugin({
                maxAgeSeconds: 7 * 24 * 60 * 60,
            }),
        ],
    })
);

/**
 * Cache JS files
 */
registerRoute(
    ({ url }) => {
        return (url.pathname && url.pathname.match(/\.js$/) && !url.pathname.match(/wp-admin|wp-includes|wp-json/) && !url.pathname.match(/redirection/));
    },
    new CacheFirst({
        cacheName: "__gulp_init_namespace__-js-cache",
        plugins: [
            new ExpirationPlugin({
                maxAgeSeconds: 7 * 24 * 60 * 60,
            }),
        ],
    })
);

/**
 * Cache image files
 */
registerRoute(
    ({ url }) => {
        return (url.pathname && url.pathname.match(/\.gif|jpeg|jpg|png|svg|webp$/) && !url.pathname.match(/wp-admin|wp-includes|wp-json/));
    },
    new CacheFirst({
        cacheName: "__gulp_init_namespace__-image-cache",
        plugins: [
            new ExpirationPlugin({
                maxAgeSeconds: 7 * 24 * 60 * 60,
            }),
        ],
    })
);

/**
 * Cache font files
 */
registerRoute(
    ({ url }) => {
        return (url.pathname && url.pathname.match(/\.otf|ttf|woff|woff2$/) && !url.pathname.match(/wp-admin|wp-includes|wp-json/));
    },
    new CacheFirst({
        cacheName: "__gulp_init_namespace__-font-cache",
        plugins: [
            new ExpirationPlugin({
                maxAgeSeconds: 7 * 24 * 60 * 60,
            }),
        ],
    })
);
