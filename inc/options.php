<?php
/**
 * Site-wide ACF options.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

function stature_register_options_page(): void {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Stature settings', 'stature' ),
			'menu_title' => __( 'Stature', 'stature' ),
			'menu_slug'  => 'stature-settings',
			'capability' => 'edit_theme_options',
			'icon_url'   => 'dashicons-admin-customizer',
			'position'   => 59,
			'redirect'   => false,
		)
	);
}
add_action( 'acf/init', 'stature_register_options_page' );

/**
 * The site-wide call to action, used by the CTA banner block and the case study template.
 *
 * @return array{heading:string,body:string,cta:array,motif:mixed}
 */
function stature_site_cta(): array {
	$heading = function_exists( 'get_field' ) ? (string) get_field( 'cta_heading', 'option' ) : '';
	$body    = function_exists( 'get_field' ) ? (string) get_field( 'cta_body', 'option' ) : '';
	$link    = function_exists( 'get_field' ) ? get_field( 'cta_link', 'option' ) : null;
	$motif   = function_exists( 'get_field' ) ? get_field( 'cta_motif', 'option' ) : null;

	return array(
		'heading' => '' !== $heading ? $heading : __( 'Ready to look like the agency you are?', 'stature' ),
		'body'    => $body,
		'cta'     => stature_block_link( $link, stature_url( 'start-a-project' ), __( 'Start a Project', 'stature' ) ),
		'motif'   => $motif,
	);
}
