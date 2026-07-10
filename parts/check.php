<?php
/**
 * Check mark icon. Inherits its colour from the element that contains it.
 *
 * @param string $args['class'] Extra classes.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$check_class = trim( 'stature-check ' . ( $args['class'] ?? '' ) );
?>
<svg
	class="<?php echo esc_attr( $check_class ); ?>"
	width="16"
	height="16"
	viewBox="0 0 16 16"
	fill="none"
	aria-hidden="true"
	focusable="false"
>
	<path
		d="M3 8.5l3.2 3L13 4.5"
		stroke="currentColor"
		stroke-width="1.5"
		stroke-linecap="round"
		stroke-linejoin="round"
	/>
</svg>
