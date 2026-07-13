<?php
/**
 * Prose block: a heading and long-form rich text in a readable column.
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
$meta    = (string) get_field( 'meta' );
$body    = (string) get_field( 'body' );
$level   = (string) get_field( 'heading_level' );

$tag = stature_block_heading_tag( $level, array( 'h1', 'h2' ), 'h1' );

$classes = stature_section_classes( $block, 'stature-prose-block', 'white' );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<div class="stature-container stature-section__inner">
		<div class="stature-prose-block__inner">
			<?php if ( '' !== $heading || '' !== $eyebrow ) : ?>
				<header class="stature-prose-block__header">
					<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $eyebrow ) ); ?>

					<?php if ( '' !== $heading ) : ?>
						<<?php echo esc_attr( $tag ); ?> class="stature-prose-block__heading stature-heading stature-heading--h1">
							<?php echo esc_html( $heading ); ?>
						</<?php echo esc_attr( $tag ); ?>>
					<?php endif; ?>

					<?php if ( '' !== $meta ) : ?>
						<p class="stature-prose-block__meta"><?php echo esc_html( $meta ); ?></p>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<?php if ( '' !== $body ) : ?>
				<div class="stature-prose-block__body stature-prose">
					<?php echo wp_kses_post( $body ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
