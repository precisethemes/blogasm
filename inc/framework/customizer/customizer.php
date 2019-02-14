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
Kirki::add_config( 'blogasm_config', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'theme_mod',
) );

/**
 * A proxy function. Automatically passes-on the config-id.
 *
 * @param array $args The field arguments.
 */
function blogasm_add_field( $args ) {
    Kirki::add_field( 'blogasm_config', $args );
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

    /**
     * Upsell customizer section.
     *
     * @since  1.0.4
     * @access public
     */
    class Blogasm_Upsell_Section extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.4
         * @access public
         * @var    string
         */
        public $type = 'upsell';

        /**
         * Custom button text to output.
         *
         * @since  1.0.4
         * @access public
         * @var    string
         */
        public $pro_text = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.4
         * @access public
         * @var    string
         */
        public $pro_url = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.4
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();

            $json['pro_text'] = $this->pro_text;
            $json['pro_url']  = esc_url( $this->pro_url );

            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.4
         * @access public
         * @return void
         */
        protected function render_template() { ?>

            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 10px 10px 20px; background: #dce6f6 !important;">
                    {{ data.title }}

                    <# if ( data.pro_text && data.pro_url ) { #>
                    <a href="{{ data.pro_url }}" class="button button-primary alignright" target="_blank">{{ data.pro_text }}</a>
                    <# } #>
                </h3>
            </li>
        <?php }
    }

    $wp_customize->register_section_type( 'Blogasm_Upsell_Section' );

    // Upsell section.
    $wp_customize->add_section(
        new Blogasm_Upsell_Section( $wp_customize, 'custom_theme_upsell',
            array(
                'title'    => esc_html__( 'Need More Options?', 'blogasm' ),
                'pro_text' => esc_html__( 'Buy PRO Version', 'blogasm' ),
                'pro_url'  => esc_url( 'https://precisethemes.com/wordpress-theme/blogasm-pro/' ),
                'priority' => 1,
            )
        )
    );

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
