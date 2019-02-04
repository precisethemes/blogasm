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

            // OCDI before widget import
            add_filter( 'pt-ocdi/before_widgets_import', array( $this, 'ocdi_before_widgets_import' ) );

            // Reset Wizard
            add_action( 'admin_init', array( $this, 'reset_wizard_actions' ) );

        }


        /**
         * Reset actions when a reset button is clicked.
         */
        public function reset_wizard_actions() {
            global $wpdb, $current_user;

            if ( ! empty( $_GET['do_reset_wordpress'] ) ) {

                require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

                $template     = get_option( 'template' );
                $blogname     = get_option( 'blogname' );
                $admin_email  = get_option( 'admin_email' );
                $blog_public  = get_option( 'blog_public' );

                if ( $current_user->user_login != 'admin' ) {
                    $user = get_user_by( 'login', 'admin' );
                }

                if ( empty( $user->user_level ) || $user->user_level < 10 ) {
                    $user = $current_user;
                }

                // Drop tables.
                $drop_tables = $wpdb->get_col( sprintf( "SHOW TABLES LIKE '%s%%'", str_replace( '_', '\_', $wpdb->prefix ) ) );
                foreach ( $drop_tables as $table ) {
                    $wpdb->query( "DROP TABLE IF EXISTS $table" );
                }

                // Installs the site.
                $result = wp_install( $blogname, $user->user_login, $user->user_email, $blog_public );

                // Updates the user password with a old one.
                $wpdb->update( $wpdb->users, array( 'user_pass' => $user->user_pass, 'user_activation_key' => '' ), array( 'ID' => $result['user_id'] ) );

                // Set up the Password change nag.
                $default_password_nag = get_user_option( 'default_password_nag', $result['user_id'] );
                if ( $default_password_nag ) {
                    update_user_option( $result['user_id'], 'default_password_nag', false, true );
                }

                // Switch current theme.
                $current_theme = wp_get_theme( $template );
                if ( $current_theme->exists() ) {
                    switch_theme( $template );
                }

                // Activate required plugins.
                activate_plugin( 'one-click-demo-import/one-click-demo-import.php' );

                // Update the cookies.
                wp_clear_auth_cookie();
                wp_set_auth_cookie( $result['user_id'] );

                // Redirect to demo importer page to display reset success notice.
                wp_safe_redirect( admin_url( 'themes.php?page=pt-one-click-demo-import' ) );
                exit();
            }
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
        public function additional_intro_text( $intro, $new_array = array() ) {

            $demo_activated_id  = get_option( 'blogasm_demo_install_slug' );
            $intro_content      = isset( $this->config['intro_content'] ) ? $this->config['intro_content'] : '';
            $demos              = isset( $this->config['ocdi'] ) ? $this->config['ocdi'] : array();

            if ( ! empty( $demos ) ) {
                foreach ( $demos as $key => $value ) {
                    $new_array[] = $value['import_file_name'];
                }
            }

            if ( ! empty( $intro_content ) ) {
                $message  = '<div class="ocdi__intro-text">';
                $message .= wp_kses_post( wpautop( $intro_content ) );
                if ( $demo_activated_id && in_array( $demo_activated_id, array_keys( $new_array ) ) ) {
                    $message .= sprintf(
                    /* translators: %s: Name of current post */
                        __( '<p class="submit"><a href="%s" class="button button-primary blogasm-reset-default">Run the Reset Wizard</a> &#8211; If you need to reset the WordPress back to default again :)<p>', 'blogasm' ),
                        add_query_arg( 'do_reset_wordpress', 'true', esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import' ) ) )
                    );
                }

                $message .= '</div><!-- .ocdi__intro-text -->';
                $intro   .= $message;
            }

            return $intro;
        }

        /**
         * Reset active widget for sidebar
         *
         * @since 0.2.0
         *
         * @param string $intro Intro.
         * @return string Modified intro.
         */
        public function ocdi_before_widgets_import() {

            $sidebars_widgets = wp_get_sidebars_widgets();
            // Reset active widgets.
            foreach ( $sidebars_widgets as $key => $widgets ) {
                $sidebars_widgets[ $key ] = array();
            }

            wp_set_sidebars_widgets( $sidebars_widgets );

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

            // Update option for the demo successful
            update_option( 'blogasm_demo_install_slug', sanitize_text_field( $selected_import['import_file_name'] ) );

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



