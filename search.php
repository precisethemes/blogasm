<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 d-flex flex-wrap">
                            <h1 class="page-title w-100 mb-5">
                                <?php global $wp_query;
                                printf(__( '<span class="results-count">%d </span><span class="results-text">Search Results Found, </span>', 'blogasm'), absint( $wp_query->found_posts ) ); ?>

                                <?php printf(__( '<span class="search-for">for:</span><span class="search-word">%s</span>', 'blogasm'), get_search_query() ); ?>
                            </h1>
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container-fluid -->

                <div class="col-12 d-flex flex-wrap">
                    <div id="primary" class="<?php echo esc_attr( implode( ' ', $primary_class ) ); ?>">
                        <main id="main" class="site-main">

                            <?php if ( have_posts() ) : ?>

                                <div class="blog-posts archived-posts search-results-posts d-flex flex-wrap">
                                    <div class="search-result-posts-container d-flex flex-wrap">

                                        <?php while ( have_posts() ) : the_post();

                                            /*
                                             * Include the Post-Type-specific template for the content.
                                             * If you want to override this in a child theme, then include a file
                                             * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                                             */

                                            get_template_part( 'template-parts/content', 'search' );

                                        endwhile; ?>

                                    </div><!-- .search-result-posts-container -->


                                </div><!-- .blog-posts -->

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

                        </main><!-- #main -->
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
