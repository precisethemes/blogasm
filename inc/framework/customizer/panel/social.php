<?php
/**
 * Theme Customizer Social Panel
 *
 * @package Blogasm
 */

if ( ! function_exists( 'blogasm_customizer_social_controls_init' ) ) :

    function blogasm_customizer_social_controls_init() {
        /*--------------------------------------------------------------
        # Social Panel
        --------------------------------------------------------------*/
        Kirki::add_panel( 'blogasm_social_panel', array(
            'priority'      => 102,
            'title'         => esc_html__( 'Social', 'blogasm' ),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections = array(
            'blogasm_social_profile_section'      => array( esc_attr__( 'Social Profiles', 'blogasm' ), '' ),
        );
        foreach ( $sections as $section_id => $section ) {
            $section_args = array(
                'title'       => $section[0],
                'description' => $section[1],
                'panel'       => 'blogasm_social_panel',
            );
            if ( isset( $section[2] ) ) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section( $section_id, $section_args );
        }

        /*--------------------------------------------------------------
        # Repeatable Social Profile Setting & Control
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type'                  => 'repeater',
                'label'                 => esc_html__( 'Add Social Profile', 'blogasm' ),
                'description'           => esc_html__( 'Drag & Drop items to re-arrange order of appearance.', 'blogasm' ),
                'section'               => 'blogasm_social_profile_section',
                'row_label'             => array(
                    'type'              => 'field',
                    'value'             => esc_html__('Social', 'blogasm' ),
                    'field'             => 'social_name',
                ),
                'settings'              => 'blogasm_social_repeatable_social_profiles',
                'default'               => array(
                    array(
                        'social_name'   => esc_html__( 'Facebook', 'blogasm' ),
                        'social_url'    => 'https://facebook.com/',
                        'social_icon'   => 'fa-facebook',
                        'social_image'  => '',

                    ),
                ),
                'fields'                => array(
                    'social_name'       => array(
                        'type'          => 'text',
                        'label'         => esc_html__( 'Profile Name', 'blogasm' ),
                        'default'       => '',
                    ),
                    'social_url'        => array(
                        'type'          => 'text',
                        'label'         => esc_html__( 'URL', 'blogasm' ),
                        'default'       => '',
                    ),
                    'social_icon'       => array(
                        'label'         => esc_html__( 'Icon', 'blogasm' ),
                        'type'          => 'select',
                        'default'       => 'fa-facebook',
                        'choices'       => blogasm_social_profiles()
                    ),
                    'social_image'      => array(
                        'type'          => 'image',
                        'label'         => esc_html__( 'Custom Icon', 'blogasm' ),
                        'default'       => '',
                    ),
                ),
            )
        );

    }
endif;
add_action( 'init', 'blogasm_customizer_social_controls_init', 999 );
