<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blogasm
 */

get_header();

$row_class          = array( 'row' );
$primary_class      = array( 'content-area' );

if ( blogasm_has_secondary_content_class() != 'full-width' ) {
	$row_class[]    = 'have-sidebar';
}

if ( blogasm_has_primary_content_class() ) {
	$primary_class[] = blogasm_has_primary_content_class();
} ?>

    <div class="outer-container have-mt">
        <div class="container-fluid">
            <div class="<?php echo esc_attr( implode( ' ', $row_class ) ); ?>">
                <div class="col-12 d-flex flex-wrap">
                    <div id="primary" class="<?php echo esc_attr( implode( ' ', $primary_class ) ); ?>">

                        <?php if ( have_posts() ) : ?>

                            <main id="main" class="site-main">
                                <div class="blog-posts archived-posts">

                                    <?php if ( is_home() && ! is_front_page() ) : ?>

                                        <header class="w-100">
                                            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                                        </header>

                                    <?php endif; ?>

                                    <div class="blog-posts-container d-flex flex-wrap">

                                        <?php while ( have_posts() ) : the_post();

                                            /*
                                             * Include the Post-Type-specific template for the content.
                                             * If you want to override this in a child theme, then include a file
                                             * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                                             */

                                            get_template_part( 'template-parts/blog/content', get_post_format() );

                                        endwhile; ?>

                                    </div><!-- .blog-posts-container -->
                                </div><!-- .blog-posts -->
                            </main><!-- #main -->

                            <?php
                            /**
                             * Hook - blogasm_action_posts_pagination.
                             *
                             * @hooked: blogasm_add_posts_pagination - 10
                             */
                            do_action( 'blogasm_action_posts_pagination' );

                        else :

                            get_template_part( 'template-parts/content', 'none' );

                        endif; ?>

                    </div><!-- #primary -->

                    <?php
                    /**
                     * Hook - blogasm_action_sidebar.
                     *
                     * @hooked: blogasm_add_sidebar - 10
                     */
                    do_action( 'blogasm_action_sidebar' ); ?>

                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container-fluid -->
    </div><!-- .outer-container -->

<?php

get_footer();
