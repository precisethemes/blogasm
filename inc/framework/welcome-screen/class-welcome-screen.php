<?php
/**
 * Blogasm Welcome Screen
 *
 * @since  1.0.0
 * @package blogasm
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Blogasm_Welcome_Screen' ) ) :

    /**
     * Blogasm_Welcome_Screen Class.
     */
    class Blogasm_Welcome_Screen {

        /**
         * Constructor.
         */
        public function __construct() {
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
            add_action( 'admin_init', array( 'PAnD', 'init' ) );
            add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
        }

        /**
         * Add admin menu.
         */
        public function admin_menu() {

            add_theme_page(
                esc_html__( 'Getting Started', 'blogasm' ),
                esc_html__( 'Getting Started', 'blogasm' ),
                'edit_theme_options',
                'blogasm-welcome' ,
                array( $this, 'welcome_screen' )
            );
        }

        /**
         * Show welcome notice.
         */
        public function welcome_notice() {
            global $pagenow;
            if ( ! PAnD::is_admin_notice_active( 'blogasm-welcome-forever' )  ) {
                return;
            }

            if ( ( 'post-new.php' == $pagenow ) || ( 'post.php' == $pagenow ) ) {
                return;
            }

            ?>

            <div data-dismissible="blogasm-welcome-forever" class="updated notice notice-success is-dismissible welcome-notice">

                <h1><?php printf( esc_html__( 'Welcome to %s', 'blogasm' ), BLOGASM_THEME_NAME ); ?></h1>
                <p><?php printf( esc_html__( 'Welcome! Thank you for choosing %1$s ! To fully take advantage of the best our theme can offer please make sure you visit our %2$s welcome page%3$s.', 'blogasm' ),BLOGASM_THEME_NAME,'<br/><a href="' . esc_url( admin_url( 'themes.php?page=blogasm-welcome' ) ) . '">', '</a>' ); ?></p>
                <p>
                    <a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=blogasm-welcome' ) ); ?>">
                        <?php printf( esc_html__( 'Get started with %s', 'blogasm' ), BLOGASM_THEME_NAME ); ?>
                    </a>
                </p>
                <button type="button" class="notice-dismiss">
                    <a class="blogasm-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'blogasm-hide-notice', 'welcome' ) ), 'blogasm_pro_hide_notices_nonce', '_blogasm_pro_notice_nonce' ) ); ?>">
                        <span class="screen-reader-text"><?php esc_html_e( 'Dismiss', 'blogasm' ); ?></span>
                    </a>
                </button>

            </div>
            <?php
        }

        /**
         * Welcome screen page.
         */
        public function welcome_screen() {
            $user = wp_get_current_user();
            $rating_url     = 'https://wordpress.org/support/theme/blogasm/reviews/#new-post';
            $rating_link    = sprintf( __( '<a href="%s" target="_blank">Blogasm</a>', 'blogasm' ), esc_url( $rating_url ) ); ?>

            <div class="blogasm-welcome-container">
                <div class="flex blogasm-info-wrapper">
                    <div class="blogasm-left-wrap">
                        <h4><?php echo sprintf( __( 'Hello, %s,', 'blogasm' ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?></h4>
                        <h1 class="entry-title"><?php echo sprintf( __( 'Welcome to %1$s version %2$s', 'blogasm' ), BLOGASM_THEME_NAME, BLOGASM_THEME_VERSION ); ?></h1>
                        <p class="entry-content"><?php echo wp_kses_post( BLOGASM_THEME_DESC ); ?></p>
                    </div>

                    <figure class="blogasm-right-wrap">
                        <img src="<?php echo esc_url( BLOGASM_THEME_URI ) . '/screenshot.png'; ?>" />
                    </figure>
                </div>

                <div class="blogasm-tabs-wrapper">
                    <ul class="blogasm-welcome-tab-nav">
                        <li class="tab-link" data-tab="getting_started"><?php esc_html_e( 'Getting Started', 'blogasm' ); ?></li>
                        <li class="tab-link" data-tab="support"><?php esc_html_e( 'Support Forum', 'blogasm' ); ?></li>
                        <li class="tab-link" data-tab="changelog"><?php esc_html_e( 'Changelog', 'blogasm' ); ?></li>
                        <li class="tab-link" data-tab="free_vs_pro"><?php esc_html_e( 'Free vs Pro', 'blogasm' ); ?></li>
                        <li class="tab-link" data-tab="upgrade_pro"><?php esc_html_e( ' Upgrade to Pro', 'blogasm' ); ?></li>
                    </ul>

                    <?php $this->getting_started();?>

                    <?php $this->supports();?>

                    <?php $this->changelog();?>

                    <?php $this->free_vs_pro();?>

                    <?php $this->upgrade_pro();?>

                    <div class="blogasm-rating-wrap">
                        <p><?php
                            printf( __( 'Have you ❤ using %1$s? Please rate ⭐⭐⭐⭐⭐ our theme %2$s on WordPress.org ☺ Thank you', 'blogasm' ), BLOGASM_THEME_NAME, $rating_link ); ?></p>
                    </div>

                </div>
            </div>
            <?php
        }

        /**
         * Show Getting Started Content.
         */
        public function getting_started() { ?>

            <div id="getting_started" class="blogasm-welcome-section">
                <section>
                    <h3><?php esc_html_e( 'Documentation & Installation Guide', 'blogasm' ); ?></h3>

                    <p><?php esc_html_e( 'Theme documentation page will guide you to install and configure theme quick and easy. We have included details, screenshots and stepwise description about theme installation guides and tutorials.', 'blogasm' ); ?></p>

                    <p><a class="button button-primary button-large" href="<?php echo esc_url( 'https://precisethemes.com/docs/blogasm/' ); ?>" target="_blank"><?php esc_html_e( 'View Documentation', 'blogasm' ); ?></a></p>
                </section>

                <section>
                    <h3><?php esc_html_e( 'Support Forum', 'blogasm' ); ?></h3>

                    <p><?php esc_html_e( 'Need help to setup your website with Blogasm theme? Visit our support forum and browse support topics or create new, one of our support member will follow and help you to solver your issue.', 'blogasm' ); ?></p>

                    <p><a class="button button-primary button-large" href="<?php echo esc_url( 'https://precisethemes.com/support-forum/forum/blogasm/' ); ?>" target="_blank"><?php esc_html_e( 'Support Forum', 'blogasm' ); ?></a></p>
                </section>

                <section>
                    <h3><?php esc_html_e( 'Demo content', 'blogasm' ); ?></h3>

                    <h4><?php esc_html_e( 'Install:  One Click Demo Import', 'blogasm' ); ?></h4>
                    <p><?php esc_html_e( 'Install the following plugin and then come back here to access the importer. With it you can import all demo content and change your homepage and blog page to the ones from our demo site, automatically. It will also assign a menu.', 'blogasm' ); ?></p>

                    <?php if ( !class_exists('OCDI_Plugin') ) : ?>
                        <?php $odi_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=one-click-demo-import'), 'install-plugin_one-click-demo-import'); ?>
                        <p>
                            <a target="_blank" class="install-now button importer-install" href="<?php echo esc_url( $odi_url ); ?>"><?php esc_html_e( 'Install and Activate', 'blogasm' ); ?></a>
                            <a style="display:none;" class="button button-primary button-large importer-button" href="<?php echo esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import.php' ) ); ?>"><?php esc_html_e( 'Go to the importer', 'blogasm' ); ?></a>
                        </p>
                    <?php else : ?>
                        <p style="color:#23d423;font-style:italic;font-size:14px;"><?php esc_html_e( 'Plugin installed and active!', 'blogasm' ); ?></p>
                        <a class="button button-primary button-large" href="<?php echo esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import.php' ) ); ?>"><?php esc_html_e( 'Import Demo', 'blogasm' ); ?></a>
                    <?php endif; ?>

                    <br> <br>
                </section>

                <section>
                    <h3><?php esc_html_e( 'Theme Option & Customization', 'blogasm' ); ?></h3>

                    <p><?php esc_html_e( 'Most of theme settings customization options are available through theme customizer. To setup and customise your website elements and sections.', 'blogasm' ); ?></p>

                    <p><a class="button button-primary button-large" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Go to Customizer', 'blogasm' ); ?></a></p>
                </section>

            </div>
            <?php
        }

        /**
         * Show Getting Supports Content.
         */
        public function supports() { ?>

            <div id="support" class="blogasm-welcome-section flex">
                <section>
                    <h3><?php esc_html_e( 'Support Forum', 'blogasm' ); ?></h3>

                    <p><?php esc_html_e( 'Need help to setup your website with Blogasm theme? Visit our support forum and browse support topics or create new, one of our support member will follow and help you to solver your issue.', 'blogasm' ); ?></p>

                    <p><a class="button button-primary button-large" href="<?php echo esc_url( 'https://precisethemes.com/support-forum/forum/blogasm/' ); ?>" target="_blank"><?php esc_html_e( 'Visit Support Forum', 'blogasm' ); ?></a></p>
                </section>
            </div>
            
            <?php
        }

        /**
         * Show Getting Supports Content.
         */
        public function free_vs_pro() { ?>

            <div id="free_vs_pro" class="blogasm-welcome-section">
                <table>
                    <tr>
                        <td><?php esc_html_e( 'Theme Features', 'blogasm' ); ?></td>
                        <td><?php esc_html_e( 'Free Version', 'blogasm' ); ?></td>
                        <td><?php esc_html_e( 'Pro Version', 'blogasm' ); ?></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Coming Soon Page', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Top Header Bar', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Slide in Box', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Number of Header Layouts', 'blogasm' ); ?></td>
                        <td>1</td>
                        <td>7</td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Advanced Header Settings', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Sticky Header', 'blogasm' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Smooth Page Scroll', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Hero Slider Support', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Featured Posts Slider for Homepage', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Built-in Custom Widgets', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Sticky Sidebar', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Unlimited Widget Area (Sidebar) Generator', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Unique Sidebar Selection', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Typography Option (850+ Google Fonts)', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Custom Responsive Values', 'blogasm' ); ?>
                            <br/><p class="description"><?php esc_html_e( 'Custom Responsive values for different screen size(Desktop, Laptop, Tablet, Mobile).', 'blogasm' ); ?></p></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Advanced Archive/Blog Settings', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Unique Page Header', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Post Navigation Layout', 'blogasm' ); ?></td>
                        <td class="redFeature">1</span></td>
                        <td class="greenFeature">3</span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Related Posts for blog/archive page', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Advanced Post/Page Settings', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Social Share', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Advanced Post/Page Options', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Advanced 404 Error Page Editor', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Footer Instagram Feed', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Pop up Box', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Number of Footer Widgets Position Layouts', 'blogasm' ); ?></td>
                        <td>1</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Sortable Footer Bar Elements', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Footer Copyright Editor', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Inbuilt Theme Widgets', 'blogasm' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Contact Form 7 Compatible', 'blogasm' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'MailChimp Compatible', 'blogasm' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'WPML Compatible', 'blogasm' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-no dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Polylang Support in Customizer', 'blogasm' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Theme Support', 'blogasm' ); ?></td>
                        <td><?php esc_html_e( 'Support via Forum', 'blogasm' ); ?></td>
                        <td><?php esc_html_e( 'Quick Ticket Support', 'blogasm' ); ?></td>
                    </tr>
                </table>

                <br>
            </div>
            
            <?php
        }

        /**
         * Show Upgrade Pro Content.
         */
        public function upgrade_pro() { ?>

            <div id="upgrade_pro" class="blogasm-welcome-section">
                <section>
                    <h3><?php esc_html_e( 'Upgrade to Pro', 'blogasm' ); ?></h3>

                    <p><?php esc_html_e( 'Need help to upgrade your website with Blogasm Pro theme for more exciting features and additional theme options.', 'blogasm' ); ?></p>

                    <p><a class="button button-primary button-large" href="<?php echo esc_url( 'https://precisethemes.com/wordpress-theme/blogasm-pro/' ); ?>" target="_blank"><?php esc_html_e( 'Upgrade to Pro', 'blogasm' ); ?></a></p>

                </section>
            </div>
            <?php
        }

        /**
         * Show Changelog Content.
         */
        public function changelog() {
            global $wp_filesystem; ?>

            <div id="changelog" class="blogasm-welcome-section">
                <div class="wrap about-wrap">

                    <?php

                    $changelog_file = apply_filters( 'blogasm_changelog_file', get_template_directory() . '/readme.txt' );

                    // Check if the changelog file exists and is readable.
                    if ( $changelog_file && is_readable( $changelog_file ) ) {
                        WP_Filesystem();
                        $changelog = $wp_filesystem->get_contents( $changelog_file );
                        $changelog_list = $this->parse_changelog( $changelog );

                        echo wp_kses_post( $changelog_list );
                    }

                    ?>

                </div>
            </div>
            <?php
        }


        /**
         * Parse changelog from readme file.
         */
        private function parse_changelog( $content ) {
            $matches   = null;
            $regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
            $changelog = '';

            if ( preg_match( $regexp, $content, $matches ) ) {
                $changes = explode( '\r\n', trim( $matches[1] ) );

                $changelog .= '<pre class="changelog">';

                foreach ( $changes as $index => $line ) {
                    $changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
                }

                $changelog .= '</pre>';
            }

            return wp_kses_post( $changelog );
        }
    }

endif;

return new Blogasm_Welcome_Screen();
