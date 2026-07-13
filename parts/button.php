<?php
/**
 * Button component. Renders an anchor styled as a Stature button.
 *
 * @param string $args['label']   Button text.
 * @param string $args['url']     Destination.
 * @param string $args['variant'] primary | secondary | ghost.
 * @param string $args['size']    md | lg.
 * @param bool   $args['on_navy'] Whether the button sits on a navy surface.
 * @param string $args['target']  Link target.
 * @param string $args['rel']     Link rel.
 * @param bool   $args['arrow']   Append a trailing arrow.
 * @param string $args['class']   Extra classes, placed before the button classes.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$button = wp_parse_args(
	$args ?? array(),
	array(
		'label'   => '',
		'url'     => '',
		'variant' => 'primary',
		'size'    => 'md',
		'on_navy' => false,
		'target'  => '',
		'rel'     => '',
		'arrow'   => false,
		'class'   => '',
	)
);

if ( '' === $button['label'] || '' === $button['url'] ) {
	return;
}

$button['size'] = in_array( $button['size'], array( 'md', 'lg' ), true ) ? $button['size'] : 'md';

$button_classes = trim(
	$button['class'] . ' ' . stature_button_classes( $button['variant'], $button['size'], (bool) $button['on_navy'] )
);
?>
<a
	class="<?php echo esc_attr( $button_classes ); ?>"
	href="<?php echo esc_url( $button['url'] ); ?>"
	<?php if ( '' !== $button['target'] ) : ?>
		target="<?php echo esc_attr( $button['target'] ); ?>"
		rel="<?php echo esc_attr( $button['rel'] ); ?>"
	<?php endif; ?>
>
	<?php echo esc_html( $button['label'] ); ?>
	<?php if ( $button['arrow'] ) : ?>
		<span class="stature-btn__arrow" aria-hidden="true">&rarr;</span>
	<?php endif; ?>
</a>
