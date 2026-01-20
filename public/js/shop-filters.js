// Shop Filters AJAX Handler
(function() {
    'use strict';

    let searchTimeout;
    
    // Initialize on DOM load
    document.addEventListener('DOMContentLoaded', function() {
        initializeFilters();
    });

    function initializeFilters() {
        // Search input with debouncing
        const searchInput = document.getElementById('search-input');
        const searchClear = document.getElementById('search-clear');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                
                // Show/hide clear button
                if (this.value.length > 0) {
                    searchClear.classList.add('active');
                } else {
                    searchClear.classList.remove('active');
                }
                
                // Debounce search
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 500); // 500ms debounce
            });
            
            // Clear search button
            searchClear.addEventListener('click', function() {
                searchInput.value = '';
                this.classList.remove('active');
                applyFilters();
            });
        }

        // Sort dropdown
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                applyFilters();
            });
        }

        // Quick filter pills
        const filterPills = document.querySelectorAll('.filter-pill');
        filterPills.forEach(pill => {
            pill.addEventListener('click', function() {
                this.classList.toggle('active');
                applyFilters();
            });
        });

        // Clear all filters button
        const clearAllBtn = document.getElementById('clear-all-filters');
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', function() {
                clearAllFilters();
            });
        }

        // Initialize filter count
        updateFilterCount();
    }

    function applyFilters() {
        const filters = getActiveFilters();
        
        // Build URL with query parameters
        const params = new URLSearchParams();
        
        // Search
        if (filters.search) {
            params.append('search', filters.search);
        }
        
        // Sort
        if (filters.sort) {
            params.append('sort', filters.sort);
        }
        
        // Existing filters from form
        const categories = document.getElementById('hdnCategories');
        if (categories && categories.value) {
            params.append('categories', categories.value);
        }
        
        const brands = document.getElementById('hdnBrands');
        if (brands && brands.value) {
            params.append('brands', brands.value);
        }
        
        const regions = document.getElementById('hdnRegions');
        if (regions && regions.value) {
            params.append('regions', regions.value);
        }
        
        // Quick filters
        if (filters.best_rated) {
            params.append('best_rated', '1');
        }
        if (filters.on_sale) {
            params.append('on_sale', '1');
        }
        if (filters.organic) {
            params.append('organic', '1');
        }
        if (filters.ready_stock) {
            params.append('ready_stock', '1');
        }
        
        // Redirect with new parameters (page reload approach for simplicity)
        window.location.href = '/shop?' + params.toString();
    }

    function getActiveFilters() {
        const filters = {};
        
        // Search value
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            filters.search = searchInput.value.trim();
        }
        
        // Sort value
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            filters.sort = sortSelect.value;
        }
        
        // Quick filter pills
        const filterPills = document.querySelectorAll('.filter-pill.active');
        filters.best_rated = false;
        filters.on_sale = false;
        filters.organic = false;
        filters.ready_stock = false;
        
        filterPills.forEach(pill => {
            const filterType = pill.getAttribute('data-filter');
            if (filterType) {
                filters[filterType] = true;
            }
        });
        
        return filters;
    }

    function clearAllFilters() {
        // Clear search
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.value = '';
            document.getElementById('search-clear').classList.remove('active');
        }
        
        // Reset sort
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.value = '';
        }
        
        // Deactivate all quick filter pills
        document.querySelectorAll('.filter-pill.active').forEach(pill => {
            pill.classList.remove('active');
        });
        
        // Clear existing form filters
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Clear hidden inputs
        const hdnCategories = document.getElementById('hdnCategories');
        const hdnBrands = document.getElementById('hdnBrands');
        const hdnRegions = document.getElementById('hdnRegions');
        
        if (hdnCategories) hdnCategories.value = '';
        if (hdnBrands) hdnBrands.value = '';
        if (hdnRegions) hdnRegions.value = '';
        
        // Redirect to clean shop page
        window.location.href = '/shop';
    }

    function updateFilterCount() {
        const filters = getActiveFilters();
        let count = 0;
        
        // Count active filters
        if (filters.search) count++;
        if (filters.sort) count++;
        if (filters.best_rated) count++;
        if (filters.on_sale) count++;
        if (filters.organic) count++;
        if (filters.ready_stock) count++;
        
        // Count category/brand/region filters
        const categories = document.getElementById('hdnCategories');
        if (categories && categories.value) {
            count += categories.value.split(',').filter(v => v).length;
        }
        
        const brands = document.getElementById('hdnBrands');
        if (brands && brands.value) {
            count += brands.value.split(',').filter(v => v).length;
        }
        
        const regions = document.getElementById('hdnRegions');
        if (regions && regions.value) {
            count += regions.value.split(',').filter(v => v).length;
        }
        
        // Update UI
        const badge = document.getElementById('active-filters-badge');
        const clearBtn = document.getElementById('clear-all-filters');
        
        if (count > 0) {
            if (badge) {
                badge.textContent = count + ' filter' + (count > 1 ? 's' : '');
                badge.style.display = 'inline-block';
            }
            if (clearBtn) {
                clearBtn.style.display = 'inline-block';
            }
        } else {
            if (badge) {
                badge.style.display = 'none';
            }
            if (clearBtn) {
                clearBtn.style.display = 'none';
            }
        }
    }

    // Make functions globally accessible if needed
    window.shopFilters = {
        apply: applyFilters,
        clear: clearAllFilters,
        updateCount: updateFilterCount
    };
})();
