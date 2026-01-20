/**
 * Session Toast Handler
 * 
 * Automatically converts Laravel session flash messages to toast notifications
 * Works with: session('success'), session('error'), session('warning'), session('info')
 */

(function() {
    'use strict';

    /**
     * Initialize session toast conversion on DOM ready
     */
    function initSessionToasts() {
        // Wait for Toast system to be ready
        if (typeof Toast === 'undefined') {
            console.warn('SessionToast: Toast system not loaded yet');
            return;
        }

        // Check for session messages in data attributes
        const sessionData = document.querySelector('[data-session-messages]');
        
        if (!sessionData) {
            return;
        }

        try {
            const messages = JSON.parse(sessionData.getAttribute('data-session-messages'));
            
            // Process each message type with a slight delay for better UX
            let delay = 0;
            
            if (messages.success) {
                setTimeout(() => Toast.success(messages.success), delay);
                delay += 100;
            }
            
            if (messages.error) {
                setTimeout(() => Toast.error(messages.error), delay);
                delay += 100;
            }
            
            if (messages.warning) {
                setTimeout(() => Toast.warning(messages.warning), delay);
                delay += 100;
            }
            
            if (messages.info) {
                setTimeout(() => Toast.info(messages.info), delay);
                delay += 100;
            }

            // Handle validation errors array
            if (messages.errors && Array.isArray(messages.errors)) {
                messages.errors.forEach((error, index) => {
                    setTimeout(() => Toast.warning(error), delay + (index * 150));
                });
            }
            
        } catch (e) {
            console.error('SessionToast: Failed to parse session messages', e);
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSessionToasts);
    } else {
        initSessionToasts();
    }

    // Export for manual usage if needed
    window.SessionToast = {
        init: initSessionToasts
    };
})();
