import './bootstrap';

import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.atmosferSwiper', {
        modules: [Navigation, Autoplay],
        loop: true,
        centeredSlides: true,
        slidesPerView: 3,
        spaceBetween: 40,
        speed: 900,

        autoplay: {
            delay: 4500,
            disableOnInteraction: false,
        },

        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 3,
            }
        }
    });
});