<?php

if ( ! class_exists( 'Philosophy_Notify_System' ) ) {
	/**
	 * Class Philosophy_Notify_System
	 */
	class Philosophy_Notify_System extends Epsilon_Notify_System {
		/**
		 * @param $ver
		 *
		 * @return mixed
		 */
		public static function philosophy_version_check( $ver ) {
			$philosophy = wp_get_theme();

			return version_compare( $philosophy['Version'], $ver, '>=' );
		}

		/**
		 * @return bool
		 */
		public static function philosophy_is_not_static_page() {
			return 'page' == get_option( 'show_on_front' ) ? true : false;
		}


		/**
		 * @return bool
		 */
		public static function philosophy_has_content() {
			$option = get_option( 'philosophy_imported_demo', false );
			if ( $option ) {
				return true;
			};

			return false;
		}

		/**
		 * @return bool|mixed
		 */
		public static function philosophy_check_import_req() {
			$needs = array(
				'has_content' => self::philosophy_has_content(),
				'has_plugin'  => self::philosophy_has_plugin( 'philosophy-companion' ),
			);

			if ( $needs['has_content'] ) {
				return true;
			}

			if ( $needs['has_plugin'] ) {
				return false;
			}

			return true;
		}

		/**
		 * @return bool
		 */
		public static function philosophy_check_plugin_is_installed( $slug ) {
			$slug2 = $slug;
			if ( 'wordpress-seo' === $slug ) {
				$slug2 = 'wp-seo';
			}

			$path = WPMU_PLUGIN_DIR . '/' . $slug . '/' . $slug2 . '.php';
			if ( ! file_exists( $path ) ) {
				$path = WP_PLUGIN_DIR . '/' . $slug . '/' . $slug2 . '.php';

				if ( ! file_exists( $path ) ) {
					$path = false;
				}
			}

			if ( file_exists( $path ) ) {
				return true;
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public static function philosophy_check_plugin_is_active( $slug ) {
			$slug2 = $slug;
			if ( 'wordpress-seo' === $slug ) {
				$slug2 = 'wp-seo';
			}

			$path = WPMU_PLUGIN_DIR . '/' . $slug . '/' . $slug2 . '.php';
			if ( ! file_exists( $path ) ) {
				$path = WP_PLUGIN_DIR . '/' . $slug . '/' . $slug2 . '.php';
				if ( ! file_exists( $path ) ) {
					$path = false;
				}
			}

			if ( file_exists( $path ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

				return is_plugin_active( $slug . '/' . $slug2 . '.php' );
			}
		}

		public static function philosophy_has_plugin( $slug = null ) {

			$check = array(
				'installed' => self::check_plugin_is_installed( $slug ),
				'active'    => self::check_plugin_is_active( $slug ),
			);

			if ( ! $check['installed'] || ! $check['active'] ) {
				return false;
			}

			return true;
		}

		public static function philosophy_companion_title() {
			$installed = self::check_plugin_is_installed( 'philosophy-companion' );
			if ( ! $installed ) {
				return esc_html__( 'Install: Philosophy Companion Plugin', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'philosophy-companion' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: Philosophy Companion Plugin', 'philosophy' );
			}

			return esc_html__( 'Install: Philosophy Companion Plugin', 'philosophy' );
		}

		public static function philosophy_elementor_title() {
			$installed = self::check_plugin_is_installed( 'elementor' );
			if ( ! $installed ) {
				return esc_html__( 'Install: Elementor Page Builder Plugin', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'elementor' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: Elementor Page Builder Plugin', 'philosophy' );
			}

			return esc_html__( 'Install: Elementor Page Builder Plugin', 'philosophy' );
		}

		public static function philosophy_weglot_title() {
			$installed = self::check_plugin_is_installed( 'weglot' );
			if ( ! $installed ) {
				return esc_html__( 'Install: Weglot Translate Plugin', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'wordpress-seo' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: Weglot Translate Plugin', 'philosophy' );
			}

			return esc_html__( 'Install: Weglot Translate Plugin', 'philosophy' );
		}

		public static function philosophy_woocommerce_title() {
			$installed = self::check_plugin_is_installed( 'woocommerce' );
			if ( ! $installed ) {
				return esc_html__( 'Install: WooCommerce', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'woocommerce' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: WooCommerce', 'philosophy' );
			}

			return esc_html__( 'Install: WooCommerce', 'philosophy' );
		}

		public static function philosophy_cf7_title() {
			$installed = self::check_plugin_is_installed( 'contac-form-7' );
			if ( ! $installed ) {
				return esc_html__( 'Install: Contact Form 7', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'contac-form-7' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: Contact Form 7', 'philosophy' );
			}

			return esc_html__( 'Install: Contact Form 7', 'philosophy' );
		}

		public static function philosophy_oneclick_title() {
			$installed = self::check_plugin_is_installed( 'one-click-demo-import' );
			if ( ! $installed ) {
				return esc_html__( 'Install: One Click Demo Import', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'one-click-demo-import' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: One Click Demo Import', 'philosophy' );
			}

			return esc_html__( 'Install: One Click Demo Import', 'philosophy' );
		}

		/**
		 * @return string
		 */
		public static function philosophy_companion_description() {
			$installed = self::check_plugin_is_installed( 'philosophy-companion' );

			if ( ! $installed ) {
				return esc_html__( 'Please install Philosophy Companion plugin.', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'philosophy-companion' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate Philosophy Companion plugin.', 'philosophy' );
			}

			return esc_html__( 'Please install Philosophy Companion plugin.', 'philosophy' );
		}

		/**
		 * @return string
		 */
		public static function philosophy_woocommerce_description() {
			$installed = self::check_plugin_is_installed( 'woocommerce' );

			if ( ! $installed ) {
				return esc_html__( 'Please install WooCommerce. Note that you won\'t be able to use the shop without it.', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'woocommerce' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate WooCommerce. Note that you won\'t be able to use the shop without it.', 'philosophy' );
			}

			return esc_html__( 'Please install WooCommerce. Note that you won\'t be able to use the shop without it.', 'philosophy' );
		}

		public static function philosophy_cf7_description() {
			$installed = self::check_plugin_is_installed( 'contac-form-7' );

			if ( ! $installed ) {
				return esc_html__( 'Please install Contact Form 7. Note that you won\'t be able to use Contact Form without it.', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'contac-form-7' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate Contact Form 7. Note that you won\'t be able to use Contact Form without it.', 'philosophy' );
			}

			return esc_html__( 'Please install Contact Form 7. Note that you won\'t be able to use Contact Form without it.', 'philosophy' );
		}

		public static function philosophy_elementor_description() {
			$installed = self::check_plugin_is_installed( 'elementor' );
			if ( ! $installed ) {
				return esc_html__( 'Please install Elementor page builder plugin.', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'elementor' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate Elementor page builder plugin.', 'philosophy' );
			}

			return esc_html__( 'Please install Elementor page builder plugin.', 'philosophy' );

		}

		public static function philosophy_weglot_description() {
			$installed = self::check_plugin_is_installed( 'weglot' );
			if ( ! $installed ) {
				return esc_html__( 'Please install Weglot Translate plugin.', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'weglot' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate Weglot Translate plugin.', 'philosophy' );
			}

			return esc_html__( 'Please install Weglot Translate plugin.', 'philosophy' );

		}

		public static function philosophy_oneclick_description() {
			$installed = self::check_plugin_is_installed( 'one-click-demo-import' );
			if ( ! $installed ) {
				return esc_html__( 'Please install One Click Demo Import plugin to import demo data.', 'philosophy' );
			}

			$active = self::check_plugin_is_active( 'one-click-demo-import' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate One Click Demo Import plugin to import demo data.', 'philosophy' );
			}

			return esc_html__( 'Please install One Click Demo Import plugin to import demo data.', 'philosophy' );

		}

		/**
		 * @return bool
		 */
		public static function philosophy_is_not_template_front_page() {
			$page_id = get_option( 'page_on_front' );

			return get_page_template_slug( $page_id ) == 'page-templates/frontpage-template.php' ? true : false;
		}
	}
}// End if().
