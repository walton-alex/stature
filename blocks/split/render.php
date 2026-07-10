<?php
/**
 * Editorial split block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$eyebrow      = (string) get_field( 'eyebrow' );
$heading      = (string) get_field( 'heading' );
$level        = (string) get_field( 'heading_level' );
$size         = (string) get_field( 'heading_size' );
$body         = (string) get_field( 'body' );
$image        = get_field( 'image' );
$position     = (string) get_field( 'media_position' );
$ratio        = (string) get_field( 'media_ratio' );
$columns      = (string) get_field( 'columns' );
$align        = (string) get_field( 'align' );
$placeholder  = (string) get_field( 'placeholder_label' );
$scrim        = (bool) get_field( 'media_scrim' );
$bg           = (string) get_field( 'background' );

$bg      = in_array( $bg, array( 'white', 'grey', 'navy' ), true ) ? $bg : 'grey';
$on_navy = 'navy' === $bg;
$size    = in_array( $size, array( 'h2', 'h3' ), true ) ? $size : 'h2';

$classes = stature_section_classes( $block, 'stature-split', $bg );

if ( 'left' === $position ) {
	$classes .= ' stature-split--media-left';
}

if ( '4-5' === $ratio ) {
	$classes .= ' stature-split--portrait';
}

if ( 'media-narrow' === $columns ) {
	$classes .= ' stature-split--media-narrow';
}

if ( 'start' === $align ) {
	$classes .= ' stature-split--align-start';
}

if ( $on_navy ) {
	$classes .= ' is-on-navy';
}

$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
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
		<div class="stature-split__grid">
			<div class="stature-split__text">
				<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $eyebrow, 'on_navy' => $on_navy ) ); ?>

				<?php if ( '' !== $heading ) : ?>
					<?php $tag = stature_block_heading_tag( $level, array( 'h2', 'h3' ), 'h2' ); ?>
					<<?php echo esc_attr( $tag ); ?> class="stature-split__heading stature-heading stature-heading--<?php echo esc_attr( $size ); ?><?php echo $on_navy ? ' is-on-navy' : ''; ?>">
						<?php echo esc_html( $heading ); ?>
					</<?php echo esc_attr( $tag ); ?>>
				<?php endif; ?>

				<?php if ( '' !== $body ) : ?>
					<div class="stature-split__body stature-prose"><?php echo wp_kses_post( $body ); ?></div>
				<?php endif; ?>
			</div>

			<div class="stature-split__media">
				<?php
				if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
					echo wp_get_attachment_image(
						(int) $image['ID'],
						'large',
						false,
						array(
							'class'   => 'stature-split__image stature-cover',
							'loading' => 'lazy',
						)
					);
				} elseif ( '' !== $placeholder ) {
					printf(
						'<div class="stature-split__placeholder"><span>%s</span></div>',
						esc_html( $placeholder )
					);
				} else {
					echo '<div class="stature-split__image stature-split__image--placeholder stature-cover" aria-hidden="true"></div>';
				}
				?>

				<?php if ( $scrim ) : ?>
					<div class="stature-split__scrim" aria-hidden="true"></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
