<?php
/**
 * The header bar: logo, social menu, search and navigation.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<!-- ***** Header Area Start ***** -->
<header class="header">
	<div class="header__content row">

		<div class="header__logo">
			<?php echo philosophy_theme_logo( 'logo' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in philosophy_theme_logo(). ?>
		</div> <!-- end header__logo -->

		<?php
		if ( has_nav_menu( 'social-menu' ) && philosophy_opt( 'philosophy_headersocial_toggle' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'social-menu',
					'container'      => 'nav',
					'container_class' => 'header__social-wrap',
					'container_aria_label' => esc_attr__( 'Social links', 'philosophy' ),
					'depth'          => 1,
					'menu_class'     => 'header__social',
					'fallback_cb'    => false,
					'walker'         => new philosophy_social_navwalker(),
				)
			);
		}
		?>

		<?php if ( philosophy_opt( 'philosophy_hsearchform_toggle' ) ) : ?>
			<button type="button" class="header__search-trigger" aria-expanded="false" aria-controls="philosophy-search">
				<span class="search-label"><?php esc_html_e( 'Search', 'philosophy' ); ?></span>
			</button>

			<div class="header__search" id="philosophy-search">
				<?php get_search_form( array( 'philosophy_context' => 'header' ) ); ?>

				<button type="button" class="header__overlay-close">
					<span class="screen-reader-text"><?php esc_html_e( 'Close the search form', 'philosophy' ); ?></span>
					<span aria-hidden="true"><?php esc_html_e( 'Close', 'philosophy' ); ?></span>
				</button>
			</div>  <!-- end header__search -->
		<?php endif; ?>

		<button type="button" class="header__toggle-menu" aria-expanded="false" aria-controls="philosophy-primary-nav" aria-label="<?php esc_attr_e( 'Open the menu', 'philosophy' ); ?>">
			<span aria-hidden="true"><?php esc_html_e( 'Menu', 'philosophy' ); ?></span>
		</button>

		<nav class="header__nav-wrap" id="philosophy-primary-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'philosophy' ); ?>">

			<h2 class="header__nav-heading h6"><?php esc_html_e( 'Site Navigation', 'philosophy' ); ?></h2>

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary-menu',
					'container'      => '',
					'depth'          => 2,
					'menu_class'     => 'header__nav',
					'fallback_cb'    => 'philosophy_bootstrap_navwalker::fallback',
					'walker'         => new philosophy_bootstrap_navwalker(),
				)
			);
			?>

			<?php
			// The social icons in the header bar are hidden below 900px. Repeating
			// them inside the overlay is the only way a phone visitor can reach
			// them at all.
			if ( has_nav_menu( 'social-menu' ) && philosophy_opt( 'philosophy_headersocial_toggle' ) ) {
				wp_nav_menu(
					array(
						'theme_location'       => 'social-menu',
						'container'            => 'nav',
						'container_class'      => 'header__nav-social',
						'container_aria_label' => esc_attr__( 'Social links', 'philosophy' ),
						'depth'                => 1,
						'menu_class'           => 'header__social header__social--nav',
						'fallback_cb'          => false,
						'walker'               => new philosophy_social_navwalker(),
					)
				);
			}
			?>

			<button type="button" class="header__overlay-close close-mobile-menu">
				<span class="screen-reader-text"><?php esc_html_e( 'Close the menu', 'philosophy' ); ?></span>
				<span aria-hidden="true"><?php esc_html_e( 'Close', 'philosophy' ); ?></span>
			</button>

		</nav> <!-- end header__nav-wrap -->

	</div> <!-- header-content -->
</header> <!-- header -->
