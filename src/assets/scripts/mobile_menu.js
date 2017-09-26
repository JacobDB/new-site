// JavaScript Document

// Scripts written by @@init_author_name @ @@init_author_company

// Inspired by https://medium.com/outsystems-experts/gestures-glamour-setting-up-a-touch-menu-6d9b94039997#.d2r8ubylw

document.addEventListener("DOMContentLoaded", () => {
    const menu_container      = document.querySelector(".navigation-block.-flyout");
    const menu                = document.querySelector(".navigation_inner");
    const overlay             = document.querySelector(".navigation_background");
    const toggle              = document.querySelector(".menu-toggle");
    const active_class        = "is-active";
    const transitioning_class = "is-transitioning";
    const max_opacity         = 0.5; // if changed, don't forget to change opacity in css
    const velocity            = 0.3;

    let trackable_element     = false;
    let touching_element      = false;
    let start_time            = 0;
    let start_coords          = [0, 0];
    let current_coords        = [0, 0];

    let is_open               = false;
    let is_moving             = false;
    let menu_width            = 0;
    let last_coords           = [0, 0];
    let move_x                = 0; // where the menu currently
    let drag_direction        = "";

    const focus_trapper = focusTrap(".navigation-block.-flyout");

    const close_menu = (translate_x) => {
        focus_trapper.deactivate();

        const on_transition_end = () => {
            overlay.style.opacity = "";

            menu_container.removeEventListener("transitionend", on_transition_end, false);
        };

        if (translate_x < 0 || !is_open) {
            menu.style.transform = "";
            menu.style.webkitTransform = "";

            overlay.classList.remove(active_class);

            menu_container.setAttribute("aria-hidden", "true");
            menu_container.classList.remove(active_class);
            menu_container.addEventListener("transitionend", on_transition_end, false);
        }
    };

    const open_menu = () => {
        menu.style.transform = "";
        menu.style.webkitTransform = "";

        menu_container.classList.add(active_class);

        overlay.classList.add(active_class);
        overlay.style.opacity = "";

        focus_trapper.activate();

        menu_container.setAttribute("aria-hidden", "false");
    };

    const close_menu_overlay = () => {
        focus_trapper.deactivate();

        const on_transition_end = () => {
            overlay.classList.remove(active_class);
            menu_container.removeEventListener("transitionend", on_transition_end);
        };

        menu_container.addEventListener("transitionend", on_transition_end, false);
        menu_container.setAttribute("aria-hidden", "true");
        menu_container.classList.remove(active_class);
    };

    const click_open_menu = () => {
        overlay.classList.add(active_class);

        requestAnimationFrame(() => {
            setTimeout(() => {
                menu_container.setAttribute("aria-hidden", "false");
                menu_container.classList.add(active_class);
                menu_container.focus();
                focus_trapper.activate();
            }, 1);
        });
    };

    const update_ui = () => {
        if (is_moving) {
            menu.style.transform = "translateX(" + move_x + "px)";
            menu.style.webkitTransform = "translateX(" + move_x + "px)";

            requestAnimationFrame(update_ui);
        }
    };

    const toggle_transitions = (elem, mode = 0) => {
        if (mode === 1) {
            elem.style.transition = "";
        } else {
            elem.style.transition = "none";
        }
    };

    const touch_start = (start_coords) => {
        const menu_open = menu_container.classList.contains(active_class);

        if (menu_open !== false) {
            is_open = true;
        } else {
            is_open = false;
        }

        // disable transitions
        toggle_transitions(menu_container);
        toggle_transitions(menu);

        is_moving   = true;
        menu_width  = menu.offsetWidth;
        last_coords = start_coords;

        if (is_open) {
            move_x = 0;
        } else {
            move_x = -menu_width;
        }

        menu_container.classList.add(transitioning_class);

        overlay.classList.add(active_class);

        drag_direction = "";
    };

    const touch_move = (event, current_coords, translate_coords) => {
        if (!drag_direction) {
            if (Math.abs(translate_coords[0]) >= Math.abs(translate_coords[1])) {
                drag_direction = "horizontal";
            } else {
                drag_direction = "vertical";
            }

            requestAnimationFrame(update_ui); // this is what effectively does the animation (ﾉ◕ヮ◕)ﾉ*:・ﾟ✧
        }
        if (drag_direction === "vertical") {
            last_coords = current_coords;
        } else {
            event.preventDefault();

            if (move_x + (current_coords[0] - last_coords[0]) < 0 && move_x + (current_coords[0] - last_coords[0]) > -menu_width) {
                move_x = move_x + (current_coords[0] - last_coords[0]);
            }

            last_coords = current_coords;

            // disable transitions
            toggle_transitions(overlay);

            const new_opacity = (((max_opacity) * (100 - ((Math.abs(move_x) * 100) / menu_width))) / 100);

            if (overlay.style.opacity !== new_opacity.toFixed(2) && new_opacity.toFixed(1) % 1 !== 0) {
                overlay.style.opacity = new_opacity.toFixed(2);
            }
        }
    };

    const touch_end = (current_coords, translate_coords, time_taken) => {
        is_moving = false;

        if (current_coords === [0, 0]) {
            // enable transitions
            toggle_transitions(menu_container, 1);

            if (is_open) {
                toggle_transitions(menu, 1);
            } else {
                toggle_transitions(overlay, 1);
            }
        } else {
            if (is_open) {
                if ((translate_coords[0] < (-menu_width) / 2) || (Math.abs(translate_coords[0]) / time_taken > velocity)) {
                    close_menu(translate_coords[0]);
                    is_open = false;
                } else {
                    open_menu();
                    is_open = true;
                }
            } else {
                if (translate_coords[0] > menu_width / 2 || (Math.abs(translate_coords[0]) / time_taken > velocity)) {
                    open_menu();
                    is_open = true;
                } else {
                    close_menu(translate_coords[0]);
                    is_open = false;
                }

            }
        }

        menu_container.classList.remove(transitioning_class);

        // enable transitions
        toggle_transitions(menu_container, 1);
        toggle_transitions(menu, 1);
        toggle_transitions(overlay, 1);
    };

    const on_touch_start = (event) => {
        let element      = document.elementFromPoint(event.changedTouches[0].clientX, event.changedTouches[0].clientY);
        let is_clickable = false;

        if (element) {
            while (element.parentNode) {
                if ((element.tagName === "A" || element.tagName === "BUTTON" || element.tagName === "INPUT") && element != overlay) {
                    is_clickable = true; return;
                }

                element = element.parentNode;
            }
        }

        if (is_clickable) {
            return;
        }

        start_time = new Date().getTime();
        start_coords = [event.touches[0].pageX, event.touches[0].pageY];

        touching_element = true;

        touch_start(start_coords);
    };

    const on_touch_move = (event) => {
        let element      = document.elementFromPoint(event.changedTouches[0].clientX, event.changedTouches[0].clientY);
        let is_clickable = false;

        if (element) {
            while (element.parentNode) {
                if ((element.tagName === "A" || element.tagName === "BUTTON" || element.tagName === "INPUT") && element != overlay) {
                    is_clickable = true; return;
                }

                element = element.parentNode;
            }
        }

        if (!touching_element || is_clickable) {
            return;
        }

        current_coords          = [event.touches[0].pageX, event.touches[0].pageY];
        const translate_coords  = [(current_coords[0] - start_coords[0]), (current_coords[1] - start_coords[1])];

        touch_move(event, current_coords, translate_coords);
    };

    const on_touch_end = (event) => {
        let element      = document.elementFromPoint(event.changedTouches[0].clientX, event.changedTouches[0].clientY);
        let is_clickable = false;

        if (element) {
            while (element.parentNode) {
                if ((element.tagName === "A" || element.tagName === "BUTTON" || element.tagName === "INPUT") && element != overlay) {
                    is_clickable = true; return;
                }

                element = element.parentNode;
            }
        }

        if (!touching_element || is_clickable) {
            return;
        }

        touching_element = false;

        const translate_coords = [(current_coords[0] - start_coords[0]), (current_coords[1] - start_coords[1])];

        const time_taken = (new Date().getTime() - start_time);

        touch_end(current_coords, translate_coords, time_taken);
    };

    const init = (element) => {
        trackable_element = element;

        start_time = new Date().getTime(); // start time of the touch

        trackable_element.addEventListener("touchstart", on_touch_start, false);
        trackable_element.addEventListener("touchmove", on_touch_move, false);
        trackable_element.addEventListener("touchend", on_touch_end, false);

        overlay.addEventListener("click", close_menu_overlay, false); // click the overlay to immediately close the menu
        toggle.addEventListener("click", click_open_menu, false);     // click the toggle to immediately open the menu
    };

    init(menu);
});
