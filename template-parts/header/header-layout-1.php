<?php
/**
 * Header Layout 1
 *
 * @package Blogasm
 */

$enable_site_title      = get_theme_mod( 'blogasm_header_site_title_visible', true );
$enable_site_tagline    = get_theme_mod( 'blogasm_header_site_tagline_visible' );
$enable_social          = get_theme_mod( 'blogasm_header_social_profile_enable', true );
$enable_search          = get_theme_mod( 'blogasm_header_search_enable', true );

if ( $enable_social == true || $enable_search == true ) {
    $site_title_col     = 'col-6 col-lg-3';
    $menu_col           = 'col-1 col-lg-6';
    $menu_class         = 'primary-menu d-flex flex-wrap flex-column flex-lg-row justify-content-center p-0 m-0 ls-none';
    $extended_menu_col  = 'col-5 col-lg-3';
} else {
    $site_title_col     = 'col-9 col-lg-3';
    $menu_col           = 'col-1 col-lg-9';
    $menu_class         = 'primary-menu d-flex flex-wrap flex-column flex-lg-row justify-content-end p-0 m-0 ls-none';
    $extended_menu_col  = 'col-2 d-lg-none';
} ?>

<div class="body-overlay w-100 h-100 opacity-0 invisible transition-5s"></div>

<div class="<?php echo esc_attr( $site_title_col ); ?>">
    <div class="site-branding d-flex flex-wrap align-items-center">

        <?php the_custom_logo(); ?>

        <div class="site-title-wrap">

            <?php

            $site_title = get_bloginfo( 'name ');

            $site_title_class = array( 'site-title' );

            if ( $enable_site_title !== true ) {
                $site_title_class[] = 'screen-reader-text';
            }

            if ( is_front_page() && is_home() ) : ?>

                <h1 class="<?php echo esc_attr( implode(' ', $site_title_class ) ); ?>"><a class="d-inline-block td-none outline-none" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( $site_title ); ?></a></h1>

            <?php else : ?>

                <p class="<?php echo esc_attr( implode(' ', $site_title_class ) ); ?>"><a class="d-inline-block td-none outline-none" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( $site_title ); ?></a></p>

            <?php endif;

            if ( $enable_site_tagline == true ) :

                $blogasm_description = get_bloginfo( 'description', 'display' );
                if ( $blogasm_description || is_customize_preview() ) : ?>

                    <p class="site-description"><?php echo wp_kses_post( $blogasm_description ); /* WPCS: xss ok. */ ?></p>

                <?php endif;

            endif; ?>

        </div><!-- .site-title-wrap -->
    </div><!-- .site-branding -->
</div><!-- .col -->

<div class="<?php echo esc_attr( $menu_col ); ?>">
    <nav class="main-navigation slide-in transition-5s">
        <div class="close-navigation d-flex justify-content-center align-items-center position-absolute transition-5s cursor-pointer d-lg-none"><span class="pt-icon icon-cross"></span></div>

        <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_id' => 'primary-menu', 'container' => 'ul', 'menu_class' => $menu_class ) );

        if ( $enable_social == true ) : ?>
            <div class="d-lg-none">
                <?php get_template_part( 'template-parts/header/header', 'social' ); // Header Social Profile ?>
            </div>
        <?php endif; ?>
    </nav><!-- .main-navigation -->
</div><!-- .col -->

<div class="<?php echo esc_attr( $extended_menu_col ); ?>">
    <div class="extended-header d-flex justify-content-end align-items-center">
        <div class="hamburger-menu cursor-pointer d-lg-none">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div><!-- .hamburger-menu -->

        <?php if ( $enable_social == true ) : ?>

            <div class="d-none d-lg-block">
                <?php get_template_part( 'template-parts/header/header', 'social' ); // Header Social Profile ?>
            </div>

        <?php endif;

        get_template_part( 'template-parts/header/header', 'search' ); // Header Search ?>
    </div><!-- .extended-header -->
</div><!-- .col -->
