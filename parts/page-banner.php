<?php
/**
 * Page banner component: flat navy, eyebrow, heading, optional lead and badges.
 *
 * @param string $args['eyebrow'] Eyebrow label.
 * @param string $args['heading'] Heading text.
 * @param string $args['lead']    Lead paragraph.
 * @param string $args['width']   760 | narrow | wide.
 * @param array  $args['badges']  Each: array{label:string,tone:string}.
 * @param string $args['classes'] Extra classes for the section.
 * @param string $args['anchor']  Section id.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$banner = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow' => '',
		'heading' => '',
		'lead'    => '',
		'width'   => '760',
		'badges'  => array(),
		'classes' => '',
		'anchor'  => '',
	)
);

$classes = trim( 'stature-banner ' . $banner['classes'] );

if ( in_array( $banner['width'], array( 'narrow', 'wide' ), true ) ) {
	$classes .= " stature-banner--{$banner['width']}";
}
?>
<section
	<?php if ( '' !== $banner['anchor'] ) : ?>
		id="<?php echo esc_attr( $banner['anchor'] ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
>
	<div class="stature-banner__inner">
		<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $banner['eyebrow'], 'on_navy' => true ) ); ?>

		<?php if ( '' !== $banner['heading'] ) : ?>
			<h1 class="stature-banner__heading stature-heading stature-heading--h1 is-on-navy">
				<?php echo esc_html( $banner['heading'] ); ?>
			</h1>
		<?php endif; ?>

		<?php if ( '' !== $banner['lead'] ) : ?>
			<p class="stature-banner__lead stature-lead"><?php echo esc_html( $banner['lead'] ); ?></p>
		<?php endif; ?>

		<?php if ( $banner['badges'] ) : ?>
			<div class="stature-banner__badges">
				<?php
				foreach ( $banner['badges'] as $badge ) {
					get_template_part(
						'parts/badge',
						null,
						array(
							'label'   => $badge['label'] ?? '',
							'tone'    => $badge['tone'] ?? 'grey',
							'on_navy' => true,
						)
					);
				}
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
