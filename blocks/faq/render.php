<?php
/**
 * FAQ accordion block.
 *
 * Uses native <details>/<summary>: several may be open at once, it is keyboard
 * accessible, and it needs no JavaScript.
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
$bg      = (string) get_field( 'background' );

$bg = in_array( $bg, array( 'white', 'grey' ), true ) ? $bg : 'white';

$classes = stature_section_classes( $block, 'stature-faq', $bg );
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
			'parts/section-intro',
			null,
			array(
				'eyebrow' => $eyebrow,
				'heading' => $heading,
				'lead'    => $lead,
			)
		);
		?>

		<?php if ( have_rows( 'items' ) ) : ?>
			<div class="stature-faq__list">
				<?php
				while ( have_rows( 'items' ) ) :
					the_row();

					$question = (string) get_sub_field( 'question' );
					$answer   = (string) get_sub_field( 'answer' );
					$is_open  = (bool) get_sub_field( 'open_by_default' );

					if ( '' === $question ) {
						continue;
					}
					?>
					<details class="stature-faq__item"<?php echo $is_open ? ' open' : ''; ?>>
						<summary class="stature-faq__question">
							<span><?php echo esc_html( $question ); ?></span>
							<svg class="stature-faq__icon" aria-hidden="true" focusable="false" width="14" height="14" viewBox="0 0 14 14">
								<path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"></path>
							</svg>
						</summary>

						<?php if ( '' !== $answer ) : ?>
							<p class="stature-faq__answer"><?php echo esc_html( $answer ); ?></p>
						<?php endif; ?>
					</details>
					<?php
				endwhile;
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
