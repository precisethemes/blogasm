<?php
/**
 * Theme Customizer
 *
 * @package Blogasm
 */

/*--------------------------------------------------------------
# Configuration for Kirki Toolkit
--------------------------------------------------------------*/
function blogasm_kirki_configuration() {
    return array( 'url_path'     => BLOGASM_THEME_URI . '/inc/libraries/kirki/' );
}
add_filter( 'kirki/config', 'blogasm_kirki_configuration' );

/*--------------------------------------------------------------
# Blogasm Kirki Config
--------------------------------------------------------------*/
Kirki::add_config( 'blogasm-pro_config', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'theme_mod',
) );

/**
 * A proxy function. Automatically passes-on the config-id.
 *
 * @param array $args The field arguments.
 */
function blogasm_add_field( $args ) {
    Kirki::add_field( 'blogasm-pro_config', $args );
}

// Panels
require BLOGASM_THEME_DIR . '/inc/framework/customizer/panel/social.php';
require BLOGASM_THEME_DIR . '/inc/framework/customizer/panel/header.php';
require BLOGASM_THEME_DIR . '/inc/framework/customizer/panel/archive.php';
require BLOGASM_THEME_DIR . '/inc/framework/customizer/panel/sidebar.php';
require BLOGASM_THEME_DIR . '/inc/framework/customizer/panel/footer.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blogasm_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    // Remove
    $wp_customize->remove_control( 'display_header_text' );
    $wp_customize->remove_control( 'header_textcolor' );

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'blogasm_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'blogasm_customize_partial_blogdescription',
        ) );
    }
}
add_action( 'customize_register', 'blogasm_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blogasm_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blogasm_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blogasm_customize_preview_js() {

    $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    wp_enqueue_script( 'blogasm-customizer-preview', BLOGASM_THEME_URI . '/assets/back-end/js/customizer-preview'. $min .'.js', array( 'customize-preview' ), false, true );
}
add_action( 'customize_preview_init', 'blogasm_customize_preview_js' );
