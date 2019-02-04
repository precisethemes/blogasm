<?php
/**
 * Blogasm functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blogasm
 */

/**
 * Blogasm only works in WordPress 4.7 or later and PHP 5.4.0 or later.
 */
if ( ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) || ( version_compare( PHP_VERSION, '5.4.0', '<' ) ) ){
    require get_template_directory() . '/inc/back-compat.php';
    return;
}

/**
 * Define constants
 */
$blogasm_theme_options  = wp_get_theme();
$blogasm_theme_name     = $blogasm_theme_options->get( 'Name' );
$blogasm_theme_author   = $blogasm_theme_options->get( 'Author' );
$blogasm_theme_desc     = $blogasm_theme_options->get( 'Description' );
$blogasm_theme_version  = $blogasm_theme_options->get( 'Version' );

define( 'BLOGASM_THEME_NAME', $blogasm_theme_name );
define( 'BLOGASM_THEME_AUTHOR', $blogasm_theme_author );
define( 'BLOGASM_THEME_DESC', $blogasm_theme_desc );
define( 'BLOGASM_THEME_VERSION', $blogasm_theme_version );
define( 'BLOGASM_THEME_URI', get_template_directory_uri() );
define( 'BLOGASM_THEME_DIR', get_template_directory() );

/*--------------------------------------------------------------
# Sets up and registers support
--------------------------------------------------------------*/
if ( ! function_exists( 'blogasm_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function blogasm_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Blogasm, use a find and replace
         * to change 'blogasm' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'blogasm', BLOGASM_THEME_DIR . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

	    /* Portrait Thumbnail */
	    add_image_size( 'blogasm-576-portrait', 576, 768, true );

	    /* Landscape Thumbnail */
	    add_image_size( 'blogasm-960-landscape', 960, 595, true );
	    add_image_size( 'blogasm-1370-850', 1370, 850, true );

	    /* Wider Thumbnail ) */
	    add_image_size( 'blogasm-1800-540', 1800, 540, true );
	    add_image_size( 'blogasm-1800-auto', 1800 );

	    /* Image Ratio - 4:3 */
	    add_image_size( 'blogasm-576-4x3', 576, 432, true );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary-menu' => esc_html__( 'Primary', 'blogasm' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ) );

    }
endif;
add_action( 'after_setup_theme', 'blogasm_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

// Register Sidebars
function blogasm_widgets_init() {

    // Register Default Sidebar
    register_sidebar( array(
        'name'          => esc_html__('Sidebar', 'blogasm'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'blogasm'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    /* ---------------------------------------------
    # Header Search Widget Areas
     ---------------------------------------------*/
    if ( get_theme_mod( 'blogasm_header_search_enable', true ) == true ) {
        $no_search_widget       = 1;
        for ($i = 1; $i <= $no_search_widget; $i++) {

            register_sidebar( array(
                'name'          => sprintf( esc_html__('Search Popup Column %d', 'blogasm'), $i),
                'id'            => 'header_search_sidebar_' . $i,
                'description'   => esc_html__('Add widgets here.', 'blogasm'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));

        }
    }

    /* ---------------------------------------------
    # Footer Widget Areas
    ---------------------------------------------*/
    $activate_footer_widget_area    = get_theme_mod( 'blogasm_footer_widget_area_activate', true );

    if ( true == $activate_footer_widget_area ) {
        $number_of_widgets = 4;
        for ($i = 1; $i <= $number_of_widgets; $i++) {

            register_sidebar( array(
                'name'          => sprintf( esc_html__('Footer Widgets Column %d', 'blogasm'), $i),
                'id'            => 'footer_sidebar_' . $i,
                'description'   => esc_html__('Add widgets here.', 'blogasm'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
        }
    }

}
add_action( 'widgets_init', 'blogasm_widgets_init' );

/*--------------------------------------------------------------
# Set content width
--------------------------------------------------------------*/
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blogasm_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters( 'blogasm_content_width', 640 );
}
add_action( 'after_setup_theme', 'blogasm_content_width', 0 );

/*--------------------------------------------------------------
# function for google fonts
--------------------------------------------------------------*/
if ( ! function_exists('blogasm_google_fonts_url') ) :

    /**
     * Return fonts URL.
     *
     * @return string Fonts URL.
     */
    function blogasm_google_fonts_url(){

        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Barlow Semi Condensed, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== _x( 'on', 'Roboto, Work Sans font: on or off', 'blogasm' ) ) {
            $fonts[] = 'Roboto:300,400,500,700|Work+Sans:300,400,500,600,700';
        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => rawurlencode( implode( '|', $fonts ) ),
                'subset' => rawurlencode( $subsets ),
            ), 'https://fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
endif;

/*--------------------------------------------------------------
# Front-End Enqueue scripts and styles.
--------------------------------------------------------------*/
function blogasm_scripts() {

    $fonts_url = blogasm_google_fonts_url();

    if ( ! empty($fonts_url) ) {
        wp_enqueue_style('blogasm-google-fonts', $fonts_url, array(), null);
    }

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Enqueue Style
    wp_enqueue_style( 'lib-style', BLOGASM_THEME_URI .'/assets/front-end/css/lib.css', false, BLOGASM_THEME_VERSION, 'all' );
    wp_enqueue_style( 'blogasm-style', get_stylesheet_uri() );

    // Enqueue Script
    wp_enqueue_script( 'lib-script', BLOGASM_THEME_URI . '/assets/front-end/js/lib.js', array( 'jquery' ), BLOGASM_THEME_VERSION, true );
    wp_enqueue_script( 'custom-script', BLOGASM_THEME_URI . '/assets/front-end/js/custom' . $min . '.js', array( 'jquery' ), BLOGASM_THEME_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'blogasm_scripts' );

/*--------------------------------------------------------------
# Back-End Enqueue scripts and styles.
--------------------------------------------------------------*/
if ( !function_exists( 'blogasm_admin_scripts' ) ) {
    function blogasm_admin_scripts( $hook ) {

        $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

        if ( 'customize.php' == $hook || $hook == 'widgets.php' ) {

            // Enqueue Style
            wp_enqueue_style( 'blogasm-customizer-style', BLOGASM_THEME_URI .'/assets/back-end/css/customizer-style' . $min . '.css', false, BLOGASM_THEME_VERSION, 'all' );
        }

    }
}
add_action( 'admin_enqueue_scripts', 'blogasm_admin_scripts' );

/**
 * Load template functions.
 */
require BLOGASM_THEME_DIR . '/inc/helpers/template-functions.php';

/**
 * Load themes custom hooks.
 */
require BLOGASM_THEME_DIR . '/inc/helpers/theme-hooks.php';

/**
 * Load kirki library in theme
 */
require BLOGASM_THEME_DIR . '/inc/libraries/kirki/kirki.php';

/**
 * Load plugin recommendations.
 */
require BLOGASM_THEME_DIR . '/inc/libraries/tgm/tgm.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require BLOGASM_THEME_DIR . '/inc/libraries/jetpack.php';
}

/**
 * Customizer options.
 */
require BLOGASM_THEME_DIR . '/inc/framework/customizer/customizer.php';

/**
 * Load theme meta box
 */
require BLOGASM_THEME_DIR . '/inc/framework/meta-boxes/class-meta-box.php';


/**
 * Include Welcome page and demo importer.
 */
if ( is_admin() ) {
    // Demo.
    require BLOGASM_THEME_DIR . '/inc/framework/demo-importer/class-demo.php';
}
