<?php 
/**
 * @Packge 	   : Colorlib
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	// Front-End script and style Enqueue class 
	class philosophy_Enqueue{

		public $scripts = array();

		public function philosophy_scripts_enqueue_init(){
			add_action( 'wp_enqueue_scripts', array( $this, 'philosophy_frontend_enqueue_scripts', ) );
		}

		public function philosophy_frontend_enqueue_scripts( ){

			$scripts = $this->scripts;
			
			// variable type check
			if( is_array( $scripts ) && count( $scripts ) > 0 ){

				// Style Enqueue
				if( is_array( $scripts['style'] ) && count( $scripts['style'] ) > 0 ){

					foreach( $scripts['style'] as $style ){

						// Check handler
						$handler = '';
						if( !empty( $style['handler'] ) ){
							$handler = $style['handler'];
						}

						// Check file
						$file = '';
						if( !empty( $style['file'] ) ){
							$file = $style['file'];
						}
						// Check dependency
						$dependency = '';
						if( !empty( $style['dependency'] ) ){
							$dependency = $style['dependency'];
						}
						// Check version
						$version = '';
						if( !empty( $style['version'] ) ){
							$version = $style['version'];
						}

						// wp_enqueue_style
						wp_enqueue_style( esc_html( $handler ), esc_url( $file ), $dependency, esc_html( $version ) );

					}

				} // End Style Enqueue

				// Scripts Enqueue 
				if( is_array( $scripts['scripts'] ) && count( $scripts['scripts'] ) > 0 ){

					foreach( $scripts['scripts'] as $script ){

						// Check handler
						$handler = '';
						if( !empty( $script['handler'] ) ){
							$handler = $script['handler'];
						}

						// Check file
						$file = '';
						if( !empty( $script['file'] ) ){
							$file = $script['file'];
						}
						// Check dependency
						$dependency = array('jquery');
						if( !empty( $script['dependency'] ) ){
							$dependency = $script['dependency'];
						}
						// Check version
						$version = '';
						if( !empty( $script['version'] ) ){
							$version = $script['version'];
						}
						// Check in_footer
						$in_footer = '';
						if( !empty( $script['in_footer'] ) ){
							$in_footer = $script['in_footer'];
						}
												
						// wp enqueue script
						if( !empty( $script['register'] ) ){
							wp_register_script( esc_html( $handler ), esc_url( $file ), $dependency, esc_html( $version ), esc_html( $in_footer ) );
						}else{							
							wp_enqueue_script( esc_html( $handler ), esc_url( $file ), $dependency, esc_html( $version ), esc_html( $in_footer )  );
						}
						
						// Condational Script
						if( !empty( $script['condation'] ) ){
							wp_script_add_data( esc_html( $handler ), 'conditional', esc_html( $script['condation'] ) );
						}
	
					}
					
					// Comment replay
					if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
						wp_enqueue_script( 'comment-reply' );
					}

				} // End Scripts Enqueue


			} // End variable type check

		}

	}




?>