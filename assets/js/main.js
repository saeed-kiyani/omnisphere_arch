document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | OmniSphere Navbar Scroll Effect
    |--------------------------------------------------------------------------
    */

    const navbar = document.querySelector('.os-navbar');

    if (navbar) {

        function handleNavbarScroll() {

            if (window.scrollY > 30) {

                navbar.classList.add('is-scrolled');

            } else {

                navbar.classList.remove('is-scrolled');

            }

        }

        handleNavbarScroll();

        window.addEventListener(
            'scroll',
            handleNavbarScroll,
            { passive: true }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Testimonials Slider
    |--------------------------------------------------------------------------
    */

    const testimonialSlider = document.querySelector(
        '.os-testimonials-slider'
    );

    if (
        testimonialSlider &&
        typeof Swiper !== 'undefined'
    ) {

        new Swiper(
            testimonialSlider,
            {

                slidesPerView: 1,

                spaceBetween: 24,

                loop: true,

                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },

                pagination: {
                    el: '.os-testimonial-pagination',
                    clickable: true
                },

                navigation: {
                    nextEl: '.os-testimonial-next',
                    prevEl: '.os-testimonial-prev'
                },

                breakpoints: {

                    768: {
                        slidesPerView: 2
                    },

                    1200: {
                        slidesPerView: 3
                    }

                }

            }
        );

    }

});