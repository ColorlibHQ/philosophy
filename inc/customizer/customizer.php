<?php
/**
 * Customizer bootstrap.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

require_once PHILOSOPHY_DIR_PATH_INC . 'customizer/class-philosophy-customizer.php';

if ( ! function_exists( 'philosophy_load_customizer_controls' ) ) {
	/**
	 * Loads the theme's Customizer control classes.
	 *
	 * They extend WP_Customize_Control, which core only defines once the
	 * Customizer is being built, so they cannot be required from functions.php.
	 */
	function philosophy_load_customizer_controls() {
		if ( ! class_exists( 'WP_Customize_Control' ) ) {
			return;
		}

		require_once PHILOSOPHY_DIR_PATH_INC . 'customizer/controls/class-philosophy-control-toggle.php';
		require_once PHILOSOPHY_DIR_PATH_INC . 'customizer/controls/class-philosophy-control-text-editor.php';
		require_once PHILOSOPHY_DIR_PATH_INC . 'customizer/controls/class-philosophy-control-repeater.php';
		require_once PHILOSOPHY_DIR_PATH_INC . 'customizer/controls/class-philosophy-control-layout.php';
	}
}

if ( ! function_exists( 'philosophy_enqueue_customizer_control_assets' ) ) {
	/**
	 * Enqueues the shared styling and behaviour for the theme's own controls.
	 *
	 * Called from each control's enqueue() method; WordPress deduplicates by handle.
	 */
	function philosophy_enqueue_customizer_control_assets() {
		wp_enqueue_style(
			'philosophy-customizer-controls',
			PHILOSOPHY_DIR_URI . 'inc/customizer/assets/css/customizer-controls.css',
			array( 'customize-controls' ),
			PHILOSOPHY_VERSION
		);

		wp_enqueue_script(
			'philosophy-customizer-controls',
			PHILOSOPHY_DIR_URI . 'inc/customizer/assets/js/customizer-controls.js',
			array( 'customize-controls' ),
			PHILOSOPHY_VERSION,
			true
		);
	}
}

if ( ! class_exists( 'philosophy_theme_customizer' ) ) {

	/**
	 * Class philosophy_theme_customizer
	 *
	 * Class name kept from 1.1.x: child themes instantiate it.
	 */
	class philosophy_theme_customizer {

		/**
		 * Hooks the Customizer up.
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'philosophy_theme_customizer_options' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'philosophy_customizer_js' ) );
			add_action( 'customize_preview_init', array( $this, 'philosophy_customizer_preview_js' ) );
		}

		/**
		 * Registers every panel, section and field.
		 *
		 * @param WP_Customize_Manager $wp_customize Customizer manager.
		 */
		public function philosophy_theme_customizer_options( $wp_customize ) {
			philosophy_load_customizer_controls();

			Philosophy_Customizer::set_manager( $wp_customize );

			require PHILOSOPHY_DIR_PATH_INC . 'customizer/fields/sections.php';
			require PHILOSOPHY_DIR_PATH_INC . 'customizer/fields/fields.php';

			// Site identity belongs with the rest of the theme options.
			$title_tagline = $wp_customize->get_section( 'title_tagline' );

			if ( $title_tagline ) {
				$title_tagline->panel    = 'philosophy_theme_options_panel';
				$title_tagline->priority = 0;
			}

			// Live preview for the settings that only move text around.
			foreach ( array( 'blogname', 'blogdescription' ) as $setting_id ) {
				$setting = $wp_customize->get_setting( $setting_id );

				if ( $setting ) {
					$setting->transport = 'postMessage';
				}
			}

			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.header__logo h2 a',
					'render_callback' => 'philosophy_customize_partial_blogname',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.header__logo span',
					'render_callback' => 'philosophy_customize_partial_blogdescription',
				)
			);
		}

		/**
		 * Enqueues the Customizer pane script.
		 */
		public function philosophy_customizer_js() {
			wp_enqueue_script(
				'philosophy-customizer',
				PHILOSOPHY_DIR_URI . 'inc/customizer/js/customizer.js',
				array( 'customize-controls' ),
				PHILOSOPHY_VERSION,
				true
			);

			$about_page   = self::philosophy_get_page_name( 'page-about.php' );
			$contact_page = self::philosophy_get_page_name( 'page-contact.php' );

			wp_localize_script(
				'philosophy-customizer',
				'customizerdata',
				array(
					'home'         => home_url( '/' ),
					'blog_page'    => get_post_type_archive_link( 'post' ),
					'about_page'   => ! empty( $about_page[0]->post_name ) ? $about_page[0]->post_name : '',
					'contact_page' => ! empty( $contact_page[0]->post_name ) ? $contact_page[0]->post_name : '',
				)
			);
		}

		/**
		 * Enqueues the live-preview script that runs inside the preview iframe.
		 */
		public function philosophy_customizer_preview_js() {
			wp_enqueue_script(
				'philosophy-customizer-preview',
				PHILOSOPHY_DIR_URI . 'inc/customizer/js/customizer-preview.js',
				array( 'customize-preview' ),
				PHILOSOPHY_VERSION,
				true
			);
		}

		/**
		 * Finds pages using a given page template.
		 *
		 * @param string $template Template file name.
		 *
		 * @return WP_Post[]
		 */
		public static function philosophy_get_page_name( $template ) {
			return get_pages(
				array(
					'meta_key'   => '_wp_page_template',
					'meta_value' => $template,
				)
			);
		}

		/**
		 * Image sanitization callback.
		 *
		 * @param string               $image   Image URL.
		 * @param WP_Customize_Setting $setting Setting instance.
		 *
		 * @return string
		 */
		public static function philosophy_sanitize_image( $image, $setting = null ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png',
				'bmp'          => 'image/bmp',
				'tif|tiff'     => 'image/tiff',
				'webp'         => 'image/webp',
				'ico'          => 'image/x-icon',
			);

			$file = wp_check_filetype( $image, $mimes );

			if ( $file['ext'] ) {
				return esc_url_raw( $image );
			}

			return ( $setting instanceof WP_Customize_Setting ) ? $setting->default : '';
		}
	}
}

if ( ! function_exists( 'philosophy_customize_partial_blogname' ) ) {
	/**
	 * Renders the site title for selective refresh.
	 */
	function philosophy_customize_partial_blogname() {
		bloginfo( 'name' );
	}
}

if ( ! function_exists( 'philosophy_customize_partial_blogdescription' ) ) {
	/**
	 * Renders the site description for selective refresh.
	 */
	function philosophy_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
}
