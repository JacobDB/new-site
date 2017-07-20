// JavaScript Document

// Scripts written by YOURNAME @ YOURCOMPANY

// no service worker for previews
self.addEventListener("fetch", (event) => {
    if (event.request.url.match(/preview=true/)) {
        return;
    }
});

// set up caching
toolbox.precache(["/", "./license.txt"]);
toolbox.router.get("/*", toolbox.networkFirst, {NetworkTimeoutSeconds: 5});
