document.addEventListener('DOMContentLoaded', function () {
    // 1. Changed to generic IDs so it works on ANY page with these elements
    const searchForm = document.getElementById('ajax-search-form');
    const resultsContainer = document.getElementById('ajax-results-container');
    const loadingBar = document.getElementById('search-loading');

    if (searchForm && resultsContainer) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Show loading state
            if (loadingBar) loadingBar.classList.remove('d-none');
            resultsContainer.style.opacity = '0.4';
            resultsContainer.style.pointerEvents = 'none';

            const formData = new FormData(searchForm);
            const searchParams = new URLSearchParams(formData);
            const baseUrl = searchForm.action.split('?')[0];
            const url = baseUrl + '?' + searchParams.toString();

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Server returned an error');
                    return response.text();
                })
                .then(html => {
                    const parser = new DOMParser();
                    const newDoc = parser.parseFromString(html, 'text/html');

                    // 2. Make sure it extracts the generic container from the new HTML
                    const newResults = newDoc.getElementById('ajax-results-container');

                    if (newResults) {
                        // Replace the old cards with the new ones
                        resultsContainer.innerHTML = newResults.innerHTML;
                        window.history.pushState({}, '', url);

                        // ==========================================
                        // THE FIX: FORCE ANIMATED ELEMENTS TO BE VISIBLE
                        // ==========================================
                        // Because the page didn't reload, the scroll animation script ignores the new cards.
                        // We manually strip the animation class and force them to show up instantly.
                        const hiddenElements = resultsContainer.querySelectorAll('.scroll-fade-in');
                        hiddenElements.forEach(el => {
                            el.classList.remove('scroll-fade-in'); // Remove the class hiding it
                            el.style.opacity = '1';                // Force it to be visible
                            el.style.transform = 'none';           // Remove any slide-up transformations
                        });
                        // ==========================================

                    } else {
                        window.location.href = url; // Fallback
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    window.location.href = url; // Fallback
                })
                .finally(() => {
                    // Clean up UI
                    if (loadingBar) loadingBar.classList.add('d-none');
                    resultsContainer.style.opacity = '1';
                    resultsContainer.style.pointerEvents = 'auto';
                });
        });
    }
});