<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blogasm
 */

$sidebar_class = blogasm_has_secondary_content_class();

if ( $sidebar_class == 'full-width' ) {
    return;
}

$secondary_classes      = array('widget-area');
$secondary_classes[]    = $sidebar_class;
$secondary_classes[]    = blogasm_get_sidebar_layout(); ?>

<aside id="secondary" class="<?php echo esc_attr( implode( ' ', $secondary_classes ) );?>">
    <div class="sidebar-wrap h-100">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div><!-- .sidebar-wrap -->
</aside><!-- #secondary -->
