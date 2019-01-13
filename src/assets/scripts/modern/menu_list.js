// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

import transition from "transition-to-from-auto";
import inViewport from "in-vp";

/**
 * Create an array of attribtes to target lists for
 */
const ATTRIBUTES = {
    classes:  ["menu-list", "menu-list__container--mega"],
    datasets: ["accordion", "hover", "touch"],
};

const SELECTOR = [];

/**
 * Create an array out of the CLASSES and DATAS in order to reduce duplicate code.
 */
ATTRIBUTES.classes.forEach((CLASS) => {
    ATTRIBUTES.datasets.forEach((DATA) => {
        SELECTOR.push(`.${CLASS}[data-${DATA}=true]`);
    });
});

/**
 * Find all MENU_LISTS which can be hovered or touched
 */
const MENU_LISTS = document.querySelectorAll(SELECTOR.join());

/**
 * Mark an item active
 *
 * @param {Object} LIST_ITEM - A DOM object to mark as active
 * @param {Object} MENU_LIST - A DOM object to mark as visible and reverse based on viewport
 * @param {Boolean} EVENT - An event to prevent from firing
 */
const MARK_ACTIVE = (LIST_ITEM, MENU_LIST, EVENT = false) => {
    /**
     * Prevent the EVENT from finishing unless the LIST_ITEM is already active
     */
    if (EVENT && !LIST_ITEM.classList.contains("is-active")) {
        EVENT.preventDefault();
    }

    /**
     * Mark the LIST_ITEM as active
     */
    LIST_ITEM.classList.add("is-active");

    /**
     * Transition open the MENU_LIST if it's an accordion
     */
    if (MENU_LIST.dataset.accordion === "true") {
        transition({ element: MENU_LIST, val: "auto" });
    }

    /**
     * Mark the MENU_LIST as aria-hidden="false"
     */
    MENU_LIST.setAttribute("aria-hidden", "false");

    /**
     * Reverse the MENU_LIST if it's not fully within the viewport
     */
    if (inViewport(MENU_LIST).fully === false) {
        MENU_LIST.classList.add("menu-list--reverse");
    }
};

/**
 * Mark an item and its children inactive
 *
 * @param {Object} LIST_ITEM - A DOM object to mark as inactive
 * @param {Object} MENU_LIST - A DOM object to mark as hidden and unreverse
 */
const MARK_INACTIVE = (LIST_ITEM, MENU_LIST) => {
    /**
     * Find any active CHILDREN
     */
    const CHILDREN = LIST_ITEM.querySelectorAll("is-active");

    /**
     * Recursively mark active CHILDREN as inactive
     */
    if (CHILDREN.length > 0) {
        CHILDREN.foreach((CHILD) => {
            MARK_INACTIVE(CHILD);
        });
    }

    /**
     * Mark the LIST_ITEM as inactive
     */
    LIST_ITEM.classList.remove("is-active");

    /**
     * Transition open the MENU_LIST if it's an accordion
     */
    if (MENU_LIST.dataset.accordion === "true") {
        transition({ element: MENU_LIST, val: 0 });
    }

    /**
     * Mark the MENU_LIST as aria-hidden="false"
     */
    MENU_LIST.setAttribute("aria-hidden", "true");

    /**
     * Unreverse the MENU_LIST
     */
    MENU_LIST.classList.remove("menu-list--reverse");
};

/**
 * Compare two sets of coordinates to determine if the user dragged
 *
 * @param {Object} START_COORDS - The coordinates where the user started their touch
 * @param {Object} END_COORDS - The coordinates where the user ended their touch
 * @param {Integer} THRESHOLD - The minimum distance in pixels to mark something as dragged
 */
const DID_USER_DRAG = (START_COORDS, END_COORDS, THRESHOLD = 10) => {
    return Math.abs(END_COORDS.clientX - START_COORDS.clientX) > THRESHOLD || Math.abs(END_COORDS.clientY - START_COORDS.clientY) > THRESHOLD;
};

/**
 * Store various events to listen for
 */
const EVENTS = {
    document:  ["click", "touchstart", "touchend"],
    list_item: {
        activate: {
            accordion: ["touchstart", "touchend"],
            hover:     ["mouseenter"],
            touch:     ["touchstart", "touchend"],
        },
        deactivate: ["mouseleave"],
    },
};

/**
 * Set up an object to track touches
 */
let start_coords = {clientX: 0, clientY: 0};
let end_coords   = {clientX: 0, clientY: 0};

/**
 * Listen for interactions on each menu
 */
MENU_LISTS.forEach((MENU_LIST) => {
    const LIST_ITEM   = MENU_LIST.closest(".menu-list__item");
    const MENU_TOGGLE = LIST_ITEM.querySelector(".menu-list__toggle");

    /**
     * Mark the LIST_ITEM as active when moused into or touched
     */
    for (const MODE in EVENTS.list_item.activate) {
        if (MENU_LIST.dataset[MODE] === "true") {

            for (const EVENT in EVENTS.list_item.activate[MODE]) {
                LIST_ITEM.addEventListener(EVENTS.list_item.activate[MODE][EVENT], (e) => {
                    /**
                     * Store the touchstart position
                     */
                    if (e.type === "touchstart") {
                        start_coords = e.touches[0];
                    }

                    /**
                     * Store the touchend position
                     */
                    if (e.type === "touchend") {
                        end_coords = e.changedTouches[0];
                    }

                    /**
                     * Mark the item as active if the event isn't touchstart and
                     * the user didn't drag their touch
                     */
                    if (e.type !== "touchstart" && !DID_USER_DRAG(start_coords, end_coords)) {
                        MARK_ACTIVE(LIST_ITEM, MENU_LIST, e);
                    }
                });
            }
        }
    }

    /**
     * Mark the LIST_ITEM as inactive when moused away
     */
    EVENTS.list_item.deactivate.forEach((EVENT) => {
        LIST_ITEM.addEventListener(EVENT, () => {
            MARK_INACTIVE(LIST_ITEM, MENU_LIST);
        }, { passive: true });
    });

    /**
     * Mark the LIST_ITEM as active or inactive when MENU_TOGGLE is clicked
     */
    MENU_TOGGLE.addEventListener("click", () => {
        if (!LIST_ITEM.classList.contains("is-active")) {
            MARK_ACTIVE(LIST_ITEM, MENU_LIST);
        } else {
            MARK_INACTIVE(LIST_ITEM, MENU_LIST);
        }
    });

    /**
     * Mark the LIST_ITEM as inactive when clicked away or touched away
     */
    EVENTS.document.forEach((EVENT) => {
        document.addEventListener(EVENT, (e) => {
            if (LIST_ITEM.classList.contains("is-active")) {
                /**
                 * Get the event path
                 */
                const PATH = e.path || (e.composedPath && e.composedPath());

                /**
                 * Determine if the LIST_ITEM is in the path of touched elements
                 */
                const LIST_ITEM_TOUCHED = PATH.some((ELEMENT) => {
                    return LIST_ITEM === ELEMENT;
                });

                /**
                 * Store the touchstart position
                 */
                if (e.type === "touchstart") {
                    start_coords = e.touches[0];
                }

                /**
                 * Store the touchend position
                 */
                if (e.type === "touchend") {
                    end_coords = e.changedTouches[0];
                }

                /**
                 * Mark the LIST_ITEM as inactive if it's not in the path of
                 * touched elements, and the user didn't drag their touch
                 */
                if (!LIST_ITEM_TOUCHED && !DID_USER_DRAG(start_coords, end_coords)) {
                    MARK_INACTIVE(LIST_ITEM, MENU_LIST);
                }
            }
        }, { passive: true });
    });
});
