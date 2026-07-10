<?php
/**
 * Case study detail template.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$case_id  = get_the_ID();
	$sector   = (string) get_field( 'sector' );
	$scope    = (string) get_field( 'scope' );
	$caption  = (string) get_field( 'screens_caption' );
	$thumb_id = (int) get_post_thumbnail_id( $case_id );

	$badges = array();

	if ( '' !== $sector ) {
		$badges[] = array( 'label' => $sector, 'tone' => 'cyan' );
	}

	if ( '' !== $scope ) {
		$badges[] = array( 'label' => $scope, 'tone' => 'outline' );
	}

	$rows = array(
		array( 'label' => __( 'The Challenge', 'stature' ), 'body' => (string) get_field( 'challenge' ) ),
		array( 'label' => __( 'The Approach', 'stature' ), 'body' => (string) get_field( 'approach' ) ),
		array( 'label' => __( 'The Result', 'stature' ), 'body' => (string) get_field( 'result' ) ),
	);
	$rows = array_filter( $rows, static fn( $row ) => '' !== $row['body'] );

	get_template_part(
		'parts/page-banner',
		null,
		array(
			'eyebrow' => __( 'Case Study', 'stature' ),
			'heading' => get_the_title(),
			'badges'  => $badges,
		)
	);
	?>

	<section class="stature-case-study__feature stature-section stature-section--white">
		<div class="stature-container stature-section__inner">
			<div class="stature-case-study__image-panel">
				<?php
				if ( $thumb_id ) {
					echo wp_get_attachment_image(
						$thumb_id,
						'full',
						false,
						array(
							'class' => 'stature-case-study__image stature-cover',
							'alt'   => sprintf(
								/* translators: %s: case study name. */
								esc_attr__( '%s website', 'stature' ),
								get_the_title()
							),
						)
					);
				} else {
					echo '<div class="stature-case-study__image stature-case-study__image--placeholder stature-cover" aria-hidden="true"></div>';
				}
				?>

				<div class="stature-case-study__scrim" aria-hidden="true"></div>

				<?php if ( '' !== $caption ) : ?>
					<span class="stature-case-study__caption stature-label"><?php echo esc_html( $caption ); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if ( $rows ) : ?>
		<section class="stature-section stature-section--white">
			<div class="stature-container stature-section__inner">
				<div class="stature-case-study__narrative">
					<?php foreach ( $rows as $row ) : ?>
						<div class="stature-case-study__row">
							<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $row['label'] ) ); ?>
							<p class="stature-case-study__body"><?php echo esc_html( $row['body'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php
	$quote = (string) get_field( 'testimonial_quote' );

	if ( '' !== $quote ) :
		?>
		<section class="stature-section stature-section--grey">
			<div class="stature-container stature-section__inner">
				<div class="stature-case-study__testimonial">
					<?php
					get_template_part(
						'parts/testimonial',
						null,
						array(
							'quote'       => $quote,
							'attribution' => (string) get_field( 'testimonial_attribution' ),
							'surface'     => 'white',
						)
					);
					?>
				</div>
			</div>
		</section>
		<?php
	endif;
	?>

	<?php
	$next = stature_next_case_study( $case_id );

	if ( $next ) :
		?>
		<section class="stature-case-study__next-section stature-section stature-section--white">
			<div class="stature-container stature-section__inner">
				<?php
				get_template_part(
					'parts/link-row',
					null,
					array(
						'label'   => __( 'Next case study', 'stature' ),
						'title'   => get_the_title( $next ),
						'url'     => (string) get_permalink( $next ),
						'classes' => 'stature-link-row--no-top',
					)
				);
				?>
			</div>
		</section>
		<?php
	endif;
	?>

	<?php
	$site = stature_site_cta();
	get_template_part( 'parts/cta-banner', null, $site );
	?>

	<?php
endwhile;

get_footer();
