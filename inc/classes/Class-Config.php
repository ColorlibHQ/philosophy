<?php
/**
 * Theme setup and asset loading.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Philosophy' ) ) {

	/**
	 * Class Philosophy
	 *
	 * Class name kept from 1.0: functions.php instantiates it and child themes
	 * reference it.
	 */
	final class Philosophy {

		/**
		 * Theme version, used to bust asset caches.
		 *
		 * @var string
		 */
		private $philosophy_version = PHILOSOPHY_VERSION;

		/**
		 * Hooks the theme up.
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'support' ) );
			add_action( 'wp_head', array( $this, 'no_js_class' ), 0 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );

			$this->init();
		}

		/**
		 * Boots the pieces that are not hooks.
		 */
		public function init() {
			$this->customizer_init();
		}

		/**
		 * Declares theme support.
		 */
		public function support() {
			$GLOBALS['content_width'] = apply_filters( 'philosophy_content_width', 751 );

			load_theme_textdomain( 'philosophy', PHILOSOPHY_DIR_PATH . 'languages' );

			add_theme_support( 'title-tag' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'customize-selective-refresh-widgets' );

			add_theme_support(
				'custom-logo',
				array(
					'height'      => 100,
					'width'       => 300,
					'flex-height' => true,
					'flex-width'  => true,
				)
			);

			add_theme_support( 'post-formats', array( 'video', 'audio' ) );
			add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
			add_image_size( 'philosophy_widget_post_thumb', 70, 70, true );

			add_theme_support(
				'html5',
				array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'style',
					'script',
					'navigation-widgets',
				)
			);

			// Block editor. The theme has always been a classic theme; these make
			// its content look the same in the editor as it does on the front end.
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );
			add_theme_support( 'wp-block-styles' );
			add_theme_support( 'editor-styles' );
			add_editor_style( 'assets/css/editor-style.css' );

			add_theme_support(
				'custom-background',
				apply_filters(
					'philosophy_custom_background_args',
					array(
						'default-color' => 'ffffff',
						'default-image' => '',
					)
				)
			);

			register_nav_menus(
				array(
					'primary-menu' => esc_html__( 'Primary Menu', 'philosophy' ),
					'social-menu'  => esc_html__( 'Social Menu', 'philosophy' ),
				)
			);
		}

		/**
		 * Registers and enqueues the front-end styles and scripts.
		 *
		 * Handles are all prefixed: before 1.2.0 this theme claimed the generic
		 * handles "base", "main", "vendor" and "font-awesome", so whichever plugin
		 * registered one of those first won and the theme's own file never loaded.
		 */
		public function enqueue_assets() {
			$css = PHILOSOPHY_DIR_CSS_URI;
			$js  = PHILOSOPHY_DIR_JS_URI;
			$min = philosophy_asset_suffix();
			$ver = $this->philosophy_version;

			wp_enqueue_style( 'philosophy-fonts', $css . 'fonts.css', array(), $ver );
			wp_enqueue_style( 'philosophy-icons', $css . 'fontawesome/all' . $min . '.css', array(), PHILOSOPHY_FONTAWESOME_VERSION );
			wp_enqueue_style( 'philosophy-base', $css . 'base' . $min . '.css', array(), $ver );
			wp_enqueue_style( 'philosophy-vendor', $css . 'vendor' . $min . '.css', array( 'philosophy-base' ), $ver );
			wp_enqueue_style( 'philosophy-main', $css . 'main' . $min . '.css', array( 'philosophy-vendor' ), $ver );

			// style.css last so a child theme's copy still wins the cascade.
			wp_enqueue_style( 'philosophy-style', get_stylesheet_uri(), array( 'philosophy-main' ), $ver );

			wp_enqueue_script( 'philosophy-scripts', $js . 'philosophy' . $min . '.js', array(), $ver, true );

			wp_localize_script(
				'philosophy-scripts',
				'philosophySettings',
				array(
					'preloader'    => (bool) philosophy_opt( 'philosophy_preloader_toggle', true ),
					'backToTop'    => (bool) philosophy_opt( 'philosophy_backtotop_btn', true ),
					'mapApiKey'    => (string) philosophy_opt( 'philosophy_gmap_api_key' ),
					'i18n'         => array(
						'openMenu'   => esc_html__( 'Open the menu', 'philosophy' ),
						'closeMenu'  => esc_html__( 'Close the menu', 'philosophy' ),
						'openSearch' => esc_html__( 'Open the search form', 'philosophy' ),
					),
				)
			);

			// Core's player, instead of the copy of MediaElement this theme used to
			// bundle: same library, kept current by WordPress, loaded only when a
			// page actually has audio or video on it.
			if ( philosophy_needs_media_player() ) {
				wp_enqueue_style( 'wp-mediaelement' );
				wp_enqueue_script( 'wp-mediaelement' );
			}

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Swaps the no-js class on <html> for js.
		 *
		 * The preloader covers the whole viewport, so a visitor whose JavaScript
		 * never runs must be able to see the page anyway; assets/css/main.css
		 * hides the overlay under .no-js.
		 */
		public function no_js_class() {
			echo '<script>document.documentElement.className=document.documentElement.className.replace(/\bno-js\b/,"js");</script>' . "\n";
		}

		/**
		 * Loads the front-end typography into the block editor.
		 */
		public function enqueue_block_editor_assets() {
			wp_enqueue_style(
				'philosophy-editor-fonts',
				PHILOSOPHY_DIR_CSS_URI . 'fonts.css',
				array(),
				$this->philosophy_version
			);
		}

		/**
		 * Instantiates the Customizer.
		 */
		private function customizer_init() {
			new philosophy_theme_customizer();
		}
	}
}
