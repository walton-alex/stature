<?php
/**
 * Stature theme bootstrap.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

define( 'STATURE_VERSION', '0.1.0' );

require_once get_theme_file_path( 'inc/blocks.php' );
require_once get_theme_file_path( 'inc/post-types.php' );
require_once get_theme_file_path( 'inc/options.php' );
require_once get_theme_file_path( 'inc/class-stature-header-walker.php' );
require_once get_theme_file_path( 'inc/template-tags.php' );

function stature_asset_version( string $relative_path ): string {
	$path = get_theme_file_path( $relative_path );

	return file_exists( $path ) ? (string) filemtime( $path ) : STATURE_VERSION;
}

function stature_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'primary'       => __( 'Primary (header)', 'stature' ),
			'footer_first'  => __( 'Footer — first column', 'stature' ),
			'footer_second' => __( 'Footer — second column', 'stature' ),
		)
	);

	add_editor_style(
		array(
			'assets/css/tokens.css',
			'assets/css/typography.css',
			'assets/css/base.css',
		)
	);
}
add_action( 'after_setup_theme', 'stature_setup' );

function stature_enqueue_assets(): void {
	$styles = array(
		'stature-tokens'     => 'assets/css/tokens.css',
		'stature-typography' => 'assets/css/typography.css',
		'stature-base'       => 'assets/css/base.css',
		'stature-header'     => 'assets/css/header.css',
		'stature-footer'     => 'assets/css/footer.css',
	);

	$deps = array();

	foreach ( $styles as $handle => $path ) {
		wp_enqueue_style( $handle, get_theme_file_uri( $path ), $deps, stature_asset_version( $path ) );

		$deps = array( $handle );
	}

	if ( is_singular( 'case_study' ) ) {
		wp_enqueue_style(
			'stature-case-study',
			get_theme_file_uri( 'assets/css/case-study.css' ),
			array( 'stature-base' ),
			stature_asset_version( 'assets/css/case-study.css' )
		);

		// The template renders these components directly, so their block styles
		// are never triggered by the block renderer.
		stature_enqueue_block_styles( array( 'stature/banner', 'stature/cta-banner' ) );
	}

	$id = get_queried_object_id();

	if ( is_singular() && ( has_block( 'stature/contact', $id ) || has_block( 'stature/questionnaire', $id ) ) ) {
		wp_enqueue_style(
			'stature-gforms',
			get_theme_file_uri( 'assets/css/gforms.css' ),
			array( 'stature-base' ),
			stature_asset_version( 'assets/css/gforms.css' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'stature_enqueue_assets' );

/**
 * Enqueue the stylesheets a block registers, for components rendered outside the block editor.
 *
 * @param array $block_names Fully qualified block names.
 */
function stature_enqueue_block_styles( array $block_names ): void {
	$registry = WP_Block_Type_Registry::get_instance();

	foreach ( $block_names as $name ) {
		$type = $registry->get_registered( $name );

		if ( ! $type ) {
			continue;
		}

		foreach ( (array) $type->style_handles as $handle ) {
			wp_enqueue_style( $handle );
		}
	}
}

function stature_enqueue_script_modules(): void {
	if ( ! function_exists( 'wp_enqueue_script_module' ) ) {
		return;
	}

	wp_register_script_module(
		'@stature/utils',
		get_theme_file_uri( 'assets/js/utils.js' ),
		array(),
		stature_asset_version( 'assets/js/utils.js' )
	);

	wp_enqueue_script_module(
		'@stature/header',
		get_theme_file_uri( 'assets/js/header.js' ),
		array( '@stature/utils' ),
		stature_asset_version( 'assets/js/header.js' )
	);

	if ( is_singular() && has_block( 'stature/questionnaire', get_queried_object_id() ) ) {
		wp_enqueue_script_module(
			'@stature/questionnaire',
			get_theme_file_uri( 'assets/js/questionnaire.js' ),
			array( '@stature/utils' ),
			stature_asset_version( 'assets/js/questionnaire.js' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'stature_enqueue_script_modules' );

function stature_block_category( array $categories ): array {
	array_unshift(
		$categories,
		array(
			'slug'  => 'stature',
			'title' => __( 'Stature', 'stature' ),
			'icon'  => null,
		)
	);

	return $categories;
}
add_filter( 'block_categories_all', 'stature_block_category' );

function stature_register_blocks(): void {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	foreach ( (array) glob( get_theme_file_path( 'blocks' ) . '/*/block.json' ) as $block_json ) {
		register_block_type( dirname( $block_json ) );
	}
}
add_action( 'init', 'stature_register_blocks' );

function stature_acf_json_save_point(): string {
	return get_theme_file_path( 'acf-json' );
}
add_filter( 'acf/settings/save_json', 'stature_acf_json_save_point' );

function stature_acf_json_load_point( array $paths ): array {
	$paths[] = get_theme_file_path( 'acf-json' );

	return $paths;
}
add_filter( 'acf/settings/load_json', 'stature_acf_json_load_point' );

function stature_acf_missing_notice(): void {
	if ( function_exists( 'acf_register_block_type' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	printf(
		'<div class="notice notice-error"><p>%s</p></div>',
		esc_html__( 'The Stature theme requires Advanced Custom Fields Pro. Its blocks will not register or render until ACF Pro is installed and activated.', 'stature' )
	);
}
add_action( 'admin_notices', 'stature_acf_missing_notice' );
