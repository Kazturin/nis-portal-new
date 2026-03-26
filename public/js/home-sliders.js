document.addEventListener('DOMContentLoaded', function () {
    // Partners slider
    new Swiper('.partner-slider', {
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        mousewheel: true,
        grabCursor: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            480: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1300: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
        },
    });

    // Resources slider
    new Swiper('.resource-slider', {
        direction: 'horizontal',
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        grabCursor: true,
        navigation: {
            nextEl: '.resource-swiper-button-next',
            prevEl: '.resource-swiper-button-prev',
        },
        freeMode: false,
        breakpoints: {
            480: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
            1500: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
            1700: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
        },
        mousewheel: {
            enabled: true,
            forceToAxis: true,
            noMousewheelClass: 'swiper-no-mousewheel',
        },
    });

    // Ads / banners slider
    new Swiper('.ad-slider', {
        centeredSlides: true,
        loop: true,
        autoHeight: true,
        spaceBetween: 10,
        navigation: {
            nextEl: '.ad-swiper-button-next',
            prevEl: '.ad-swiper-button-prev',
        },
        breakpoints: {
            1200: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            1500: {
                slidesPerView: 1.7,
            },
        },
    });

    // Gallery slider
    new Swiper('.gallery-slider', {
        spaceBetween: 40,
        centeredSlides: true,
        loop: true,
        navigation: {
            nextEl: '.gallery-swiper-button-next',
            prevEl: '.gallery-swiper-button-prev',
        },
        breakpoints: {
            1200: {
                slidesPerView: 1,
                spaceBetween: 30,
            },
            1500: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    // Statistics slider
    new Swiper('.statistics-slider', {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 1,
        navigation: {
            nextEl: '.statistics-swiper-button-next',
            prevEl: '.statistics-swiper-button-prev',
        },
    });
});
