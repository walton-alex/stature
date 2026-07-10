<?php
/**
 * Eyebrow component.
 *
 * @param string $args['text']    Label text.
 * @param bool   $args['on_navy'] Whether the eyebrow sits on a navy surface.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$eyebrow = wp_parse_args(
	$args ?? array(),
	array(
		'text'    => '',
		'on_navy' => false,
	)
);

if ( '' === trim( (string) $eyebrow['text'] ) ) {
	return;
}
?>
<div class="stature-eyebrow stature-label<?php echo $eyebrow['on_navy'] ? ' is-on-navy' : ''; ?>">
	<?php echo esc_html( $eyebrow['text'] ); ?>
</div>
