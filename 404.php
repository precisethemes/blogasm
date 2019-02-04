<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Blogasm
 */

get_header();

$row_class              = array( 'row' );
$primary_class          = array( 'content-area' );
$primary_class[]        = 'text-left';

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
                        <main id="main" class="site-main">
                            <section class="error-404 not-found">
                                <div class="page-content">
                                    <div class="entry-content">

                                        <h1 class="page-title"><?php echo esc_html( 'Oops! That page can&rsquo;t be found.', 'blogasm' ); ?></h1>

                                        <p class="error-description"><?php echo esc_html( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'blogasm' ); ?></p>

                                    </div><!-- .entry-content -->

                                    <div class="404-search-wrap mt-5 mb-5">
                                        <?php get_search_form(); ?>
                                    </div><!-- .404-search-wrap -->
                                </div><!-- .page-content -->
                            </section><!-- .error-404 -->
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
