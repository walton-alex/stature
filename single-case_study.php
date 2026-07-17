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
	$thumb_id = (int) get_post_thumbnail_id( $case_id );
	$site_url = (string) get_field( 'site_url' );

	// An id can outlive its attachment; only treat it as an image if it still is one.
	$thumb_id = $thumb_id && wp_attachment_is_image( $thumb_id ) ? $thumb_id : 0;

	// Label the link with the bare domain — more concrete than "the live site".
	$site_host = '';

	if ( '' !== $site_url ) {
		$host      = wp_parse_url( $site_url, PHP_URL_HOST );
		$site_host = is_string( $host ) ? (string) preg_replace( '/^www\./', '', $host ) : '';
	}

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
			<div class="stature-case-study__media">
				<?php
				if ( $thumb_id ) {
					echo wp_get_attachment_image(
						$thumb_id,
						'full',
						false,
						array(
							'class' => 'stature-case-study__shot stature-cover',
							'alt'   => sprintf(
								/* translators: %s: case study name. */
								esc_attr__( '%s website — desktop', 'stature' ),
								get_the_title()
							),
						)
					);
				} else {
					?>
					<div class="stature-case-study__placeholder" aria-hidden="true"></div>
					<span class="stature-case-study__caption stature-label"><?php esc_html_e( 'Desktop screens to follow', 'stature' ); ?></span>
					<?php
				}
				?>
			</div>
			<?php if ( '' !== $site_url ) : ?>
				<p class="stature-case-study__visit">
					<a
						class="stature-case-study__visit-link"
						href="<?php echo esc_url( $site_url ); ?>"
						target="_blank"
						rel="noopener"
					>
						<?php
						if ( '' !== $site_host ) {
							printf(
								/* translators: %s: the case study's domain, e.g. vero.co.uk. */
								esc_html__( 'Visit %s', 'stature' ),
								esc_html( $site_host )
							);
						} else {
							esc_html_e( 'Visit the live site', 'stature' );
						}
						?>
						<span class="stature-btn__arrow" aria-hidden="true">&rarr;</span>
					</a>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( $rows ) : ?>
		<section class="stature-case-study__narrative-section stature-section stature-section--white">
			<div class="stature-container stature-section__inner">
				<div class="stature-case-study__narrative">
					<?php foreach ( $rows as $row ) : ?>
						<div class="stature-case-study__row">
							<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $row['label'] ) ); ?>
							<div class="stature-case-study__body stature-prose"><?php echo wp_kses_post( $row['body'] ); ?></div>
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
