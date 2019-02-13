<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blogasm
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
    return;
} ?>

<div id="comments" class="comments-area w-100">

    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) : ?>
        <h2 class="comments-title section-title">
            <?php
            $blogasm_comment_count = get_comments_number();
            if ( '1' === $blogasm_comment_count ) {
                printf(
                /* translators: 1: title. */
                    esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'blogasm' ),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf( // WPCS: XSS OK.
                /* translators: 1: comment count number, 2: title. */
                    esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $blogasm_comment_count, 'comments title', 'blogasm' ) ),
                    number_format_i18n( $blogasm_comment_count ),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <ol class="comment-list p-0">
            <?php
            wp_list_comments( array(
                'avatar_size'   => 100,
                'style'         => 'ol',
                'short_ping'    => true,
            ) );
            ?>
        </ol><!-- .comment-list -->

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
            ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'blogasm' ); ?></p>
        <?php
        endif;

    endif; // Check for have_comments().

    comment_form();
    ?>

</div><!-- #comments -->
