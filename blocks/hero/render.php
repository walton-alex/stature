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

/*
 * The panel features a case study: the one picked, or the most recent. It falls
 * back to the block's own image only when there's no case study to show.
 */
$picked = (int) get_field( 'case_study' );
$case   = $picked ? get_post( $picked ) : stature_latest_case_study();

if ( ! $case instanceof WP_Post || 'case_study' !== $case->post_type || 'publish' !== $case->post_status ) {
	$case = null;
}

$panel_image      = $case ? (int) get_post_thumbnail_id( $case->ID ) : 0;
$panel_image      = $panel_image && wp_attachment_is_image( $panel_image ) ? $panel_image : 0;
$panel_url        = '';
$case_name        = '';
$case_quote       = '';
$case_attribution = '';

if ( $panel_image ) {
	$panel_url        = (string) get_permalink( $case );
	$case_name        = (string) get_the_title( $case );
	$caption          = $case_name;
	$case_attribution = (string) get_field( 'testimonial_attribution', $case->ID );

	$snapshot = trim( (string) get_field( 'testimonial_snapshot', $case->ID ) );

	if ( '' !== $snapshot ) {
		// Written for this spot, so it runs as authored.
		$case_quote = $snapshot;
	} else {
		/*
		 * Falling back to the full testimonial, held to its opening paragraph and
		 * then to a word count: the hero has a fixed amount of room beside the
		 * shot, and a long quote would otherwise stretch the card past it.
		 */
		$quote_parts = stature_quote_paragraphs( (string) get_field( 'testimonial_quote', $case->ID ) );
		$case_quote  = $quote_parts ? wp_trim_words( $quote_parts[0], 34, '…' ) : '';
	}
} elseif ( is_array( $image ) && ! empty( $image['ID'] ) && wp_attachment_is_image( (int) $image['ID'] ) ) {
	$panel_image = (int) $image['ID'];
}

$panel_tag = $panel_url ? 'a' : 'div';

/*
 * A client quote earns the second column. Without one there's nothing to put
 * beside the shot, so the panel keeps the full width it always had.
 */
$has_aside       = '' !== $panel_url && '' !== $case_quote;
$feature_classes = 'stature-hero__feature' . ( $has_aside ? ' stature-hero__feature--case' : '' );

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

		<div class="<?php echo esc_attr( $feature_classes ); ?>">
			<<?php echo esc_attr( $panel_tag ); ?>
				class="stature-hero__panel"
				<?php if ( '' !== $panel_url ) : ?>
					href="<?php echo esc_url( $panel_url ); ?>"
					aria-label="<?php echo esc_attr( sprintf(
						/* translators: %s: case study name. */
						__( 'View the %s case study', 'stature' ),
						$case_name
					) ); ?>"
				<?php endif; ?>
			>
				<?php
				if ( $panel_image ) {
					echo wp_get_attachment_image(
						$panel_image,
						'large',
						false,
						array(
							'class'   => 'stature-hero__image stature-cover',
							'loading' => 'eager',
							'alt'     => $case ? sprintf(
								/* translators: %s: case study name. */
								esc_attr__( '%s website', 'stature' ),
								get_the_title( $case )
							) : '',
						)
					);
				} else {
					echo '<div class="stature-hero__image stature-hero__image--placeholder stature-cover" aria-hidden="true"></div>';
				}
				?>

				<div class="stature-hero__scrim" aria-hidden="true"></div>

				<?php if ( '' !== $panel_url ) : ?>
					<div class="stature-hero__tag">
						<?php
						get_template_part(
							'parts/eyebrow',
							null,
							array(
								'text'    => __( 'Case Study', 'stature' ),
								'on_navy' => true,
							)
						);
						?>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $caption ) : ?>
					<div class="stature-hero__caption">
						<img
							class="stature-hero__symbol"
							src="<?php echo esc_url( stature_asset( 'logos/stature_symbol_white.svg' ) ); ?>"
							alt=""
							aria-hidden="true"
						>
						<span class="stature-label"><?php echo esc_html( $caption ); ?></span>
						<?php if ( '' !== $panel_url ) : ?>
							<span class="stature-btn__arrow" aria-hidden="true">&rarr;</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</<?php echo esc_attr( $panel_tag ); ?>>

			<?php if ( $has_aside ) : ?>
				<div class="stature-hero__aside">
					<?php
					// The same card the contact block and case studies use, on the hero's white.
					get_template_part(
						'parts/testimonial',
						null,
						array(
							'quote'       => $case_quote,
							'attribution' => $case_attribution,
							'surface'     => 'grey',
						)
					);
					?>

					<?php // Names the client here so the link stands on its own out of context. ?>
					<a class="stature-hero__case-link" href="<?php echo esc_url( $panel_url ); ?>">
						<?php
						printf(
							/* translators: %s: case study name. */
							esc_html__( 'View the %s case study', 'stature' ),
							esc_html( $case_name )
						);
						?>
						<span class="stature-btn__arrow" aria-hidden="true">&rarr;</span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
