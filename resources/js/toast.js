/**
 * SIPETA Toast Notification System
 * Modern, animated toast notifications
 */

const Toast = {
    container: null,
    queue: [],
    maxToasts: 5,

    // Icon SVGs
    icons: {
        success: `<svg viewBox="0 0 24 24"><path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>`,
        error: `<svg viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>`,
        warning: `<svg viewBox="0 0 24 24"><path fill="currentColor" d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>`,
        info: `<svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>`,
        close: `<svg viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>`,
    },

    /**
     * Initialize toast container
     */
    init() {
        if (this.container) return;

        this.container = document.createElement("div");
        this.container.className = "toast-container";
        this.container.id = "toast-container";
        document.body.appendChild(this.container);
    },

    /**
     * Show a toast notification
     * @param {Object} options - Toast options
     * @param {string} options.type - Toast type: success, error, warning, info
     * @param {string} options.title - Toast title
     * @param {string} options.message - Toast message
     * @param {number} options.duration - Auto-dismiss duration in ms (default: 4000, 0 = no auto-dismiss)
     * @param {boolean} options.showProgress - Show progress bar (default: true)
     * @param {Object} options.action - Action button config { text, onClick }
     */
    show(options = {}) {
        this.init();

        const config = {
            type: options.type || "info",
            title: options.title || "",
            message: options.message || "",
            duration: options.duration !== undefined ? options.duration : 4000,
            showProgress: options.showProgress !== false,
            action: options.action || null,
        };

        // Create toast element
        const toast = document.createElement("div");
        toast.className = `toast toast--${config.type}`;

        let actionHtml = "";
        if (config.action) {
            actionHtml = `
                <div class="toast__action">
                    <button class="btn-toast-action btn-toast-action--primary">${config.action.text}</button>
                </div>
            `;
        }

        let progressHtml = "";
        if (config.showProgress && config.duration > 0) {
            progressHtml = `<div class="toast__progress" style="animation-duration: ${config.duration}ms"></div>`;
        }

        toast.innerHTML = `
            <div class="toast__icon">${this.icons[config.type]}</div>
            <div class="toast__content">
                ${
                    config.title
                        ? `<div class="toast__title">${config.title}</div>`
                        : ""
                }
                <div class="toast__message">${config.message}</div>
                ${actionHtml}
            </div>
            <button class="toast__close">${this.icons.close}</button>
            ${progressHtml}
        `;

        // Add to container
        this.container.appendChild(toast);

        // Limit visible toasts
        const toasts = this.container.querySelectorAll(".toast");
        if (toasts.length > this.maxToasts) {
            this.hide(toasts[0]);
        }

        // Trigger show animation
        requestAnimationFrame(() => {
            toast.classList.add("toast--show");
            toast.classList.add("show"); // Bootstrap 5 compatibility - required for visibility
        });

        // Close button handler
        const closeBtn = toast.querySelector(".toast__close");
        closeBtn.addEventListener("click", () => this.hide(toast));

        // Action button handler
        if (config.action && config.action.onClick) {
            const actionBtn = toast.querySelector(".btn-toast-action");
            actionBtn.addEventListener("click", () => {
                config.action.onClick();
                this.hide(toast);
            });
        }

        // Auto-dismiss
        if (config.duration > 0) {
            setTimeout(() => {
                this.hide(toast);
            }, config.duration);
        }

        return toast;
    },

    /**
     * Hide a toast
     * @param {HTMLElement} toast - Toast element to hide
     */
    hide(toast) {
        if (!toast || !toast.parentNode) return;

        toast.classList.remove("toast--show");
        toast.classList.remove("show"); // Also remove Bootstrap class
        toast.classList.add("toast--hide");

        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 400);
    },

    /**
     * Shorthand methods
     */
    success(message, title = "Berhasil", options = {}) {
        return this.show({ ...options, type: "success", title, message });
    },

    error(message, title = "Error", options = {}) {
        return this.show({ ...options, type: "error", title, message });
    },

    warning(message, title = "Perhatian", options = {}) {
        return this.show({ ...options, type: "warning", title, message });
    },

    info(message, title = "Info", options = {}) {
        return this.show({ ...options, type: "info", title, message });
    },

    /**
     * Clear all toasts
     */
    clear() {
        if (!this.container) return;
        const toasts = this.container.querySelectorAll(".toast");
        toasts.forEach((toast) => this.hide(toast));
    },
};

// Make globally available
window.Toast = Toast;

// Auto-init on DOM ready
document.addEventListener("DOMContentLoaded", () => {
    Toast.init();
});
