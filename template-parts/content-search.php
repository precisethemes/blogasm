<?php
/**
 * Template part for displaying posts on archive page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blogasm
 */

$url_link                       = blogasm_get_permalink();
$featured_img_meta_value        = get_post_meta( blogasm_get_the_ID(), 'blogasm_featured_img_type', true );
$featured_img_type              = !empty( $featured_img_meta_value ) ? $featured_img_meta_value : 'portrait-img';
$excerpt_length                 = 20;
$post_class                     = array( 'post-col w-100' );
$post_class[]                   = 'text-left';

if ( $featured_img_type == 'landscape-img' ) {
    $thumbnail_size = 'blogasm-960-landscape';
    $excerpt_length = 45;
} elseif ( $featured_img_type == 'full-width-img' ) {
    $thumbnail_size = 'blogasm-1800-540';
    $excerpt_length = 45;
} else {
    $thumbnail_size = 'blogasm-576-portrait';
}

$post_content_wrap_class    = array( 'post-content-wrap d-flex flex-wrap justify-content-between align-items-center' );
$post_content_class         = array( 'post-content d-flex flex-wrap' );
$post_thumbnail_wrap_class  = array( 'post-thumbnail-wrap mb-4 mb-lg-0' );
$post_figure_class          = array( 'post-thumbnail d-block');?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
    <div class="<?php echo esc_attr( implode( ' ', $post_content_wrap_class ) ); ?>">
        <h5 class="post-type w-100"><?php echo get_post_type(); ?></h5>

        <?php if ( has_post_thumbnail() ) { // Featured Image ?>

            <div class="<?php echo esc_attr( implode( ' ', $post_thumbnail_wrap_class ) ); ?>">
                <figure class="<?php echo esc_attr( implode( ' ', $post_figure_class ) ); ?>">
                    <a class="post-thumbnail-link d-block" href="<?php echo esc_url( $url_link ); ?>">

                        <?php the_post_thumbnail( $thumbnail_size, array(
                            'alt' => the_title_attribute( array(
                                'echo' => false,
                            ) ),
                        ) ); ?>

                    </a><!-- .post-thumbnail-link -->
                </figure><!-- .post-thumbnail -->

                <?php if( is_sticky() ) {
                    echo '<span class="sticky-icon position-absolute d-flex justify-content-center align-items-center"><i class="fas fa-thumbtack"></i></span>';
                } ?>

            </div><!-- .post-thumbnail-wrap -->

        <?php } ?>

        <div class="<?php echo esc_attr( implode( ' ', $post_content_class ) ); ?>">

			<?php blogasm_cat_links();

			the_title( '<h2 class="entry-title w-100 td-none"><a class="d-block transition-35s" href="' . esc_url( $url_link ) . '" rel="bookmark">', '</a></h2>' );?>

            <div class="entry-content">
                <p class="mb-0"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), $excerpt_length, '' ) ); ?></p>
            </div><!-- .entry-content -->
        </div><!-- .post-content -->
    </div><!-- .post-content-wrap -->
</article><!-- #post-<?php the_ID(); ?> -->
