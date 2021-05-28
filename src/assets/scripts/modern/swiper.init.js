// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

import Swiper from "swiper";

const HERO = document.querySelector(".swiper-container--hero");

// init swiper
if (HERO && HERO.querySelectorAll(".swiper-slide").length > 1) {
    new Swiper (HERO, {
        autoplay: {
            delay: 15000,
        },
        loop: true,
        navigation: {
            nextEl: HERO.querySelector(".swiper-button--next"),
            prevEl: HERO.querySelector(".swiper-button--prev"),
        },
        pagination: {
            el: HERO.querySelector(".swiper-pagination"),
            clickable: true,
        },
        speed: 150,
    });
}
