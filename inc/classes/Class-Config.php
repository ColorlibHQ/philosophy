<?php 
/**
 * @Packge 	   : Philosophy
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	// Final Class
	final class Philosophy{


		// Theme Version
		private $philosophy_version = '1.0';

		// Minimum WordPress Version required
		private $min_wp = '4.0';

		// Minimum PHP version required 
		private $min_php = '5.6.25';

		function __construct(){
			// Theme Support
			add_action( 'after_setup_theme', array( $this, 'support' ) );

			// 
			$this->init();
			// Instantiate Philosophy Dashboard
			$Philosophy_Dashboard = Philosophy_Dashboard::get_instance();
		}

		// Theme init
		public function init(){
			
			$this->setup();
		}

		// Theme setup
		private function setup(){
			
			// Create enqueue class instance
			$enqueu = new philosophy_Enqueue();
			$enqueu->scripts = $this->enqueue() ;
			$enqueu->philosophy_scripts_enqueue_init() ;

		}
		// Theme Support
		public function support(){
			// content width
	        $GLOBALS['content_width'] = apply_filters( 'philosophy_content_width', 751 );

	        
	        // text domain for translation.
	        load_theme_textdomain( 'philosophy', PHILOSOPHY_DIR_PATH . '/languages' );
	        
	        // support title tage
	        add_theme_support( 'title-tag' );
	        
	        // support logo
	        add_theme_support( 'custom-logo' );
	        
	        //  support post format
	        add_theme_support( 'post-formats', array( 'video','audio' ) );
	        
	        // support post-thumbnails
	        add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
			
			// Latest post thumbnail Widget thumbnail size
			add_image_size( 'philosophy_widget_post_thumb', 70, 70, true );
	        	        
	        // support automatic feed links
	        add_theme_support( 'automatic-feed-links' );
	        
	        // support html5
	        add_theme_support( 'html5' );
			
			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
						    
	        // register nav menu
	        register_nav_menus( array(
	            'primary-menu'   => esc_html__( 'Primary Menu', 'philosophy' ),
	            'social-menu'    => esc_html__( 'Social Menu', 'philosophy' ),
	        ) );

	        // editor style
	        add_editor_style('assets/css/editor-style.css');

		} // end support method

		// enqueue theme style and script
		private function enqueue(){

			$cssPath = PHILOSOPHY_DIR_CSS_URI;
			$jsPath  = PHILOSOPHY_DIR_JS_URI;
			$apiKey	 = philosophy_opt('philosophy_gmap_api_key');
			

			$scripts = array(
				'style' => array(
					array(
						'handler'		=> 'google-font',
						'file' 			=> $this->google_font(),
					),
					array(
						'handler'		=> 'base',
						'file' 			=> $cssPath.'base.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'font-awesome',
						'file' 			=> $cssPath.'font-awesome.min.css',
						'dependency' 	=> array(),
						'version' 		=> '4.7.0',
					),
					array(
						'handler'		=> 'fonts',
						'file' 			=> $cssPath.'fonts.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'vendor',
						'file' 			=> $cssPath.'vendor.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'main',
						'file' 			=> $cssPath.'main.css',
						'dependency' 	=> array(),
						'version' 		=> $this->philosophy_version,
					),
					array(
						'handler'		=> 'philosophy-style',
						'file' 			=> get_stylesheet_uri(),
					),
				),
				
				'scripts' => array(
					array(
						'handler'		=> 'maps-googleapis',
						'file' 			=> '//maps.googleapis.com/maps/api/js?key='.$apiKey,
					),
					array(
						'handler'		=> 'modernizr',
						'file' 			=> $jsPath.'modernizr.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> '3.3.1',
						'in_footer' 	=> true
					),
					array(
						'handler'		=> 'pace',
						'file' 			=> $jsPath.'pace.min.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> '1.0.0',
						'in_footer' 	=> true
					),
					array(
						'handler'		=> 'plugins',
						'file' 			=> $jsPath.'plugins.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> '1.0',
						'in_footer' 	=> true
					),
					array(
						'handler'		=> 'philosophy-main',
						'file' 			=> $jsPath.'main.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> $this->philosophy_version,
						'in_footer' 	=> true
					),

				)
			);

			return $scripts;

		} // end enqueu method 



		// Google Font  
		private function google_font(){

			$fontUrl = '';
			
			if ( 'off' !== _x( 'on', 'Google font: on or off', 'philosophy' ) ) {
			
				$font_families = array(
					'Roboto:400,500,700,900'
				);

				$familyArgs = array(
					'family' => htmlentities( implode( '|', $font_families ) ),
					'subset' => urlencode( 'latin, latin-text' ),
				);

				$fontUrl = add_query_arg( $familyArgs, '//fonts.googleapis.com/css' );
			}
			
			return esc_url_raw( $fontUrl );

		} //End google_font method

	} // End Philosophy Class

?>