<?php
/**
 * Compatibility shims for the removed Epsilon framework.
 *
 * Philosophy 1.2.0 dropped the vendored Epsilon framework and the theme dashboard
 * that came with it. Their upstream repositories were deleted, which is why every
 * page of the theme fatalled on a fresh checkout.
 *
 * Nothing in the theme uses the classes below any more. They exist so a child
 * theme or a stale snippet that still calls Epsilon_Customizer::add_field() keeps
 * working instead of taking the site down.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Epsilon_Customizer' ) ) {

	/**
	 * Class Epsilon_Customizer
	 *
	 * @deprecated 1.2.0 Use Philosophy_Customizer.
	 */
	class Epsilon_Customizer {

		/**
		 * Registers panels and sections.
		 *
		 * @param array $collection Panel and section definitions.
		 */
		public static function add_multiple( $collection = array() ) {
			Philosophy_Customizer::add_multiple( $collection );
		}

		/**
		 * Registers a setting and its control.
		 *
		 * @param string $id   Setting id.
		 * @param array  $args Field definition.
		 */
		public static function add_field( $id, $args = array() ) {
			Philosophy_Customizer::add_field( $id, $args );
		}
	}
}

if ( ! function_exists( 'philosophy_deprecated_epsilon_classes' ) ) {
	/**
	 * Declares no-op stand-ins for the Epsilon classes the theme used to construct.
	 *
	 * Registered on after_setup_theme so a real Epsilon-based plugin, if one is
	 * ever active, still wins.
	 */
	function philosophy_deprecated_epsilon_classes() {
		if ( ! class_exists( 'Epsilon_Framework' ) ) {
			/**
			 * Class Epsilon_Framework
			 *
			 * @deprecated 1.2.0
			 */
			class Epsilon_Framework {}
		}

		if ( ! class_exists( 'Epsilon_init_Dashboard' ) ) {
			/**
			 * Class Epsilon_init_Dashboard
			 *
			 * @deprecated 1.2.0 Replaced by Philosophy_Welcome.
			 */
			class Epsilon_init_Dashboard {

				/**
				 * Returns the singleton.
				 *
				 * @param array $theme Theme data.
				 *
				 * @return Epsilon_init_Dashboard
				 */
				public static function get_instance( $theme = array() ) {
					static $instance;

					if ( ! $instance ) {
						$instance = new self();
					}

					return $instance;
				}
			}
		}
	}
}
add_action( 'after_setup_theme', 'philosophy_deprecated_epsilon_classes', 1 );

if ( ! function_exists( 'philosophy_social' ) ) {
	/**
	 * Renders social links from a theme_mod that was never registered.
	 *
	 * @deprecated 1.2.0 Assign a menu to the Social Menu location instead.
	 *
	 * @param array $args Unused.
	 */
	function philosophy_social( $args = array() ) {
		_deprecated_function( __FUNCTION__, '1.2.0', 'the Social Menu location' );
	}
}
