<?php
/**
 * Contact block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$eyebrow     = (string) get_field( 'eyebrow' );
$heading     = (string) get_field( 'heading' );
$level       = (string) get_field( 'heading_level' );
$body        = (string) get_field( 'body' );
$quote       = (string) get_field( 'quote' );
$attribution = (string) get_field( 'attribution' );
$form_id     = (int) get_field( 'form_id' );
$bg          = (string) get_field( 'background' );

$bg  = in_array( $bg, array( 'white', 'grey' ), true ) ? $bg : 'grey';
$tag = stature_block_heading_tag( $level, array( 'h1', 'h2' ), 'h1' );

$classes = stature_section_classes( $block, 'stature-contact', $bg );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<div class="stature-container stature-section__inner">
		<div class="stature-contact__grid">
			<div class="stature-contact__intro">
				<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $eyebrow ) ); ?>

				<?php if ( '' !== $heading ) : ?>
					<<?php echo esc_attr( $tag ); ?> class="stature-contact__heading stature-heading stature-heading--h2">
						<?php echo esc_html( $heading ); ?>
					</<?php echo esc_attr( $tag ); ?>>
				<?php endif; ?>

				<?php if ( '' !== $body ) : ?>
					<div class="stature-contact__body stature-prose">
						<?php echo wp_kses_post( $body ); ?>
					</div>
				<?php endif; ?>

				<?php
				get_template_part(
					'parts/testimonial',
					null,
					array(
						'quote'       => $quote,
						'attribution' => $attribution,
						'surface'     => 'white',
					)
				);
				?>
			</div>

			<div class="stature-contact__panel stature-gform">
				<?php if ( $form_id > 0 && function_exists( 'gravity_form' ) ) : ?>
					<?php gravity_form( $form_id, false, false, false, null, true, 0, true ); ?>
				<?php elseif ( $is_preview ) : ?>
					<p class="stature-contact__placeholder">
						<?php esc_html_e( 'Choose a form to display it here.', 'stature' ); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
