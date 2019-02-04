<?php
/**
 * Plugin recommendation
 *
 * @package Blogasm
 */

// Load TGM library.
require BLOGASM_THEME_DIR . '/inc/libraries/tgm/class-tgm-plugin-activation.php';

if ( ! function_exists( 'blogasm_register_recommended_plugins' ) ) :

	/**
	 * Register recommended plugins.
	 *
	 * @since 1.0.3
	 */
	function blogasm_register_recommended_plugins() {
        $plugins = array(
            array(
                'name'     => esc_html__( 'One Click Demo Importer', 'blogasm' ),
                'slug'     => 'one-click-demo-import',
                'required' => false,
            ),
        );

        $config = array();

        tgmpa( $plugins, $config );
	}

endif;

add_action( 'tgmpa_register', 'blogasm_register_recommended_plugins' );
