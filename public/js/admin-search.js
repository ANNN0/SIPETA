/**
 * Admin Search Auto-Submit with Debounce
 * Automatically submits search forms after user stops typing (500ms delay)
 * Also submits when search is cleared to show all results
 */

(function($) {
    'use strict';

    /**
     * Debounce function to limit rate of function calls
     * @param {Function} func - Function to debounce
     * @param {Number} wait - Delay in milliseconds
     * @returns {Function} Debounced function
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    /**
     * Initialize auto-search on all search forms
     */
    function initAutoSearch() {
        // Find all search forms in admin panel
        const searchForms = document.querySelectorAll('.form-search');
        
        searchForms.forEach(form => {
            // Find the search input field (typically has name="name")
            const searchInput = form.querySelector('input[type="text"]');
            
            if (!searchInput) return;

            // Store the last search value to detect changes
            let lastValue = searchInput.value;

            // Create debounced submit function (500ms delay)
            const debouncedSubmit = debounce(function() {
                const currentValue = searchInput.value.trim();
                
                // Only submit if value has changed
                if (currentValue !== lastValue) {
                    lastValue = currentValue;
                    form.submit();
                }
            }, 500);

            // Listen to input events
            searchInput.addEventListener('input', function(e) {
                const currentValue = e.target.value.trim();
                
                // If search is cleared, submit immediately to show all results
                if (currentValue === '' && lastValue !== '') {
                    lastValue = '';
                    form.submit();
                } else {
                    // Otherwise, use debounced submit
                    debouncedSubmit();
                }
            });

            // Preserve existing functionality (icon click and Enter key work as before)
            // The submit button already triggers form submission
            form.addEventListener('submit', function() {
                lastValue = searchInput.value.trim();
            });
        });
    }

    // Initialize when DOM is ready
    $(document).ready(function() {
        initAutoSearch();
    });

})(jQuery);
