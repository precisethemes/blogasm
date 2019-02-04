<?php
/**
 * Theme Customizer Global Panel
 *
 * @package Blogasm
 */

if ( ! function_exists( 'blogasm_customizer_sidebar_controls_init' ) ) :

    function blogasm_customizer_sidebar_controls_init()
    {
        /*--------------------------------------------------------------
        # Panel
        --------------------------------------------------------------*/
        Kirki::add_panel('blogasm_sidebar_settings_panel', array(
            'priority' => 122,
            'title' => esc_html__('Sidebar Settings', 'blogasm'),
        ));

        /*--------------------------------------------------------------
        # Sections
        --------------------------------------------------------------*/
        $sections['blogasm_sidebar_section'] = array(esc_attr__('Sidebar', 'blogasm'), '');
        $sections['blogasm_sidebar_spacing_section'] = array(esc_attr__('Spacing', 'blogasm'), '');
        $sections['blogasm_sidebar_typography_section'] = array(esc_attr__('Typography', 'blogasm'), '');

        foreach ($sections as $section_id => $section) {
            $section_args = array(
                'title' => $section[0],
                'description' => $section[1],
                'panel' => 'blogasm_sidebar_settings_panel',
            );
            if (isset($section[2])) {
                $section_args['type'] = $section[2];
            }
            Kirki::add_section($section_id, $section_args);
        }

        /*--------------------------------------------------------------
        # Sidebar Layout
        --------------------------------------------------------------*/
        blogasm_add_field(
            array(
                'type' => 'radio-image',
                'settings' => 'blogasm_sidebar_layout',
                'label' => esc_html__('Layout', 'blogasm'),
                'description' => esc_html__('This sidebar will be reflected in whole site blog, archives, categories, tags, authors and search result page.', 'blogasm'),
                'section' => 'blogasm_sidebar_section',
                'default' => 'right-sidebar',
                'choices' => array(
                    'full-width' => BLOGASM_THEME_URI . '/assets/back-end/images/sidebar/no-sidebar.svg',
                    'left-sidebar' => BLOGASM_THEME_URI . '/assets/back-end/images/sidebar/left-sidebar.svg',
                    'right-sidebar' => BLOGASM_THEME_URI . '/assets/back-end/images/sidebar/right-sidebar.svg',
                ),
            )
        );
    }

endif;
add_action( 'init', 'blogasm_customizer_sidebar_controls_init', 999 );
