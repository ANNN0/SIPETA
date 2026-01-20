/* eslint-disable no-unused-vars */
// eslint-disable-next-line no-undef
var $ = jQuery.noConflict();

let UomoSections = {};
let UomoElements = {};

let UomoSelectors = {
  pageBackDropActiveClass: 'page-overlay_visible',
  quantityControl: '.qty-control',
  scrollToTopId: 'scrollTop',
  $pageBackDrop: document.querySelector('.page-overlay'),
  scrollWidth:   window.innerWidth - document.body.clientWidth + 'px',
  jsContentVisible: '.js-content_visible',
  starRatingControl: '.star-rating .star-rating__star-icon',
}

// Utility functions
let UomoHelpers = {
  isMobile: false,
  sideStkEl: {},

  debounce: (callback, wait, immediate = false) => {
    let timeout = null;

    return function() {
      const callNow = immediate && !timeout;
      const next = () => callback.apply(this, arguments);

      clearTimeout(timeout);
      timeout = setTimeout(next, wait);

      if (callNow) {
        next();
      }
    }
  },

  showPageBackdrop: () => {
    UomoSelectors.$pageBackDrop && UomoSelectors.$pageBackDrop.classList.add(UomoSelectors.pageBackDropActiveClass);
    document.body.classList.add('overflow-hidden');
    document.body.style.paddingRight = UomoSelectors.scrollWidth;
    document.querySelectorAll('.header_sticky, .footer-mobile').forEach(element => {
      element.style.borderRight = UomoSelectors.scrollWidth + ' solid transparent';
    });
  },

  hidePageBackdrop: () => {
    UomoSelectors.$pageBackDrop && UomoSelectors.$pageBackDrop.classList.remove(UomoSelectors.pageBackDropActiveClass);
    document.body.classList.remove('overflow-hidden');
    document.body.style.paddingRight = '';
    document.querySelectorAll('.header_sticky, .footer-mobile').forEach(element => {
      element.style.borderRight = '';
    });
  },

  hideHoverComponents: () => {
    document.querySelectorAll(UomoSelectors.jsContentVisible).forEach( el => {
      el.classList.remove(UomoSelectors.jsContentVisible.substring(1));
    });
  },

  updateDeviceSize: () => {
    return window.innerWidth < 992
  }
};

function purecookieDismiss() {
  setCookie("purecookieDismiss", "1", 7), pureFadeOut("cookieConsentContainer")
}

function setCookie(e, o, i) {
  var t = "";
  if (i) {
    var n = new Date;
    n.setTime(n.getTime() + 24 * i * 60 * 60 * 1e3), t = "; expires=" + n.toUTCString()
  }
  document.cookie = e + "=" + (o || "") + t + "; path=/"
}

function pureFadeOut(e) {
  var o = document.getElementById(e);
  o.style.opacity = 1,
    function e() {
      (o.style.opacity -= .02) < 0 ? o.style.display = "none" : requestAnimationFrame(e)
    }()
}

(function () {
  'use strict';

  // Scroll bar width
  const scrollBarWidth = window.innerWidth - document.body.clientWidth

  // Components appear after click
  UomoElements.JsHoverContent = (function () {
    function JsHoverContent () {
      const visibleClass = UomoSelectors.jsContentVisible.substring(1);

      document.querySelectorAll('.js-hover__open').forEach(el => {
        el.addEventListener('click', (e) => {
          e.preventDefault();

          const $container = e.currentTarget.closest('.hover-container');
          if ($container.classList.contains(visibleClass)) {
            $container.classList.remove(visibleClass);
            // e.stopPropagation();
          } else {
            UomoHelpers.hideHoverComponents();
            $container.classList.add(visibleClass);
          }
        });
      });

      document.addEventListener('click', (e) => {
        if (!e.target.closest(UomoSelectors.jsContentVisible)) {
          UomoHelpers.hideHoverComponents();
        }
      });
    }


    return JsHoverContent;
  })();

  UomoElements.QtyControl = (function () {
    function QtyControl () {
      document.querySelectorAll(UomoSelectors.quantityControl).forEach(function($qty) {
        if ($qty.classList.contains('qty-initialized')) {
          return;
        }

        $qty.classList.add('qty-initialized');
        const $reduce = $qty.querySelector('.qty-control__reduce');
        const $increase = $qty.querySelector('.qty-control__increase');
        const $number = $qty.querySelector('.qty-control__number');

        $reduce.addEventListener('click', function() {
          $number.value = parseInt($number.value) > 1 ? parseInt($number.value) - 1 : parseInt($number.value);
        });

        $increase.addEventListener('click', function() {
          $number.value = parseInt($number.value) + 1;
        });
      });
    }

    return QtyControl;
  })();

  UomoElements.AddToCart = (function () {
    function AddToCart () {
      this.selectors = {
        form: '.ajax-add-to-cart-form',
        button: 'button[type="submit"]',
        btnText: '.btn-text',
        btnSpinner: '.btn-spinner',
        cartCount: '.js-cart-items-count'  // Updated selector
      };

      this.$forms = document.querySelectorAll(this.selectors.form);
      this._init();
    }

    AddToCart.prototype = Object.assign({}, AddToCart.prototype, {
      _init: function () {
        const _this = this;
        this.$forms.forEach(function($form) {
          $form.addEventListener('submit', function(event) {
            event.preventDefault();
            _this._handleSubmit($form);
          });
        });
      },

      _handleSubmit: function ($form) {
        const _this = this;
        const $button = $form.querySelector(this.selectors.button);
        
        // Safety check - if no button found, log and return
        if (!$button) {
          console.error('AddToCart: Submit button not found in form', $form);
          return;
        }
        
        // Handle both button structures
        let $btnText = $button.querySelector(this.selectors.btnText);
        let $btnSpinner = $button.querySelector(this.selectors.btnSpinner);
        
        // Try alternative selectors if not found (.btn-content wrapper)
        if (!$btnText) {
          const $btnContent = $button.querySelector('.btn-content');
          if ($btnContent) {
            $btnText = $btnContent.querySelector(this.selectors.btnText) || $btnContent;
          }
        }
        
        const formData = new FormData($form);
        const url = $form.getAttribute('action');

        // Show loading state
        $button.disabled = true;
        if ($btnText) $btnText.classList.add('d-none');
        if ($btnSpinner) $btnSpinner.classList.remove('d-none');

        // Send AJAX request
        fetch(url, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': formData.get('_token')
          }
        })
        .then(function(response) {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(function(data) {
          // Success handling
          if (data.success) {
            // Update cart count
            _this._updateCartCount(data.cart_count);
            
            // Refresh cart drawer content (without auto-opening)
            if (window.cartDrawerInstance && typeof window.cartDrawerInstance.refresh === 'function') {
              window.cartDrawerInstance.refresh();
            }
            
            // Show success notification
            _this._showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');

            // Replace form with "Go to Cart" button (for product cards ONLY)
            // Product card buttons have 'pc__atc' class, Details page buttons have 'btn-addtocart' class
            if ($button.classList.contains('pc__atc')) {
              // Create "Go to Cart" button
              const goToCartBtn = document.createElement('a');
              goToCartBtn.href = '/cart';
              goToCartBtn.className = 'pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3';
              goToCartBtn.textContent = 'Go to Cart';
              
              // Replace form with button
              $form.parentNode.replaceChild(goToCartBtn, $form);
            } else {
              // Restore button state for product details page and other instances
              $button.disabled = false;
              if ($btnText) $btnText.classList.remove('d-none');
              if ($btnSpinner) $btnSpinner.classList.add('d-none');
            }
          }
        })
        .catch(function(error) {
          console.error('Error:', error);
          _this._showNotification('Gagal menambahkan produk ke keranjang. Silakan coba lagi.', 'error');
          
          // Reset button state on error
          $button.disabled = false;
          if ($btnText) $btnText.classList.remove('d-none');
          if ($btnSpinner) $btnSpinner.classList.add('d-none');
        });
      },

      _updateCartCount: function (count) {
        // Update all cart count elements
        const $cartCounts = document.querySelectorAll(this.selectors.cartCount);
        $cartCounts.forEach(function($count) {
          $count.textContent = count;
          
          // Show/hide based on count
          if (count > 0) {
            $count.classList.remove('d-none');
          } else {
            $count.classList.add('d-none');
          }
          
          // Add a pulse animation
          $count.classList.add('cart-count-pulse');
          setTimeout(function() {
            $count.classList.remove('cart-count-pulse');
          }, 600);
        });
      },

      _showNotification: function (message, type) {
        // Use the global Toast system if available
        if (typeof Toast !== 'undefined') {
          if (type === 'success') {
            Toast.success(message);
          } else {
            Toast.error(message);
          }
        } else {
          // Toast system not loaded - log error
          console.error('Toast system not available. Message:', message);
        }
      },

      _replaceWithGoToCart: function ($form, productId) {
        // Create "Go to Cart" link
        const $goToCartLink = document.createElement('a');
        $goToCartLink.href = '/cart';
        $goToCartLink.className = 'pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3';
        $goToCartLink.textContent = 'Go to Cart';
        
        // Replace form with link
        $form.parentNode.replaceChild($goToCartLink, $form);
      }
    });

    return AddToCart;
  })();


  UomoElements.ScrollToTop = (function () {
    function ScrollToTop () {
      const $scrollTop = document.getElementById(UomoSelectors.scrollToTopId);

      if (!$scrollTop) {
        return;
      }

      $scrollTop.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        window.scrollTo(window.scrollX, 0);
      });

      let scrolled = false;
      window.addEventListener('scroll', function() {
        if ( 250 < window.scrollY && !scrolled ) {
          $scrollTop.classList.remove('visually-hidden');
          scrolled = true;
        }

        if ( 250 > window.scrollY && scrolled ) {
          $scrollTop.classList.add('visually-hidden');
          scrolled = false;
        }
      });
    }

    return ScrollToTop;
  })();

  UomoElements.Search = (function() {
    function Search() {
      // Declare variables
      this.selectors = {
        container: '.search-field',
        inputBox: '.search-field__input',
        searchSuggestItem: '.search-suggestion a.menu-link',
        searchFieldActor: '.search-field__actor',
        resetButton: '.search-popup__reset',
        searchCategorySelector: '.js-search-select',
        resultContainer: '.search-result',
        ajaxURL: './search.html'
      }

      this.searchInputFocusedClass = 'search-field__focused';

      this.$containers = document.querySelectorAll(this.selectors.container);

      this._initSearchSelect();
      this._initSearchReset();
      this._initSearchInputFocus();
      this._initAjaxSearch();

      this._handleAjaxSearch = this._handleAjaxSearch.bind(this);
      this._updateSearchResult = this._updateSearchResult.bind(this);
    }

    Search.prototype = Object.assign({}, Search.prototype, {
      _initSearchSelect: function () {
        const _this = this;
        this.$containers.forEach( el => {
          /**
           * Filter suggestion list on input
           */

          const $inputBox = el.querySelector(_this.selectors.inputBox);
          $inputBox && $inputBox.addEventListener('keyup', (e) => {
            const filterValue = e.currentTarget.value.toUpperCase();
            el.querySelectorAll(_this.selectors.searchSuggestItem).forEach( el => {
              const txtValue = el.innerText;

              if (txtValue.toUpperCase().indexOf(filterValue) > -1) {
                el.style.display = "";
              } else {
                el.style.display = "none";
              }
            });
          });

          /**
           * Search category selector
           */
          el.querySelectorAll(_this.selectors.searchCategorySelector).forEach( scs => {
            scs.addEventListener('click', function(e) {
              e.preventDefault();
              const $s_f_a = el.querySelector(_this.selectors.searchFieldActor);
              if ($s_f_a) {
                $s_f_a.value = e.target.innerText;
              }
            });
          });
        })
      },

      _removeFormActiveClass($eventEl) {
        const $parentDiv = $eventEl.closest(this.selectors.container);
        $parentDiv.classList.remove(this.searchInputFocusedClass);
      },

      _initSearchReset: function () {
        const _this = this;
        document.querySelectorAll(this.selectors.resetButton).forEach( el => {
          el.addEventListener('click', function(e) {
            const $parentDiv = e.target.closest(_this.selectors.container);
            const $inputBox = $parentDiv.querySelector(_this.selectors.inputBox);
            const $rc = $parentDiv.querySelector(_this.selectors.resultContainer);

            $inputBox.value = '';
            $rc.innerHtml = '';
            _this._removeFormActiveClass(e.target);
          });
        })
      },

      _initSearchInputFocus: function () {
        const _this = this;

        document.querySelectorAll(this.selectors.inputBox).forEach( el => {
          el.addEventListener('blur', function(e) {
            if (e.target.value.length == 0) {
              _this._removeFormActiveClass(e.target);
            }
          })
        });
      },

      _initAjaxSearch: function () {
        const _this = this;
        document.querySelectorAll(this.selectors.inputBox).forEach( el => {
          el.addEventListener('keyup', (event) => {
            if (event.target.value.length == 0) {
              _this._removeFormActiveClass(event.target);
            } else {
              _this._handleAjaxSearch(event, _this);
            }
          });
        })
      },

      _handleAjaxSearch: UomoHelpers.debounce((event, _this) => {
        const $form = event.target.closest(_this.selectors.container);
        const method = $form ? $form.method : 'GET';
        const url = _this.selectors.ajaxURL;

        url && fetch(url, { method: method }).then(function (response) {
          if (response.ok) {
            return response.text();
          } else {
            return Promise.reject(response);
          }
        }).then(function(data) {
          _this._updateSearchResult(data, $form);
        }).catch(function (err) {
          _this._handleAjaxSearchError(err.message, $form);
        });
      }, 180),

      _updateSearchResult: function(data, $form) {
        const $ajaxDom = new DOMParser().parseFromString(data, 'text/html');
        // Get filtered result dom
        const $f_r = $ajaxDom.querySelector('.search-result');
        $form.querySelector(this.selectors.resultContainer).innerHTML = $f_r.innerHTML;
        $form.classList.add(this.searchInputFocusedClass);
      },

      _handleAjaxSearchError: function (error, $form) {
        $form.classList.remove(this.searchInputFocusedClass);
        console.log(error);
      }
    });

    return Search
  })();

  // Aside Popup
  UomoElements.Aside = (function () {
    function Aside () {
      this.selectors = {
        activator:    '.js-open-aside',
        closeBtn:     '.js-close-aside',
        activeClass:  'aside_visible'
      }

      this.$asideActivators = document.querySelectorAll(this.selectors.activator);
      this.$closeBtns = document.querySelectorAll(this.selectors.closeBtn);

      this._init();
      this._initCloseActions();
      this._initBackDropClick();
    }

    Aside.prototype = Object.assign({}, Aside.prototype, {
      _init: function () {
        const _this = this;
        this.$asideActivators.forEach(function($activator) {
          $activator.addEventListener('click', (event) => {
            event.preventDefault();
            const targetElId = event.currentTarget.dataset.aside;
            const $targetAside = document.getElementById(targetElId);

            UomoHelpers.showPageBackdrop();
            $targetAside && $targetAside.classList.add(_this.selectors.activeClass);
          });
        });
      },

      _initCloseActions: function () {
        const _this = this;
        this.$closeBtns.forEach( el => {
          el.addEventListener('click', (event) => {
            event.preventDefault();
            _this._closeAside();
          });
        });
      },

      _initBackDropClick() {
        if (UomoSelectors.$pageBackDrop) {
          UomoSelectors.$pageBackDrop.addEventListener('click', () => {
            this._closeAside();
          });
        }
      },

      _closeAside: function () {
        UomoHelpers.hidePageBackdrop();
        document.querySelectorAll('.' + this.selectors.activeClass).forEach( el => {
          el.classList.remove(this.selectors.activeClass);
        });
      }
    });

    return Aside;
  })();

  UomoElements.Countdown = (function () {
    function Countdown (container) {
      this.selectors = {
        element: '.js-countdown'
      }

      this.$container = container || document.body;

      this._init()
    }

    Countdown.prototype = Object.assign({}, Countdown.prototype, {
      _init: function () {
        const _this = this;
        const $countdowns = this.$container.querySelectorAll(this.selectors.element);
        $countdowns.forEach(function($el) {
          _this._initElement($el);
        });
      },

      _initElement($el) {
        // eslint-disable-next-line no-undef
        const timer = new countdown({
          target: $el
        });
      }
    });


    return Countdown;
  })();

  UomoElements.ShopViewChange = (function () {
    function ShopViewChange () {
      this.selectors = {
        element: '.js-cols-size',
        activeClass: 'btn-link_active'
      }

      this.$buttons = document.querySelectorAll(this.selectors.element);

      this._init();
    }

    ShopViewChange.prototype = Object.assign({}, ShopViewChange.prototype, {
      _init: function () {
        const _this = this;
        this.$buttons.forEach(function($btn) {
          $btn.addEventListener('click', function(event) {
            event.preventDefault();
            const targetDomId = $btn.dataset.target;
            _this._resetActiveLinks();
            this.classList.add(_this.selectors.activeClass);
            const newCol = $btn.dataset.cols;
            _this._changeViewCols(targetDomId, newCol);
          });
        });
      },

      _changeViewCols(parentId, newCol) {
        const $targetDom = document.getElementById(parentId);
        if ($targetDom) {
          $targetDom.classList.remove(
            'row-cols-xl-2', 'row-cols-xl-3', 'row-cols-xl-4', 'row-cols-xl-5', 'row-cols-xl-6',
            'row-cols-lg-2', 'row-cols-lg-3', 'row-cols-lg-4', 'row-cols-lg-5', 'row-cols-lg-6');
          $targetDom.classList.add('row-cols-xl-' + newCol, 'row-cols-lg-' + newCol);
        }
      },

      _resetActiveLinks() {
        const _this = this;
        document.querySelectorAll(`${this.selectors.element}.${this.selectors.activeClass}`).forEach($el => {
          $el.classList.remove(_this.selectors.activeClass);
        });
      }
    });

    return ShopViewChange;
  })();

  UomoElements.Filters = (function () {
    function Filters () {
      this.selectors = {
        element: '.js-filter',
        activeClass: 'swatch_active',
      }

      this.$buttons = document.querySelectorAll(this.selectors.element);

      this._init();
    }

    Filters.prototype = Object.assign({}, Filters.prototype, {
      _init: function () {
        const _this = this;
        this.$buttons.forEach(function($btn) {
          $btn.addEventListener('click', function(event) {
            event.preventDefault();
            _this._toggleActive($btn);
          });
        });
      },

      _toggleActive($btn) {
        if ($btn.classList.contains(this.selectors.activeClass)) {
          $btn.classList.remove(this.selectors.activeClass);
        } else {
          $btn.classList.add(this.selectors.activeClass);
        }
      }
    });


    return Filters;
  })();

  UomoElements.StickyElement = (function () {
    function StickyElement () {
      this.selectors = {
        element: '.side-sticky'
      }

      this.$stickies = document.querySelectorAll(this.selectors.element);
      this._updateStatus = this._updateStatus.bind(this);
      this._init();
    }

    StickyElement.prototype = Object.assign({}, StickyElement.prototype, {
      _init: function () {
        if (UomoHelpers.isMobile) {
          return;
        }

        this.$stickies.forEach(function($sticky) {
          const $grid = $sticky.previousElementSibling || $sticky.nextElementSibling;
          const $target = $grid.offsetHeight > $sticky.offsetHeight ? $sticky : $grid;

          $target.lastKnownY = window.scrollY;
          if (!UomoHelpers.sideStkEl.currentTop) {
            UomoHelpers.sideStkEl.currentTop = 0;
          } else {
            return;
          }


          UomoHelpers.sideStkEl.initialTopOffset = parseInt(window.getComputedStyle($target).top);
        });

        window.addEventListener('scroll', this._updateStatus);
      },

      _updateStatus() {
        const _this = this;

        _this.$stickies.forEach(function($sticky) {
          const $grid = $sticky.previousElementSibling || $sticky.nextElementSibling;
          const $target = $grid.offsetHeight > $sticky.offsetHeight ? $sticky : $grid;

          var bounds = $target.getBoundingClientRect(),
              maxTop = bounds.top + window.scrollY - $target.offsetTop + UomoHelpers.sideStkEl.initialTopOffset,
              minTop = $target.clientHeight - window.innerHeight + 30;

          if (window.scrollY < $target.lastKnownY) {
            UomoHelpers.sideStkEl.currentTop -= window.scrollY - $target.lastKnownY;
          } else {
            UomoHelpers.sideStkEl.currentTop += $target.lastKnownY - window.scrollY;
          }


          UomoHelpers.sideStkEl.currentTop = Math.min(Math.max(UomoHelpers.sideStkEl.currentTop, -minTop), maxTop, UomoHelpers.sideStkEl.initialTopOffset);
          $target.lastKnownY = window.scrollY;

          $target.style.top = UomoHelpers.sideStkEl.currentTop + 'px';
        });
      }
    });


    return StickyElement;
  })();

  // Header Section
  UomoSections.Header = (function () {
    function Header () {
      this.selectors = {
        header: '.header',
        mobileHeader: '.header-mobile',
        mobileMenuActivator: '.mobile-nav-activator',
        mobileMenu: '.navigation',
        mobileMenuActiveClass: 'mobile-menu-opened',
        mobileSubNavOpen: '.js-nav-right',
        mobileSubNavClose: '.js-nav-left',
        mobileSubNavHiddenClass: 'd-none',
        stickyHeader: '.header_sticky',
        stickyActiveClass: 'header_sticky-active',
      }

      // Set sticky active class from
      this.stickyMinPos = 25;
      this.stkHd = false;

      this._init = this._init.bind(this);
      this._stickyScrollHander = this._stickyScrollHander.bind(this);
      this._init();
      window.addEventListener('resize', this._init);
    }

    Header.prototype = Object.assign({}, Header.prototype, {
      _init: function () {
        const headerClass = UomoHelpers.isMobile ? this.selectors.mobileHeader : this.selectors.header;

        this.lastScrollTop = 0;
        this.$header = document.querySelector(headerClass);

        if (!this.$header) {
          return;
        }

        if (!UomoHelpers.isMobile) {
          this._initMenuPosition();
        } else {
          this._initMobileMenu();
        }

        this._initStickyHeader();
      },

      _initMobileMenu: function() {
        const _this = this;
        const $mobileMenuActivator = this.$header.querySelector(this.selectors.mobileMenuActivator);
        const $mobileDropdown = this.$header.querySelector(this.selectors.mobileMenu);
        let transformLeft = 0;

        if ($mobileDropdown) {
          $mobileMenuActivator && $mobileMenuActivator.addEventListener('click', function(event) {
            event.preventDefault();
            if (document.body.classList.contains(_this.selectors.mobileMenuActiveClass)) {
              document.body.classList.remove(_this.selectors.mobileMenuActiveClass);
              _this.$header.style.paddingRight = '';
              $mobileDropdown.style.paddingRight = '';
            } else {
              document.body.classList.add(_this.selectors.mobileMenuActiveClass);
              _this.$header.style.paddingRight = UomoSelectors.scrollWidth;
              $mobileDropdown.style.paddingRight = UomoSelectors.scrollWidth;
            }
          });

          const $mobileMenu = $mobileDropdown.querySelector('.navigation__list');
          let menuMaxHeight = $mobileMenu.offsetHeight;
          $mobileMenu && $mobileMenu.querySelectorAll(_this.selectors.mobileSubNavOpen).forEach($btn => {
            $btn.addEventListener('click', function(event) {
              event.preventDefault;
              $btn.nextElementSibling.classList.remove(_this.selectors.mobileSubNavHiddenClass);

              transformLeft -= 100;
              if (menuMaxHeight < $btn.nextElementSibling.offsetHeight) {
                $mobileMenu.style.transform = 'translateX(' + transformLeft.toString() + '%)';
                $mobileMenu.style.minHeight = $btn.nextElementSibling.offsetHeight + 'px';
              } else {
                $mobileMenu.style.transform = 'translateX(' + transformLeft.toString() + '%)';
                $mobileMenu.style.minHeight = menuMaxHeight + 'px';
              }
            });
          });


          $mobileMenu && $mobileMenu.querySelectorAll(_this.selectors.mobileSubNavClose).forEach($btn => {
            $btn.addEventListener('click', function(event) {
              event.preventDefault;
              transformLeft += 100;
              $mobileMenu.style.transform = 'translateX(' + transformLeft.toString() + '%)';
              $btn.parentElement.classList.add(_this.selectors.mobileSubNavHiddenClass);
              const $wrapper = $btn.closest('.sub-menu');
              if ($wrapper) {
                const minHeight = menuMaxHeight < $wrapper.offsetHeight ? $wrapper.offsetHeight : menuMaxHeight;
                $mobileMenu.style.minHeight = minHeight + 'px';
              }
            });
          });
        }
      },

      _initStickyHeader: function () {
        if (this.$header.classList.contains(this.selectors.stickyHeader)) {
          return;
        }

        const _this = this;
        let headerHeight = this.$header.offsetHeight;
        if(this.$header.classList.contains("header-transparent-bg")) {
          headerHeight = 0;

          if(document.querySelectorAll(".header-transparent-bg .header-top").length > 0) {
            headerHeight = document.querySelector(".header-transparent-bg .header-top").offsetHeight;
          }
        }

        document.querySelector("main").style.paddingTop = headerHeight + 'px';
        _this.$header.classList.add('position-absolute');

        document.removeEventListener('scroll', this._stickyScrollHander);
        document.addEventListener('scroll', this._stickyScrollHander);
      },

      _initMenuPosition () {
        const _this = this;
        _this.$header.querySelectorAll('.box-menu').forEach( el => {
          _this._setBoxMenuPosition(el)
        });

        _this.$header.querySelectorAll('.default-menu').forEach( el => {
          _this._setDefaultMenuPosition(el)
        });
      },

      _setBoxMenuPosition (menu) {
        const limitR = window.innerWidth - menu.offsetWidth - scrollBarWidth;
        const limitL = 0;
        const menuPaddingLeft = parseInt(window.getComputedStyle(menu, null).getPropertyValue('padding-left'));
        const parentPaddingLeft = parseInt(window.getComputedStyle(menu.previousElementSibling, null).getPropertyValue('padding-left'));
        const centerPos = menu.previousElementSibling.offsetLeft - menuPaddingLeft + parentPaddingLeft;

        let menuPos = centerPos;
        if (centerPos < limitL) {
          menuPos = limitL;
        } else if (centerPos > limitR) {
          menuPos = limitR;
        }

        menu.style.left = `${menuPos}px`;
      },

      _setDefaultMenuPosition (menu) {
        const limitR = window.innerWidth - menu.offsetWidth - scrollBarWidth;
        const limitL = 0;
        const menuPaddingLeft = parseInt(window.getComputedStyle(menu, null).getPropertyValue('padding-left'));
        const parentPaddingLeft = parseInt(window.getComputedStyle(menu.previousElementSibling, null).getPropertyValue('padding-left'));
        const centerPos = menu.previousElementSibling.offsetLeft - menuPaddingLeft + parentPaddingLeft;

        let menuPos = centerPos;
        if (centerPos < limitL) {
          menuPos = limitL;
        } else if (centerPos > limitR) {
          menuPos = limitR;
        }

        menu.style.left = `${menuPos}px`;
      },

      _stickyScrollHander() {
        if (this.$header.classList.contains("sticky_disabled")) {
          return;
        }
        const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Show sticky header when scrolled past threshold
        if (currentScrollTop > this.stickyMinPos) {
          this.$header.classList.add(this.selectors.stickyActiveClass);
          this.$header.classList.remove('position-absolute');
        } else {
          this.$header.classList.remove(this.selectors.stickyActiveClass);
          this.$header.classList.add('position-absolute');
        }

        this.lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
      }
    });


    return Header;
  })();

  // Footer Section
  UomoSections.Footer = (function () {
    function Footer () {
      this.selectors = {
        footer: '.footer-mobile'
      }
      this.$footer = document.querySelector(this.selectors.footer);

      this._init = this._init.bind(this);
      this._init();
      window.addEventListener('resize', this._init);
    }

    Footer.prototype = Object.assign({}, Footer.prototype, {
      _init: function() {
        if (!this.$footer || !UomoHelpers.isMobile) {
          return;
        }

        setTimeout(() => {
          this._initStickyFooter();
        }, 750);
      },

      _initStickyFooter: function () {
        const height = this.$footer.offsetHeight;

        document.body.style.paddingBottom = height + 'px';
        this.$footer.classList.add('position-fixed');
        setTimeout(() => {
          this.$footer.classList.add('footer-mobile_initialized');
        }, 750);
      },
    });


    return Footer;
  })();

  // Customer login form
  UomoSections.CustomerSideForm = (function () {
    function CustomerSideForm () {
      this.selectors = {
        aside:        '.aside.customer-forms',
        formsWrapper:  '.customer-forms__wrapper',
        registerActivator:  '.js-show-register',
        loginActivator:     '.js-show-login'
      }

      this.$aside = document.querySelector(this.selectors.aside);
      if (!this.$aside) {
        return false;
      }

      this.$formsWrapper = this.$aside.querySelector(this.selectors.formsWrapper);
      this.$registerActivator = this.$aside.querySelector(this.selectors.registerActivator);
      this.$loginActivator = this.$aside.querySelector(this.selectors.loginActivator);

      this.$formsWrapper && this._showLoginForm()
      this.$formsWrapper && this._showRegisterForm()
    }

    CustomerSideForm.prototype = Object.assign({}, CustomerSideForm.prototype, {
      _showLoginForm: function () {
        this.$loginActivator.addEventListener('click', () => {
          this.$formsWrapper.style.left = 0;
        });
      },

      _showRegisterForm: function () {
        this.$registerActivator.addEventListener('click', () => {
          this.$formsWrapper.style.left = '-100%';
        });
      }
    });

    return CustomerSideForm;
  })();

  UomoSections.CartDrawer = (function () {
    function CartDrawer () {
      this.drawer = document.getElementById('cartDrawer');
      if (!this.drawer) {
        return;
      }

      this.backdrop = this.drawer.querySelector('.cart-drawer-backdrop');
      this.closeBtn = this.drawer.querySelector('.cart-drawer-close');
      this.triggers = document.querySelectorAll('[data-cart-drawer]');
      
      this._init();
    }

    CartDrawer.prototype = Object.assign({}, CartDrawer.prototype, {
      _init: function () {
        const _this = this;
        
        // Open drawer triggers
        this.triggers.forEach(trigger => {
          trigger.addEventListener('click', (e) => {
            e.preventDefault();
            _this.open();
          });
        });

        // Close button
        if (this.closeBtn) {
          this.closeBtn.addEventListener('click', () => _this.close());
        }

        // Backdrop click to close
        if (this.backdrop) {
          this.backdrop.addEventListener('click', () => _this.close());
        }

        // ESC key to close
        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape' && _this.drawer.classList.contains('active')) {
            _this.close();
          }
        });

        // Quantity controls
        this._initQuantityControls();

        // Remove item buttons
        this._initRemoveButtons();
      },

      open: function () {
        this.drawer.classList.add('active');
        document.body.style.overflow = 'hidden';
      },

      close: function () {
        this.drawer.classList.remove('active');
        document.body.style.overflow = '';
      },

      _initQuantityControls: function () {
        const _this = this;
        
        // Increase quantity
        this.drawer.querySelectorAll('.qty-increase').forEach(btn => {
          btn.addEventListener('click', function() {
            const rowId = this.getAttribute('data-row-id');
            _this._updateQuantity(rowId, 'increase');
          });
        });

        // Decrease quantity
        this.drawer.querySelectorAll('.qty-decrease').forEach(btn => {
          btn.addEventListener('click', function() {
            const rowId = this.getAttribute('data-row-id');
            _this._updateQuantity(rowId, 'decrease');
          });
        });
      },

      _updateQuantity: function (rowId, action) {
        const _this = this;
        const route = action === 'increase' 
          ? `/cart/increase-quantity/${rowId}` 
          : `/cart/decrease-quantity/${rowId}`;

        // Find the cart item and qty display
        const cartItem = this.drawer.querySelector(`[data-row-id="${rowId}"]`);
        const qtyDisplay = cartItem?.querySelector('.qty-value');
        const currentQty = parseInt(qtyDisplay?.textContent || 1);
        
        // Optimistic update - update UI immediately
        if (action === 'increase') {
          qtyDisplay.textContent = currentQty + 1;
        } else if (action === 'decrease' && currentQty > 1) {
          qtyDisplay.textContent = currentQty - 1;
        }

        fetch(route, {
          method: 'PUT',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update cart count in header
            const cartCounts = document.querySelectorAll('.js-cart-items-count');
            cartCounts.forEach(el => {
              if (data.cart_count !== undefined) {
                el.textContent = data.cart_count;
                if (data.cart_count > 0) {
                  el.classList.remove('d-none');
                }
              }
            });
            
            // Update total if provided
            if (data.cart_total) {
              const totalEl = this.drawer.querySelector('.total-value');
              if (totalEl) {
                totalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.cart_total);
              }
            }

            // Update items count
            const itemsCountEl = this.drawer.querySelector('.items-count');
            if (itemsCountEl && data.cart_count !== undefined) {
              itemsCountEl.textContent = data.cart_count + ' Items';
            }

            // If item was removed (qty became 0), remove the item from drawer
            if (data.item_removed && cartItem) {
              cartItem.style.transition = 'all 0.3s ease';
              cartItem.style.opacity = '0';
              cartItem.style.transform = 'translateX(50px)';
              setTimeout(() => {
                cartItem.remove();
                // Check if cart is now empty
                const remainingItems = this.drawer.querySelectorAll('.cart-item');
                if (remainingItems.length === 0) {
                  window.location.reload();
                }
              }, 300);
            }
          }
        })
        .catch(error => {
          console.error('Error updating quantity:', error);
          // Revert on error
          qtyDisplay.textContent = currentQty;
        });
      },

      _initRemoveButtons: function () {
        const _this = this;
        
        this.drawer.querySelectorAll('.cart-item-remove').forEach(btn => {
          btn.addEventListener('click', function() {
            const rowId = this.getAttribute('data-row-id');
            _this._removeItem(rowId);
          });
        });
      },

      _removeItem: function (rowId) {
        const itemName = this.drawer.querySelector(`[data-row-id="${rowId}"] .cart-item-name`)?.textContent || 'item';
        
        ModalUtils.showDelete(itemName, 'Cart Item', () => {
          fetch(`/cart/remove/${rowId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              'Accept': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Reload to update cart
              window.location.reload();
            }
          })
          .catch(error => {
            console.error('Error removing item:', error);
          });
        });
      },

      refresh: function() {
        const _this = this;
        const contentContainer = this.drawer.querySelector('.cart-drawer-content');
        
        if (!contentContainer) {
          console.error('Cart drawer content container not found');
          return;
        }

        // Fetch updated drawer content
        fetch('/cart/drawer-content', {
          method: 'GET',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
          }
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to fetch cart drawer content');
          }
          return response.text();
        })
        .then(html => {
          // Create a temporary container to parse the HTML
          const tempDiv = document.createElement('div');
          tempDiv.innerHTML = html;
          
          // Find the three separate components
          const newHeader = tempDiv.querySelector('.cart-drawer-items-header');
          const newItemsList = tempDiv.querySelector('#cart-drawer-items-list');
          const newFooter = tempDiv.querySelector('#cart-drawer-footer');
          
          // Replace items header
          if (newHeader) {
            const oldHeader = contentContainer.querySelector('.cart-drawer-items-header');
            if (oldHeader) {
              oldHeader.replaceWith(newHeader);
            }
          }
          
          // Replace items list (scrollable content)
          if (newItemsList) {
            const oldItemsList = contentContainer.querySelector('#cart-drawer-items-list');
            if (oldItemsList) {
              oldItemsList.replaceWith(newItemsList);
            }
          }
          
          // Replace or remove footer
          const oldFooter = contentContainer.querySelector('#cart-drawer-footer');
          if (newFooter) {
            if (oldFooter) {
              oldFooter.replaceWith(newFooter);
            } else {
              contentContainer.appendChild(newFooter);
            }
          } else if (oldFooter) {
            // Remove footer if cart is empty
            oldFooter.remove();
          }
          
          // Re-initialize event listeners for the new content
          _this._initQuantityControls();
          _this._initRemoveButtons();
        })
        .catch(error => {
          console.error('Error refreshing cart drawer:', error);
        });
      }
    });

    return CartDrawer;
  })();

  UomoSections.SwiperSlideshow = (function () {
    function SwiperSlideshow () {
      this.selectors = {
        container: '.js-swiper-slider'
      }

      this.$containers = document.querySelectorAll(this.selectors.container);
      this._initSliders();
    }

    SwiperSlideshow.prototype = Object.assign({}, SwiperSlideshow.prototype, {
      _initSliders() {
        this.$containers.forEach(function($sliderContainer) {
          if ($sliderContainer.classList.contains('swiper-container-initialized')) {
            return;
          }

          let settings = {
            autoplay: 0,
            slidesPerView: 1,
            loop: true,
            navigation: {
              nextEl: ".pc__img-next",
              prevEl: ".pc__img-prev"
            }
          };

          if ($sliderContainer.classList.contains('swiper-number-pagination')) {
            settings = Object.assign(settings, {
              pagination: {
                "el": ".slideshow-pagination",
                "type": "bullets",
                "clickable": true,
                renderBullet: function(index, className) {
                  return '<span class="' + className + '">' + (index + 1).toString().padStart(2, '0') + '</span>';
                }
              }
            });
          }

          if ($sliderContainer.dataset.settings) {
            settings = Object.assign(settings, JSON.parse($sliderContainer.dataset.settings));
          }

          if ($sliderContainer.querySelectorAll('.swiper-slide').length > 1) {
            // eslint-disable-next-line no-undef
            new Swiper($sliderContainer, settings);
          } else {
            $sliderContainer.classList.add('swiper-container-initialized');
            const $active_slide = $sliderContainer.querySelector('.swiper-slide');
            $active_slide && $active_slide.classList.add('swiper-slide-active');
          }
        });
      }
    });

    return SwiperSlideshow;
  })();

  UomoSections.ProductSingleMedia = (function () {
    function ProductSingleMedia () {
      this.selectors = {
        container: '.product-single__media'
      }

      this.$containers = $(this.selectors.container);
      this._initProductMedia();
    }

    function setSlideHeight(that){
      $('.product-single__thumbnail .swiper-slide').css({height:'auto'});
          var currentSlide = that.activeIndex;
          var newHeight = $(that.slides[currentSlide]).height();
  
          $('.product-single__thumbnail .swiper-wrapper, .product-single__thumbnail .swiper-slide').css({ height : newHeight })
          that.update();
     }

    ProductSingleMedia.prototype = Object.assign({}, ProductSingleMedia.prototype, {
      _initProductMedia() {
        this.$containers.each(function() {
          if ($(this).hasClass('product-media-initialized')) {
            return;
          }

          let media_type = $(this).data('media-type');

          $(this).addClass(media_type);

          if (media_type == 'vertical-thumbnail') {
            var galleryThumbs = new Swiper(".product-single__thumbnail .swiper-container", {
              direction: 'vertical',
              slidesPerView: 6,
              spaceBetween: 0,
              freeMode: true,
              breakpoints: {
                0: {
                  direction: 'horizontal',
                  slidesPerView: 4,
                },
                992: {
                  direction: 'vertical',
                }
              },
              on: {
                init:function(){
                  setSlideHeight(this);
                },
                slideChangeTransitionEnd:function(){
                  setSlideHeight(this);
                }
              }
            });
            var galleryMain = new Swiper(".product-single__image .swiper-container", {
              direction: 'horizontal',
              slidesPerView: 1,
              spaceBetween: 32,
              mousewheel: false,
              navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
              },
              grabCursor: true,
              thumbs: {
                swiper: galleryThumbs
              },
              on: {
                slideChangeTransitionStart: function() {
                  galleryThumbs.slideTo(galleryMain.activeIndex);
                }
              }
            });
          } else if (media_type == 'vertical-dot') {
            var galleryMain = new Swiper(".product-single__image .swiper-container", {
              direction: 'horizontal',
              slidesPerView: 1,
              spaceBetween: 32,
              mousewheel: false,
              grabCursor: true,
              pagination: {
                el: ".product-single__image .swiper-pagination",
                type: "bullets",
                clickable: true
              },
            });
          } else if (media_type == 'scroll-snap') {
            // $("html").addClass("snap");

            // window.addEventListener('scroll', function() {
            //   if ( $(".product-single__media").height() - $(window).height() < window.scrollY ) {
            //     $("html").removeClass("snap");
            //   } else {
            //     $("html").addClass("snap");
            //   }
            // });
          } else if (media_type == 'horizontal-thumbnail') {
            var galleryThumbs = new Swiper(".product-single__thumbnail .swiper-container", {
              direction: 'horizontal',
              slidesPerView: 6,
              spaceBetween: 0,
              freeMode: true,
              breakpoints: {
                0: {
                  slidesPerView: 4,
                },
                992: {
                  slidesPerView: 7,
                }
              }
            });
            var galleryMain = new Swiper(".product-single__image .swiper-container", {
              direction: 'horizontal',
              slidesPerView: 1,
              spaceBetween: 32,
              mousewheel: false,
              navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
              },
              grabCursor: true,
              thumbs: {
                swiper: galleryThumbs
              },
              on: {
                slideChangeTransitionStart: function() {
                  galleryThumbs.slideTo(galleryMain.activeIndex);
                }
              }
            });
          }

          $(this).addClass('product-media-initialized');
        });
      }
    });

    return ProductSingleMedia;
  })();

  UomoElements.StarRating = (function () {
    function StarRating () {
      let stars = Array.from(document.querySelectorAll(UomoSelectors.starRatingControl));
      let user_selected_star = document.querySelector('#form-input-rating');

      stars.forEach(star => {
        // Mouseover event
        star.addEventListener('mouseover', (e) => {
          stars.forEach((item, current_index) => {
            if (current_index <= stars.indexOf(e.target)) {
              item.classList.add('is-overed');
            } else {
              item.classList.remove('is-overed');
            }
          })
        })
      
        // Mouseover event
        star.addEventListener('mouseleave', (e) => {
          stars.forEach((item) => {
            item.classList.remove('is-overed');
          })
        })
      
        // Click event
        star.addEventListener('click', (e) => {
          const selected_index = stars.indexOf(e.target);
          user_selected_star.value = selected_index + 1;
          stars.forEach((item, current_index) => {
            if (current_index <= stars.indexOf(e.target)) {
              item.classList.add('is-selected');
            } else {
              item.classList.remove('is-selected');
            }
          })
        })
      })
    }

    return StarRating;
  })();

  class Uomo {
    constructor() {
      this.initCookieConsient();
      this.initAccessories();
      this.initMultiSelect();
      this.initBsTooltips();
      this.initRangeSlider();

      new UomoElements.JsHoverContent();
      new UomoElements.Search();
      new UomoElements.Aside();
      new UomoElements.QtyControl();
      new UomoElements.AddToCart();
      new UomoElements.ScrollToTop();
      new UomoElements.Countdown();
      new UomoElements.ShopViewChange();
      new UomoElements.Filters();
      new UomoElements.StickyElement();
      new UomoElements.StarRating();

      new UomoSections.Header();
      new UomoSections.Footer();
      new UomoSections.CustomerSideForm();
      window.cartDrawerInstance = new UomoSections.CartDrawer();
      new UomoSections.SwiperSlideshow();
      new UomoSections.ProductSingleMedia();
    }

    initCookieConsient() {
      const purecookieDesc = "In order to provide you a personalized shopping experience, our site uses cookies. By continuing to use this site, you are agreeing to our cookie policy.",
      purecookieButton = "Accept";

      function pureFadeIn(e, o) {
        var i = document.getElementById(e);
        i.style.opacity = 0, i.style.display = o || "block",
        function e() {
          var o = parseFloat(i.style.opacity);
          (o += .02) > 1 || (i.style.opacity = o, requestAnimationFrame(e))
        }()
      }

      function getCookie(e) {
        for (var o = e + "=", i = document.cookie.split(";"), t = 0; t < i.length; t++) {
          for (var n = i[t];" " == n.charAt(0);) {
            n = n.substring(1, n.length);
          }
          if (0 == n.indexOf(o))
            return n.substring(o.length, n.length)
        }
        return null
      }

      function appendHtml(el, str) {
        var div = document.createElement('div');
        div.innerHTML = str;
        while (div.children.length > 0) {
          el.appendChild(div.children[0]);
        }
      }

      // getCookie("purecookieDismiss") || (appendHtml(document.body, '<div class="cookieConsentContainer" id="cookieConsentContainer"><div class="cookieDesc"><p>' + purecookieDesc + '</p></div><div class="cookieButton"><a onClick="purecookieDismiss();">' + purecookieButton + "</a></div></div>"), pureFadeIn("cookieConsentContainer"))
    }

    initAccessories() {
      // Check if device is mobile on resize
      window.addEventListener('resize', function() {
        UomoHelpers.isMobile = UomoHelpers.updateDeviceSize();
      });
    }

    initMultiSelect() {
      // Declare variables
      const $containers = document.querySelectorAll('.multi-select');

      this._initMultiSelect($containers);
    }

    _initMultiSelect($containers) {
      $containers.forEach( el => {
        const $component = el;
        const $list = el.querySelector('.multi-select__list');
        const $select = $component.querySelector('select');
        const $actor = $component.querySelector('.multi-select__actor');

        /**
         * Change hero value when selecting item
         */
        const $selectArray = $component.querySelectorAll('.js-multi-select');
        $selectArray.forEach( el => {
          el.addEventListener('click', function(e) {
            e.preventDefault();

            const optionIndex = (Array.prototype.indexOf.call($list.children, e.currentTarget)).toString();
            const selectedOption = $select.options[optionIndex];

            if (selectedOption && !selectedOption.selected) {
              e.currentTarget.classList.add('mult-select__item_selected');
              selectedOption.selected = true;
            } else {
              e.currentTarget.classList.remove('mult-select__item_selected');
              selectedOption.selected = false;
            }

            if ($actor && !$actor.classList.contains('js-no-update')) {
              let content = $actor.dataset.placeholder;
              if ($select.selectedIndex > -1) {
                content = '';
                for (let i = 0; i < $select.selectedOptions.length; i++) {
                  const $option = $select.selectedOptions[i];
                  content = content + $option.innerText;
                  if (i < $select.selectedOptions.length - 1) {
                    content = content + ', ';
                  }
                }
              }

              $actor.innerText = content;
            }
          });
        });
      });
    }

    initBsTooltips() {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        // eslint-disable-next-line no-undef
        return new bootstrap.Tooltip(tooltipTriggerEl)
      });
    }

    initRangeSlider() {
      const selectors = {
        elementClass: '.price-range-slider',
        minElement: '.price-range__min',
        maxElement: '.price-range__max'
      }

      document.querySelectorAll(selectors.elementClass).forEach($se => {
        // $se = sliderElement
        const currency = $se.dataset.currency;

        if ($se) {
          // Format Rupiah with thousand separators (dots)
          const formatRupiah = function(value) {
            if (Array.isArray(value)) {
              return value.map(v => currency + ' ' + v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')).join(' - ');
            }
            return currency + ' ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
          };

          // eslint-disable-next-line no-undef
          const priceRange = new Slider($se, {
            tooltip_split: true,
            formatter: formatRupiah
          });

          priceRange.on('slideStop', (value) => {
            const $minEl = $se.parentElement.querySelector(selectors.minElement);
            const $maxEl = $se.parentElement.querySelector(selectors.maxElement);
            $minEl.innerText = formatRupiah(value[0]);
            $maxEl.innerText = formatRupiah(value[1]);
          });
        }
      });
    }
  }

  document.addEventListener("DOMContentLoaded", function() {
    // Init theme
    UomoHelpers.isMobile = UomoHelpers.updateDeviceSize();
    new Uomo();
  });

  $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
    var paneTarget = $(e.target).attr('href');
    var $thePane = $('.tab-pane' + paneTarget);
    if ($thePane.find('.swiper-container').length > 0 && 0 === $thePane.find('.swiper-slide-active').length) {
      document.querySelectorAll('.tab-pane' + paneTarget + ' .swiper-container').forEach( function(item) {
        item.swiper.update();
        item.swiper.lazy.load();
      });
     }
  });

  $('#quickView.modal').on('shown.bs.modal', function(e) {
    var paneTarget = "#quickView";
    var $thePane = $('.modal' + paneTarget);
    if ($thePane.find('.swiper-container').length > 0 && 0 === $thePane.find('.swiper-slide-active').length) {
      document.querySelectorAll('.modal' + paneTarget + ' .swiper-container').forEach( function(item) {
        item.swiper.update();
        item.swiper.lazy.load();
      });
     }
  });

  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl, {'html':true})
  });

  $('.shopping-cart .btn-checkout').off('click').on('click', function() {
    // DISABLED: Conflicts with Midtrans AJAX checkout
    // window.location.href='./shop_checkout.html';
  });

  // ORDER PLACE
  $('.checkout-form').on('submit', function (e) {
    // DISABLED: Conflicts with Midtrans AJAX checkout
    // window.location.href='./shop_order_complete.html';
  });
 
  // ORDER PLACE 2
  $('.checkout-form .btn-checkout').off('click').on('click', function () {
    // DISABLED: Conflicts with Midtrans AJAX checkout  
    // window.location.href='./shop_order_complete.html';
  });

  // DISABLED: Conflicts with Midtrans AJAX checkout - Third listener
  // const checkoutBtn = document.querySelector('.checkout-form .btn-checkout');
  // if (checkoutBtn) {
  //   checkoutBtn.addEventListener('click', function() {
  //     window.location.href='./shop_order_complete.html';
  //   });
  // }

  const registerLink = document.querySelector('.js-show-register');
  if (registerLink) {
    registerLink.addEventListener('click', function(e) {
      const targetHref = this.getAttribute("href");
      const targetElement = document.querySelector(targetHref);
      if (targetElement) {
        targetElement.click();
      }
    });
  }

  $('button.js-add-wishlist, a.add-to-wishlist').off('click').on('click', function() {
    if($(this).hasClass("active"))
      $(this).removeClass("active");
    else
      $(this).addClass("active");
    return false;
  });

  // Only initialize fancybox if the plugin is loaded
  if($('[data-fancybox="gallery"]').length > 0 && typeof $.fn.fancybox === 'function') {
    $('[data-fancybox="gallery"]').fancybox({
      backFocus: false
    });
  }

  $(window).off("scroll").on("scroll", function() {
    if($(".mobile_fixed-btn_wrapper").length > 0) {
      if($(this).width() < 992 && $(this).width() >= 768) {
        if($(this).scrollTop() + $(this).height() - 76 <= $(".mobile_fixed-btn_wrapper").offset().top && $(this).scrollTop() > $(this).height()) {
          $(".mobile_fixed-btn_wrapper > .button-wrapper").addClass("fixed-btn");
        } else {
          $(".mobile_fixed-btn_wrapper > .button-wrapper").removeClass("fixed-btn");
        }
      } else if($(this).width() < 768) {
        if($(this).scrollTop() + $(this).height() - 124 <= $(".mobile_fixed-btn_wrapper").offset().top && $(this).scrollTop() > $(this).height()) {
          $(".mobile_fixed-btn_wrapper > .button-wrapper").addClass("fixed-btn");
        } else {
          $(".mobile_fixed-btn_wrapper > .button-wrapper").removeClass("fixed-btn");
        }
      } else {
        $(".mobile_fixed-btn_wrapper > .button-wrapper").removeClass("fixed-btn");
      }
    }
  });

  window.onload = () => {
    if($("#newsletterPopup").length > 0)
      $("#newsletterPopup").modal("show");

    $('.btn-video-player').each(function() {
      $(this).off("click").on("click", function() {
        if ($(this).hasClass("playing")) {
          $(this).removeClass("playing");
          $($(this).data("video")).get(0).pause();
        } else {
          $(this).addClass("playing");
          $($(this).data("video")).get(0).play();
        }
      });

      const btn_player = $(this);
  
      $($(this).data("video")).off("ended").on("ended", function() {
        $(btn_player).removeClass("playing");
        this.currentTime = 0;
      });
    });
  }
})($);

(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.querySelectorAll("input[data-cf-pwd]").forEach(function (el) {
          if(form.querySelector(el.getAttribute("data-cf-pwd")).value != el.value) {
            event.preventDefault();
            event.stopPropagation();
          }
        });

        form.classList.add('was-validated')
      }, false);

      form.querySelectorAll("input[data-cf-pwd]").forEach(function (el) {
        el.addEventListener('keyup', function (event) {
          if (!el.value || form.querySelector(el.getAttribute("data-cf-pwd")).value != el.value) {
            el.classList.add("is-invalid");
            el.classList.remove("is-valid");
            el.setCustomValidity("Invalid field.");
          } else {
            el.classList.remove("is-invalid");
            el.classList.add("is-valid");
            el.setCustomValidity("");
          }
        });
        form.querySelector(el.getAttribute("data-cf-pwd")).addEventListener('keyup', function (event) {
          if (!el.value || form.querySelector(el.getAttribute("data-cf-pwd")).value != el.value) {
            el.classList.add("is-invalid");
            el.classList.remove("is-valid");
            el.setCustomValidity("Invalid field.");
          } else {
            el.classList.remove("is-invalid");
            el.classList.add("is-valid");
            el.setCustomValidity("");
          }
        });
      });
    });
})();

window.addEventListener('load', () => {
  try {
    let url = window.location.href.split('#').pop();
    document.querySelector('#'+url).click();
  } catch {

  }
});