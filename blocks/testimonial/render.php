<?php
/**
 * Testimonial block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$quote = (string) get_field( 'quote' );

if ( '' === $quote ) {
	return;
}

$bg      = (string) get_field( 'background' );
$bg      = in_array( $bg, array( 'white', 'grey', 'navy' ), true ) ? $bg : 'grey';
$on_navy = 'navy' === $bg;

$classes = stature_section_classes( $block, 'stature-testimonial-block', $bg );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<?php if ( $on_navy ) : ?>
		<div class="stature-grain" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="stature-container stature-section__inner">
		<div class="stature-testimonial-block__card">
			<?php
			get_template_part(
				'parts/testimonial',
				null,
				array(
					'quote'       => $quote,
					'attribution' => (string) get_field( 'attribution' ),
					'on_navy'     => $on_navy,
					'surface'     => 'grey' === $bg ? 'white' : 'grey',
				)
			);
			?>
		</div>
	</div>
</section>
