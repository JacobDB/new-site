// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

import debounce from "debounce";
import createFocusTrap from "focus-trap";
import { disableBodyScroll, enableBodyScroll } from "body-scroll-lock";

// get the elements
const MENU    = document.getElementById("mobile-menu");
const INNER   = MENU ? MENU.querySelector(".navigation__inner") : null;
const OVERLAY = document.getElementById("mobile-overlay");
const TOGGLE  = document.querySelector("[data-toggle=mobile-menu]");

/**
 * Verify that elements exist
 */
if (MENU !== null && INNER !== null && OVERLAY !== null && TOGGLE !== null) {
    /**
     * Check if the menu is active
     */
    const IS_ACTIVE = () => {
        return document.documentElement.classList.contains("menu-active");
    };

    /**
     * Set up a focus trap
     */
    const FOCUS_TRAP = createFocusTrap(MENU, {
        clickOutsideDeactivates: true,
    });

    /**
     * Open the menu
     */
    const OPEN_MENU = () => {
        /**
         * Add the active class
         */
        document.documentElement.classList.add("menu-active");

        /**
         * Focus the menu
         */
        MENU.focus();

        /**
         * Trap the focus
         */
        FOCUS_TRAP.activate();

        /**
         * Disable scrolling on the body
         */
        disableBodyScroll(INNER);
    };

    /**
     * Close the menu
     */
    const CLOSE_MENU = () => {
        /**
         * Remove the active class
         */
        document.documentElement.classList.remove("menu-active");

        /**
         * Focus the toggle
         */
        TOGGLE.focus();

        /**
         * Release the focus
         */
        FOCUS_TRAP.deactivate();

        /**
         * Enable scrolling on the body
         */
        enableBodyScroll(INNER);
    };

    /**
     * Toggle the menu
     */
    const TOGGLE_MENU = () => {
        if (! IS_ACTIVE()) {
            OPEN_MENU();
        } else {
            CLOSE_MENU();
        }
    };

    /**
     * Toggle the menu when clicking the menu icon
     */
    TOGGLE.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();

        TOGGLE_MENU();
    }, { passive: false });

    /**
     * Close the menu when it's open and the content is clicked
     */
    OVERLAY.addEventListener("click", (e) => {
        if (IS_ACTIVE()) {
            e.preventDefault();

            CLOSE_MENU();
        }
    }, { passive: false });

    /**
     * Close the menu once it is set to `display: none;`
     */
    window.onresize = debounce(() => {
        if (IS_ACTIVE() && getComputedStyle(MENU, null).display === "none") {
            CLOSE_MENU();
        }
    }, 200);
}
