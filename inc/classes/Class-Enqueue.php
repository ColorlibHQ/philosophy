<?php
/**
 * Legacy enqueue helper.
 *
 * @deprecated 1.2.0 The theme enqueues its own assets in Philosophy::enqueue_assets().
 *                   This class is kept only so a child theme that instantiated it
 *                   does not fatal.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'philosophy_Enqueue' ) ) {

	/**
	 * Class philosophy_Enqueue
	 *
	 * @deprecated 1.2.0
	 */
	class philosophy_Enqueue {

		/**
		 * Style and script definitions.
		 *
		 * @var array
		 */
		public $scripts = array();

		/**
		 * Hooks the enqueue callback up.
		 */
		public function philosophy_scripts_enqueue_init() {
			add_action( 'wp_enqueue_scripts', array( $this, 'philosophy_frontend_enqueue_scripts' ) );
		}

		/**
		 * Enqueues everything in $scripts.
		 */
		public function philosophy_frontend_enqueue_scripts() {
			if ( ! empty( $this->scripts['style'] ) && is_array( $this->scripts['style'] ) ) {
				foreach ( $this->scripts['style'] as $style ) {
					if ( empty( $style['handler'] ) || empty( $style['file'] ) ) {
						continue;
					}

					wp_enqueue_style(
						sanitize_key( $style['handler'] ),
						esc_url_raw( $style['file'] ),
						isset( $style['dependency'] ) ? (array) $style['dependency'] : array(),
						isset( $style['version'] ) ? $style['version'] : false
					);
				}
			}

			if ( ! empty( $this->scripts['scripts'] ) && is_array( $this->scripts['scripts'] ) ) {
				foreach ( $this->scripts['scripts'] as $script ) {
					if ( empty( $script['handler'] ) || empty( $script['file'] ) ) {
						continue;
					}

					$handle    = sanitize_key( $script['handler'] );
					$deps      = isset( $script['dependency'] ) ? (array) $script['dependency'] : array();
					$version   = isset( $script['version'] ) ? $script['version'] : false;
					$in_footer = ! empty( $script['in_footer'] );

					if ( ! empty( $script['register'] ) ) {
						wp_register_script( $handle, esc_url_raw( $script['file'] ), $deps, $version, $in_footer );
					} else {
						wp_enqueue_script( $handle, esc_url_raw( $script['file'] ), $deps, $version, $in_footer );
					}
				}
			}
		}
	}
}
