<?php

use Newsmatic\CustomizerDefault as ND;

add_action ( 'newsmatic_before_main_content', 'newsmatic_child_author_hook');

/* Load styles and scripts */
add_action( 'wp_enqueue_scripts', 'newsmatic_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'newsmatic_child_register_style', 11 );

/* Load internationalisation / translations */
add_action( 'after_setup_theme', 'newsmatic_child_theme_locale' );

/* Retrieve mods from parent to child theme */
add_action( 'after_switch_theme', 'set_newsmatic_child_theme_mods' );

/* Remove self pings */
add_action( 'pre_ping', 'no_self_ping' );

/* Override header for 404 */
add_action( 'newsmatic_header__menu_section_hook', 'newsmatic_child_header_menu_404_hook', 11 );

/* Override header */
add_action( 'newsmatic_header__site_branding_section_hook', 'newsmatic_child_header_branding_hook', 4 );

/* Override bottom footer */
add_action( 'newsmatic_botttom_footer_hook', 'newsmatic_child_bottom_footer_hook', 11 );

/* Update parent theme */
add_action( 'newsmatic_child_404_header__menu_section_hook', 'newsmatic_header_menu_part' );
add_action( 'newsmatic_child_404_header_icon__menu_section_hook', 'newsmatic_header_theme_mode_icon_part' );
add_action( 'newsmatic_child_404_header__section_hook', 'newsmatic_header_search_part' );

add_action('init', 'nesmatic_child_init_hook');

// Override header title to remove the separator
add_filter( 'pre_get_document_title', 'newsmatic_child_title', 999, 1 );
function newsmatic_child_title($title): string
{
    return rtrim($title, " -");
}

function nesmatic_child_init_hook(): void
{
    # Update pagination button
    if (function_exists('newsmatic_pagination_fnc')) {
        remove_action('newsmatic_pagination_link_hook', 'newsmatic_pagination_fnc');
        add_action('newsmatic_pagination_link_hook', 'newsmatic_child_pagination_fnc');
    }
}

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

    wp_register_style( 'newsmatic-child-style-author', get_stylesheet_directory_uri() . '/styles/author.css' );
    wp_enqueue_style( 'newsmatic-child-style-author');

    wp_register_style( 'newsmatic-child-style-articles', get_stylesheet_directory_uri() . '/styles/articles.css' );
    wp_enqueue_style( 'newsmatic-child-style-articles');

    wp_register_style( 'newsmatic-child-style-footer', get_stylesheet_directory_uri() . '/styles/footer.css' );
    wp_enqueue_style( 'newsmatic-child-style-footer');

    wp_register_style( 'newsmatic-child-style-header', get_stylesheet_directory_uri() . '/styles/header.css' );
    wp_enqueue_style( 'newsmatic-child-style-header');

    wp_register_style( 'newsmatic-child-style-homepage', get_stylesheet_directory_uri() . '/styles/homepage.css' );
    wp_enqueue_style( 'newsmatic-child-style-homepage');

    wp_register_style( 'newsmatic-child-style-main-child', get_stylesheet_directory_uri() . '/styles/main-child.css' );
    wp_enqueue_style( 'newsmatic-child-style-main-child');

    wp_register_style( 'newsmatic-child-style-404', get_stylesheet_directory_uri() . '/styles/404.css' );
    wp_enqueue_style( 'newsmatic-child-style-404');

    wp_register_style( 'newsmatic-child-style-search', get_stylesheet_directory_uri() . '/styles/search.css' );
    wp_enqueue_style( 'newsmatic-child-style-search');
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
function newsmatic_child_author_hook(): void
{
    /* Update author template */
    if (function_exists('newsmatic_category_archive_author_html')) {
        remove_action( 'newsmatic_before_main_content', 'newsmatic_category_archive_author_html', 20 );
        add_action( 'newsmatic_before_main_content', 'newsmatic_child_category_archive_author_html', 20 );
    }
}

function newsmatic_child_header_menu_404_hook(): void
{
    # Remove native menu for 404
    if(is_404() && function_exists('newsmatic_header_menu_part')) {
        remove_action( 'newsmatic_header__menu_section_hook', 'newsmatic_header_theme_mode_icon_part', 60 );
        remove_action( 'newsmatic_header__menu_section_hook', 'newsmatic_header_search_part', 50 );
        remove_action( 'newsmatic_header__menu_section_hook', 'newsmatic_header_menu_part', 40 );
    }
}

function newsmatic_child_header_branding_hook(): void
{
    # Remove social media part to center logo properly
    if (function_exists('newsmatic_top_header_social_part')) {
        remove_action('newsmatic_header__site_branding_section_hook', 'newsmatic_top_header_social_part', 5);
    }

    # Update search and theme buttons
    if (function_exists('newsmatic_header_search_part')) {
        remove_action('newsmatic_header__menu_section_hook', 'newsmatic_header_search_part', 50);
        add_action('newsmatic_header__menu_section_hook', 'newsmatic_child_header_search_part', 50);
    }

    if (function_exists('newsmatic_header_theme_mode_icon_part')) {
        remove_action('newsmatic_header__menu_section_hook', 'newsmatic_header_theme_mode_icon_part', 60);
        add_action('newsmatic_header__menu_section_hook', 'newsmatic_child_header_theme_mode_icon_part', 60);
    }
}

function newsmatic_child_bottom_footer_hook(): void
{
    # Remove the newsmatic's theme footer function to overide it
    if (function_exists('newsmatic_bottom_footer_copyright_part')) {
        remove_action('newsmatic_botttom_footer_hook', 'newsmatic_bottom_footer_copyright_part', 20);
        add_action('newsmatic_botttom_footer_hook', 'newsmatic_child_bottom_footer_copyright_part', 20);
    }
}

/**
 * Add details on search button in header
 * @return void
 */
function newsmatic_child_header_search_part(): void
{
    if(!ND\newsmatic_get_customizer_option( 'header_search_option')) return;
    ?>
    <div class="search-wrap">
        <button class="search-trigger" aria-label="Rechercher du contenu" name="Rechercher du contenu">
            <i class="fas fa-search"></i>
        </button>
        <div class="search-form-wrap hide">
            <?php echo get_search_form(); ?>
        </div>
    </div>
    <?php
}

function newsmatic_child_header_theme_mode_icon_part(): void
{
    if(!ND\newsmatic_get_customizer_option( 'header_theme_mode_toggle_option')) return;
    $theme_mode_dark = ( isset( $_COOKIE['themeMode'] ) && $_COOKIE['themeMode'] == 'dark' );
    ?>
    <div class="mode_toggle_wrap">
        <input aria-label="Changer de mode d'affichage" class="mode_toggle" type="checkbox" name="mode_toggle"
            <?php echo checked(true, $theme_mode_dark); ?>
        >
    </div>
    <?php
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

function newsmatic_child_category_archive_author_html(): void
{
    if( ! is_author() ) return;
    $author_id =  get_query_var( 'author' );
    ?>
    <div class="newsmatic-container newsmatic-author-section">
        <div class="row">
            <?php echo wp_kses_post( get_avatar($author_id, 125) ); ?>
            <div class="author-content">
                <h2 class="author-name"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></h2>
                <p class="author-desc"><?php echo nl2br(wp_kses_post( get_the_author_meta('description', $author_id) )); ?></p>
            </div>
        </div>
    </div>
    <?php
}

function newsmatic_child_pagination_fnc(): void
{
    if( is_null( paginate_links() ) ) {
        return;
    }
    echo '<div class="pagination">' .
        wp_kses_post(paginate_links([
            'prev_text' => '<i class="fas fa-chevron-left" aria-label="Chevron gauche"></i>',
            'next_text' => '<i class="fas fa-chevron-right" aria-label="Chevron gauche"></i>',
            'type' => 'list'
        ])) .
        '</div>'
    ;
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

