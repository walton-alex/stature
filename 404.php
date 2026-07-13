<?php
/**
 * 404 (not found) template.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="stature-error stature-section stature-section--navy">
	<div class="stature-grain" aria-hidden="true"></div>

	<div class="stature-container stature-section__inner stature-error__inner">
		<?php get_template_part( 'parts/eyebrow', null, array( 'text' => __( 'Error 404', 'stature' ), 'on_navy' => true ) ); ?>

		<h1 class="stature-error__heading stature-heading stature-heading--display is-on-navy">
			<?php esc_html_e( 'Page not found', 'stature' ); ?>
		</h1>

		<p class="stature-error__lead">
			<?php esc_html_e( 'The page you are looking for may have moved, or the link might be out of date.', 'stature' ); ?>
		</p>

		<div class="stature-error__actions">
			<?php
			get_template_part(
				'parts/button',
				null,
				array(
					'label'   => __( 'Back to home', 'stature' ),
					'url'     => stature_url(),
					'variant' => 'primary',
					'size'    => 'lg',
					'on_navy' => true,
					'arrow'   => true,
				)
			);

			get_template_part(
				'parts/button',
				null,
				array(
					'label'   => __( 'View our work', 'stature' ),
					'url'     => stature_url( 'case-studies' ),
					'variant' => 'secondary',
					'size'    => 'lg',
					'on_navy' => true,
				)
			);
			?>
		</div>
	</div>
</section>
<?php
get_footer();
