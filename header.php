<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blogasm
 */

$header_class   = array( 'site-header' );
$header_class[] = 'header-layout-1';
$header_class[] = 'scroll';
$header_class[] = 'transition-5s'; ?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site website-container">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'blogasm' ); ?></a>

    <header id="masthead" class="<?php echo esc_attr( implode( ' ', $header_class ) ); ?>">

        <?php
        /**
         * Hook - blogasm_action_header
         *
         * @hooked: blogasm_add_header    - 20
         */
        do_action( 'blogasm_action_header' ); ?>

    </header><!-- #masthead -->

    <div class="site-header-separator"></div>

<div id="content" class="site-content">
