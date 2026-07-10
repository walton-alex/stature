<?php
/**
 * Pricing cards block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$eyebrow   = (string) get_field( 'eyebrow' );
$heading   = (string) get_field( 'heading' );
$lead      = (string) get_field( 'lead' );
$bg        = (string) get_field( 'background' );
$card_size = (string) get_field( 'card_size' );

$bg      = in_array( $bg, array( 'white', 'grey' ), true ) ? $bg : 'grey';
$compact = 'compact' === $card_size;

$classes = stature_section_classes( $block, 'stature-pricing', $bg );

if ( $compact ) {
	$classes .= ' stature-pricing--compact';
}

$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
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
			array( 'eyebrow' => $eyebrow, 'heading' => $heading, 'lead' => $lead )
		);
		?>

		<?php if ( have_rows( 'plans' ) ) : ?>
			<div class="stature-pricing__grid">
				<?php
				while ( have_rows( 'plans' ) ) :
					the_row();

					$name     = (string) get_sub_field( 'name' );
					$prefix   = (string) get_sub_field( 'price_prefix' );
					$price    = (string) get_sub_field( 'price' );
					$suffix   = (string) get_sub_field( 'price_suffix' );
					$timeline = (string) get_sub_field( 'timeline' );
					$body     = (string) get_sub_field( 'body' );
					$badge    = (string) get_sub_field( 'badge' );
					$featured = (bool) get_sub_field( 'featured' );

					$cta = stature_block_link(
						get_sub_field( 'cta' ),
						stature_url( 'start-a-project' ),
						__( 'Start a Project', 'stature' )
					);
					?>
					<article class="stature-pricing__card<?php echo $featured ? ' is-featured' : ''; ?>">
						<div class="stature-pricing__head">
							<?php if ( '' !== $name ) : ?>
								<h3 class="stature-pricing__name stature-heading stature-heading--h4<?php echo $featured ? ' is-on-navy' : ''; ?>">
									<?php echo esc_html( $name ); ?>
								</h3>
							<?php endif; ?>

							<?php get_template_part( 'parts/badge', null, array( 'label' => $badge, 'tone' => 'cyan' ) ); ?>
						</div>

						<?php if ( '' !== $price ) : ?>
							<div class="stature-pricing__price">
								<?php if ( '' !== $prefix ) : ?>
									<span class="stature-pricing__affix"><?php echo esc_html( $prefix ); ?> </span>
								<?php endif; ?>
								<span class="stature-pricing__figure"><?php echo esc_html( $price ); ?></span>
								<?php if ( '' !== $suffix ) : ?>
									<span class="stature-pricing__affix"><?php echo esc_html( $suffix ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( '' !== $timeline ) : ?>
							<div class="stature-pricing__timeline"><?php echo esc_html( $timeline ); ?></div>
						<?php endif; ?>

						<?php if ( '' !== $body ) : ?>
							<p class="stature-pricing__body"><?php echo esc_html( $body ); ?></p>
						<?php endif; ?>

						<?php if ( have_rows( 'features' ) ) : ?>
							<ul class="stature-pricing__features">
								<?php
								while ( have_rows( 'features' ) ) :
									the_row();

									$feature = (string) get_sub_field( 'text' );

									if ( '' === $feature ) {
										continue;
									}
									?>
									<li class="stature-pricing__feature">
										<?php get_template_part( 'parts/check' ); ?>
										<?php echo esc_html( $feature ); ?>
									</li>
									<?php
								endwhile;
								?>
							</ul>
						<?php endif; ?>

						<?php
						get_template_part(
							'parts/button',
							null,
							array_merge(
								$cta,
								array(
									'variant' => $featured ? 'primary' : 'secondary',
									'on_navy' => $featured,
									'arrow'   => true,
									'class'   => 'stature-pricing__cta',
								)
							)
						);
						?>
					</article>
					<?php
				endwhile;
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
