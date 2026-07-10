<?php
/**
 * Section intro component: eyebrow, heading and optional lead paragraph.
 *
 * @param string $args['eyebrow'] Eyebrow label.
 * @param string $args['heading'] Heading text.
 * @param string $args['tag']     h2 | h3.
 * @param string $args['lead']    Lead paragraph.
 * @param bool   $args['on_navy'] Whether the intro sits on a navy surface.
 * @param bool   $args['center']  Centre the intro.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$intro = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow' => '',
		'heading' => '',
		'tag'     => 'h2',
		'lead'    => '',
		'on_navy' => false,
		'center'  => false,
	)
);

if ( '' === $intro['heading'] && '' === $intro['eyebrow'] ) {
	return;
}

$intro_classes = array( 'stature-section-intro' );

if ( $intro['center'] ) {
	$intro_classes[] = 'is-centred';
}

if ( $intro['on_navy'] ) {
	$intro_classes[] = 'is-on-navy';
}

$intro_tag = stature_block_heading_tag( $intro['tag'], array( 'h2', 'h3' ), 'h2' );
?>
<div class="<?php echo esc_attr( implode( ' ', $intro_classes ) ); ?>">
	<?php
	get_template_part(
		'parts/eyebrow',
		null,
		array(
			'text'    => $intro['eyebrow'],
			'on_navy' => $intro['on_navy'],
		)
	);
	?>

	<?php if ( '' !== $intro['heading'] ) : ?>
		<<?php echo esc_attr( $intro_tag ); ?> class="stature-section-intro__heading stature-heading stature-heading--h2<?php echo $intro['on_navy'] ? ' is-on-navy' : ''; ?>">
			<?php echo esc_html( $intro['heading'] ); ?>
		</<?php echo esc_attr( $intro_tag ); ?>>
	<?php endif; ?>

	<?php if ( '' !== $intro['lead'] ) : ?>
		<p class="stature-section-intro__lead stature-lead"><?php echo esc_html( $intro['lead'] ); ?></p>
	<?php endif; ?>
</div>
