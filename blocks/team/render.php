<?php
/**
 * Team grid block.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$eyebrow = (string) get_field( 'eyebrow' );
$heading = (string) get_field( 'heading' );
$lead    = (string) get_field( 'lead' );
$bg      = (string) get_field( 'background' );

$bg = in_array( $bg, array( 'white', 'grey' ), true ) ? $bg : 'grey';

$classes = stature_section_classes( $block, 'stature-team', $bg );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
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
			array(
				'eyebrow' => $eyebrow,
				'heading' => $heading,
				'lead'    => $lead,
			)
		);
		?>

		<?php if ( have_rows( 'members' ) ) : ?>
			<div class="stature-team__grid">
				<?php
				while ( have_rows( 'members' ) ) :
					the_row();

					$name  = (string) get_sub_field( 'name' );
					$role  = (string) get_sub_field( 'role' );
					$bio   = (string) get_sub_field( 'bio' );
					$photo = get_sub_field( 'photo' );
					?>
					<article class="stature-team__member">
						<div class="stature-team__photo">
							<?php
							if ( is_array( $photo ) && ! empty( $photo['ID'] ) ) {
								echo wp_get_attachment_image(
									(int) $photo['ID'],
									'medium_large',
									false,
									array(
										'class'   => 'stature-team__image stature-cover',
										'alt'     => $name,
										'loading' => 'lazy',
									)
								);
							} else {
								printf(
									'<span class="stature-team__placeholder">%s</span>',
									esc_html__( 'Photo to follow', 'stature' )
								);
							}
							?>
						</div>

						<?php if ( '' !== $name ) : ?>
							<h3 class="stature-team__name"><?php echo esc_html( $name ); ?></h3>
						<?php endif; ?>

						<?php if ( '' !== $role ) : ?>
							<div class="stature-team__role"><?php echo esc_html( $role ); ?></div>
						<?php endif; ?>

						<?php if ( '' !== $bio ) : ?>
							<p class="stature-team__bio"><?php echo esc_html( $bio ); ?></p>
						<?php endif; ?>
					</article>
					<?php
				endwhile;
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
