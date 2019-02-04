<?php
/**
 * Envy Blog Customizer General Panel
 *
 * @package Blogasm
 */

if ( ! function_exists( 'blogasm_customizer_typography_controls_init' ) ) :

    function blogasm_customizer_typography_controls_init() {
        /*--------------------------------------------------------------
        # Typography Panel
        --------------------------------------------------------------*/
        Kirki::add_panel( 'blogasm_typography_panel', array(
            'priority'      => 101,
            'title'         => esc_html__( 'Typography', 'blogasm' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections = array(
            'blogasm_typography_body_section'             => array( esc_attr__( 'Body', 'blogasm' ), '' ),
            'blogasm_typography_logo_section'             => array( esc_attr__( 'Logo', 'blogasm' ), '' ),
            'blogasm_typography_main_menu_section'        => array( esc_attr__( 'Main Menu', 'blogasm' ), '' ),
            'blogasm_typography_heading_h1_section'       => array( esc_attr__( 'H1', 'blogasm' ), '' ),
            'blogasm_typography_heading_h2_section'       => array( esc_attr__( 'H2', 'blogasm' ), '' ),
            'blogasm_typography_heading_h3_section'       => array( esc_attr__( 'H3', 'blogasm' ), '' ),
            'blogasm_typography_heading_h4_section'       => array( esc_attr__( 'H4', 'blogasm' ), '' ),
            'blogasm_typography_heading_h5_section'       => array( esc_attr__( 'H5', 'blogasm' ), '' ),
            'blogasm_typography_heading_h6_section'       => array( esc_attr__( 'H6', 'blogasm' ), '' ),
            'blogasm_typography_post_meta_section'        => array( esc_attr__( 'Post Meta', 'blogasm' ), '' ),
            'blogasm_typography_widgets_title_section'    => array( esc_attr__( 'Widget Title', 'blogasm' ), '' ),
        );
        foreach ( $sections as $section_id => $section ) {
            $section_args = array(
                'title'       => $section[0],
                'description' => $section[1],
                'panel'       => 'blogasm_typography_panel',
            );
            if ( isset( $section[2] ) ) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section( $section_id, $section_args );
        }

        /*--------------------------------------------------------------
        # Body Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_body',
                'label'       => esc_attr__( 'Body', 'blogasm' ),
                'section'     => 'blogasm_typography_body_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => 'body',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Site Title Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_site_title',
                'label'       => esc_attr__( 'Site Title', 'blogasm' ),
                'section'     => 'blogasm_typography_logo_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => '.site-branding .site-title',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Tagline Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_site_tagline',
                'label'       => esc_attr__( 'Site Tagline', 'blogasm' ),
                'section'     => 'blogasm_typography_logo_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => '.site-branding p',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Main Menu Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_main_menu',
                'label'       => esc_attr__( 'Main Menu', 'blogasm' ),
                'section'     => 'blogasm_typography_main_menu_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => '.main-navigation ul li',
                    ),
                ),
            )
        );


        /*--------------------------------------------------------------
        # H1 Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_heading_h1',
                'label'       => esc_attr__( 'H1', 'blogasm' ),
                'section'     => 'blogasm_typography_heading_h1_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => 'h1',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # H2 Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_heading_h2',
                'label'       => esc_attr__( 'H2', 'blogasm' ),
                'section'     => 'blogasm_typography_heading_h2_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => '500',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => 'h2',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # H3 Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_heading_h3',
                'label'       => esc_attr__( 'H3', 'blogasm' ),
                'section'     => 'blogasm_typography_heading_h3_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => 'h3',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # H4 Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_heading_h4',
                'label'       => esc_attr__( 'H4', 'blogasm' ),
                'section'     => 'blogasm_typography_heading_h4_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => 'h4',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # H5 Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_heading_h5',
                'label'       => esc_attr__( 'H5', 'blogasm' ),
                'section'     => 'blogasm_typography_heading_h5_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => 'h5',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # H6 Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_heading_h6',
                'label'       => esc_attr__( 'H6', 'blogasm' ),
                'section'     => 'blogasm_typography_heading_h6_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => 'h6',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Post Meta Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_post_meta',
                'label'       => esc_attr__( 'Post Meta', 'blogasm' ),
                'section'     => 'blogasm_typography_post_meta_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => '.entry-meta label',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Widget Title Typography & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'typography',
                'settings'    => 'blogasm_typography_widgets_title',
                'label'       => esc_attr__( 'Widget Title', 'blogasm' ),
                'section'     => 'blogasm_typography_widgets_title_section',
                'default'     => array(
                    'font-family'    => 'Roboto',
                    'variant'        => 'regular',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'output'      => array(
                    array(
                        'element' => '.widget-title',
                    ),
                ),
            )
        );
    }
endif;
add_action( 'init', 'blogasm_customizer_typography_controls_init', 999 );
