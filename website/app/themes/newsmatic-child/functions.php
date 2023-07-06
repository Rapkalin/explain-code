<?php

use Newsmatic\CustomizerDefault as ND;

/* Load styles and scripts */
add_action( 'wp_enqueue_scripts', 'newsmatic_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'newsmatic_child_register_style', 11 );

/* Load internationalisation / translations */
add_action( 'after_setup_theme', 'newsmatic_child_theme_locale' );

/* Retrieve mods from parent to child theme */
add_action( 'after_switch_theme', 'set_newsmatic_child_theme_mods' );

/* Remove self pings */
add_action( 'pre_ping', 'no_self_ping' );

/* Remove parent theme actions */
add_action( 'newsmatic_botttom_footer_hook', 'newsmatic_update_parent_action', 11 );
add_action( 'newsmatic_header__menu_section_hook', 'newsmatic_update_parent_action', 11 );
add_action( 'newsmatic_header__site_branding_section_hook', 'newsmatic_update_parent_action_404', 4 );

/* Update parent theme */
add_action( 'newsmatic_child_404_header__menu_section_hook', 'set_newsmatic_child_404_menu_header_section' );
add_action( 'newsmatic_child_404_header_icon__menu_section_hook', 'set_newsmatic_child_404_toggle_header_section' );
add_action( 'newsmatic_child_404_header__section_hook', 'set_newsmatic_child_404_search_header_section' );


/**
 * Add the parent theme style
 *
 * @return void
 */
function newsmatic_enqueue_styles(): void
{
    $parenthandle = 'newsmatic-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css',
        [],  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
}

/**
 * Register and add child theme style
 *
 * @return void
 */
function newsmatic_child_register_style(): void
{
    wp_register_style( 'newsmatic-child-style', get_stylesheet_uri());
    wp_enqueue_style( 'newsmatic-child-style');

    wp_register_style( 'newsmatic-child-style-articles', get_stylesheet_directory_uri() . '/styles/articles.css' );
    wp_enqueue_style( 'newsmatic-child-style-articles');

    wp_register_style( 'newsmatic-child-style-footer', get_stylesheet_directory_uri() . '/styles/footer.css' );
    wp_enqueue_style( 'newsmatic-child-style-footer');

    wp_register_style( 'newsmatic-child-style-header', get_stylesheet_directory_uri() . '/styles/header.css' );
    wp_enqueue_style( 'newsmatic-child-style-header');

    wp_register_style( 'newsmatic-child-style-homepage', get_stylesheet_directory_uri() . '/styles/homepage.css' );
    wp_enqueue_style( 'newsmatic-child-style-homepage');

    wp_register_style( 'newsmatic-child-style-main', get_stylesheet_directory_uri() . '/styles/main.css' );
    wp_enqueue_style( 'newsmatic-child-style-main');

    wp_register_style( 'newsmatic-child-style-404', get_stylesheet_directory_uri() . '/styles/404.css' );
    wp_enqueue_style( 'newsmatic-child-style-404');
}

/**
 * Retrieve parent theme mods and set them for child theme
 *
 * @return void
 */
function set_newsmatic_child_theme_mods(): void
{
    $parent_theme = get_template_directory();
    $theme_parent_slug = basename($parent_theme);
    $theme_parent_mods = get_option( "theme_mods_{$theme_parent_slug}");
    $theme_child_mods = get_theme_mods();

    if (!array_key_exists('newsmatic_site_logo_width', $theme_child_mods) && !empty($theme_parent_mods) && is_array($theme_parent_mods)) {
        foreach ($theme_parent_mods as $key => $mod) {
            set_theme_mod($key, $mod);
        }
    }
}

/**
 * Remove parent functions to override them
 *
 * @return void
 */
function newsmatic_update_parent_action(): void
{
    # Remove the newsmatic's theme footer function to overide it
    if (function_exists('newsmatic_bottom_footer_copyright_part')) {
        remove_action( 'newsmatic_botttom_footer_hook', 'newsmatic_bottom_footer_copyright_part', 20 );
        add_action( 'newsmatic_botttom_footer_hook', 'newsmatic_child_bottom_footer_copyright_part', 20 );
    }

    # Remove native menu for 404
    if(is_404() && function_exists('newsmatic_header_menu_part')) {
        remove_action( 'newsmatic_header__menu_section_hook', 'newsmatic_header_theme_mode_icon_part', 60 );
        remove_action( 'newsmatic_header__menu_section_hook', 'newsmatic_header_search_part', 50 );
        remove_action( 'newsmatic_header__menu_section_hook', 'newsmatic_header_menu_part', 40 );
    }
}

/**
 * @return void
 */
function newsmatic_update_parent_action_404(): void
{
    # Remove social media part to center logo properly
    if(is_404() && function_exists('newsmatic_top_header_social_part')) {
        remove_action('newsmatic_header__site_branding_section_hook', 'newsmatic_top_header_social_part', 5);
    }
}


/**
 * Add a copyright in the footer
 *
 * @return void
 */
function newsmatic_child_bottom_footer_copyright_part(): void
{
    ?>
    <div class="site-info">
        <?php echo  '© ' . date('Y') . ' - ' . 'Powered By Rapkalin and Noweh.' ?>
    </div>
    <?php
}

/**
 * @return void
 *
 * Load translation files from child and parent themes
 */
function newsmatic_child_theme_locale(): void
{
    load_child_theme_textdomain( 'newsmatic', get_stylesheet_directory() . '/languages' );
    load_child_theme_textdomain( 'explain', get_stylesheet_directory() . '/languages' );
}

/**
 * @param $links
 *
 * @return void
 *
 * Deactivate self pingbacks
 */
function no_self_ping(&$links): void
{
    $home = get_option('home');
    foreach ($links as $l => $link) {
        if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
}

function set_newsmatic_child_404_menu_header_section()
{
    add_action( 'newsmatic_child_404_header__menu_section_hook', 'newsmatic_header_menu_part', 40 );
}

function set_newsmatic_child_404_search_header_section()
{
    add_action( 'newsmatic_child_404_header__section_hook', 'newsmatic_header_search_part', 50 );
}

function set_newsmatic_child_404_toggle_header_section()
{
    add_action( 'newsmatic_child_404_header_icon__menu_section_hook', 'newsmatic_header_theme_mode_icon_part', 60 );
}