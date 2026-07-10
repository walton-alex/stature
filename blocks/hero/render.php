<?php
/**
 * Hero block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$heading   = (string) get_field( 'heading' );
$lead      = (string) get_field( 'lead' );
$caption   = (string) get_field( 'caption' );
$level     = (string) get_field( 'heading_level' );
$image     = get_field( 'image' );
$primary   = stature_block_link( get_field( 'primary_cta' ), stature_url( 'start-a-project' ), __( 'Start a Project', 'stature' ) );
$secondary = stature_block_link( get_field( 'secondary_cta' ), stature_url( 'case-studies' ), __( 'View Our Work', 'stature' ) );

$heading_tag = stature_block_heading_tag( $level );
$classes     = stature_block_classes( $block, 'stature-hero' );
$anchor      = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<img
		class="stature-hero__motif"
		src="<?php echo esc_url( stature_asset( 'logos/stature_symbol_cyan.svg' ) ); ?>"
		alt=""
		aria-hidden="true"
	>

	<div class="stature-hero__inner">
		<?php if ( '' !== $heading ) : ?>
			<<?php echo esc_attr( $heading_tag ); ?> class="stature-hero__heading stature-heading stature-heading--display"><?php echo esc_html( $heading ); ?></<?php echo esc_attr( $heading_tag ); ?>>
		<?php endif; ?>

		<?php if ( '' !== $lead ) : ?>
			<p class="stature-hero__lead stature-lead"><?php echo esc_html( $lead ); ?></p>
		<?php endif; ?>

		<div class="stature-hero__actions">
			<?php
			get_template_part( 'parts/button', null, array_merge( $primary, array( 'size' => 'lg' ) ) );
			get_template_part( 'parts/button', null, array_merge( $secondary, array( 'variant' => 'secondary', 'size' => 'lg' ) ) );
			?>
		</div>

		<div class="stature-hero__panel">
			<?php
			if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
				echo wp_get_attachment_image(
					(int) $image['ID'],
					'large',
					false,
					array(
						'class'   => 'stature-hero__image stature-cover',
						'loading' => 'eager',
					)
				);
			} else {
				echo '<div class="stature-hero__image stature-hero__image--placeholder stature-cover" aria-hidden="true"></div>';
			}
			?>

			<div class="stature-hero__scrim" aria-hidden="true"></div>

			<?php if ( '' !== $caption ) : ?>
				<div class="stature-hero__caption">
					<img
						class="stature-hero__symbol"
						src="<?php echo esc_url( stature_asset( 'logos/stature_symbol_white.svg' ) ); ?>"
						alt=""
						aria-hidden="true"
					>
					<span class="stature-label"><?php echo esc_html( $caption ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
