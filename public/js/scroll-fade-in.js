document.addEventListener("DOMContentLoaded", function () {
    // Set up the Intersection Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            // If the element is visible on the screen
            if (entry.isIntersecting) {
                // Add the class that triggers the CSS animation
                entry.target.classList.add('is-visible');

                // Stop watching this element so it doesn't animate out and in again
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1 // Triggers when exactly 10% of the element is visible
    });

    // Find all elements with the 'scroll-fade-in' class and start watching them
    const hiddenElements = document.querySelectorAll('.scroll-fade-in');
    hiddenElements.forEach((el) => observer.observe(el));
});

$('form').submit(function () {
    if ($(document.activeElement).attr('type') == 'submit')
        return true;
    else return false;
});