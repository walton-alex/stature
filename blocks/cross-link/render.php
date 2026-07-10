<?php
/**
 * Cross-link row block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$link = get_field( 'link' );

if ( ! is_array( $link ) || empty( $link['url'] ) ) {
	return;
}

$classes = stature_section_classes( $block, 'stature-cross-link', 'white' );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<div class="stature-container stature-section__inner">
		<?php
		get_template_part(
			'parts/link-row',
			null,
			array(
				'label' => (string) get_field( 'label' ),
				'title' => ! empty( $link['title'] ) ? $link['title'] : $link['url'],
				'url'   => $link['url'],
			)
		);
		?>
	</div>
</section>
