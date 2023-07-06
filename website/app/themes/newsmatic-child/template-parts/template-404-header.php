<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newsmatic
 */
use Newsmatic\CustomizerDefault as ND;
?>
    <!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>

<body <?php body_class(); ?> <?php newsmatic_schema_body_attributes(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'newsmatic' ); ?></a>
    <div class="newsmatic_ovelay_div"></div>
    <?php
    /**
     * hook - newsmatic_page_prepend_hook
     *
     * @package Newsmatic
     * @since 1.0.0
     */
    do_action( "newsmatic_page_prepend_hook" );
    ?>

    <header id="masthead" class="site-header layout--default layout--one">
        <?php
        /**
         * Function - newsmatic_top_header_html
         *
         * @since 1.0.0
         *
         */
        newsmatic_top_header_html();
        ?>
    </header><!-- #masthead -->

<?php
/**
 * function - newsmatic_after_header_html
 *
 * @since 1.0.0
 */
newsmatic_after_header_html();