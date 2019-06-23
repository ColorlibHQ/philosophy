<?php 
/**
 * @Packge     : Philosophy
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
    // Block direct access
    if( !defined( 'ABSPATH' ) ){
        exit( 'Direct script access denied.' );
    }

        /**
         * Footer Area
         *
         * @Footer
         * @Back To Top Button
         *
         * @Hook philosophy_footer
         *
         * @Hooked  philosophy_footer_area 
         *
         */

		do_action( 'philosophy_footer' );

	wp_footer(); 
 ?>
</body>
</html>