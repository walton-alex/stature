<?php
/**
 * Process steps block.
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

$classes = stature_section_classes( $block, 'stature-process', $bg );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';

$steps = get_field( 'steps' );
$total = is_array( $steps ) ? count( $steps ) : 0;
$index = 0;
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

		<?php if ( have_rows( 'steps' ) ) : ?>
			<ol class="stature-process__list">
				<?php
				while ( have_rows( 'steps' ) ) :
					the_row();
					++$index;

					$title = (string) get_sub_field( 'title' );
					$body  = (string) get_sub_field( 'body' );
					$last  = $index === $total;
					?>
					<li class="stature-process__step<?php echo $last ? ' is-last' : ''; ?>">
						<div class="stature-process__marker" aria-hidden="true">
							<span class="stature-process__number"><?php echo esc_html( (string) $index ); ?></span>
							<?php if ( ! $last ) : ?>
								<span class="stature-process__connector"></span>
							<?php endif; ?>
						</div>

						<div class="stature-process__content">
							<?php if ( '' !== $title ) : ?>
								<h3 class="stature-process__title stature-heading stature-heading--h4"><?php echo esc_html( $title ); ?></h3>
							<?php endif; ?>

							<?php if ( '' !== $body ) : ?>
								<p class="stature-process__body"><?php echo esc_html( $body ); ?></p>
							<?php endif; ?>
						</div>
					</li>
					<?php
				endwhile;
				?>
			</ol>
		<?php endif; ?>
	</div>
</section>
