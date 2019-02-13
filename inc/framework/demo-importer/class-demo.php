<?php
/**
 * Demo class
 *
 * @package Blogasm
 */

if ( ! class_exists( 'Blogasm_Demo' ) ) {

    /**
     * Main class.
     *
     * @since 0.2.0
     */
    class Blogasm_Demo {

        /**
         * Singleton instance of Blogasm_Demo.
         *
         * @var Blogasm_Demo $instance Blogasm_Demo instance.
         */
        private static $instance;

        /**
         * Configuration.
         *
         * @var array $config Configuration.
         */
        private $config;

        /**
         * Main Blogasm_Demo instance.
         *
         * @since 0.2.0
         *
         * @param array $config Configuration array.
         */
        public static function init( $config ) {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogasm_Demo ) ) {
                self::$instance = new Blogasm_Demo();
                if ( ! empty( $config ) && is_array( $config ) ) {
                    self::$instance->config = $config;
                    self::$instance->setup_actions();
                }
            }
        }

        /**
         * Setup actions.
         *
         * @since 0.2.0
         */
        public function setup_actions() {

            // Disable branding.
            add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

            // OCDI import files.
            add_filter( 'pt-ocdi/import_files', array( $this, 'ocdi_files' ), 99 );

            // OCDI after import.
            add_action( 'pt-ocdi/after_import', array( $this, 'ocdi_after_import' ) );

            // OCDI additional intro text.
            add_filter( 'pt-ocdi/plugin_intro_text', array( $this, 'additional_intro_text' ) );


        }

        /**
         * OCDI files.
         *
         * @since 0.2.0
         */
        public function ocdi_files() {

            $ocdi = isset( $this->config['ocdi'] ) ? $this->config['ocdi'] : array();
            return $ocdi;
        }

        /**
         * Intro message.
         *
         * @since 0.2.0
         *
         * @param string $intro Intro.
         * @return string Modified intro.
         */
        public function additional_intro_text( $intro ) {

            $intro_content = isset( $this->config['intro_content'] ) ? $this->config['intro_content'] : '';

            if ( ! empty( $intro_content ) ) {
                $message  = '<div class="ocdi__intro-text">';
                $message .= wp_kses_post( wpautop( $intro_content ) );
                $message .= '</div><!-- .ocdi__intro-text -->';
                $intro   .= $message;
            }
            return $intro;
        }


        /**
         * OCDI after import.
         *
         * @since 0.2.0
         */
        public function ocdi_after_import( $selected_import ) {

            // Set static front page.
            $static_page = isset( $this->config['static_page'] ) ? $this->config['static_page'] : '';
            $posts_page  = isset( $this->config['posts_page'] ) ? $this->config['posts_page'] : '';

            $pages = array();

            if ( $static_page ) {
                $pages['page_on_front'] = $static_page;
            }

            if ( $posts_page ) {
                $pages['page_for_posts'] = $posts_page;
            }

            if ( ! empty( $pages ) ) {
                foreach ( $pages as $option_key => $slug ) {
                    $result = get_page_by_path( $slug );
                    if ( $result ) {
                        if ( is_array( $result ) ) {
                            $object = array_shift( $result );
                        } else {
                            $object = $result;
                        }

                        update_option( $option_key, $object->ID );
                    }
                }

                update_option( 'show_on_front', 'page' );
            }

            // Set menu locations.
            $menu_details = isset( $this->config['menu_locations'] ) ? $this->config['menu_locations'] : array();
            if ( ! empty( $menu_details ) ) {
                $nav_settings  = array();
                $current_menus = wp_get_nav_menus();

                if ( ! empty( $current_menus ) && ! is_wp_error( $current_menus ) ) {
                    foreach ( $current_menus as $menu ) {
                        foreach ( $menu_details as $location => $menu_slug ) {
                            if ( $menu->slug === $menu_slug ) {
                                $nav_settings[ $location ] = $menu->term_id;
                            }
                        }
                    }
                }

                set_theme_mod( 'nav_menu_locations', $nav_settings );
            }

            // Update default post as draft
            $post_id = 1;
            $post_type = get_post_type( $post_id );

            if ( 'post' == $post_type ) {

                //add the default category with id
                $data = array(
                    'ID'            => $post_id,
                    'post_status'   => 'draft',
                );

                wp_update_post( $data );
            }

            if ( 'Demo 1' === $selected_import['import_file_name'] ) {
                // Set posts per page.
                update_option( 'posts_per_page', 15 );
            }
        }
    }

} // End if().

/**
 * Demo configuration
 *
 * @package Blogasm
 */

$config = array(
    'menu_locations' => array(
        'primary-menu'      => 'primary-menu',
        'secondary-menu'    => 'secondary-menu',
    ),
    'ocdi'           => array(

        array(
            'import_file_name'             => 'Demo 1',
            //'categories'                   => array( 'Minimalist' ),
            'local_import_file'            => BLOGASM_THEME_DIR . '/inc/framework/demo-importer/demo/demo-1/content.xml',
            'local_import_widget_file'     => BLOGASM_THEME_DIR . '/inc/framework/demo-importer/demo/demo-1/widget.wie',
            'local_import_customizer_file' => BLOGASM_THEME_DIR . '/inc/framework/demo-importer/demo/demo-1/customizer.dat',
            'import_preview_image_url'     => BLOGASM_THEME_URI . '/inc/framework/demo-importer/demo/demo-1/screenshot.jpg',
            'preview_url'                  => 'https://precisethemes.com/demo/blogasm-free/',
        ),
    ),

    'intro_content'  => esc_html__( 'NOTE: In demo import, category selection could be omitted in old (non-fresh) WordPress setup. After import is complete, please go to Widgets admin page under Appearance menu and select the appropriate category in the widgets.', 'blogasm' ),
);

Blogasm_Demo::init( apply_filters( 'blogasm_demo_filter', $config ) );



