/*!
 Project   : Blogasm WordPress Theme
 Purpose   : Meta Box Area Js
 Author    : precisethemes
 Theme URI : https://precisethemes.com/
 */
/**
 * File metabox-script.js.
 *
 * Theme Post/Page Meta Box enhancements for a better user experience.
 *
 * @package Blogasm
 */
( function( $ ) {

    "use strict";

    // Welcome Page Tabs
    $('ul.metabox-tab-nav li').on( 'click', function (e) {
        window.localStorage.setItem('active_metabox_tab', $(e.target).data('tab'));
        var tab_id = $(this).data('tab');
        $('ul.metabox-tab-nav li').removeClass('active');
        $('.setting-tab').removeClass('active');

        $(this).addClass('active');
        $("#" + tab_id).addClass('active');
    });

    // Store tab data value in local storage
    var active_metabox_tab = window.localStorage.getItem('active_metabox_tab');

    // Add Active Class in both tab and content with browser refresh
    if (active_metabox_tab) {
        $('ul.metabox-tab-nav li').removeClass('active');
        $('.setting-tab').removeClass('active');
        $('ul.metabox-tab-nav li[data-tab="'+active_metabox_tab+'"]').addClass('active');
        $("#"+active_metabox_tab).addClass('active');
        localStorage.removeItem('active_metabox_tab');
    } else {
        $('ul.metabox-tab-nav li[data-tab="setting-tab-2"]').addClass('active');
        $("#setting-tab-2").addClass('active');
    }
    
} ) ( jQuery );
