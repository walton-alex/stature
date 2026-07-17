<?php
/**
 * Minimal footer for standalone tool pages.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;
?>
</main>

<footer class="stature-tool-footer">
	<span>
		<?php
		printf(
			/* translators: %s: current year. */
			esc_html__( '&copy; %s Stature. All rights reserved.', 'stature' ),
			esc_html( wp_date( 'Y' ) )
		);
		?>
	</span>
	<span class="stature-tool-footer__policies">
		<a href="<?php echo esc_url( stature_url( 'privacy-policy' ) ); ?>">
			<?php esc_html_e( 'Privacy Policy', 'stature' ); ?>
		</a>
		<a href="<?php echo esc_url( stature_url( 'cookie-policy' ) ); ?>">
			<?php esc_html_e( 'Cookie Policy', 'stature' ); ?>
		</a>
	</span>
</footer>

<?php wp_footer(); ?>
</body>
</html>
