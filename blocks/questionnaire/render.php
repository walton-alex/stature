<?php
/**
 * Questionnaire block: a start splash that reveals a multi-step Gravity Form.
 *
 * @param array  $block      Block settings.
 * @param string $content    Block inner HTML.
 * @param bool   $is_preview Whether this is an editor preview render.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$eyebrow     = (string) get_field( 'eyebrow' );
$heading     = (string) get_field( 'heading' );
$lead        = (string) get_field( 'lead' );
$meta        = (string) get_field( 'meta' );
$start_label = (string) get_field( 'start_label' );
$form_id     = (int) get_field( 'form_id' );

$start_label = '' !== $start_label ? $start_label : __( 'Start questionnaire', 'stature' );

$classes = stature_section_classes( $block, 'stature-questionnaire', 'grey' );
$anchor  = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
$form_dom = 'stature-questionnaire-form';
?>
<section
	<?php if ( '' !== $anchor ) : ?>
		id="<?php echo esc_attr( $anchor ); ?>"
	<?php endif; ?>
	class="<?php echo esc_attr( $classes ); ?>"
	data-questionnaire
>
	<div class="stature-container stature-section__inner">
		<div class="stature-questionnaire__intro" data-questionnaire-panel="intro">
			<?php get_template_part( 'parts/eyebrow', null, array( 'text' => $eyebrow ) ); ?>

			<?php if ( '' !== $heading ) : ?>
				<h1 class="stature-questionnaire__heading stature-heading stature-heading--h1"><?php echo esc_html( $heading ); ?></h1>
			<?php endif; ?>

			<?php if ( '' !== $lead ) : ?>
				<p class="stature-questionnaire__lead stature-lead"><?php echo esc_html( $lead ); ?></p>
			<?php endif; ?>

			<?php
			if ( '' !== $meta ) :
				$meta_items = array_filter( array_map( 'trim', (array) preg_split( '/\s*[·•|]\s*/u', $meta ) ) );
				?>
				<div class="stature-tool-meta stature-questionnaire__meta">
					<?php foreach ( $meta_items as $meta_item ) : ?>
						<span class="stature-tool-meta__item"><?php echo esc_html( $meta_item ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $form_id > 0 && function_exists( 'gravity_form' ) ) : ?>
				<button
					type="button"
					class="stature-questionnaire__start stature-btn stature-btn--primary stature-btn--lg"
					data-questionnaire-start
					aria-controls="<?php echo esc_attr( $form_dom ); ?>"
					aria-expanded="false"
				>
					<?php echo esc_html( $start_label ); ?>
					<span class="stature-btn__arrow" aria-hidden="true">&rarr;</span>
				</button>
			<?php endif; ?>
		</div>

		<div class="stature-questionnaire__form stature-gform" id="<?php echo esc_attr( $form_dom ); ?>" data-questionnaire-panel="form" hidden>
			<?php if ( $form_id > 0 && function_exists( 'gravity_form' ) ) : ?>
				<?php gravity_form( $form_id, false, false, false, null, true, 0, true ); ?>
			<?php elseif ( $is_preview ) : ?>
				<p class="stature-questionnaire__placeholder">
					<?php esc_html_e( 'Choose a form to display it here.', 'stature' ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</section>
