<?php
/**
 * Header Search
 *
 * @package Blogasm
 */

$search_enabled             = get_theme_mod( 'blogasm_header_search_enable', true );

if ( $search_enabled == true ) :

    $header_search_column   = get_theme_mod( 'blogasm_header_search_column', 'header-search-columns-1' );
    $no_search_widget       = 1;
    $col_class              = 'col-12 offset-lg-1 col-lg-10 my-4';

    if ( $header_search_column === 'header-search-columns-3') {
        $no_search_widget   = 3;
        $col_class          = 'col-12 col-md-6 col-lg-4 my-4';
    } elseif ( $header_search_column === 'header-search-columns-2' ) {
        $no_search_widget   = 2;
        $col_class          = 'col-12 col-lg-6 my-4';
    } ?>

    <div class="header-search d-flex align-items-center cursor-pointer">
        <span class="pt-icon icon-search"></span>
    </div><!-- .header-search -->

    <div class="search-popup d-flex align-items-center fixed-top overflow-y-auto w-100 h-100 opacity-0 invisible transition-5s">
        <div class="search-close">
            <span class="pt-icon icon-cross"></span>
        </div><!-- .search-close -->

        <div class="outer-container my-auto">
            <div class="container position-relative">
                <div class="row align-items-center justify-lg-content-center">

                    <?php for ( $i = 1; $i <= $no_search_widget; $i++ ) : ?>
                        <div class="<?php echo esc_attr( $col_class ); ?>">
                            <div class="search-popup-widgets">

                                <?php
                                    if ( is_active_sidebar( 'header_search_sidebar_' . $i ) ) {
                                        dynamic_sidebar( 'header_search_sidebar_' . $i );
                                    } else {
                                        printf( __( 'No widgets found! <a href="%s" target="_blank">Add Widget </a>', 'blogasm'), esc_url( admin_url( 'widgets.php' ) ) );
                                    };
                                ?>

                            </div><!-- .search-popup-widgets -->
                        </div><!-- .col -->

                    <?php endfor; ?>

                </div><!-- .row -->
            </div><!-- .container-fluid -->
        </div><!-- .outer-container -->
    </div><!-- .search-popup -->

<?php endif;
