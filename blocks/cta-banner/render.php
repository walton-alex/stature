<?php
/**
 * CTA banner block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$site    = stature_site_cta();
$heading = (string) get_field( 'heading' );
$body    = (string) get_field( 'body' );
$motif   = get_field( 'motif' );

get_template_part(
	'parts/cta-banner',
	null,
	array(
		'heading' => '' !== $heading ? $heading : $site['heading'],
		'body'    => '' !== $body ? $body : $site['body'],
		'cta'     => stature_block_link( get_field( 'cta' ), $site['cta']['url'], $site['cta']['label'] ),
		'motif'   => $motif ? $motif : $site['motif'],
		'classes' => ! empty( $block['className'] ) ? $block['className'] : '',
		'anchor'  => ! empty( $block['anchor'] ) ? $block['anchor'] : '',
	)
);
