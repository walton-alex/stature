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

$heading = (string) get_field( 'heading' );
$body    = (string) get_field( 'body' );
$motif   = get_field( 'motif' );

$cta = stature_block_link(
	get_field( 'cta' ),
	stature_url( 'start-a-project' ),
	__( 'Start a Project', 'stature' )
);

$classes = stature_section_classes( $block, 'stature-cta-banner', 'white' );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<div class="stature-container stature-section__inner">
		<div class="stature-cta-banner__panel">
			<div class="stature-grain" aria-hidden="true"></div>

			<?php if ( is_array( $motif ) && ! empty( $motif['ID'] ) ) : ?>
				<?php
				echo wp_get_attachment_image(
					(int) $motif['ID'],
					'full',
					false,
					array(
						'class'       => 'stature-cta-banner__motif',
						'aria-hidden' => 'true',
						'alt'         => '',
						'loading'     => 'lazy',
					)
				);
				?>
			<?php endif; ?>

			<div class="stature-cta-banner__content">
				<?php if ( '' !== $heading ) : ?>
					<h2 class="stature-cta-banner__heading stature-heading stature-heading--h2 is-on-navy">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( '' !== $body ) : ?>
					<p class="stature-cta-banner__body"><?php echo esc_html( $body ); ?></p>
				<?php endif; ?>

				<?php
				get_template_part(
					'parts/button',
					null,
					array_merge(
						$cta,
						array(
							'size'    => 'lg',
							'on_navy' => true,
						)
					)
				);
				?>
			</div>
		</div>
	</div>
</section>
