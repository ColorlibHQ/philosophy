<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit( 'Direct script access denied.' );
} 
/**
 * @Packge     : Philosophy
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
 
// enqueue css
function philosophy_common_custom_css(){
    
    wp_enqueue_style( 'philosophy-common', get_template_directory_uri().'/assets/css/common.css' );
		
		$headerBg          		  = philosophy_opt( 'philosophy_header_bg_color' );
		$menuColor          	  = philosophy_opt( 'philosophy_header_menu_color' );
		$menuHoverColor           = philosophy_opt( 'philosophy_header_menu_hover_color' );

		$dropMenuBgColor          = philosophy_opt( 'philosophy_header_menu_dropbg_color' );
		$dropMenuColor            = philosophy_opt( 'philosophy_header_drop_menu_color' );
		$dropMenuHovColor         = philosophy_opt( 'philosophy_header_drop_menu_hover_color' );

		$geadertopColor           = philosophy_opt( 'philosophy_header_top_color' );

		$footerwbgColor     	  = philosophy_opt('philosophy_footer_widget_bdcolor');
		$footerwTextColor   	  = philosophy_opt('philosophy_footer_widget_textcolor');
		$footerwanchorcolor 	  = philosophy_opt('philosophy_footer_widget_anchorcolor');
		$footerwanchorhovcolor    = philosophy_opt('philosophy_footer_widget_anchorhovcolor');
		$widgettitlecolor  		  = philosophy_opt('philosophy_footer_widget_titlecolor');

		$preloaderbgcolor  	      = philosophy_opt('philosophy_preloader_bg_color');
		$preloaderbordercolor  	  = philosophy_opt('philosophy_preloader_color');

		$bttopbgcolor  	      = philosophy_opt('philosophy_backtotop_btn_bg_color');
		$bttophovbgcolor  	  = philosophy_opt('philosophy_backtotop_btn_hover_bg_color');

		$fofbg  	  		  = philosophy_opt('philosophy_fof_bg_color');
		$foftonecolor  	  	  = philosophy_opt('philosophy_fof_textone_color');
		$fofttwocolor  	  	  = philosophy_opt('philosophy_fof_texttwo_color');


        $customcss ="
			.s-pageheader:before {
			   background-color: {$headerBg};
			}
			.header__nav li.has-children > a::after {
			   border-color: {$menuColor};
			}
			.header__nav li a {
			   color: {$menuColor};
			}
			.header__nav li:hover > a, 
			.header__nav li:focus > a {
			   color: {$menuHoverColor};
			}
			.header__nav li ul {
			   background: {$dropMenuBgColor};
			}
			.header__nav li ul li a {
			   color: {$dropMenuColor};
			}
			.header__nav li ul li a:hover, 
			.header__nav li ul li a:focus {
			   color: {$dropMenuHovColor};
			}
			.header__search-trigger::before,
			.header__social a {
			    color: {$geadertopColor};
			}
			#preloader {
				background-color: {$preloaderbgcolor}
    		}
			.line-scale > div {
			   background-color: {$preloaderbordercolor};
			}
			.go-top a, 
			.go-top a:visited {
			   background-color: {$bttopbgcolor};
			}
			.go-top a:hover, 
			.go-top a:focus {
			   background-color: {$bttophovbgcolor};
			}
			.s-footer {
				background-color: {$footerwbgColor};
			}
			.s-footer,
			abbr {
				color: {$footerwTextColor}
			}
			.s-footer__main h4 {
				color: {$widgettitlecolor}
			}
			footer a {
			   color: {$footerwanchorcolor};
			}
			footer a:hover {
			   color: {$footerwanchorhovcolor};
			}
			#f0f {
			   background-color: {$fofbg};
			}
			.f0f-content .h1 {
			   color: {$foftonecolor};
			}
			.f0f-content p {
			   color: {$fofttwocolor};
			}

        ";
       
    wp_add_inline_style( 'philosophy-common', $customcss );
    
}
add_action( 'wp_enqueue_scripts', 'philosophy_common_custom_css', 50 );