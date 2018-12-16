<?php
/**
 * Gutenberg theme support.
 *
 * @package Sant Joan de Gracia
 * @author  Max Terbeck
 * @license GPL-2.0-or-later
 * @link    https://www.mediactiu.com/
 */

add_action( 'wp_enqueue_scripts', 'sjdg_enqueue_gutenberg_frontend_styles' );
/**
 * Enqueues Gutenberg front-end styles.
 *
 * @since 2.7.0
 */
function sjdg_enqueue_gutenberg_frontend_styles() {

	wp_enqueue_style(
		'sjdg-gutenberg',
		get_stylesheet_directory_uri() . '/lib/gutenberg/front-end.css',
		array( 'sjdg' ),
		CHILD_THEME_VERSION
	);

	wp_enqueue_script(
		'fitvids',
		get_stylesheet_directory_uri() . '/lib/gutenberg/js/jquery.fitvids.min.js',
		array( 'jquery' ),
		'1.1',
		true
	);

	wp_enqueue_script(
		'fitvids-init',
		get_stylesheet_directory_uri() . '/lib/gutenberg/js/fitvids-init.js',
		array( 'jquery', 'fitvids' ),
		CHILD_THEME_VERSION,
		true
	);

}

add_action( 'enqueue_block_editor_assets', 'sjdg_block_editor_styles' );
/**
 * Enqueues Gutenberg admin editor fonts and styles.
 *
 * @since 2.7.0
 */
function sjdg_block_editor_styles() {

	wp_enqueue_style(
		'sjdg-gutenberg-fonts',
		'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700',
		array(),
		CHILD_THEME_VERSION
	);

}

// Add support for editor styles.
add_theme_support( 'editor-styles' );

// Enqueue editor styles.
add_editor_style( '/lib/gutenberg/style-editor.css' );

// Adds support for block alignments.
add_theme_support( 'align-wide' );

// Adds support for editor font sizes.
add_theme_support(
	'editor-font-sizes',
	array(
		array(
			'name'      => __( 'small', 'sjdg' ),
			'shortName' => __( 'S', 'sjdg' ),
			'size'      => 12,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'regular', 'sjdg' ),
			'shortName' => __( 'M', 'sjdg' ),
			'size'      => 16,
			'slug'      => 'regular',
		),
		array(
			'name'      => __( 'large', 'sjdg' ),
			'shortName' => __( 'L', 'sjdg' ),
			'size'      => 20,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'larger', 'sjdg' ),
			'shortName' => __( 'XL', 'sjdg' ),
			'size'      => 24,
			'slug'      => 'larger',
		),
	)
);

// Adds support for editor color palette.
add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => __( 'Light gray', 'sjdg' ),
			'slug'  => 'light-gray',
			'color' => '#f5f5f5',
		),
		array(
			'name'  => __( 'Medium gray', 'sjdg' ),
			'slug'  => 'medium-gray',
			'color' => '#999',
		),
		array(
			'name'  => __( 'Dark gray', 'sjdg' ),
			'slug'  => 'dark-gray',
			'color' => '#333',
		),
	)
);

add_action( 'after_setup_theme', 'sjdg_content_width', 0 );
/**
 * Set content width to match the “wide” Gutenberg block width.
 */
function sjdg_content_width() {

	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- See https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/924
	$GLOBALS['content_width'] = apply_filters( 'sjdg_content_width', 1062 );

}
