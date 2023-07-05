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
                        <section class="error-404-child">
                            <div class="post-inner-wrapper-404">

                                <header class="page-header-404-child site-header layout--default layout--on">
                                    <div class="explain-code-to-me-404" >
                                        <img id="lost-404-gif" src="/app/themes/newsmatic-child/images/explain-code-to-me-404.gif" alt="">
                                    </div>
                                    <h1 class="main-header page-title-404 newsmatic-block-title"><?php echo esc_html__( '404 Not Found', 'explain' ); ?></h1>
                                    <p><?php echo esc_html__( 'Wouuupsy, looks like you got lost!', 'explain' ); ?></p>
                                    <?php
                                        do_action( 'newsmatic_child_404_header__menu_section_hook' );
                                    ?>
                                    <div>
                                        <?php echo get_search_form(); ?>
                                    </div>
                                </header><!-- .page-header -->

                                <div class="page-content-404-child">
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
