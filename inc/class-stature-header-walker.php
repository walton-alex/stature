<?php
/**
 * Header navigation walker.
 *
 * Produces the markup the header CSS expects: a flat row of links, where any
 * item with children becomes a hover/focus dropdown with a rotating chevron.
 *
 * Reference: _design/components/marketing/SiteHeader.jsx
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

class Stature_Header_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="stature-header__submenu">';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes      = (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$is_current   = in_array( 'current-menu-item', $classes, true )
			|| in_array( 'current-menu-ancestor', $classes, true )
			|| in_array( 'current-menu-parent', $classes, true );

		$item_classes = array( 'stature-header__item' );
		$link_classes = array( 0 === $depth ? 'stature-header__link' : 'stature-header__sublink' );

		if ( $has_children ) {
			$item_classes[] = 'stature-header__dropdown';
			$link_classes[] = 'stature-header__link--parent';
		}

		if ( $is_current ) {
			$link_classes[] = 'is-active';
		}

		$attributes = '';

		if ( ! empty( $item->url ) ) {
			$attributes .= ' href="' . esc_url( $item->url ) . '"';
		}

		if ( ! empty( $item->target ) ) {
			$attributes .= ' target="' . esc_attr( $item->target ) . '" rel="noopener"';
		}

		if ( $has_children ) {
			$attributes .= ' aria-haspopup="true" aria-expanded="false"';
		}

		$chevron = $has_children
			? '<svg class="stature-header__chevron" aria-hidden="true" focusable="false" width="10" height="10" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>'
			: '';

		$output .= sprintf(
			'<li class="%s"><a class="%s"%s>%s%s</a>',
			esc_attr( implode( ' ', $item_classes ) ),
			esc_attr( implode( ' ', $link_classes ) ),
			$attributes,
			esc_html( $item->title ),
			$chevron
		);
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
