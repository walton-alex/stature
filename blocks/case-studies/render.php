<?php
/**
 * Case study cards block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$bg            = (string) get_field( 'background' );
$feature_first = (bool) get_field( 'feature_first' );
$count         = (int) get_field( 'count' );

$bg = in_array( $bg, array( 'white', 'grey' ), true ) ? $bg : 'white';

$query = new WP_Query(
	array(
		'post_type'      => 'case_study',
		'post_status'    => 'publish',
		'posts_per_page' => $count > 0 ? $count : -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'  => true,
	)
);

if ( ! $query->have_posts() ) {
	return;
}

$posts = $query->posts;
wp_reset_postdata();

$featured = $feature_first ? array_shift( $posts ) : null;

$classes = stature_section_classes( $block, 'stature-case-studies', $bg );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<div class="stature-container stature-section__inner">
		<div class="stature-case-studies__stack">
			<?php
			if ( $featured ) {
				get_template_part( 'parts/case-study-card', null, array( 'post' => $featured, 'featured' => true ) );
			}
			?>

			<?php if ( $posts ) : ?>
				<div class="stature-case-studies__grid">
					<?php
					foreach ( $posts as $case_study ) {
						get_template_part( 'parts/case-study-card', null, array( 'post' => $case_study, 'featured' => false ) );
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
