<?php
/**
 * Footer Bar Section.
 *
 * @package Blogasm
 */

$footer_bar_class   = array( 'footer-bar cs-dark' );

$footer_row_class   = array( 'row flex-wrap align-items-center justify-content-center' );
?>

<div class="footer-bar-separator"></div>

<div id="colophon" class="<?php echo esc_attr( implode( ' ', $footer_bar_class ) ); ?>" role="contentinfo">
    <div class="outer-container">
        <div class="container-fluid">
            <div class="<?php echo esc_attr( implode( ' ', $footer_row_class ) ); ?>">
                <div class="footer-copyright order-3 mt-3 mb-2 mb-lg-0 mt-lg-0">
                    <?php do_action( 'blogasm_footer_copyright' ); ?>
                </div><!-- .footer-copyright -->
            </div><!-- .row -->
        </div><!-- .container-fluid -->
    </div><!-- .outer-container -->
</div><!-- .footer-bar -->

