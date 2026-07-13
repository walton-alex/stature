<?php
/**
 * Service cards block.
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
$lead         = (string) get_field( 'lead' );
$note         = (string) get_field( 'note' );
$bg           = (string) get_field( 'background' );
$card_size    = (string) get_field( 'card_size' );
$intro_layout = (string) get_field( 'intro_layout' );

$bg      = in_array( $bg, array( 'white', 'grey', 'navy' ), true ) ? $bg : 'navy';
$on_navy = 'navy' === $bg;

$cta = get_field( 'cta' );
$cta = is_array( $cta ) && ! empty( $cta['url'] ) ? stature_block_link( $cta, '', '' ) : array();

$classes = stature_section_classes( $block, 'stature-services', $bg );

if ( $on_navy ) {
	$classes .= ' is-on-navy';
}

if ( 'compact' === $card_size ) {
	$classes .= ' stature-services--compact';
}

$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
$icons  = array( 'copywriting', 'web_design', 'web_development' );
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
		<?php
		get_template_part(
			'parts/section-intro',
			null,
			array(
				'eyebrow' => $eyebrow,
				'heading' => $heading,
				'lead'    => $lead,
				'on_navy' => $on_navy,
				'split'   => 'split' === $intro_layout,
			)
		);
		?>

		<?php if ( have_rows( 'cards' ) ) : ?>
			<div class="stature-services__grid">
				<?php
				while ( have_rows( 'cards' ) ) :
					the_row();

					$icon       = (string) get_sub_field( 'icon' );
					$has_icon   = in_array( $icon, $icons, true );
					$card_title = (string) get_sub_field( 'title' );
					$card_body  = (string) get_sub_field( 'body' );
					$step       = (string) get_sub_field( 'step' );
					$colourway  = $on_navy ? 'cyan' : 'navy';
					?>
					<article class="stature-services__card">
						<?php if ( '' !== $step ) : ?>
							<span class="stature-services__step stature-label" aria-hidden="true"><?php echo esc_html( $step ); ?></span>
						<?php endif; ?>

						<?php if ( $has_icon ) : ?>
							<img
								class="stature-services__icon"
								src="<?php echo esc_url( stature_asset( "icons/{$icon}_{$colourway}.svg" ) ); ?>"
								alt=""
								aria-hidden="true"
								width="44"
								height="44"
							>
						<?php endif; ?>

						<?php if ( '' !== $card_title ) : ?>
							<h3 class="stature-services__card-title stature-heading stature-heading--h4"><?php echo esc_html( $card_title ); ?></h3>
						<?php endif; ?>

						<?php if ( '' !== $card_body ) : ?>
							<p class="stature-services__card-body"><?php echo esc_html( $card_body ); ?></p>
						<?php endif; ?>
					</article>
					<?php
				endwhile;
				?>
			</div>
		<?php endif; ?>

		<?php if ( '' !== $note || ! empty( $cta ) ) : ?>
			<div class="stature-services__footnote">
				<?php if ( '' !== $note ) : ?>
					<span class="stature-services__note"><?php echo esc_html( $note ); ?></span>
				<?php endif; ?>

				<?php
				if ( ! empty( $cta ) ) {
					get_template_part(
						'parts/button',
						null,
						array_merge(
							$cta,
							array(
								'size'    => 'md',
								'on_navy' => $on_navy,
							)
						)
					);
				}
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
