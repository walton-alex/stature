<?php
/**
 * Banner block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

get_template_part(
	'parts/page-banner',
	null,
	array(
		'eyebrow' => (string) get_field( 'eyebrow' ),
		'heading' => (string) get_field( 'heading' ),
		'lead'    => (string) get_field( 'lead' ),
		'width'   => (string) get_field( 'heading_width' ),
		'classes' => ! empty( $block['className'] ) ? $block['className'] : '',
		'anchor'  => ! empty( $block['anchor'] ) ? $block['anchor'] : '',
	)
);
