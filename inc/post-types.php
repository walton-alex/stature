<?php
/**
 * Custom post types.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

function stature_register_post_types(): void {
	register_post_type(
		'case_study',
		array(
			'labels'              => array(
				'name'               => __( 'Case studies', 'stature' ),
				'singular_name'      => __( 'Case study', 'stature' ),
				'add_new_item'       => __( 'Add case study', 'stature' ),
				'edit_item'          => __( 'Edit case study', 'stature' ),
				'new_item'           => __( 'New case study', 'stature' ),
				'view_item'          => __( 'View case study', 'stature' ),
				'search_items'       => __( 'Search case studies', 'stature' ),
				'not_found'          => __( 'No case studies found', 'stature' ),
				'menu_name'          => __( 'Case studies', 'stature' ),
			),
			'public'              => true,
			'has_archive'         => false,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-portfolio',
			'menu_position'       => 21,
			'supports'            => array( 'title', 'thumbnail', 'page-attributes', 'revisions' ),
			'rewrite'             => array(
				'slug'       => 'case-studies',
				'with_front' => false,
			),
			'exclude_from_search' => false,
		)
	);
}
add_action( 'init', 'stature_register_post_types' );

/**
 * The next case study by menu order, wrapping around to the first.
 *
 * @param int $current_id The case study being viewed.
 */
function stature_next_case_study( int $current_id ): ?WP_Post {
	$all = get_posts(
		array(
			'post_type'        => 'case_study',
			'post_status'      => 'publish',
			'numberposts'      => -1,
			'orderby'          => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
			'suppress_filters' => false,
		)
	);

	if ( count( $all ) < 2 ) {
		return null;
	}

	$ids   = wp_list_pluck( $all, 'ID' );
	$index = array_search( $current_id, $ids, true );

	if ( false === $index ) {
		return null;
	}

	return $all[ ( $index + 1 ) % count( $all ) ];
}
