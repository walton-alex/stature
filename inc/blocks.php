<?php
/**
 * Shared helpers for ACF block render templates.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

function stature_block_link( $link, string $fallback_url, string $fallback_label ): array {
	$link   = is_array( $link ) ? $link : array();
	$target = ! empty( $link['target'] ) ? $link['target'] : '';

	return array(
		'url'    => ! empty( $link['url'] ) ? $link['url'] : $fallback_url,
		'label'  => ! empty( $link['title'] ) ? $link['title'] : $fallback_label,
		'target' => $target,
		'rel'    => $target ? 'noopener' : '',
	);
}

function stature_block_classes( array $block, string $base ): string {
	$classes = array( $base );

	if ( ! empty( $block['className'] ) ) {
		$classes[] = $block['className'];
	}

	return implode( ' ', $classes );
}

function stature_block_heading_tag( string $level, array $allowed = array( 'h1', 'h2' ), string $default = 'h1' ): string {
	return in_array( $level, $allowed, true ) ? $level : $default;
}

function stature_section_classes( array $block, string $base, string $background = 'white' ): string {
	$classes = array( $base, 'stature-section', "stature-section--{$background}" );

	if ( ! empty( $block['className'] ) ) {
		$classes[] = $block['className'];
	}

	return implode( ' ', $classes );
}

/**
 * Offer the site's Gravity Forms as choices on the Contact block's form field.
 *
 * @param array $field The ACF field.
 */
function stature_load_gravity_forms( array $field ): array {
	$field['choices'] = array();

	if ( ! class_exists( 'GFAPI' ) ) {
		return $field;
	}

	foreach ( GFAPI::get_forms() as $form ) {
		$field['choices'][ (string) $form['id'] ] = $form['title'];
	}

	return $field;
}
add_filter( 'acf/load_field/name=form_id', 'stature_load_gravity_forms' );

