<?php
/**
 * Theme Customizer Blog Panel
 *
 * @package Blogasm
 */

if ( ! function_exists( 'blogasm_customizer_blog_controls_init' ) ) :

    function blogasm_customizer_blog_controls_init() {
        /*--------------------------------------------------------------
        # Panel
        --------------------------------------------------------------*/
        Kirki::add_panel( 'blogasm_archive_panel', array(
            'priority'      => 122,
            'title'         => esc_html__( 'Archive/Blog Settings', 'blogasm' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections = array('blogasm_archive_sidebar_section'              => array( esc_attr__( 'Sidebar', 'blogasm' ), '' ) );

        foreach ( $sections as $section_id => $section ) {
            $section_args = array(
                'title'       => $section[0],
                'description' => $section[1],
                'panel'       => 'blogasm_archive_panel',
            );
            if ( isset( $section[2] ) ) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section( $section_id, $section_args );
        }

        /*--------------------------------------------------------------
        # Archive/Blog Sidebar Layout
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'radio-image',
                'settings'    => 'blogasm_archive_sidebar_layout',
                'label'       => esc_html__( 'Sidebar Layout', 'blogasm' ),
                'description' => esc_html__( 'Default layout is inherit from customizer -> sidebar settings -> sidebar. Assign new default layout for all archive pages.','blogasm' ),
                'section'     => 'blogasm_archive_sidebar_section',
                'default'     => 'full-width',
                'choices'     => array(
                    'default'           => BLOGASM_THEME_URI . '/assets/back-end/images/sidebar/default-sidebar.svg',
                    'left-sidebar'      => BLOGASM_THEME_URI . '/assets/back-end/images/sidebar/left-sidebar.svg',
                    'full-width'        => BLOGASM_THEME_URI . '/assets/back-end/images/sidebar/no-sidebar.svg',
                    'right-sidebar'     => BLOGASM_THEME_URI . '/assets/back-end/images/sidebar/right-sidebar.svg',

                ),
            )
        );


    }

endif;
add_action( 'init', 'blogasm_customizer_blog_controls_init', 999 );
