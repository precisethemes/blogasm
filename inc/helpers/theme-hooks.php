<?php
/**
 * Functions hooked to custom hook
 *
 * @package Blogasm
 */

/*----------------------------------------------------------------------
# Header
-------------------------------------------------------------------------*/

if ( ! function_exists( 'blogasm_add_header' ) ) :

    /**
     * Header Layout
     *
     * @since 0.1.0
     */
    function blogasm_add_header() { ?>

        <div class="nav-bar bg-white nav-bar-setting transition-35s">
            <div class="outer-container overflow-visible">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <?php get_template_part( 'template-parts/header/header-layout', '1' ); ?>
                    </div><!-- .row -->
                </div><!-- .container-fluid -->
            </div><!-- .outer-container -->
        </div><!-- .nav-bar -->

    <?php }

endif;
add_action( 'blogasm_action_header', 'blogasm_add_header', 20 );

/*----------------------------------------------------------------------
# Sidebar hook
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_add_sidebar' ) ) :

    /**
     * Add Sidebar
     *
     * @since 0.1.0
     */
    function blogasm_add_sidebar() {

        get_sidebar(); // sidebar area

    }

endif;

add_action( 'blogasm_action_sidebar', 'blogasm_add_sidebar', 10 );


/*----------------------------------------------------------------------
# Footer widget hook / Footer bar hook
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_add_footer_widgets' ) ) :

    /**
     * Add footer widgets
     *
     * @since 0.1.0
     */
    function blogasm_add_footer_widgets() {

        get_template_part( 'template-parts/footer/footer', 'widget' ); // Footer Widget Area

    }

endif;

if ( ! function_exists( 'blogasm_add_footer_bar' ) ) :

    /**
     * Add footer bar
     *
     * @since 0.1.0
     */
    function blogasm_add_footer_bar() {

        get_template_part( 'template-parts/footer/footer', 'bar' ); // Footer Bar

    }

endif;

add_action( 'blogasm_action_footer', 'blogasm_add_footer_widgets', 10 );
add_action( 'blogasm_action_footer', 'blogasm_add_footer_bar', 20 );


/*----------------------------------------------------------------------
# Post navigation hook
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_add_posts_pagination' ) ) :

    /**
     * Add custom posts pagination
     *
     * @since 0.1.0
     */
    function blogasm_add_posts_pagination() {

        the_posts_pagination();

    }

endif;

add_action( 'blogasm_action_posts_pagination', 'blogasm_add_posts_pagination', 10 );
