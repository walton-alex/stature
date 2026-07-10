<?php
/**
 * Badge component.
 *
 * @param string $args['label']   Badge text.
 * @param string $args['tone']    grey | cyan | navy | outline.
 * @param bool   $args['on_navy'] Whether the badge sits on a navy surface.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$badge = wp_parse_args(
	$args ?? array(),
	array(
		'label'   => '',
		'tone'    => 'grey',
		'on_navy' => false,
	)
);

if ( '' === trim( (string) $badge['label'] ) ) {
	return;
}

$tone    = in_array( $badge['tone'], array( 'grey', 'cyan', 'navy', 'outline' ), true ) ? $badge['tone'] : 'grey';
$classes = "stature-badge stature-badge--{$tone}" . ( $badge['on_navy'] ? ' is-on-navy' : '' );
?>
<span class="<?php echo esc_attr( $classes ); ?>"><?php echo esc_html( $badge['label'] ); ?></span>
