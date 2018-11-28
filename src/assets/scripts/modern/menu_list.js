// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

import transition from "transition-to-from-auto";

const menuListInit = () => {
    const MENU_ITEMS = document.querySelectorAll(".menu-list__item");
    const MENU_LINKS = document.querySelectorAll(".menu-list__link");
    const MENU_TOGGLES = document.querySelectorAll(".menu-list__toggle");

    // function to mark elements as inactive
    // @param  {Element}  elem - An element to mark as inactive
    const markMenuItemInactive = (elem) => {
        const CHILDREN = elem.childNodes;
        const CHILD_MENUS = elem.querySelectorAll(`#${elem.id} > .menu-list--accordion, #${elem.id} > .menu-list--overlay`);

        // mark the item as inactive
        elem.classList.remove("is-active");

        // close the accordions
        if (CHILD_MENUS) {
            for (let i = 0; i < CHILD_MENUS.length; i++) {
                if (CHILD_MENUS[i].classList.contains("menu-list--accordion")) {
                    transition({element: CHILD_MENUS[i], val: "0"});
                }
            }
        }

        for (let i = 0; i < CHILDREN.length; i++) {
            if (CHILDREN[i].nodeType === 1) {
                // mark the item as hidden
                if (CHILDREN[i].hasAttribute("aria-hidden")) {
                    CHILDREN[i].setAttribute("aria-hidden", "true");
                }

                // mark the item as inactive
                if (CHILDREN[i].classList.contains("is-active")) {
                    CHILDREN[i].classList.remove("is-active");
                }
            }
        }
    };

    // function to mark parent elements as inactive
    // @param  {Element}  elem - An element to mark parents inactive
    const markMenuItemParentsInactive = (elem) => {
        let parent = elem.parentNode;

        setTimeout(() => { // give it a moment to process
            while (parent && parent.nodeType === 1 && !parent.classList.contains("menu-list__container")) {
                if (parent.classList.contains("is-active") && !parent.contains(document.activeElement)) {
                    markMenuItemInactive(parent);
                }

                parent = parent.parentNode;
            }
        }, 10);
    };

    // function to mark sibling elements as inactive
    // @param  {Element}  elem - An element to mark siblings inactive
    const markMenuItemSiblingsInactive = (elem) => {
        const SIBLINGS = elem.parentNode.childNodes;

        // mark all siblings as inactive
        for (let i = 0; i < SIBLINGS.length; i++) {
            if (SIBLINGS[i].nodeType === 1 && SIBLINGS[i] !== elem) {
                markMenuItemInactive(SIBLINGS[i]);
            }
        }
    };

    // function to mark elements as active
    // @param  {Element}  elem - An element to mark as active
    const markMenuItemActive = (elem) => {
        const CHILDREN = elem.childNodes;
        const CHILD_MENU = elem.querySelector(`#${elem.id} > .menu-list--accordion, #${elem.id} > .menu-list--overlay`);

        // mark the item as active
        elem.classList.add("is-active");

        // open the accordion
        if (CHILD_MENU && CHILD_MENU.classList.contains("menu-list--accordion")) {
            transition({element: CHILD_MENU, val: "auto"});
        }

        for (let i = 0; i < CHILDREN.length; i++) {
            if (CHILDREN[i].nodeType === 1 && CHILDREN[i].hasAttribute("aria-hidden")) {
                // mark the item as visible
                CHILDREN[i].setAttribute("aria-hidden", "false");
            }
        }
    };

    // handle touch away from menu-list elements
    document.addEventListener("touchstart", (e) => {
        let parentElement = e.target.parentElement;
        let clickedOnMenu = false;

        // loop through all parent elements until it is determiend if a menu was in the stack
        while (parentElement && clickedOnMenu === false) {
            if (parentElement.classList.contains("menu-list") || parentElement.dataset.menu === "true" || e.target.dataset.menu === "true") {
                clickedOnMenu = true;
            }

            parentElement = parentElement.parentElement;
        }

        // close all menus if a menu wasn't clicked
        // @TODO make sure the touched menu-list is active
        if (clickedOnMenu === false) {
            for (let i = 0; i < MENU_ITEMS.length; i++) {
                markMenuItemInactive(MENU_ITEMS[i]);
            }
        }
    });

    // handle interactions with menu-list_item elements
    for (let i = 0; i < MENU_ITEMS.length; i++) {
        // check if the menu is hoverable
        if (MENU_ITEMS[i].parentElement.dataset.hover === "true") {
            // open on mouseover
            MENU_ITEMS[i].addEventListener("mouseover", () => {
                markMenuItemSiblingsInactive(MENU_ITEMS[i]);
                markMenuItemActive(MENU_ITEMS[i]);
            }, {passive: true});

            // close on mouseout
            MENU_ITEMS[i].addEventListener("mouseout", () => {
                markMenuItemInactive(MENU_ITEMS[i]);
            }, {passive: true});
        }

        // check if the menu is touchable
        if (MENU_ITEMS[i].parentElement.dataset.touch === "true") {
            // mark active on touch
            MENU_ITEMS[i].addEventListener("touchstart", (e) => {
                // check if the element is already active
                if (MENU_ITEMS[i].classList.contains("menu-list__item--parent") && !MENU_ITEMS[i].classList.contains("is-active")) {
                    e.preventDefault();
                    markMenuItemSiblingsInactive(MENU_ITEMS[i]);
                    markMenuItemActive(MENU_ITEMS[i]);
                }
            });
        }
    }

    // handle interactions with menu-list_link elements
    for (let i = 0; i < MENU_LINKS.length; i++) {
        // mark inactive on blur (only if no other siblings or children are focused)
        MENU_LINKS[i].addEventListener("blur", () => {
            markMenuItemParentsInactive(MENU_LINKS[i]);
        }, {passive: true});
    }

    // handle interactions with menu-list_toggle elements
    for (let i = 0; i < MENU_TOGGLES.length; i++) {
        // mark active on click
        MENU_TOGGLES[i].addEventListener("click", (e) => {
            e.preventDefault();

            if (MENU_TOGGLES[i].parentNode.classList.contains("is-active")) {
                markMenuItemInactive(MENU_TOGGLES[i].parentNode);
            } else {
                markMenuItemActive(MENU_TOGGLES[i].parentNode);
            }
        });

        // mark inactive on blur (only if no other siblings or children are focused)
        MENU_TOGGLES[i].addEventListener("blur", () => {
            markMenuItemParentsInactive(MENU_TOGGLES[i]);
        }, {passive: true});
    }
};

// init the function
menuListInit();
