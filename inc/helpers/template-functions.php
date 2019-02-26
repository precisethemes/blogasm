<?php
/**
 * Functions which enhance the theme by hooking into WordPress and Core theme Functions.
 *
 * @package Blogasm
 */

/*----------------------------------------------------------------------
# Exit if accessed directly
-------------------------------------------------------------------------*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*----------------------------------------------------------------------
# Adds custom classes to the array of body classes.
-------------------------------------------------------------------------*/
if ( !function_exists( 'blogasm_body_classes' ) ) {
    /**
     * @param array $classes Classes for the body element.
     * @return array
     */
    function blogasm_body_classes( $classes ) {

        // Adds a class of hfeed to non-singular pages.
        if ( ! is_singular() ) {
            $classes[] = 'hfeed';
        }

        return apply_filters( 'blogasm_body_classes', $classes );
    }
}
add_filter( 'body_class', 'blogasm_body_classes' );

/*----------------------------------------------------------------------
# Add a pingback url auto-discovery header for single posts, pages, or attachments.
-------------------------------------------------------------------------*/
if ( !function_exists( 'blogasm_pingback_header' ) ) {

    function blogasm_pingback_header() {
        if ( is_singular() && pings_open() ) {
            echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
        }
    }
}
add_action( 'wp_head', 'blogasm_pingback_header' );

/*----------------------------------------------------------------------
# Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
-------------------------------------------------------------------------*/
if ( !function_exists( 'page_menu_args' ) ) {
    function page_menu_args( $args ) {
        $args['show_home'] = true;
        return $args;
    };
}
add_filter( 'wp_page_menu_args', 'page_menu_args', 10, 1 );

/*----------------------------------------------------------------------
#  Returns correct ID
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_get_the_ID' ) ) {
    function blogasm_get_the_ID() {

        // Default value is empty
        $id = get_the_ID();

        // Blog Page
        if ( is_home() && !is_front_page() && $page_for_posts = get_option( 'page_for_posts' ) ) {
            $id = $page_for_posts;
        }

        // Apply filters and return
        return apply_filters( 'blogasm_post_id', absint( $id ) );

    }
}

/*----------------------------------------------------------------------
# Get custom permalink
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_get_permalink' ) ) :

    function blogasm_get_permalink( $post_id = '' ) {
        // Apply filters and return
        return apply_filters( 'blogasm_get_permalink', esc_url( get_permalink() ) );

    }
endif;

/*----------------------------------------------------------------------
# Prints HTML with meta information for the categories.
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_cat_links' ) ) {

    function blogasm_cat_links( $before='', $after='') {

        if ( 'post' === get_post_type() ) {

            $cat_sep            = '<span class="item-sep vertical-line"></span>';

            $categories_list    = get_the_category_list( $cat_sep );
            $output             = '';

            if ( $categories_list ) {

                $output .= '<div class="cat-links post-meta-item d-flex flex-wrap align-items-center">';

                $output .= $categories_list;
                $output .= '</div><!-- .cat-links -->';
            }

            // Filter
            $output = apply_filters( 'blogasm_cat_links', $output );

            if ( ! empty( $output ) ) {
                echo $before . $output . $after;
            }

        }

    }

}

/*----------------------------------------------------------------------
# Prints HTML with meta information for the tags.
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_tags_links' ) ) {

    function blogasm_tags_links( $before='', $after='' ) {
        if ( 'post' === get_post_type() ) {

            $tag_sep    = '<span class="item-sep comma"></span>';

            $tags_list  = get_the_tag_list( '', $tag_sep );
            $output     = '';

            if ( $tags_list ) {

                $output .= '<div class="tags-links post-meta-item d-flex flex-wrap align-items-center">';

                $output .= $tags_list;
                $output .= '</div><!-- .tags-links -->';
            }
            // Filter
            $output = apply_filters( 'blogasm_tags_links', $output );

            if ( ! empty( $output ) ) {
                echo $before . $output . $after;
            }

        }

    }

}

/*----------------------------------------------------------------------
# Prints HTML with meta information for the author.
-------------------------------------------------------------------------*/
if ( !function_exists( 'blogasm_post_author' ) ) {

    function blogasm_post_author( $before = '', $after = '' ) {

        $output = '';
        $output .= '<div class="post-author post-meta-item d-flex flex-wrap align-items-center">';

        $output .= '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a>';
        $output .= '</div>';

        // Filter
        $output = apply_filters( 'blogasm_post_author', $output );

        if ( ! empty( $output ) ) {
            echo $before . $output . $after;
        }
    }
}

/*----------------------------------------------------------------------
# Prints HTML with meta information for the date.
-------------------------------------------------------------------------*/
if ( !function_exists( 'blogasm_posted_date' ) ) {

    function blogasm_posted_date( $before='', $after='' ) {

        $icon       = get_theme_mod( 'blogasm_global_meta_date_icon', 'default' );

        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
        /* translators: %s: post date. */
            esc_html_x( ' %s', 'post date', 'blogasm' ),
            '<a href="' . esc_url( get_month_link(get_the_time('Y'), get_the_time('m')) ) . '" rel="bookmark">' . $time_string . '</a>'
        );
        $output = '';
        $output .= '<div class="posted-on post-meta-item d-flex flex-wrap align-items-center">';

        $output .= $posted_on;
        $output .= '</div>';

        // Filter
        $output = apply_filters( 'blogasm_posted_date', $output );

        if ( ! empty( $output ) ) {
            echo $before . $output . $after;
        }
    }
}

/*----------------------------------------------------------------------
# Add Action for the copyright information.
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_footer_copyright_information' ) ) {
    /**
     * Function to show the copyright information
     */
    function blogasm_footer_copyright_information() {
        
        printf( '<div class="site-info">%1$s <a href="%2$s">%3$s.</a> %4$s.<span class="sep"> | </span>%5$s <a href="%6$s" rel="designer" target="_blank">Precise Themes</a></div><!-- .site-info -->',
            sprintf('%1$s %2$s',
                esc_html__( 'Copyright &copy;', 'blogasm' ),
                esc_html( date('Y') )
            ),
            esc_url( home_url( '/' ) ),
            esc_html( get_bloginfo( 'name', 'display' ) ),
            esc_html__( 'All rights reserved','blogasm' ),
            esc_html__( 'Designed by','blogasm' ),
            esc_url( 'http://precisethemes.com/' )
        );

    }
}
add_action( 'blogasm_footer_copyright', 'blogasm_footer_copyright_information', 5 );

/*----------------------------------------------------------------------
# Returns sidebar layout
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_get_sidebar_layout' ) ) {
    function blogasm_get_sidebar_layout( $post_id = '' ) {

        // Global Sidebar Layout
        $global_layout = get_theme_mod( 'blogasm_sidebar_layout', 'right-sidebar' );

        // Get post ID
        $post_id = $post_id ? $post_id : blogasm_get_the_ID();

        // Bail if blog page or archive page
        if( is_home() || is_archive() ) {

            // For all Archive Page
            $archive_layout = get_theme_mod( 'blogasm_archive_sidebar_layout', 'full-width' );

            // Check meta first to override and return (prevents filters from overriding meta)
            if ( $post_id && $meta = get_post_meta( $post_id, 'blogasm_sidebar_layout', true ) ) {

                return apply_filters( 'blogasm_get_sidebar_layout', esc_attr( $meta ) );

            }
            elseif ( $archive_layout !== 'default' ) {

                $global_layout = $archive_layout;

            }

        }

        // Bail if single page
        elseif ( is_404() ) {

            $global_layout = 'full-width';
        }

        // Bail if single page
        elseif ( is_page() || is_single() ) {


            // Check meta first to override and return (prevents filters from overriding meta)
            if ( $post_id && $meta = get_post_meta( $post_id, 'blogasm_sidebar_layout', true ) ) {

                return apply_filters( 'blogasm_get_sidebar_layout', esc_attr( $meta ) );

            }
        }

        // Apply filters and return
        return apply_filters( 'blogasm_get_sidebar_layout', esc_attr( $global_layout ) );

    }
}

/*----------------------------------------------------------------------
# Primary Class
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_has_primary_content_class' ) ) {
    function blogasm_has_primary_content_class() {

        $sidebar_layout = blogasm_get_sidebar_layout();

        if ( $sidebar_layout == 'right-sidebar' ) {
            $primary_class = 'order-1';
        }
        elseif ( $sidebar_layout == 'left-sidebar' ) {
            $primary_class = 'order-2';
        }
        else {
            $primary_class = 'full-width';
        }
        // Apply filters and return
        return apply_filters( 'blogasm_has_primary_content_class', $primary_class );

    }
}

/*----------------------------------------------------------------------
# Secondary Class
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_has_secondary_content_class' ) ) {
    function blogasm_has_secondary_content_class() {

        $sidebar_layout = blogasm_get_sidebar_layout();

        if ( $sidebar_layout == 'right-sidebar' ) {
            $secondary_class = 'order-2';
        } elseif ( $sidebar_layout == 'left-sidebar' ) {
            $secondary_class = 'order-1';
        } else {
            $secondary_class = $sidebar_layout;
        }
        // Apply filters and return
        return apply_filters( 'blogasm_has_secondary_content_class', $secondary_class );

    }
}

/*----------------------------------------------------------------------
# Sidebar layout options
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_content_layouts' ) ) :
    /**
     * Returns array of content layouts for page or page.
     */
    function blogasm_content_layouts( $output = array() ) {

        $output['left-sidebar']     = esc_html__( 'Left Sidebar', 'blogasm' );
        $output['full-width']       = esc_html__( 'Full Width', 'blogasm' );
        $output['right-sidebar']    = esc_html__( 'Right Sidebar', 'blogasm' );
        return $output;
    }
endif;

/*----------------------------------------------------------------------
# Social Profiles lists
-------------------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_social_profiles' ) ) :
    /**
     * Returns array of social profiles.
     */
    function blogasm_social_profiles( $output = array() ) {
        $output['fa-behance']       = esc_html__( 'Behance', 'blogasm' );
        $output['fa-delicious']     = esc_html__( 'Delicious', 'blogasm' );
        $output['fa-digg']          = esc_html__( 'Digg', 'blogasm' );
        $output['fa-dribbble']      = esc_html__( 'Dribbble', 'blogasm' );
        $output['fa-facebook']      = esc_html__( 'Facebook', 'blogasm' );
        $output['fa-flickr']        = esc_html__( 'Flickr', 'blogasm' );
        $output['fa-foursquare']    = esc_html__( 'Foursquare', 'blogasm' );
        $output['fa-github']        = esc_html__( 'Github', 'blogasm' );
        $output['fa-google-plus']   = esc_html__( 'Google Plus', 'blogasm' );
        $output['fa-instagram']     = esc_html__( 'Instagram', 'blogasm' );
        $output['fa-linkedin']      = esc_html__( 'LinkedIn', 'blogasm' );
        $output['fa-envelope']      = esc_html__( 'Mail', 'blogasm' );
        $output['fa-medium']        = esc_html__( 'Medium', 'blogasm' );
        $output['fa-pinterest']     = esc_html__( 'Pinterest', 'blogasm' );
        $output['fa-reddit']        = esc_html__( 'Reddit', 'blogasm' );
        $output['fa-skype']         = esc_html__( 'Skype', 'blogasm' );
        $output['fa-slack']         = esc_html__( 'Slack', 'blogasm' );
        $output['fa-stackoverflow'] = esc_html__( 'Stackoverflow', 'blogasm' );
        $output['fa-twitter']       = esc_html__( 'Twitter', 'blogasm' );
        $output['fa-tumblr']        = esc_html__( 'Tumblr', 'blogasm' );
        $output['fa-vimeo']         = esc_html__( 'Vimeo', 'blogasm' );
        $output['fa-youtube']       = esc_html__( 'YouTube', 'blogasm' );
        return $output;
    }
endif;
