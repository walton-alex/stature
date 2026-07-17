<?php
/**
 * Case study card component.
 *
 * @param WP_Post $args['post']     The case study.
 * @param bool    $args['featured'] Render full width at 1152:540 rather than 4:3.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$card = wp_parse_args(
	$args ?? array(),
	array(
		'post'     => null,
		'featured' => false,
	)
);

if ( ! $card['post'] instanceof WP_Post ) {
	return;
}

$case_study = $card['post'];
$featured   = (bool) $card['featured'];
$summary    = (string) get_field( 'summary', $case_study->ID );
$thumb_id   = (int) get_post_thumbnail_id( $case_study->ID );
$thumb_id   = $thumb_id && wp_attachment_is_image( $thumb_id ) ? $thumb_id : 0;
$classes    = 'stature-case-card' . ( $featured ? ' stature-case-card--featured' : '' );
?>
<a class="<?php echo esc_attr( $classes ); ?>" href="<?php echo esc_url( (string) get_permalink( $case_study ) ); ?>">
	<div class="stature-case-card__media">
		<?php
		if ( $thumb_id ) {
			echo wp_get_attachment_image(
				$thumb_id,
				$featured ? 'large' : 'medium_large',
				false,
				array(
					'class'   => 'stature-case-card__shot stature-cover',
					'alt'     => sprintf(
						/* translators: %s: case study name. */
						esc_attr__( '%s website', 'stature' ),
						get_the_title( $case_study )
					),
					'loading' => 'lazy',
				)
			);
		} else {
			?>
			<div class="stature-case-card__placeholder" aria-hidden="true"></div>
			<span class="stature-case-card__caption stature-label"><?php esc_html_e( 'Website screens to follow', 'stature' ); ?></span>
			<?php
		}
		?>
	</div>

	<div class="stature-case-card__meta">
		<div class="stature-case-card__text">
			<h2 class="stature-case-card__name stature-heading stature-heading--<?php echo $featured ? 'h3' : 'h4'; ?>">
				<?php echo esc_html( get_the_title( $case_study ) ); ?>
			</h2>

			<?php if ( '' !== $summary ) : ?>
				<p class="stature-case-card__summary"><?php echo esc_html( $summary ); ?></p>
			<?php endif; ?>
		</div>

		<span class="stature-case-card__link">
			<?php esc_html_e( 'View case study', 'stature' ); ?>
			<span class="stature-btn__arrow" aria-hidden="true">&rarr;</span>
		</span>
	</div>
</a>
