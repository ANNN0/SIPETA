// Autocomplete Enhancement for SIPETA Search
// Location: resources/js/shop-autocomplete.js

(function($) {
    'use strict';

    let suggestionTimeout;
    let selectedIndex = -1;
    const SEARCH_HISTORY_KEY = 'sipeta_search_history';
    const MAX_HISTORY = 5;

    // Search History Management
    function getSearchHistory() {
        try {
            return JSON.parse(localStorage.getItem(SEARCH_HISTORY_KEY)) || [];
        } catch (e) {
            return [];
        }
    }

    function saveToHistory(searchTerm) {
        if (!searchTerm || searchTerm.trim().length < 2) return;
        let history = getSearchHistory();
        history = history.filter(item => item !== searchTerm);
        history.unshift(searchTerm);
        history = history.slice(0, MAX_HISTORY);
        try {
            localStorage.setItem(SEARCH_HISTORY_KEY, JSON.stringify(history));
        } catch (e) {
            console.error('Failed to save search history');
        }
    }

    function deleteFromHistory(index) {
        let history = getSearchHistory();
        history.splice(index, 1);
        try {
            localStorage.setItem(SEARCH_HISTORY_KEY, JSON.stringify(history));
            return history;
        } catch (e) {
            console.error('Failed to delete from history');
            return history;
        }
    }

    // Text Highlighting
    function highlightMatch(text, query) {
        if (!query) return text;
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }

    // Render Functions
    function renderHistory(history, container) {
        const $container = $(container);
        let html = '<div class="suggestion-section">';
        html += '<div class="suggestion-header">Pencarian Terakhir</div>';
        history.forEach((term, index) => {
            html += `
                <div class="suggestion-item history-item" data-type="history" data-term="${term}" data-index="${index}">
                    <svg class="suggestion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="suggestion-name">${term}</span>
                    <button class="history-delete-btn" data-index="${index}" title="Hapus">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                        </svg>
                    </button>
                </div>
            `;
        });
        html += '</div>';
        $container.html(html).addClass('show');
    }

    function renderSuggestions(suggestions, query, container, shopRoute, detailsRoute, assetPath) {
        const $container = $(container);
        
        if (suggestions && suggestions.length > 0) {
            let html = '<div class="suggestion-section">';
            html += '<div class="suggestion-header">Saran Produk</div>';
            
            suggestions.forEach(product => {
                const productUrl = detailsRoute.replace('__SLUG__', product.slug);
                const imageUrl = product.image.startsWith('http') ? product.image : 
                    assetPath + '/' + product.image;
                const formattedPrice = 'Rp ' + Number(product.price).toLocaleString('id-ID');
                
                html += `
                    <a href="${productUrl}" class="suggestion-item" data-type="product" data-name="${product.name}">
                        <img src="${imageUrl}" alt="${product.name}" class="suggestion-image">
                        <div class="suggestion-info">
                            <span class="suggestion-name">${highlightMatch(product.name, query)}</span>
                            <span class="suggestion-meta">${product.category}</span>
                        </div>
                        <span class="suggestion-price">${formattedPrice}</span>
                    </a>
                `;
            });
            html += '</div>';
            $container.html(html).addClass('show');
        } else {
            let html = '<div class="suggestion-empty">';
            html += '<div class="empty-icon">🔍</div>';
            html += '<div class="empty-text">Produk tidak ditemukan</div>';
            html += '<div class="empty-hint">Coba kata kunci lain</div>';
            html += '</div>';
            $container.html(html).addClass('show');
        }
    }

    // Fetch Suggestions via AJAX
    function fetchSuggestions(query, container, shopRoute, detailsRoute, assetPath) {
        if (!query || query.length < 2) {
            const history = getSearchHistory();
            if (history.length > 0) {
                renderHistory(history, container);
            } else {
                $(container).removeClass('show');
            }
            return;
        }

        $.ajax({
            url: shopRoute,
            type: "GET",
            data: { search: query, suggestion: '1' },
            success: function(suggestions) {
                renderSuggestions(suggestions, query, container, shopRoute, detailsRoute, assetPath);
            },
            error: function() {
                console.error('Failed to fetch suggestions');
            }
        });
    }

    // Update Selection for Keyboard Navigation
    function updateSelection(items) {
        items.removeClass('active');
        if (selectedIndex >= 0 && selectedIndex < items.length) {
            items.eq(selectedIndex).addClass('active');
        }
    }

    // Initialize Autocomplete
    window.initShopAutocomplete = function(config) {
        const { 
            shopRoute, 
            detailsRoute, 
            assetPath, 
            performAjaxSearchFn,
            searchInputId = '#search-input-top', // Default to shop page
            suggestionsContainerId = '#search-suggestions' // Default to shop page
        } = config;

        const $searchInput = $(searchInputId);
        const $suggestionsContainer = $(suggestionsContainerId);

        // Handle Input with Autocomplete
        $searchInput.on("input", function() {
            clearTimeout(suggestionTimeout);
            const searchValue = $(this).val();
            selectedIndex = -1;

            // Show suggestions quickly
            suggestionTimeout = setTimeout(() => {
                fetchSuggestions(searchValue, suggestionsContainerId, shopRoute, detailsRoute, assetPath);
            }, 300);
        });

        // Show History on Focus
        $searchInput.on("focus", function() {
            if (!$(this).val()) {
                const history = getSearchHistory();
                if (history.length > 0) {
                    renderHistory(history, suggestionsContainerId);
                }
            }
        });

        // Keyboard Navigation
        $searchInput.on("keydown", function(e) {
            const items = $(suggestionsContainerId + ' .suggestion-item');
            if (items.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = (selectedIndex + 1) % items.length;
                updateSelection(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = selectedIndex <= 0 ? items.length - 1 : selectedIndex - 1;
                updateSelection(items);
            } else if (e.key === 'Enter' && selectedIndex >= 0) {
                e.preventDefault();
                items.eq(selectedIndex)[0].click();
            } else if (e.key === 'Escape') {
                $(suggestionsContainerId).removeClass('show');
                selectedIndex = -1;
            }
        });

        // Handle Suggestion Clicks
        $(document).on('click', suggestionsContainerId + ' .suggestion-item', function(e) {
            const type = $(this).data('type');
            
            if (type === 'history') {
                e.preventDefault();
                const term = $(this).data('term');
                $searchInput.val(term);
                if (typeof performAjaxSearchFn === 'function') {
                    performAjaxSearchFn(term);
                }
                saveToHistory(term);
                $(suggestionsContainerId).removeClass('show');
            } else {
                const productName = $(this).data('name');
                if (productName) {
                    saveToHistory(productName);
                }
            }
        });

        // Handle History Delete Button
        $(document).on('click', '.history-delete-btn', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent triggering parent suggestion-item click
            
            const index = $(this).data('index');
            const newHistory = deleteFromHistory(index);
            
            // Update display
            if (newHistory.length > 0) {
                renderHistory(newHistory, suggestionsContainerId);
            } else {
                $(suggestionsContainerId).removeClass('show');
            }
        });

        // Close on Outside Click
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.shop-search, .search-popup').length) {
                $(suggestionsContainerId).removeClass('show');
                selectedIndex = -1;
            }
        });
    };

})(jQuery);
