<?php
/**
 * Testimonial card component.
 *
 * @param string $args['quote']       The quotation.
 * @param string $args['attribution'] Who said it.
 * @param bool   $args['on_navy']     Render on a navy surface.
 * @param string $args['surface']     grey | white. Ignored when on_navy.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$testimonial = wp_parse_args(
	$args ?? array(),
	array(
		'quote'       => '',
		'attribution' => '',
		'on_navy'     => false,
		'surface'     => 'grey',
	)
);

if ( '' === trim( (string) $testimonial['quote'] ) ) {
	return;
}

$on_navy = (bool) $testimonial['on_navy'];
$classes = 'stature-testimonial';

if ( $on_navy ) {
	$classes .= ' is-on-navy';
} elseif ( 'white' === $testimonial['surface'] ) {
	$classes .= ' stature-testimonial--white';
}

$symbol = $on_navy ? 'logos/stature_symbol_white.svg' : 'logos/stature_symbol_navy.svg';
?>
<figure class="<?php echo esc_attr( $classes ); ?>">
	<img class="stature-testimonial__watermark" src="<?php echo esc_url( stature_asset( $symbol ) ); ?>" alt="" aria-hidden="true">

	<div class="stature-testimonial__inner">
		<span class="stature-testimonial__mark" aria-hidden="true">&ldquo;</span>

		<blockquote class="stature-testimonial__quote"><?php echo esc_html( $testimonial['quote'] ); ?></blockquote>

		<?php if ( '' !== $testimonial['attribution'] ) : ?>
			<figcaption class="stature-testimonial__attribution">
				<span class="stature-testimonial__bar" aria-hidden="true"></span>
				<span><?php echo esc_html( $testimonial['attribution'] ); ?></span>
			</figcaption>
		<?php endif; ?>
	</div>
</figure>
