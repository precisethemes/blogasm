<?php
/**
 * Theme Customizer Header Panel
 *
 * @package Blogasm
 */

if ( ! function_exists( 'blogasm_customizer_header_controls_init' ) ) :

    function blogasm_customizer_header_controls_init() {
        /*--------------------------------------------------------------
        # Panel Header
        --------------------------------------------------------------*/
        Kirki::add_panel( 'blogasm_header_panel', array(
            'priority'      => 2,
            'title'         => esc_html__( 'Header', 'blogasm' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections = array(
            'title_tagline'                               => array( esc_attr__( 'Site Title & Tagline', 'blogasm' ), '' ),
            'blogasm_header_social_profile_section'       => array( esc_attr__( 'Social Profile', 'blogasm' ), '' ),
            'blogasm_header_search_section'               => array( esc_attr__( 'Header Search', 'blogasm' ), '' ),

        );

        foreach ( $sections as $section_id => $section ) {
            $section_args = array(
                'title'       => $section[0],
                'description' => $section[1],
                'panel'       => 'blogasm_header_panel',
            );

            if ( isset( $section[2] ) ) {
                $section_args['type'] = $section[2];
            }

            Kirki::add_section( $section_id, $section_args );
        }


        /*--------------------------------------------------------------
        # Site Title Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'          => 'toggle',
                'settings'      => 'blogasm_header_site_title_visible',
                'section'       => 'title_tagline',
                'label'         => esc_html__( 'Display Site Title', 'blogasm' ),
                'default'       => '1',
            )
        );

        /*--------------------------------------------------------------
        # Tagline Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'              => 'toggle',
                'label'             => esc_html__( 'Display Tagline', 'blogasm' ),
                'settings'          => 'blogasm_header_site_tagline_visible',
                'section'           => 'title_tagline',
            )
        );

        /*------------------------------------------------------
        # Header Social
        -------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'              => 'toggle',
                'settings'          => 'blogasm_header_social_profile_enable',
                'section'           => 'blogasm_header_social_profile_section',
                'label'             => esc_html__( 'Enable', 'blogasm' ),
                'description'       => esc_html__( 'Enable Social Profiles.', 'blogasm' ),
                'default'           => '1',
            )
        );

        /*------------------------------------------------------
       #  Header Social: Note
       -------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'              => 'custom',
                'settings'          => 'blogasm_header_social_profile_note',
                'section'           => 'blogasm_header_social_profile_section',
                'label'             => esc_html__( 'Social Profiles', 'blogasm' ),
                'description'       => esc_html__( 'To set Social Profiles, go to customizer -> Social -> Social Profiles and add your required profiles.', 'blogasm' ),
            )
        );

        /*--------------------------------------------------------------
        # Enable Search Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'              => 'toggle',
                'settings'          => 'blogasm_header_search_enable',
                'section'           => 'blogasm_header_search_section',
                'label'             => esc_html__( 'Enable', 'blogasm' ),
                'default'           => '1',
                'partial_refresh'   => array(
                    'blogasm_header_search_enable'    => array(
                        'selector'                  => '.header-search',
                        'render_callback'           => '__return_false',

                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Header Search Widgets Column Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'          => 'custom',
                'settings'      => 'blogasm_header_search_custom_blank',
                'label'         => esc_html__( 'Search Input', 'blogasm' ),
                'description'   => esc_html__( 'To add Search input, go to widgets(http://blogasm.local/wp-admin/widgets.php) and add "Search" widget to Search Popup Column 1.', 'blogasm' ),
                'section'       => 'blogasm_header_search_section',
            )
        );

        /*--------------------------------------------------------------
        # Header Search Background Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'      => 'color',
                'settings'  => 'blogasm_header_search_bg_color',
                'section'   => 'blogasm_header_search_section',
                'label'     => esc_html__( 'Background', 'blogasm' ),
                'default'   => 'rgba(255,255,255,1)',
                'choices'   => array(
                    'alpha' => true,
                ),
                'transport'     => 'postMessage',
                'js_vars'       => array(
                    array(
                        'element'   => array( '.search-popup' ),
                        'function'  => 'css',
                        'property'  => 'background'
                    )
                ),
                'output'        => array(
                    array(
                        'element'   => array( '.search-popup' ),
                        'function'  => 'css',
                        'property'  => 'background'
                    )
                )
            )
        );

    }
endif;
add_action( 'init', 'blogasm_customizer_header_controls_init', 999 );
