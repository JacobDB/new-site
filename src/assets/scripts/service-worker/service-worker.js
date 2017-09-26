// JavaScript Document

// Scripts written by @@init_author_name @ @@init_author_company

((global) => {
    // disable the service worker for post previews
    global.addEventListener("fetch", (event) => {
        if (event.request.url.match(/preview=true/)) {
            return;
        }
    });

    // ensure the service worker takes over as soon as possible
    global.addEventListener("install", event => event.waitUntil(global.skipWaiting()));
    global.addEventListener("activate", event => event.waitUntil(global.clients.claim()));

    // set up the cache
    global.toolbox.precache(["/", "/offline/"]);
    global.toolbox.router.get("/wp-content/uploads/*", toolbox.cacheFirst);
    global.toolbox.router.get("/*", toolbox.networkFirst, {NetworkTimeoutSeconds: 5});

    // redirect offline queries to offline page
    self.toolbox.router.get("/(.*)", function (req, vals, opts) {
        return toolbox.networkFirst(req, vals, opts).catch((error) => {
            if (req.method === "GET" && req.headers.get("accept").includes("text/html")) {
                return toolbox.cacheOnly(new Request("/offline/"), vals, opts);
            }

            throw error;
        });
    });
})(self);
