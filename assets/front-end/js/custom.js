/* File skip-link-focus-fix */
( function() {
    var isIe = /(trident|msie)/i.test( navigator.userAgent );

    if ( isIe && document.getElementById && window.addEventListener ) {
        window.addEventListener( 'hashchange', function() {
            var id = location.hash.substring( 1 ),
                element;

            if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
                return;
            }

            element = document.getElementById( id );

            if ( element ) {
                if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
                    element.tabIndex = -1;
                }

                element.focus();
            }
        }, false );
    }
} )();

(function($) {
   'use strict';

    // Stop Scrolling
    $.fn.stopScrolling = function() {
        $('html').on('wheel.modal mousewheel.modal', function () {return false;});
        return this;
    };

    // Restore Scrolling
    $.fn.restoreScrolling = function() {
        $('html').off('wheel.modal mousewheel.modal');
        return this;
    };

    // Toggle Menu
    var bodyOverlay = $('.body-overlay');
    $( '.hamburger-menu' ).on( 'click', function() {
        bodyOverlay.addClass('is-active');
        $('.main-navigation').toggleClass('is-active');
        $(this).toggleClass('cross');
        $.fn.stopScrolling();
    });

    $( '.hamburger-menu.cross, .close-navigation' ).on( 'click', function() {
        $('.hamburger-menu').removeClass('cross');
        bodyOverlay.removeClass('is-active');
        $('.main-navigation').removeClass('is-active');
        $.fn.restoreScrolling();
    });

    // Header Search
    $('.header-search').on('click', function() {
        $('.search-popup').addClass('show');

        setTimeout(function(){
            $('.search-popup').find('.search-field').focus();
        }, 50);

        $.fn.stopScrolling();
    });

    $('.search-close, .slide-in-box-close').on('click', function() {
        $('.search-popup').removeClass('show');
        bodyOverlay.removeClass('is-active');
    });

    // Keyboard Esc
    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            $('.search-popup').removeClass('show');
            $('.hamburger-menu').removeClass('cross');
            bodyOverlay.removeClass('is-active');
            $('.main-navigation').removeClass('is-active');
            $('.header-social .social-profiles-section').removeClass('is-active');
            $.fn.restoreScrolling();
        }
    });

    // Restore onClick closeset
    $(document).on( 'click', function (e) {
        if ( $( e.target).closest( '.hamburger-menu,.main-navigation, .header-search .icon-search' ).length === 0 ) {
            bodyOverlay.removeClass('is-active');
            $('.main-navigation').removeClass('is-active');
            $('.hamburger-menu').removeClass('cross');
            $.fn.restoreScrolling();
        }
    });

    // Image Gallery
    $('.wp-block-gallery, .gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            tError: 'The image can not be loaded.',
            titleSrc: function(item) {
                return item.el.attr('title');
            }
        },
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300, // don't forget to change the duration also in CSS
            opener: function(element) {
                return element.find('img');
            }
        }
    });

    // Back to Top
    if ($('.back-to-top').length) {
        var scrollTrigger = 500, // px
            backToTop = function () {
                var scrollTop = $( window ).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('.back-to-top').addClass('show');
                } else {
                    $('.back-to-top').removeClass('show');
                }
            };
        backToTop();

        $(window).on('scroll', function() {
            backToTop();
        });

        $('.back-to-top').on('click', function(e) {
            e.preventDefault();
            $('html,body').animate( {
                scrollTop: 0
            }, 800);
        });
    }

})(jQuery);
