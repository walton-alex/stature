<?php
/**
 * Minimal header for standalone tool pages (logo only, no navigation).
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'stature-tool-page' ); ?>>
<?php wp_body_open(); ?>

<a class="stature-skip-link screen-reader-text" href="#stature-main">
	<?php esc_html_e( 'Skip to content', 'stature' ); ?>
</a>

<header class="stature-tool-header">
	<a class="stature-tool-header__logo" href="<?php echo esc_url( stature_url() ); ?>" rel="home">
		<img
			src="<?php echo esc_url( stature_asset( 'logos/stature_logo_navy.svg' ) ); ?>"
			alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
			width="140"
			height="32"
		>
	</a>
</header>

<main id="stature-main">
