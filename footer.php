<?php
/**
 * Site footer.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$stature_footer_columns = array(
	'footer_first'  => array(
		'title' => 'Explore',
		'links' => array(
			'Home'     => '',
			'About'    => 'about',
			'Our Work' => 'our-work',
		),
	),
	'footer_second' => array(
		'title' => 'Work With Us',
		'links' => array(
			'Project Pricing'   => 'pricing',
			'Paid Discovery'    => 'paid-discovery',
			'Hosting & Support' => 'hosting-support',
			'Start a Project'   => 'start-a-project',
		),
	),
);
?>
</main>

<footer class="stature-footer">
	<img
		class="stature-footer__watermark"
		src="<?php echo esc_url( stature_asset( 'logos/stature_symbol_white.svg' ) ); ?>"
		alt=""
		aria-hidden="true"
	>

	<div class="stature-footer__inner">
		<div class="stature-footer__brand">
			<img
				class="stature-footer__logo"
				src="<?php echo esc_url( stature_asset( 'logos/stature_logo_white.svg' ) ); ?>"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
				width="114"
				height="26"
			>
			<p class="stature-footer__blurb">
				<?php esc_html_e( 'Websites for specialist recruitment agencies. UK & US.', 'stature' ); ?>
			</p>
		</div>

		<?php foreach ( $stature_footer_columns as $stature_location => $stature_column ) : ?>
			<div class="stature-footer__column">
				<div class="stature-footer__column-title stature-label">
					<?php echo esc_html( stature_menu_title( $stature_location, $stature_column['title'] ) ); ?>
				</div>
				<?php stature_footer_nav( $stature_location, $stature_column['links'] ); ?>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="stature-footer__legal">
		<span>
			<?php
			printf(
				/* translators: %s: current year. */
				esc_html__( '&copy; %s Stature. All rights reserved.', 'stature' ),
				esc_html( wp_date( 'Y' ) )
			);
			?>
		</span>
		<span class="stature-footer__policies">
			<a href="<?php echo esc_url( stature_url( 'privacy-policy' ) ); ?>">
				<?php esc_html_e( 'Privacy Policy', 'stature' ); ?>
			</a>
			<a href="<?php echo esc_url( stature_url( 'cookie-policy' ) ); ?>">
				<?php esc_html_e( 'Cookie Policy', 'stature' ); ?>
			</a>
		</span>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
