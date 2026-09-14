<?php
/**
 * Inline CSS generated from the Customizer colour settings.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! function_exists( 'philosophy_common_custom_css' ) ) {
	/**
	 * Builds the colour overrides and attaches them to the main stylesheet.
	 *
	 * Every value is escaped on the way out. Before 1.2.0 the settings were
	 * interpolated raw into a style block, so anything an administrator pasted
	 * into a colour field was echoed into every page verbatim.
	 *
	 * Up to 1.1.x this also loaded assets/css/common.css, a static file holding
	 * the same declarations with the default values in them — one extra request
	 * for rules the inline block overrode on the very next line.
	 */
	function philosophy_common_custom_css() {
		$colors = array();

		foreach ( array(
			'header_bg'            => 'philosophy_header_bg_color',
			'menu'                 => 'philosophy_header_menu_color',
			'menu_hover'           => 'philosophy_header_menu_hover_color',
			'drop_bg'              => 'philosophy_header_menu_dropbg_color',
			'drop'                 => 'philosophy_header_drop_menu_color',
			'drop_hover'           => 'philosophy_header_drop_menu_hover_color',
			'header_top'           => 'philosophy_header_top_color',
			'footer_bg'            => 'philosophy_footer_widget_bdcolor',
			'footer_text'          => 'philosophy_footer_widget_textcolor',
			'footer_link'          => 'philosophy_footer_widget_anchorcolor',
			'footer_link_hover'    => 'philosophy_footer_widget_anchorhovcolor',
			'footer_widget_title'  => 'philosophy_footer_widget_titlecolor',
			'preloader_bg'         => 'philosophy_preloader_bg_color',
			'preloader'            => 'philosophy_preloader_color',
			'backtotop_bg'         => 'philosophy_backtotop_btn_bg_color',
			'backtotop_hover_bg'   => 'philosophy_backtotop_btn_hover_bg_color',
			'fof_bg'               => 'philosophy_fof_bg_color',
			'fof_title'            => 'philosophy_fof_textone_color',
			'fof_text'             => 'philosophy_fof_texttwo_color',
		) as $key => $setting ) {
			$colors[ $key ] = philosophy_sanitize_color( philosophy_opt( $setting ) );
		}

		$rules = array(
			'.s-pageheader:before'                                         => array( 'background-color' => $colors['header_bg'] ),
			'.header__nav li.has-children > a::after'                      => array( 'border-color' => $colors['menu'] ),
			'.header__nav li a'                                            => array( 'color' => $colors['menu'] ),
			'.header__nav li:hover > a, .header__nav li:focus-within > a'  => array( 'color' => $colors['menu_hover'] ),
			'.header__nav li.current-menu-item > a, .header__nav li.current_page_item > a, .header__nav li.current-menu-ancestor > a, .header__nav li.current-menu-parent > a' => array( 'color' => $colors['menu_hover'] ),
			'.header__nav li ul'                                           => array( 'background' => $colors['drop_bg'] ),
			'.header__nav li ul li a'                                      => array( 'color' => $colors['drop'] ),
			'.header__nav li ul li a:hover, .header__nav li ul li a:focus'  => array( 'color' => $colors['drop_hover'] ),
			'.header__search-trigger, .header__search-trigger::before, .header__social a' => array( 'color' => $colors['header_top'] ),
			// The site title is a link, so without this it takes the accent
			// colour and renders at about 1.9:1 on the dark masthead.
			'.header__logo a, .header__logo h1 a, .header__logo h2 a'      => array( 'color' => $colors['header_top'] ),
			'.header__logo span'                                           => array( 'color' => $colors['menu_hover'] ),
			'#preloader'                                                   => array( 'background-color' => $colors['preloader_bg'] ),
			'.line-scale > div'                                            => array( 'background-color' => $colors['preloader'] ),
			'.go-top a, .go-top a:visited'                                 => array( 'background-color' => $colors['backtotop_bg'] ),
			'.go-top a:hover, .go-top a:focus'                             => array( 'background-color' => $colors['backtotop_hover_bg'] ),
			'.s-footer'                                                    => array( 'background-color' => $colors['footer_bg'] ),
			'.s-footer, .s-footer abbr'                                    => array( 'color' => $colors['footer_text'] ),
			'.s-footer__main h3, .s-footer__main h4'                       => array( 'color' => $colors['footer_widget_title'] ),
			'.s-footer a'                                                  => array( 'color' => $colors['footer_link'] ),
			'.s-footer a:hover, .s-footer a:focus'                         => array( 'color' => $colors['footer_link_hover'] ),
			'#f0f'                                                         => array( 'background-color' => $colors['fof_bg'] ),
			'.f0f-content .h1'                                             => array( 'color' => $colors['fof_title'] ),
			'.f0f-content p'                                               => array( 'color' => $colors['fof_text'] ),
		);

		$css = '';

		foreach ( $rules as $selector => $declarations ) {
			$body = '';

			foreach ( $declarations as $property => $value ) {
				if ( '' === $value ) {
					continue;
				}

				$body .= $property . ':' . $value . ';';
			}

			if ( '' !== $body ) {
				$css .= $selector . '{' . $body . '}';
			}
		}

		$css = apply_filters( 'philosophy_inline_css', $css );

		if ( '' !== $css ) {
			wp_add_inline_style( 'philosophy-main', wp_strip_all_tags( $css ) );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'philosophy_common_custom_css', 50 );
