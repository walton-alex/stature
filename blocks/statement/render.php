<?php
/**
 * Two-column statement block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$eyebrow    = (string) get_field( 'eyebrow' );
$lead_with  = (string) get_field( 'lead_with' );
$heading    = (string) get_field( 'heading' );
$level      = (string) get_field( 'heading_level' );
$price      = (string) get_field( 'price' );
$price_note = (string) get_field( 'price_note' );
$body       = (string) get_field( 'body' );
$bg         = (string) get_field( 'background' );
$align      = (string) get_field( 'align' );
$panelled   = (bool) get_field( 'panelled' );

$bg      = in_array( $bg, array( 'white', 'grey', 'navy' ), true ) ? $bg : 'white';
$on_navy = 'navy' === $bg;
$align   = in_array( $align, array( 'start', 'center' ), true ) ? $align : 'start';
$tag     = stature_block_heading_tag( $level, array( 'h2', 'h3' ), 'h2' );

$cta = get_field( 'cta' );
$cta = is_array( $cta ) && ! empty( $cta['url'] ) ? stature_block_link( $cta, '', '' ) : array();

$classes = stature_section_classes( $block, 'stature-statement', $bg );

$classes .= " is-align-{$align}";

if ( $on_navy ) {
	$classes .= ' is-on-navy';
}

if ( $panelled ) {
	$classes .= ' is-panelled';
}

$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
$symbol = $on_navy ? 'logos/stature_symbol_white.svg' : 'logos/stature_symbol_navy.svg';
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
		<div class="stature-statement__panel">
			<?php if ( $panelled ) : ?>
				<img class="stature-statement__watermark" src="<?php echo esc_url( stature_asset( $symbol ) ); ?>" alt="" aria-hidden="true">
			<?php endif; ?>

			<div class="stature-statement__grid">
				<div class="stature-statement__lead">
					<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $eyebrow, 'on_navy' => $on_navy ) ); ?>

					<?php if ( 'price' === $lead_with ) : ?>
						<?php if ( '' !== $price ) : ?>
							<div class="stature-statement__price">
								<span class="stature-statement__figure"><?php echo esc_html( $price ); ?></span>
							</div>
						<?php endif; ?>

						<?php if ( '' !== $price_note ) : ?>
							<div class="stature-statement__note"><?php echo esc_html( $price_note ); ?></div>
						<?php endif; ?>
					<?php elseif ( '' !== $heading ) : ?>
						<<?php echo esc_attr( $tag ); ?> class="stature-statement__heading stature-heading stature-heading--h2<?php echo $on_navy ? ' is-on-navy' : ''; ?>">
							<?php echo esc_html( $heading ); ?>
						</<?php echo esc_attr( $tag ); ?>>
					<?php endif; ?>

					<?php
					if ( ! empty( $cta ) ) {
						get_template_part(
							'parts/button',
							null,
							array_merge(
								$cta,
								array(
									'variant' => 'secondary',
									'on_navy' => $on_navy,
									'arrow'   => true,
									'class'   => 'stature-statement__cta',
								)
							)
						);
					}
					?>
				</div>

				<?php if ( '' !== $body ) : ?>
					<div class="stature-statement__body stature-prose">
						<?php echo wp_kses_post( $body ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
