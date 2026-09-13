<?php
/**
 * Theme helper functions.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! function_exists( 'philosophy_defaults' ) ) {
	/**
	 * Default value for every theme_mod the Customizer registers.
	 *
	 * philosophy_opt() consults this so a setting the user has never touched
	 * behaves the way its Customizer control says it does. Before 1.2.0 the
	 * fallback was a hard-coded 0, so the featured area, the header search, the
	 * social icons and the footer widgets were all hidden on a fresh install even
	 * though their toggles read "on".
	 *
	 * @return array
	 */
	function philosophy_defaults() {
		return apply_filters(
			'philosophy_default_settings',
			array(
				'philosophy_preloader_toggle'             => true,
				'philosophy_preloader_bg_color'           => '#050505',
				'philosophy_preloader_color'              => '#ffffff',
				'philosophy_backtotop_btn'                => true,
				'philosophy_backtotop_btn_bg_color'       => '#000000',
				'philosophy_backtotop_btn_hover_bg_color' => '#0054a5',
				'philosophy_gmap_api_key'                 => '',
				'philosophy_hsearchform_toggle'           => true,
				'philosophy_headersocial_toggle'          => true,
				'philosophy_header_bg_color'              => '#151515',
				'philosophy_header_top_color'             => '#ffffff',
				'philosophy_header_menu_color'            => '#ffffff',
				'philosophy_header_menu_hover_color'      => '#b5b3b3',
				'philosophy_header_menu_dropbg_color'     => '#050505',
				'philosophy_header_drop_menu_color'       => '#b5b3b3',
				'philosophy_header_drop_menu_hover_color' => '#ffffff',
				'philosophy_hfblog_toggle'                => true,
				'philosophy_featured_cat'                 => 'uncategorized',
				'philosophy_excerpt_length'               => 30,
				'philosophy_blog_layout'                  => '1',
				'philosophy_archive_header_content'       => '',
				'philosophy_search_header_content'        => '',
				'philosophy_about_top_title'              => '',
				'philosophy_about_infoblock'              => array(),
				'philosophy_contact_top_title'            => '',
				'philosophy_contact_latitude'             => '37.422424',
				'philosophy_contact_longitude'            => '-122.085661',
				'philosophy_contact_infoblock'            => array(),
				'philosophy_contact_formtitle'            => '',
				'philosophy_contact_formshortcode'        => 'cs',
				'philosophy_contact_custom_formshortcode' => '',
				'philosophy_fof_titleone'                 => '',
				'philosophy_fof_titletwo'                 => '',
				'philosophy_fof_textone_color'            => '#000000',
				'philosophy_fof_texttwo_color'            => '#656565',
				'philosophy_fof_bg_color'                 => '#ffffff',
				'philosophy_footer_widget_toggle'         => true,
				'philosophy_footer_copyright_text'        => '',
				'philosophy_footer_widget_bdcolor'        => '#19191b',
				'philosophy_footer_widget_textcolor'      => '#ffffff',
				'philosophy_footer_widget_titlecolor'     => '#ffffff',
				'philosophy_footer_widget_anchorcolor'    => '#888888',
				'philosophy_footer_widget_anchorhovcolor' => '#888888',
			)
		);
	}
}

if ( ! function_exists( 'philosophy_opt' ) ) {
	/**
	 * Reads a theme_mod, falling back to the setting's registered default.
	 *
	 * @param string $id      theme_mod key.
	 * @param mixed  $default Explicit fallback. When omitted the registered
	 *                        default for $id is used.
	 *
	 * @return mixed
	 */
	function philosophy_opt( $id = null, $default = null ) {
		if ( ! $id ) {
			return '';
		}

		if ( null === $default ) {
			$defaults = philosophy_defaults();
			$default  = isset( $defaults[ $id ] ) ? $defaults[ $id ] : '';
		}

		return get_theme_mod( $id, $default );
	}
}

if ( ! function_exists( 'philosophy_asset_suffix' ) ) {
	/**
	 * Returns ".min" unless the site is debugging scripts.
	 *
	 * @return string
	 */
	function philosophy_asset_suffix() {
		return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	}
}

if ( ! function_exists( 'philosophy_needs_media_player' ) ) {
	/**
	 * Whether the current view is likely to render an audio or video player.
	 *
	 * Keeps MediaElement off the ~95% of pages that have no media on them.
	 *
	 * @return bool
	 */
	function philosophy_needs_media_player() {
		if ( is_admin() ) {
			return false;
		}

		$needed = false;

		if ( have_posts() ) {
			global $wp_query;

			foreach ( (array) $wp_query->posts as $post ) {
				if ( ! $post instanceof WP_Post ) {
					continue;
				}

				if ( has_post_format( array( 'audio', 'video' ), $post ) ) {
					$needed = true;
					break;
				}

				if ( preg_match( '/\[(audio|video|playlist)[\s\]]/', (string) $post->post_content ) ) {
					$needed = true;
					break;
				}

				if ( preg_match( '/<(audio|video)[\s>]/i', (string) $post->post_content ) ) {
					$needed = true;
					break;
				}
			}
		}

		return (bool) apply_filters( 'philosophy_needs_media_player', $needed );
	}
}

if ( ! function_exists( 'philosophy_default_copyright' ) ) {
	/**
	 * The credit line shown when the Customizer field is left empty.
	 *
	 * @return string
	 */
	function philosophy_default_copyright() {
		return sprintf(
			/* translators: 1: current year, 2: heart icon, 3: opening anchor tag, 4: closing anchor tag. */
			__( 'Copyright &copy; %1$s All rights reserved. | This template is made with %2$s by %3$sColorlib%4$s', 'philosophy' ),
			esc_html( wp_date( 'Y' ) ),
			'<i class="fa-regular fa-heart" aria-hidden="true"></i>',
			'<a href="https://colorlib.com" rel="nofollow noopener" target="_blank">',
			'</a>'
		);
	}
}

if ( ! function_exists( 'philosophy_meta' ) ) {
	/**
	 * Reads a prefixed post meta value.
	 *
	 * @param string $id Meta key without the _philosophy_ prefix.
	 *
	 * @return mixed
	 */
	function philosophy_meta( $id = '' ) {
		if ( '' === $id ) {
			return '';
		}

		return get_post_meta( get_the_ID(), '_philosophy_' . $id, true );
	}
}

if ( ! function_exists( 'philosophy_blog_date_permalink' ) ) {
	/**
	 * Permalink for the day archive of the current post.
	 *
	 * @return string
	 */
	function philosophy_blog_date_permalink() {
		return get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) );
	}
}

if ( ! function_exists( 'philosophy_excerpt_length' ) ) {
	/**
	 * Returns the post excerpt trimmed to a word count.
	 *
	 * @param int $limit Word limit. Falsy values fall back to 30.
	 *
	 * @return string Paragraph markup.
	 */
	function philosophy_excerpt_length( $limit = 30 ) {
		$limit = absint( $limit );

		if ( ! $limit ) {
			$limit = 30;
		}

		$excerpt = wp_trim_words( get_the_excerpt(), $limit, '&hellip;' );

		return '<p>' . wp_kses_post( $excerpt ) . '</p>';
	}
}

if ( ! function_exists( 'philosophy_posted_comments' ) ) {
	/**
	 * A link to the comments, labelled with the comment count.
	 *
	 * @return string
	 */
	function philosophy_posted_comments() {
		if ( ! comments_open() ) {
			return esc_html__( 'Comments are closed', 'philosophy' );
		}

		$number = (int) get_comments_number();

		if ( 0 === $number ) {
			$label = esc_html__( 'No Comments', 'philosophy' );
		} else {
			$label = sprintf(
				/* translators: %s: number of comments. */
				esc_html( _n( '%s Comment', '%s Comments', $number, 'philosophy' ) ),
				esc_html( number_format_i18n( $number ) )
			);
		}

		return '<a href="' . esc_url( get_comments_link() ) . '">' . $label . '</a>';
	}
}

if ( ! function_exists( 'philosophy_iframe_match' ) ) {
	/**
	 * Whether the post's embedded audio is an iframe embed.
	 *
	 * @return int
	 */
	function philosophy_iframe_match() {
		$audio_content = philosophy_embedded_media( array( 'audio', 'iframe' ) );

		return preg_match( '/\iframe\b/i', $audio_content );
	}
}

if ( ! function_exists( 'philosophy_embedded_media' ) ) {
	/**
	 * Returns the first embedded media element found in the post content.
	 *
	 * @param array $type Media types to look for.
	 *
	 * @return string
	 */
	function philosophy_embedded_media( $type = array() ) {
		$content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
		$embed   = get_media_embedded_in_content( $content, $type );

		if ( empty( $embed[0] ) ) {
			return '';
		}

		if ( in_array( 'audio', (array) $type, true ) ) {
			return str_replace( '?visual=true', '?visual=false', $embed[0] );
		}

		return $embed[0];
	}
}

if ( ! function_exists( 'philosophy_link_pages' ) ) {
	/**
	 * Renders the page links for a multi-page post.
	 */
	function philosophy_link_pages() {
		wp_link_pages(
			array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'philosophy' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'philosophy' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			)
		);
	}
}

if ( ! function_exists( 'philosophy_theme_logo' ) ) {
	/**
	 * Returns the custom logo, or the site title and tagline.
	 *
	 * @param string $class Class applied to the link.
	 *
	 * @return string
	 */
	function philosophy_theme_logo( $class = '' ) {
		$home = home_url( '/' );

		if ( has_custom_logo() ) {
			$logo_id = get_theme_mod( 'custom_logo' );
			$image   = wp_get_attachment_image(
				$logo_id,
				'full',
				false,
				array(
					'class' => 'philosophy-logo-image',
					'alt'   => get_bloginfo( 'name', 'display' ),
				)
			);

			if ( $image ) {
				return '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $home ) . '" rel="home">' . $image . '</a>';
			}
		}

		$tag  = ( is_front_page() && is_home() ) ? 'h1' : 'h2';
		$html = '<' . $tag . '><a class="' . esc_attr( $class ) . '" href="' . esc_url( $home ) . '" rel="home">' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</a></' . $tag . '>';

		$description = get_bloginfo( 'description', 'display' );

		if ( $description ) {
			$html .= '<span>' . esc_html( $description ) . '</span>';
		}

		return $html;
	}
}

if ( ! function_exists( 'philosophy_pull_right' ) ) {
	/**
	 * Legacy helper kept for child themes.
	 *
	 * @param mixed $id        Value to test.
	 * @param mixed $condation Value to test against.
	 *
	 * @return string|bool
	 */
	function philosophy_pull_right( $id, $condation ) {
		return ( $id === $condation ) ? ' order-last' : true;
	}
}

if ( ! function_exists( 'philosophy_image_alt' ) ) {
	/**
	 * Best-effort alt text for an image URL.
	 *
	 * @param string $url Image URL.
	 *
	 * @return string
	 */
	function philosophy_image_alt( $url = '' ) {
		if ( '' === $url ) {
			return '';
		}

		$attachment_id = attachment_url_to_postid( $url );

		if ( $attachment_id ) {
			$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

			if ( $alt ) {
				return $alt;
			}
		}

		$filename = pathinfo( wp_parse_url( $url, PHP_URL_PATH ) ? wp_parse_url( $url, PHP_URL_PATH ) : $url );

		return isset( $filename['filename'] ) ? str_replace( '-', ' ', $filename['filename'] ) : '';
	}
}

if ( ! function_exists( 'philosophy_get_textareahtml_output' ) ) {
	/**
	 * Runs a stored rich-text value through the same filters post content gets.
	 *
	 * @param string $content Stored value.
	 *
	 * @return string
	 */
	function philosophy_get_textareahtml_output( $content ) {
		global $wp_embed;

		if ( $wp_embed instanceof WP_Embed ) {
			$content = $wp_embed->autoembed( $content );
			$content = $wp_embed->run_shortcode( $content );
		}

		return do_shortcode( wpautop( wp_kses_post( $content ) ) );
	}
}

if ( ! function_exists( 'philosophy_inline_bg_img' ) ) {
	/**
	 * Returns a background-image style attribute for a URL.
	 *
	 * @param string $bg_url Image URL.
	 *
	 * @return string
	 */
	function philosophy_inline_bg_img( $bg_url ) {
		if ( ! $bg_url ) {
			return '';
		}

		return 'style="background-image:url(' . esc_url( $bg_url ) . ')"';
	}
}

if ( ! function_exists( 'philosophy_featured_post_cat' ) ) {
	/**
	 * Category links for the current post, excluding the "featured" category.
	 *
	 * @return string
	 */
	function philosophy_featured_post_cat() {
		$categories = get_the_category();

		if ( ! is_array( $categories ) || ! $categories ) {
			return '';
		}

		$links = array();

		foreach ( $categories as $category ) {
			if ( 'featured' === $category->slug ) {
				continue;
			}

			$links[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
		}

		return implode( ', ', $links );
	}
}

if ( ! function_exists( 'philosophy_sidebar_opt' ) ) {
	/**
	 * The blog layout column count as "1", "2" or "3".
	 *
	 * @return string
	 */
	function philosophy_sidebar_opt() {
		$layout = philosophy_normalize_layout( philosophy_opt( 'philosophy_blog_layout' ) );

		return in_array( $layout, array( '1', '2', '3' ), true ) ? $layout : '1';
	}
}

if ( ! function_exists( 'philosophy_featured_query_args' ) ) {
	/**
	 * Query arguments for the featured area at the top of the blog.
	 *
	 * The category is only applied when it actually has published posts. The
	 * setting defaults to "uncategorized", so on any site that files its posts
	 * anywhere else — which is most of them — the featured area used to render
	 * as an empty black band the height of three panels, with no indication of
	 * why. Falling back to the most recent posts means the area always shows
	 * something, and a site that has chosen a category still gets it.
	 *
	 * @param string $term   Category slug from the Customizer.
	 * @param int    $number How many posts to return.
	 * @param int    $offset How many to skip.
	 *
	 * @return array
	 */
	function philosophy_featured_query_args( $term, $number, $offset ) {
		$args = array(
			'post_type'           => 'post',
			'posts_per_page'      => (int) $number,
			'offset'              => (int) $offset,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);

		$term = is_string( $term ) ? trim( $term ) : '';

		if ( '' !== $term && 'na' !== $term ) {
			$category = get_category_by_slug( $term );

			if ( $category && $category->count > 0 ) {
				$args['cat'] = $category->term_id;
			}
		}

		return apply_filters( 'philosophy_featured_query_args', $args, $term );
	}
}
