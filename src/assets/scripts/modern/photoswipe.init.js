// JavaScript Document

// Scripts written by __gulp_init__author_name @ __gulp_init__author_company

import PhotoSwipe from "photoswipe";
import PhotoSwipeUI_Default from "photoswipe/dist/photoswipe-ui-default.js";

const GALLERY = new PhotoSwipe(document.querySelector(".pswp"), PhotoSwipeUI_Default);

GALLERY.init();
