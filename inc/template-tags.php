<?php
/**
 * Template helpers shared by template parts and block render templates.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

function stature_url( string $slug = '' ): string {
	if ( '' === $slug ) {
		return home_url( '/' );
	}

	$page = get_page_by_path( $slug );

	return $page ? (string) get_permalink( $page ) : home_url( "/{$slug}/" );
}

function stature_header_variant(): string {
	$variant = ( is_front_page() || is_page( 'start-a-project' ) ) ? 'white' : 'navy';

	return (string) apply_filters( 'stature_header_variant', $variant );
}

function stature_button_classes( string $variant = 'primary', string $size = 'md', bool $on_navy = false ): string {
	$classes = array(
		'stature-btn',
		"stature-btn--{$variant}",
		"stature-btn--{$size}",
	);

	if ( $on_navy ) {
		$classes[] = 'is-on-navy';
	}

	return implode( ' ', $classes );
}


function stature_asset( string $path ): string {
	return get_theme_file_uri( 'assets/' . ltrim( $path, '/' ) );
}

/**
 * Sanitise a testimonial attribution. Editors write plain text, or an inline
 * link to the person's profile; everything else is stripped.
 *
 * @param string $attribution Raw field value.
 */
function stature_attribution_html( string $attribution ): string {
	return wp_kses(
		$attribution,
		array(
			'a'      => array(
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
				'title'  => array(),
			),
			'em'     => array(),
			'strong' => array(),
		)
	);
}

/**
 * Split a quote into paragraphs. Each line break the editor typed starts a new
 * one; blank lines collapse.
 *
 * @param string $quote Raw field value.
 *
 * @return string[]
 */
function stature_quote_paragraphs( string $quote ): array {
	$paragraphs = preg_split( '/\R+/', trim( $quote ) );

	return array_values( array_filter( array_map( 'trim', (array) $paragraphs ), 'strlen' ) );
}

function stature_menu_title( string $location, string $default ): string {
	$locations = get_nav_menu_locations();

	if ( ! empty( $locations[ $location ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $location ] );

		if ( $menu ) {
			return $menu->name;
		}
	}

	return $default;
}

function stature_header_nav(): void {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'stature-header__menu',
				'depth'          => 2,
				'walker'         => new Stature_Header_Walker(),
				'fallback_cb'    => false,
			)
		);

		return;
	}

	stature_header_nav_fallback();
}

function stature_header_nav_fallback(): void {
	$pricing_children = array(
		'Project Pricing'   => 'pricing',
		'Discovery'         => 'paid-discovery',
		'Hosting & Support' => 'hosting-support',
	);

	$pricing_active = is_page( array_values( $pricing_children ) );
	$work_active    = is_page( 'case-studies' ) || is_singular( 'case_study' );

	echo '<ul class="stature-header__menu">';

	printf(
		'<li class="stature-header__item"><a class="stature-header__link%s" href="%s">%s</a></li>',
		is_front_page() ? ' is-active' : '',
		esc_url( stature_url() ),
		esc_html__( 'Home', 'stature' )
	);

	printf(
		'<li class="stature-header__item"><a class="stature-header__link%s" href="%s">%s</a></li>',
		is_page( 'about' ) ? ' is-active' : '',
		esc_url( stature_url( 'about' ) ),
		esc_html__( 'About', 'stature' )
	);

	printf(
		'<li class="stature-header__item"><a class="stature-header__link%s" href="%s">%s</a></li>',
		$work_active ? ' is-active' : '',
		esc_url( stature_url( 'case-studies' ) ),
		esc_html__( 'Case Studies', 'stature' )
	);

	printf(
		'<li class="stature-header__item stature-header__dropdown"><a class="stature-header__link stature-header__link--parent%s" href="%s" aria-haspopup="true" aria-expanded="false">%s%s</a>',
		$pricing_active ? ' is-active' : '',
		esc_url( stature_url( 'pricing' ) ),
		esc_html__( 'Pricing', 'stature' ),
		'<svg class="stature-header__chevron" aria-hidden="true" focusable="false" width="10" height="10" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>'
	);

	echo '<ul class="stature-header__submenu">';

	foreach ( $pricing_children as $label => $slug ) {
		printf(
			'<li class="stature-header__item"><a class="stature-header__sublink%s" href="%s">%s</a></li>',
			is_page( $slug ) ? ' is-active' : '',
			esc_url( stature_url( $slug ) ),
			esc_html( $label )
		);
	}

	echo '</ul></li></ul>';
}

function stature_footer_nav( string $location, array $fallback ): void {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => 'stature-footer__links',
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);

		return;
	}

	echo '<ul class="stature-footer__links">';

	foreach ( $fallback as $label => $slug ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( stature_url( $slug ) ),
			esc_html( $label )
		);
	}

	echo '</ul>';
}
