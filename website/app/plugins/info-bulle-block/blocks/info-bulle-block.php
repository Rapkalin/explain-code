<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package info-bulle-block
 */

add_action( 'init', 'info_bulle_block_block_init' );

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @return void
 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function info_bulle_block_block_init() : void
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = __DIR__ ;

	$index_js = 'info-bulle-block/index.js';
	wp_register_script(
		'info-bulle-block-block-editor',
		plugins_url( $index_js, __FILE__ ),
		[
			'wp-editor',
			'wp-i18n',
			'wp-element',
            'wp-components'
		],
		filemtime( "{$dir}/{$index_js}" )
	);

	$editor_css = 'info-bulle-block/editor.css';
	wp_register_style(
		'info-bulle-block-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		[],
		filemtime( "{$dir}/{$editor_css}" )
	);

	$style_css = 'info-bulle-block/style.css';
	wp_register_style(
		'info-bulle-block-block',
		plugins_url( $style_css, __FILE__ ),
		[],
		filemtime( "{$dir}/{$style_css}" )
	);

	register_block_type( 'info-bulle-block/info-bulle-block', [
		'editor_script' => 'info-bulle-block-block-editor',
		'editor_style'  => 'info-bulle-block-block-editor',
		'style'         => 'info-bulle-block-block',
        'attributes'    => [
            'content' => ['type' => 'string'],
            'bulleMode' => ['type' => 'string', 'default' => 'information'],
            'backgroundColor' => ['type' => 'string', 'default' => '#E6F4FA'],
        ],
        'render_callback' => 'info_bulle_render'
	] );
}

/**
 * @param array $attributes
 *
 * @return string|void
 */
function info_bulle_render(array $attributes) : string
{
    if(isset($attributes['content'])) {
        return <<<HTML
            <div 
            class="info-bulle-component icon-{$attributes['bulleMode']}" 
            style="background-color: {$attributes['backgroundColor']};"
            >
                {$attributes['content']}
            </div>
        HTML;
    }

    return "";
}