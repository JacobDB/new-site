// JavaScript Document

// Scripts written by @@author_name @ @@author_company

// init swiper
new Swiper (".swiper-container", {
    autoplay: document.querySelectorAll(".swiper-container .swiper-slide").length > 1 ? 5000 : 0,
    speed: 150,
    loop: true,
    pagination: ".swiper-pagination",
    paginationClickable: true,
    nextButton: ".swiper-button.-next",
    prevButton: ".swiper-button.-prev",
});
