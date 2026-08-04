<?php
/**
 * Standalone page template for the Website Credibility Scorecard.
 *
 * Auto-selected for the page with the slug "free-scorecard". Renders a minimal
 * chrome and a single JS-driven scorecard app.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

get_header( 'tool' );
?>

<div
	class="stature-scorecard"
	data-scorecard
	data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'stature_scorecard' ) ); ?>"
	data-review-url="<?php echo esc_url( stature_scorecard_review_url() ); ?>"
	data-hosting-url="<?php echo esc_url( stature_url( 'hosting-support' ) ); ?>"
>
	<div class="stature-scorecard__wrap">
		<div id="sc-app" class="stature-scorecard__app"></div>

		<noscript>
			<p class="stature-scorecard__noscript">
				<?php esc_html_e( 'The scorecard needs JavaScript enabled to run. Please turn it on and reload the page.', 'stature' ); ?>
			</p>
		</noscript>
	</div>
</div>

<?php
get_footer( 'tool' );
