// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

import Swiper from "swiper";

// init swiper
if (document.querySelectorAll(".swiper-container--hero .swiper-slide").length > 1) {
    new Swiper (".swiper-container--hero", {
        autoplay: {
            delay: 15000,
        },
        loop: true,
        navigation: {
            nextEl: ".swiper-container--hero .swiper-button--next",
            prevEl: ".swiper-container--hero .swiper-button--prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        speed: 150,
    });
}
