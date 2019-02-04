<?php
/**
 * Theme Customizer General Panel
 *
 * @package Blogasm
 */

if ( ! function_exists( 'blogasm_customizer_general_controls_init' ) ) :

    function blogasm_customizer_general_controls_init() {
        /*--------------------------------------------------------------
        # Panel
        --------------------------------------------------------------*/
        Kirki::add_panel( 'blogasm_general_panel', array(
            'priority'  =>  2,
            'title'     =>  esc_html__( 'General Settings', 'blogasm' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections = array('blogasm_general_colors_section'    => array( esc_attr__( 'Colors', 'blogasm' ), '' ) );

        foreach ( $sections as $section_id => $section ) {
            $section_args = array(
                'title'       => $section[0],
                'description' => $section[1],
                'panel'       => 'blogasm_general_panel',
            );
            if ( isset( $section[2] ) ) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section( $section_id, $section_args );
        }

        /*--------------------------------------------------------------
        # Background Color
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'          => 'color',
                'label'         => esc_html__( 'Background Color', 'blogasm' ),
                'settings'      => 'blogasm_body_background_color',
                'section'       => 'blogasm_general_colors_section',
                'default'       => '#fff',
                'transport'     => 'postMessage',
                'js_vars'   => array(
                    array(
                        'element'       => array( 'body', '.archived-posts article.post-col.landscape-img.have-sep::before', '.archived-posts article.post-col.full-width-img.have-sep::before' ),
                        'property'      => 'background-color',
                    ),
                ),
                'output'   =>  array(
                    array(
                        'element'       => array( 'body', '.archived-posts article.post-col.landscape-img.have-sep::before', '.archived-posts article.post-col.full-width-img.have-sep::before' ),
                        'property'      => 'background-color',
                    ),
                ),
            )
        );

    }
endif;
add_action( 'init', 'blogasm_customizer_general_controls_init', 999 );
