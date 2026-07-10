<?php
/**
 * CTA banner component: rounded navy panel with grain, heading, body and button.
 *
 * @param string $args['heading'] Heading text.
 * @param string $args['body']    Paragraph.
 * @param array  $args['cta']     Normalised link: url, label, target, rel.
 * @param mixed  $args['motif']   ACF image array or attachment ID.
 * @param string $args['classes'] Extra classes for the section.
 * @param string $args['anchor']  Section id.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$panel = wp_parse_args(
	$args ?? array(),
	array(
		'heading' => '',
		'body'    => '',
		'cta'     => array(),
		'motif'   => null,
		'classes' => '',
		'anchor'  => '',
	)
);

$motif_id = 0;

if ( is_array( $panel['motif'] ) && ! empty( $panel['motif']['ID'] ) ) {
	$motif_id = (int) $panel['motif']['ID'];
} elseif ( is_numeric( $panel['motif'] ) ) {
	$motif_id = (int) $panel['motif'];
}

$classes = trim( 'stature-cta-banner stature-section stature-section--white ' . $panel['classes'] );
?>
<section
	<?php if ( '' !== $panel['anchor'] ) : ?>
		id="<?php echo esc_attr( $panel['anchor'] ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<div class="stature-container stature-section__inner">
		<div class="stature-cta-banner__panel">
			<div class="stature-grain" aria-hidden="true"></div>

			<?php
			if ( $motif_id ) {
				echo wp_get_attachment_image(
					$motif_id,
					'full',
					false,
					array(
						'class'       => 'stature-cta-banner__motif',
						'aria-hidden' => 'true',
						'alt'         => '',
						'loading'     => 'lazy',
					)
				);
			}
			?>

			<div class="stature-cta-banner__content">
				<?php if ( '' !== $panel['heading'] ) : ?>
					<h2 class="stature-cta-banner__heading stature-heading stature-heading--h2 is-on-navy">
						<?php echo esc_html( $panel['heading'] ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( '' !== $panel['body'] ) : ?>
					<p class="stature-cta-banner__body"><?php echo esc_html( $panel['body'] ); ?></p>
				<?php endif; ?>

				<?php
				if ( $panel['cta'] ) {
					get_template_part(
						'parts/button',
						null,
						array_merge( $panel['cta'], array( 'size' => 'lg', 'on_navy' => true ) )
					);
				}
				?>
			</div>
		</div>
	</div>
</section>
