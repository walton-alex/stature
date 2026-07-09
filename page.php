<?php
/**
 * Page template.
 *
 * Pages are composed entirely from Stature blocks, so the template outputs the
 * block content with no wrapping container of its own — each block owns its
 * full-bleed section and inner container.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) {
	the_post();
	the_content();
}

get_footer();
