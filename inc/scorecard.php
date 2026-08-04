<?php
/**
 * Website credibility scorecard: server-side lead capture.
 *
 * The scorecard UI runs entirely in JS. When the visitor submits the email
 * gate, the browser POSTs their details and computed score here; we store the
 * data as a Gravity Forms entry and fire the form's notifications. Nothing is
 * stored until that submission — matching the brief.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

const STATURE_SCORECARD_FORM_TITLE = 'Website Credibility Scorecard';

/**
 * Where the scorecard results send people to book a review call.
 */
function stature_scorecard_review_url(): string {
	$url = function_exists( 'get_field' ) ? (string) get_field( 'scorecard_review_url', 'option' ) : '';

	return '' !== $url ? $url : 'https://cal.com/alex-walton-stature/scorecard-review';
}

/**
 * Resolve the scorecard Gravity Form ID by title.
 */
function stature_scorecard_form_id(): int {
	if ( ! class_exists( 'GFAPI' ) ) {
		return 0;
	}

	foreach ( GFAPI::get_forms() as $form ) {
		if ( STATURE_SCORECARD_FORM_TITLE === $form['title'] ) {
			return (int) $form['id'];
		}
	}

	return 0;
}

/**
 * Handle a gate submission: validate, store a Gravity Forms entry, notify.
 */
function stature_scorecard_submit(): void {
	check_ajax_referer( 'stature_scorecard', 'nonce' );

	$first_name = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$score      = isset( $_POST['score'] ) ? max( 0, min( 60, (int) $_POST['score'] ) ) : 0;
	$band       = isset( $_POST['band'] ) ? sanitize_text_field( wp_unslash( $_POST['band'] ) ) : '';
	$breakdown  = isset( $_POST['breakdown'] ) ? sanitize_textarea_field( wp_unslash( $_POST['breakdown'] ) ) : '';

	if ( '' === $first_name || ! is_email( $email ) ) {
		wp_send_json_error(
			array( 'message' => __( 'Please enter your first name and a valid work email.', 'stature' ) ),
			400
		);
	}

	if ( ! in_array( $band, array( 'Critical', 'Developing', 'Strong', 'Excellent' ), true ) ) {
		$band = '';
	}

	$form_id = stature_scorecard_form_id();

	if ( ! $form_id || ! class_exists( 'GFAPI' ) ) {
		wp_send_json_error(
			array( 'message' => __( 'The scorecard is temporarily unavailable.', 'stature' ) ),
			500
		);
	}

	$entry = array(
		'form_id'    => $form_id,
		'1'          => $first_name,
		'2'          => $email,
		'3'          => (string) $score,
		'4'          => $band,
		'5'          => $breakdown,
		'source_url' => isset( $_POST['source_url'] ) ? esc_url_raw( wp_unslash( $_POST['source_url'] ) ) : '',
		'ip'         => class_exists( 'GFFormsModel' ) ? GFFormsModel::get_ip() : '',
	);

	$entry_id = GFAPI::add_entry( $entry );

	if ( is_wp_error( $entry_id ) ) {
		wp_send_json_error(
			array( 'message' => __( 'Something went wrong saving your details. Please try again.', 'stature' ) ),
			500
		);
	}

	$form  = GFAPI::get_form( $form_id );
	$saved = GFAPI::get_entry( $entry_id );

	if ( $form && ! is_wp_error( $saved ) ) {
		GFAPI::send_notifications( $form, $saved, 'form_submission' );
	}

	wp_send_json_success( array( 'entry_id' => $entry_id ) );
}
add_action( 'wp_ajax_stature_scorecard', 'stature_scorecard_submit' );
add_action( 'wp_ajax_nopriv_stature_scorecard', 'stature_scorecard_submit' );
