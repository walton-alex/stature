<?php
/**
 * Inner hero block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$eyebrow = (string) get_field( 'eyebrow' );
$heading = (string) get_field( 'heading' );
$lead    = (string) get_field( 'lead' );
$width   = (string) get_field( 'heading_width' );

$classes = stature_block_classes( $block, 'stature-inner-hero' );

if ( 'narrow' === $width ) {
	$classes .= ' stature-inner-hero--narrow';
}

$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<div class="stature-grain" aria-hidden="true"></div>

	<div class="stature-inner-hero__inner">
		<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $eyebrow, 'on_navy' => true ) ); ?>

		<?php if ( '' !== $heading ) : ?>
			<h1 class="stature-inner-hero__heading stature-heading stature-heading--h1 is-on-navy">
				<?php echo esc_html( $heading ); ?>
			</h1>
		<?php endif; ?>

		<?php if ( '' !== $lead ) : ?>
			<p class="stature-inner-hero__lead stature-lead"><?php echo esc_html( $lead ); ?></p>
		<?php endif; ?>
	</div>
</section>
