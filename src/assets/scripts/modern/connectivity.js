// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

import Noty from "noty";

let is_offline = false;

const OFFLINE_NOTY = new Noty({
    callbacks: {
        afterClose: () => {
            // store a cookie so the user isn't nagged on every page load
            document.cookie = `__gulp_init_namespace___offline_noty_dismissed=true; max-age=${(60 * 60 * 6)}; SameSite=Strict`;
        },
    },
    text: l10n.noty.offline.text,
    theme: false,
});

const UPDATE_STATUS = () => {
    if (typeof navigator.onLine !== "undefined") {
        is_offline = !navigator.onLine;

        if (is_offline) {
            // check a cookie so the user isn't nagged on every page load
            if (!document.cookie.match(/__gulp_init_namespace___offline_noty_dismissed=true/)) {
                OFFLINE_NOTY.show();
            }

            // add is-offline class
            document.documentElement.classList.add("is-offline");
        } else {
            OFFLINE_NOTY.close();

            // set the cookie to false so that prompt will appear again next time they go offline
            document.cookie = `__gulp_init_namespace___offline_noty_dismissed=false; max-age=${(60 * 60 * 6)}; SameSite=Strict`;

            // remove is-offline class
            document.documentElement.classList.remove("is-offline");
        }
    }
};

const CHECK_CONNECTIVITY = () => {
    UPDATE_STATUS();
    window.addEventListener("online", UPDATE_STATUS);
    window.addEventListener("offline", UPDATE_STATUS);
};

window.addEventListener("load", CHECK_CONNECTIVITY);
