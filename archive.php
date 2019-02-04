<?php
/**
 * The template for displaying archive pages
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

                <?php if ( is_author() ) {  ?>

                    <div class="col-12 d-flex flex-wrap mb-5">
                        <?php
                        // Get global post
                        global $post;
                        // Define author bio data
                        $data = array(
                            'post_author'       => $post->post_author,
                            'avatar_size'       => apply_filters( 'blogasm_author_avatar_size', 75 ),
                            'author_name'       => get_the_author(),
                            'posts_url'         => get_author_posts_url( $post->post_author ),
                            'description'       => get_the_author_meta( 'description', $post->post_author ),
                            'website'           => get_the_author_meta( 'url', $post->post_author ),
                        );

                        // Get author avatar
                        $data['avatar'] = get_avatar( $post->post_author, $data['avatar_size'] );

                        // Apply filters so we can tweak the author bio output
                        $data = apply_filters( 'blogasm_post_author_bio_data', $data );

                        // Extract variables
                        extract( $data ); ?>

                        <div class="author-box-content d-flex mt-4">
                            <?php if ( $avatar ) { ?>
                                <figure class="author-avatar m-0 mr-4">
                                    <?php echo wp_kses_post( $avatar ); ?>
                                </figure><!-- .author-avatar -->
                            <?php } ?>

                            <div class="author-content">
                                <header class="entry-header">
                                    <h1><?php echo esc_html( $author_name ); ?></h1>

                                    <?php if ( $website !== '' ) : ?>
                                        <div class="author-website">
                                            <a href="<?php echo esc_url( $website ); ?>" title="<?php esc_attr_e( 'Author Website', 'blogasm' ); ?>" target="_blank"><?php echo esc_url( $website ); ?></a>
                                        </div><!-- .author-website -->
                                    <?php endif; ?>
                                </header><!-- .entry-header -->

                                <?php if ( $description ) : ?>
                                    <div class="entry-content m-0">
                                        <p><?php echo wp_kses_post( $description ); ?></p>
                                    </div><!-- .entry-content -->
                                <?php endif; ?>

                            </div><!-- .author-content -->
                        </div><!-- .author-box-content -->
                    </div><!-- .col -->

                <?php } ?>

                <div class="col-12 d-flex flex-wrap">
                    <div id="primary" class="<?php echo esc_attr( implode( ' ', $primary_class ) ); ?>">

                        <?php if ( have_posts() ) : ?>

                            <main id="main" class="site-main">
                                <div class="blog-posts archived-posts">
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
