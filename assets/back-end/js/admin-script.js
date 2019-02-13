/*!
 Project   : Blogasm WordPress Theme
 Purpose   : Admin Area Js
 Author    : precisethemes
 Theme URI : https://precisethemes.com/
 */
/**
 * File admin-script.js.
 *
 * Theme Admin( Dashboard ) enhancements for a better user experience.
 *
 * @package Blogasm_Pro
 */

( function( $ ) {

    "use strict";

    // Welcome Page Tabs
    $('ul.blogasm-welcome-tab-nav li').on( 'click', function (e) {
        window.localStorage.setItem('active_welcome_tab', $(e.target).data('tab'));
        var about_tab_id = $(this).data('tab');
        $('ul.blogasm-welcome-tab-nav li').removeClass('active');
        $('.blogasm-welcome-section').removeClass('active');

        $(this).addClass('active');
        $("#" + about_tab_id).addClass('active');
    });

    // Store tab data value in local storage
    var active_welcome_tab = window.localStorage.getItem('active_welcome_tab');

    // Add Active Class in both tab and content with browser refresh
    if (active_welcome_tab) {
        $('ul.blogasm-welcome-tab-nav li').removeClass('active');
        $('.blogasm-welcome-section').removeClass('active');
        $('ul.blogasm-welcome-tab-nav li[data-tab="'+active_welcome_tab+'"]').addClass('active');
        $("#"+active_welcome_tab).addClass('active');
        localStorage.removeItem('active_welcome_tab');
    } else {
        $('ul.blogasm-welcome-tab-nav li[data-tab="getting_started"]').addClass('active');
        $("#getting_started").addClass('active');
    }

} ) ( jQuery );