<?php
/**
 * Theme Customizer Post Panel
 *
 * @package Blogasm
 */

if ( ! function_exists( 'blogasm_customizer_footer_controls_init' ) ) :

    function blogasm_customizer_footer_controls_init() {
        /*--------------------------------------------------------------
        # Panel
        --------------------------------------------------------------*/
        Kirki::add_panel( 'blogasm_footer_panel', array(
            'priority'      => 126,
            'title'         => esc_html__( 'Footer', 'blogasm' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections = array(
            'blogasm_footer_widgets_section'      => array( esc_attr__( 'Widgets', 'blogasm' ), '' ),
        );
        foreach ( $sections as $section_id => $section ) {
            $section_args = array(
                'title'       => $section[0],
                'description' => $section[1],
                'panel'       => 'blogasm_footer_panel',
            );
            if ( isset( $section[2] ) ) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section( $section_id, $section_args );
        }

        /*--------------------------------------------------------------
        # Footer Widgets: Enable
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'          => 'toggle',
                'settings'      => 'blogasm_footer_widget_area_activate',
                'label'         => esc_html__( 'Enable', 'blogasm' ),
                'description'   => esc_html__( 'Enable it to display Footer Widget Area on all Pages.', 'blogasm' ),
                'section'       => 'blogasm_footer_widgets_section',
                'default'       => 1,
                'partial_refresh'   => array(
                    'blogasm_footer_widget_area_activate'   => array(
                        'selector'                          => '.site-footer .footer-widgets',
                        'render_callback'                   => '__return_false',
                    ),
                ),
            )
        );

        /*--------------------------------------------------------------
        # Footer Widgets: Background Overlay Color
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'        => 'color',
                'label'       => esc_html__( 'Background Overlay', 'blogasm' ),
                'settings'    => 'blogasm_footer_widget_section_bg_color',
                'section'     => 'blogasm_footer_widgets_section',
                'default'     => 'rgba(0,0,0,0.01)',
                'choices'     => array(
                    'alpha' => true,
                ),
                'transport' => 'postMessage',
                'js_vars'   => array(
                    array(
                        'element'  => array( '.footer-widgets::before' ),
                        'property' => 'background-color',
                    )
                ),
                'output'   => array(
                    array(
                        'element'  => array( '.footer-widgets::before' ),
                        'property' => 'background-color',
                    )
                ),
            )
        );
    }

endif;
add_action( 'init', 'blogasm_customizer_footer_controls_init', 999 );
