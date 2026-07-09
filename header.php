<?php
/**
 * Site header.
 *
 * @package Stature
 */

defined( 'ABSPATH' ) || exit;

$stature_variant = stature_header_variant();
$stature_on_navy = 'navy' === $stature_variant;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( "stature-header-variant--{$stature_variant}" ); ?>>
<?php wp_body_open(); ?>

<a class="stature-skip-link screen-reader-text" href="#stature-main">
	<?php esc_html_e( 'Skip to content', 'stature' ); ?>
</a>

<div class="stature-header-bar stature-header-bar--<?php echo esc_attr( $stature_variant ); ?>">
	<header class="stature-header stature-header--<?php echo esc_attr( $stature_variant ); ?>">
		<a class="stature-header__logo" href="<?php echo esc_url( stature_url() ); ?>" rel="home">
			<img
				src="<?php echo esc_url( stature_asset( $stature_on_navy ? 'logos/stature_logo_white.svg' : 'logos/stature_logo_navy.svg' ) ); ?>"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
				width="140"
				height="32"
			>
		</a>

		<button
			class="stature-header__toggle"
			type="button"
			aria-controls="stature-primary-nav"
			aria-expanded="false"
			aria-label="<?php esc_attr_e( 'Open menu', 'stature' ); ?>"
		>
			<span class="stature-header__toggle-bar" aria-hidden="true"></span>
			<span class="stature-header__toggle-bar" aria-hidden="true"></span>
			<span class="stature-header__toggle-bar" aria-hidden="true"></span>
		</button>

		<nav id="stature-primary-nav" class="stature-header__nav" aria-label="<?php esc_attr_e( 'Primary', 'stature' ); ?>">
			<div class="stature-header__panel-head">
				<img
					class="stature-header__panel-logo"
					src="<?php echo esc_url( stature_asset( 'logos/stature_logo_white.svg' ) ); ?>"
					alt=""
					aria-hidden="true"
					width="140"
					height="32"
				>

				<button
					class="stature-header__close"
					type="button"
					aria-label="<?php esc_attr_e( 'Close menu', 'stature' ); ?>"
				>
					<span class="stature-header__close-bar" aria-hidden="true"></span>
					<span class="stature-header__close-bar" aria-hidden="true"></span>
				</button>
			</div>

			<div class="stature-header__scroll">
				<?php stature_header_nav(); ?>

				<a
					class="stature-header__cta <?php echo esc_attr( stature_button_classes( 'primary', 'md', $stature_on_navy ) ); ?>"
					href="<?php echo esc_url( stature_url( 'start-a-project' ) ); ?>"
				>
					<?php esc_html_e( 'Start a Project', 'stature' ); ?>
				</a>
			</div>
		</nav>
	</header>
</div>

<main id="stature-main">
