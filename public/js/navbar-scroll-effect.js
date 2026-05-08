document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('main-navbar');

    if (navbar) {
        window.addEventListener('scroll', function () {
            // Check if we have scrolled down more than 50 pixels
            if (window.scrollY > 50) {
                navbar.classList.remove('transparent-nav');
                navbar.classList.add('scrolled-nav');
            } else {
                // We are at the top of the page
                navbar.classList.remove('scrolled-nav');
                navbar.classList.add('transparent-nav');
            }
        });
    }
});