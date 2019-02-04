<?php
/**
 * Header Social Profiles
 *
 * @package Blogasm
 */

$social_enabled             = get_theme_mod( 'blogasm_header_social_profile_enable', true );

if ( $social_enabled == true ) :
    $default_social_profiles = array(
        array(
            'social_name'   => esc_html__( 'Facebook', 'blogasm' ),
            'social_url'    => 'https://facebook.com/',
            'social_icon'   => 'fa-facebook',
            'social_image'  => '',
        )
    );

    $social_profiles        = get_theme_mod( 'blogasm_social_repeatable_social_profiles', $default_social_profiles ); ?>

    <div class="header-social d-flex align-items-center cursor-pointer">
        <div class="social-profiles-widget">

            <?php if ( !empty( $social_profiles ) ) : ?>

                <ul class="p-0 m-0">

                    <?php foreach ( $social_profiles as $social_profile ) {

                        if ( '' != $social_profile['social_url'] ) {
                            $social_name = $social_profile['social_name'];
                            $font_icon = $social_profile['social_icon'];
                            $social_icon = '<i class="fab '.esc_attr( $font_icon ). '"></i>';

                            if ( '' != $social_profile['social_image'] ){
                                $image_id = $social_profile['social_image'];
                                $image_path = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
                                $social_icon = '<img width="'.esc_attr( $image_path[1] ).'" height="'.esc_attr( $image_path[2] ).'" src="'.esc_url( $image_path[0] ).'" />';
                            } ?>

                            <li>
                                <a href="<?php echo esc_url( $social_profile['social_url'] );?>" target="_blank">
                                    <?php echo $social_icon; ?>
                                    <label class="d-none"><?php echo esc_html( $social_name ); ?></label>
                                </a>
                            </li>

                        <?php }
                    } ?>

                </ul><!-- .social-profiles -->
            <?php endif; ?>

        </div><!-- .social-profiles-sec -->
    </div><!-- .header-search -->

<?php endif;
