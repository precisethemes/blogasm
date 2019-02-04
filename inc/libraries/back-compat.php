<?php
/**
 * Blogasm back compat functionality
 *
 * Prevents Blogasm from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package Blogasm
 */

/**
 * Prevent switching to Blogasm on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Blogasm
 */
function blogasm_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'blogasm_upgrade_notice' );
}
add_action( 'after_switch_theme', 'blogasm_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Blogasm on WordPress versions prior to 4.7.
 *
 * @since Blogasm
 *
 * @global string $wp_version WordPress version.
 */
function blogasm_upgrade_notice() {
	$message = sprintf( __( 'Blogasm requires at least WordPress version 4.7 or later and PHP version 5.4.0 or later. You are running WordPress version %1$s and PHP version %2$s. Please upgrade and try again.', 'blogasm' ), $GLOBALS['wp_version'], PHP_VERSION );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Blogasm
 *
 * @global string $wp_version WordPress version.
 */
function blogasm_customize() {
	wp_die(
		sprintf(
			__( 'Blogasm requires at least WordPress version 4.7 or later and PHP version 5.4.0 or later. You are running WordPress version %1$s and PHP version %2$s. Please upgrade and try again.', 'blogasm' ),
			$GLOBALS['wp_version'],
            PHP_VERSION
		),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'blogasm_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Blogasm
 *
 * @global string $wp_version WordPress version.
 */
function blogasm_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Blogasm requires at least WordPress version 4.7 or later and PHP version 5.4.0 or later. You are running WordPress version %1$s and PHP version %2$s. Please upgrade and try again.', 'blogasm' ), $GLOBALS['wp_version'], PHP_VERSION ) );
	}
}
add_action( 'template_redirect', 'blogasm_preview' );
