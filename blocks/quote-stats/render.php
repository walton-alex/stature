<?php
/**
 * Quote and stats block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$eyebrow     = (string) get_field( 'eyebrow' );
$quote       = (string) get_field( 'quote' );
$highlight   = (string) get_field( 'highlight' );
$attribution = stature_attribution_html( (string) get_field( 'attribution' ) );
$motif       = get_field( 'motif' );

$classes = stature_section_classes( $block, 'stature-quote-stats', 'navy' );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';

$quote_html = esc_html( $quote );

if ( '' !== $highlight && str_contains( $quote, $highlight ) ) {
	$needle     = esc_html( $highlight );
	$quote_html = str_replace(
		$needle,
		'<span class="stature-quote-stats__highlight">' . $needle . '</span>',
		$quote_html
	);
}
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<?php if ( is_array( $motif ) && ! empty( $motif['ID'] ) ) : ?>
		<?php
		echo wp_get_attachment_image(
			(int) $motif['ID'],
			'full',
			false,
			array(
				'class'       => 'stature-quote-stats__motif',
				'aria-hidden' => 'true',
				'alt'         => '',
				'loading'     => 'lazy',
			)
		);
		?>
	<?php endif; ?>

	<div class="stature-container stature-section__inner">
		<div class="stature-quote-stats__grid">
			<div class="stature-quote-stats__quote-column">
				<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $eyebrow, 'on_navy' => true ) ); ?>

				<?php if ( '' !== $quote ) : ?>
					<blockquote class="stature-quote-stats__quote">
						<?php echo wp_kses( $quote_html, array( 'span' => array( 'class' => array() ) ) ); ?>
					</blockquote>
				<?php endif; ?>

				<?php if ( '' !== trim( $attribution ) ) : ?>
					<div class="stature-quote-stats__attribution"><?php echo $attribution; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Sanitised by stature_attribution_html(). ?></div>
				<?php endif; ?>
			</div>

			<?php if ( have_rows( 'stats' ) ) : ?>
				<div class="stature-quote-stats__stats">
					<?php
					while ( have_rows( 'stats' ) ) :
						the_row();

						$value = (string) get_sub_field( 'value' );
						$label = (string) get_sub_field( 'label' );
						?>
						<div class="stature-quote-stats__stat">
							<div class="stature-quote-stats__value"><?php echo esc_html( $value ); ?></div>
							<?php if ( '' !== $label ) : ?>
								<div class="stature-quote-stats__label"><?php echo esc_html( $label ); ?></div>
							<?php endif; ?>
						</div>
						<?php
					endwhile;
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
