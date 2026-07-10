<?php
/**
 * Cross-link row: a small uppercase label on the left, a large link on the right.
 *
 * @param string $args['label']   Uppercase label.
 * @param string $args['title']   Link text.
 * @param string $args['url']     Destination.
 * @param string $args['classes'] Extra classes.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$row = wp_parse_args(
	$args ?? array(),
	array(
		'label'   => '',
		'title'   => '',
		'url'     => '',
		'classes' => '',
	)
);

if ( '' === $row['title'] || '' === $row['url'] ) {
	return;
}
?>
<a class="<?php echo esc_attr( trim( 'stature-link-row ' . $row['classes'] ) ); ?>" href="<?php echo esc_url( $row['url'] ); ?>">
	<?php if ( '' !== $row['label'] ) : ?>
		<span class="stature-link-row__label stature-label"><?php echo esc_html( $row['label'] ); ?></span>
	<?php endif; ?>

	<span class="stature-link-row__title">
		<?php echo esc_html( $row['title'] ); ?>
		<span class="stature-btn__arrow" aria-hidden="true">&rarr;</span>
	</span>
</a>
