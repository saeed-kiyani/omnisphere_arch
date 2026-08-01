document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | OmniSphere Navbar Scroll Effect
    |--------------------------------------------------------------------------
    */

    const navbar = document.querySelector('.os-navbar');

    if (!navbar) {
        return;
    }

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

});