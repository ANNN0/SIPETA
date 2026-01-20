{{-- ==========================================
    CENTRALIZED MODALS SYSTEM
    Based on minimalist red-theme design
    Include once: @include('partials.modals')
========================================== --}}

{{-- 1. DELETE CONFIRMATION MODAL --}}
<div class="modal-overlay" id="delete-modal" style="display: none;">
    <div class="modal-container">
        {{-- Red Circle Icon - Trash --}}
        <div class="modal-icon-wrapper">
            <div class="modal-icon modal-icon-delete">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </div>
        </div>

        {{-- Title --}}
        <h3 class="modal-title">Delete <span class="delete-item-type">Item</span></h3>

        {{-- Description --}}
        <p class="modal-description">
            This will permanently delete <strong class="delete-item-name"></strong>. This action cannot be undone.
        </p>

        {{-- Action Buttons --}}
        <div class="modal-actions">
            <button type="button" class="modal-btn modal-btn-cancel" data-modal-close="delete-modal">
                Cancel
            </button>
            <button type="button" class="modal-btn modal-btn-delete" id="confirm-delete-btn">
                Delete
            </button>
        </div>
    </div>
</div>

{{-- 2. LOGOUT CONFIRMATION MODAL --}}
<div class="modal-overlay" id="logout-modal" style="display: none;">
    <div class="modal-container">
        {{-- Red Circle Icon - Logout --}}
        <div class="modal-icon-wrapper">
            <div class="modal-icon modal-icon-logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </div>
        </div>

        {{-- Title --}}
        <h3 class="modal-title">Logout</h3>

        {{-- Description --}}
        <p class="modal-description">
            Are you sure you want to logout from your account?
        </p>

        {{-- Action Buttons --}}
        <div class="modal-actions">
            <button type="button" class="modal-btn modal-btn-cancel" data-modal-close="logout-modal">
                Cancel
            </button>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="modal-btn modal-btn-delete">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>

{{-- 3. GENERIC CONFIRMATION MODAL (with dynamic colors) --}}
<div class="modal-overlay" id="confirm-modal" style="display: none;">
    <div class="modal-container">
        {{-- Icon - Dynamic color --}}
        <div class="modal-icon-wrapper">
            <div class="modal-icon modal-icon-success" id="confirm-modal-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
        </div>

        {{-- Title --}}
        <h3 class="modal-title" id="confirm-modal-title">Confirm Action</h3>

        {{-- Description --}}
        <p class="modal-description" id="confirm-modal-message">
            Are you sure you want to proceed?
        </p>

        {{-- Action Buttons --}}
        <div class="modal-actions">
            <button type="button" class="modal-btn modal-btn-cancel" data-modal-close="confirm-modal">
                Cancel
            </button>
            <button type="button" class="modal-btn modal-btn-success" id="confirm-action-btn">
                Confirm
            </button>
        </div>
    </div>
</div>

{{-- MODAL JAVASCRIPT --}}
<script>
    // Modal utility functions
    const ModalUtils = {
        // Open modal
        open(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        },

        // Close modal
        close(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        },

        // Show delete modal
        showDelete(itemName, itemType = 'item', onConfirm) {
            document.querySelector('.delete-item-name').textContent = itemName;
            document.querySelector('.delete-item-type').textContent = itemType;
            this.open('delete-modal');

            const confirmBtn = document.getElementById('confirm-delete-btn');
            // Remove old event listeners
            const newBtn = confirmBtn.cloneNode(true);
            confirmBtn.parentNode.replaceChild(newBtn, confirmBtn);

            // Attach new listener
            newBtn.onclick = () => {
                if (typeof onConfirm === 'function') onConfirm();
                this.close('delete-modal');
            };
        },

        // Show confirmation modal with dynamic color
        showConfirm(title, message, colorType = 'success', onConfirm) {
            // Update modal content
            document.getElementById('confirm-modal-title').textContent = title;
            document.getElementById('confirm-modal-message').textContent = message;

            const icon = document.getElementById('confirm-modal-icon');
            const confirmBtn = document.getElementById('confirm-action-btn');

            // Apply color based on type
            if (colorType === 'danger') {
                icon.className = 'modal-icon modal-icon-delete'; // Red
                confirmBtn.className = 'modal-btn modal-btn-delete'; // Red button
            } else if (colorType === 'success') {
                icon.className = 'modal-icon modal-icon-success'; // Green
                confirmBtn.className = 'modal-btn modal-btn-success'; // Green button
            }

            this.open('confirm-modal');

            // Remove old event listeners
            const newBtn = confirmBtn.cloneNode(true);
            confirmBtn.parentNode.replaceChild(newBtn, confirmBtn);

            // Attach new listener
            newBtn.onclick = () => {
                if (typeof onConfirm === 'function') onConfirm();
                this.close('confirm-modal');
            };
        }
    };

    // Auto-attach close handlers
    document.addEventListener('DOMContentLoaded', function() {
        // Close on overlay click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });
        });

        // Close on cancel buttons
        document.querySelectorAll('[data-modal-close]').forEach(btn => {
            btn.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-close');
                ModalUtils.close(modalId);
            });
        });
    });
</script>
