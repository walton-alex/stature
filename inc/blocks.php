<?php
/**
 * Shared helpers for ACF block render templates.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

function stature_block_field( array $block, string $name, string $key ): string {
	$value = (string) get_field( $name );

	if ( '' !== $value || ! empty( $block['data'] ) ) {
		return $value;
	}

	$object = get_field_object( $key );

	return isset( $object['default_value'] ) ? (string) $object['default_value'] : '';
}

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
