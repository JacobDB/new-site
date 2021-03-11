// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

/**
 * Check if the alert exists
 */
const ALERT = document.querySelector(".alert-block");

if (ALERT) {
    /**
     * Open the alert immediately if it was not previously hidden
     */
    if (sessionStorage.getItem("alert-hidden") !== "true") {
        ALERT.classList.add("is-active");
    }

    /**
     * Find the alert button
     */
    const BUTTON = ALERT.querySelector(".alert__button");

    /**
     * On BUTTON click, remove ALERT `is-active` and store the interaction in sessionStorage
     */
    BUTTON.addEventListener("click", () => {
        ALERT.classList.remove("is-active");
        sessionStorage.setItem("alert-hidden", "true");
    }, { passive: true });
}
