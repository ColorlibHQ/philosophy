<?php

/**
 * Philosophy Theme Autoloader
 *
 * @package Philosophy
 * @since   1.1.0
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Philosophy_Autoloader
 */
class Philosophy_Autoloader {
	/**
	 * Philosophy_Autoloader constructor.
	 */
	public function __construct() {

		spl_autoload_register( array( $this, 'load' ) );
	}

	/**
	 * This function loads the necessary files
	 *
	 * @param string $class CLASS NAME.
	 */
	public function load( $class = '' ) {

		/**
		 * All classes are prefixed with Philosophy_
		 */
		$parts = explode( '_', $class );
		$bind  = implode( '-', $parts );

		/**
		 * We provide working directories
		 */
		$directories = array(
			PHILOSOPHY_DIR_PATH_FRAM ,
			PHILOSOPHY_DIR_PATH_FRAM . 'epsilon-framework/',
			PHILOSOPHY_DIR_PATH_FRAM . 'epsilon-theme-dashboard/',
			PHILOSOPHY_DIR_PATH_FRAM . 'epsilon-theme-dashboard/inc/',
			PHILOSOPHY_DIR_PATH_FRAM . 'epsilon-theme-dashboard/inc/helpers/',
			PHILOSOPHY_DIR_PATH_FRAM . 'epsilon-theme-dashboard/inc/misc/',
			PHILOSOPHY_DIR_PATH_FRAM . 'epsilon-theme-dashboard/inc/misc/demo-generators/',
			PHILOSOPHY_DIR_PATH_FRAM . 'epsilon-theme-dashboard/inc/misc/epsilon-tracking/',
			PHILOSOPHY_DIR_PATH_FRAM . 'epsilon-theme-dashboard/inc/misc/epsilon-tracking/trackers/',
		);

		/**
		 * Loop through them, if we find the class .. we load it !
		 */
		foreach ( $directories as $directory ) {
			if ( file_exists( $directory . 'class-' . strtolower( $bind ) . '.php' ) ) {
				require_once $directory . 'class-' . strtolower( $bind ) . '.php';

				return;
			}
		}


	}
}

new Philosophy_Autoloader();
