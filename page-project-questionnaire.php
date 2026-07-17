<?php
/**
 * Standalone page template for the Project Questionnaire.
 *
 * Auto-selected for the page with the slug "project-questionnaire". Shares the
 * minimal tool chrome with the scorecard so the two tools present as one
 * product. The questionnaire block owns its own section and container.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

get_header( 'tool' );

while ( have_posts() ) {
	the_post();
	the_content();
}

get_footer( 'tool' );
