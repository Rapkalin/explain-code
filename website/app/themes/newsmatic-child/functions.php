<?php


add_action( 'wp_enqueue_scripts', 'newsmatic_enqueue_styles');
add_action( 'wp_enqueue_scripts', 'newsmatic_child_enqueue_styles', 11 );
add_action( 'after_switch_theme', 'set_newsmatic_child_theme_mods' );
add_action( 'newsmatic_botttom_footer_hook', 'newsmatic_update_parent_action', 11 );

function newsmatic_update_parent_action ()
{
    if (function_exists('newsmatic_bottom_footer_copyright_part')) {
        remove_action( 'newsmatic_botttom_footer_hook', 'newsmatic_bottom_footer_copyright_part', 20 );
        add_action( 'newsmatic_botttom_footer_hook', 'newsmatic_child_bottom_footer_copyright_part', 20 );
    }


}

function newsmatic_child_bottom_footer_copyright_part() {
        ?>
        <div class="site-info">
            <?php echo  '© ' . date('Y') . ' - ' .'Powered By Rapkalin and Noweh.' ?>
        </div>
        <?php
}

function newsmatic_enqueue_styles ()
{
    $parenthandle = 'newsmatic-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css',
        [],  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
}

function newsmatic_child_enqueue_styles ()
{
    wp_enqueue_style( 'newsmatic-child-style', get_stylesheet_uri());
    wp_enqueue_style( 'newsmatic-child-style-articles', get_stylesheet_directory_uri() . '/styles/articles.css' );
    wp_enqueue_style( 'newsmatic-child-style-footer', get_stylesheet_directory_uri() . '/styles/footer.css' );
    wp_enqueue_style( 'newsmatic-child-style-header', get_stylesheet_directory_uri() . '/styles/header.css' );
    wp_enqueue_style( 'newsmatic-child-style-homepage', get_stylesheet_directory_uri() . '/styles/homepage.css' );
    wp_enqueue_style( 'newsmatic-child-style-main', get_stylesheet_directory_uri() . '/styles/main.css' );
}

function set_newsmatic_child_theme_mods ()
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