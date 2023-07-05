<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Newsmatic
 */
use Newsmatic\CustomizerDefault as ND;
get_header();
?>
    <div id="theme-content">
        <main id="primary" class="site-main">
            <div class="newsmatic-container">
                    <div class="primary-content">
                        <section class="error-404-child not-found-child">
                            <div class="post-inner-wrapper">
<!--
                                <div class="page-footer">
                                    <a class="button-404" href="<?php /*echo esc_url( home_url() ); */?>"><?php /*echo esc_html__( 'Go back to home', 'explain' ); */?></a>
                                </div>-->

                                <?php
                                    do_action( 'newsmatic_child_header__menu_section_hook' );
                                    do_action( 'newsmatic_child_header__menu_section_hook' );
                                ?>

                                <header class="page-header-404-child">
                                    <h1 class="page-title newsmatic-block-title"><?php echo esc_html__( '404 Not Found', 'explain' ); ?></h1>
                                    <p><?php echo esc_html__( 'Wouuupsy, looks like you got lost!', 'explain' ); ?></p>
                                </header><!-- .page-header -->

                                <div class="page-content-404-child">
                                    <div class="explain-code-to-me-404"></div>
                                    <?php
                                    $error_page_image = ND\newsmatic_get_customizer_option( 'error_page_image' );
                                    if( $error_page_image != 0 ) {
                                        echo wp_get_attachment_image( $error_page_image, 'full' );
                                    }
                                    ?>
                                </div><!-- .page-content -->

                            </div><!-- .post-inner-wrapper -->
                        </section><!-- .error-404 -->
                    </div>
            </div>
        </main><!-- #main -->
    </div><!-- #theme-content -->


<!-- Add news carrousel: Discover also -->
<?php
    do_action( 'newsmatic_bottom_full_width_blocks_hook' );
?>
<?php
get_footer();
