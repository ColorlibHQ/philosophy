<?php
/**
 * Navigation walkers.
 *
 * philosophy_bootstrap_navwalker started life as wp-bootstrap-navwalker 2.0.4 by
 * Edward McIntyre (GPL-2.0+). Philosophy does not use Bootstrap, so 1.2.0 dropped
 * the parts that only existed to satisfy Bootstrap 3 — the dropdown data
 * attributes, the caret and the href="#" that used to swallow clicks on parent
 * menu items.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'philosophy_bootstrap_navwalker' ) ) {

	/**
	 * Class philosophy_bootstrap_navwalker
	 */
	class philosophy_bootstrap_navwalker extends Walker_Nav_Menu {

		/**
		 * Opens a sub-menu.
		 *
		 * @param string   $output Menu markup, by reference.
		 * @param int      $depth  Current depth.
		 * @param stdClass $args   Menu arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "\n" . $indent . '<ul class="sub-menu dropdown-menu">' . "\n";
		}

		/**
		 * Renders a menu item.
		 *
		 * @param string   $output Menu markup, by reference.
		 * @param WP_Post  $item   Menu item.
		 * @param int      $depth  Current depth.
		 * @param stdClass $args   Menu arguments.
		 * @param int      $id     Menu item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$indent = $depth ? str_repeat( "\t", $depth ) : '';

			// attr_title is null for most items; casting keeps PHP 8.1 quiet.
			$attr_title    = (string) ( isset( $item->attr_title ) ? $item->attr_title : '' );
			$has_children  = ! empty( $args->has_children );

			if ( 1 === $depth && ( 0 === strcasecmp( $attr_title, 'divider' ) || 0 === strcasecmp( (string) $item->title, 'divider' ) ) ) {
				$output .= $indent . '<li class="divider" aria-hidden="true">';

				return;
			}

			if ( 1 === $depth && 0 === strcasecmp( $attr_title, 'dropdown-header' ) ) {
				$output .= $indent . '<li class="dropdown-header">' . esc_html( $item->title );

				return;
			}

			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$classes[] = 'nav-item';
			$classes[] = 'depth-' . $depth;

			if ( $has_children ) {
				$classes[] = 'dropdown';
				$classes[] = 'has-children';
			}

			if ( in_array( 'current-menu-item', $classes, true ) ) {
				$classes[] = 'active';
			}

			$class_names = implode( ' ', array_filter( apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) ) );
			$item_id     = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );

			$output .= $indent . '<li id="' . esc_attr( $item_id ) . '" class="' . esc_attr( $class_names ) . '">';

			$atts           = array();
			$atts['class']  = ( $depth > 0 ) ? 'dropdown-item' : 'nav-link';
			$atts['title']  = $attr_title;
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';

			// A parent item keeps its own link. On the mobile overlay the theme's
			// script intercepts the click to expand the sub-menu instead.
			if ( $has_children && 0 === $depth ) {
				$atts['aria-haspopup'] = 'true';
				$atts['aria-expanded'] = 'false';
			}

			if ( in_array( 'current-menu-item', $classes, true ) ) {
				$atts['aria-current'] = 'page';
			}

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';

			foreach ( $atts as $attr => $value ) {
				if ( '' === $value || false === $value ) {
					continue;
				}

				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . esc_attr( $attr ) . '="' . $value . '"';
			}

			$title = apply_filters( 'the_title', $item->title, $item->ID );

			$item_output  = isset( $args->before ) ? $args->before : '';
			$item_output .= '<a' . $attributes . '>';
			$item_output .= isset( $args->link_before ) ? $args->link_before : '';
			$item_output .= $title;
			$item_output .= isset( $args->link_after ) ? $args->link_after : '';
			$item_output .= '</a>';
			$item_output .= isset( $args->after ) ? $args->after : '';

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		/**
		 * Flags whether an element has children before rendering it.
		 *
		 * @param object $element           Menu item.
		 * @param array  $children_elements Remaining items.
		 * @param int    $max_depth         Maximum depth.
		 * @param int    $depth             Current depth.
		 * @param array  $args              Menu arguments.
		 * @param string $output            Menu markup, by reference.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element ) {
				return;
			}

			$id_field = $this->db_fields['id'];

			if ( isset( $args[0] ) && is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			}

			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		/**
		 * Fallback when no menu is assigned to the location.
		 *
		 * Renders the site's pages, so a brand-new site still has navigation.
		 * Before 1.2.0 this printed an "Add a menu" link for administrators and
		 * nothing at all for everybody else.
		 *
		 * @param array $args Menu arguments.
		 */
		public static function fallback( $args = array() ) {
			$menu_class = isset( $args['menu_class'] ) ? $args['menu_class'] : '';

			wp_page_menu(
				array(
					'menu_class'  => $menu_class,
					'container'   => 'ul',
					'echo'        => true,
					'show_home'   => true,
					'link_before' => '',
					'link_after'  => '',
				)
			);
		}
	}
}

if ( ! class_exists( 'philosophy_social_navwalker' ) ) {

	/**
	 * Class philosophy_social_navwalker
	 *
	 * Renders a menu of icon-only links. The icon is worked out from the address
	 * the item points at, so no CSS class is needed; a Font Awesome class set on
	 * the menu item still wins.
	 */
	class philosophy_social_navwalker extends Walker_Nav_Menu {

		/**
		 * Database fields.
		 *
		 * @var array
		 */
		public $db_fields = array(
			'parent' => 'menu_item_parent',
			'id'     => 'db_id',
		);

		/**
		 * Host fragment (or scheme) to Font Awesome brand icon and label.
		 *
		 * @return array
		 */
		public static function networks() {
			return apply_filters(
				'philosophy_social_networks',
				array(
					'x.com'           => array( 'fa-brands fa-x-twitter', 'X' ),
					'twitter.com'     => array( 'fa-brands fa-x-twitter', 'X' ),
					'bsky.app'        => array( 'fa-brands fa-bluesky', 'Bluesky' ),
					'threads.net'     => array( 'fa-brands fa-threads', 'Threads' ),
					'threads.com'     => array( 'fa-brands fa-threads', 'Threads' ),
					'mastodon'        => array( 'fa-brands fa-mastodon', 'Mastodon' ),
					'facebook.com'    => array( 'fa-brands fa-facebook-f', 'Facebook' ),
					'instagram.com'   => array( 'fa-brands fa-instagram', 'Instagram' ),
					'tiktok.com'      => array( 'fa-brands fa-tiktok', 'TikTok' ),
					'youtube.com'     => array( 'fa-brands fa-youtube', 'YouTube' ),
					'youtu.be'        => array( 'fa-brands fa-youtube', 'YouTube' ),
					'linkedin.com'    => array( 'fa-brands fa-linkedin-in', 'LinkedIn' ),
					'pinterest.'      => array( 'fa-brands fa-pinterest-p', 'Pinterest' ),
					'github.com'      => array( 'fa-brands fa-github', 'GitHub' ),
					'gitlab.com'      => array( 'fa-brands fa-gitlab', 'GitLab' ),
					'codepen.io'      => array( 'fa-brands fa-codepen', 'CodePen' ),
					'dribbble.com'    => array( 'fa-brands fa-dribbble', 'Dribbble' ),
					'behance.net'     => array( 'fa-brands fa-behance', 'Behance' ),
					'medium.com'      => array( 'fa-brands fa-medium', 'Medium' ),
					'tumblr.com'      => array( 'fa-brands fa-tumblr', 'Tumblr' ),
					'reddit.com'      => array( 'fa-brands fa-reddit-alien', 'Reddit' ),
					'twitch.tv'       => array( 'fa-brands fa-twitch', 'Twitch' ),
					'discord'         => array( 'fa-brands fa-discord', 'Discord' ),
					'telegram'        => array( 'fa-brands fa-telegram', 'Telegram' ),
					't.me'            => array( 'fa-brands fa-telegram', 'Telegram' ),
					'whatsapp.com'    => array( 'fa-brands fa-whatsapp', 'WhatsApp' ),
					'wa.me'           => array( 'fa-brands fa-whatsapp', 'WhatsApp' ),
					'snapchat.com'    => array( 'fa-brands fa-snapchat', 'Snapchat' ),
					'vimeo.com'       => array( 'fa-brands fa-vimeo-v', 'Vimeo' ),
					'spotify.com'     => array( 'fa-brands fa-spotify', 'Spotify' ),
					'soundcloud.com'  => array( 'fa-brands fa-soundcloud', 'SoundCloud' ),
					'flickr.com'      => array( 'fa-brands fa-flickr', 'Flickr' ),
					'500px.com'       => array( 'fa-brands fa-500px', '500px' ),
					'unsplash.com'    => array( 'fa-brands fa-unsplash', 'Unsplash' ),
					'foursquare.com'  => array( 'fa-brands fa-foursquare', 'Foursquare' ),
					'skype.'          => array( 'fa-brands fa-skype', 'Skype' ),
					'skype:'          => array( 'fa-brands fa-skype', 'Skype' ),
					'/feed'           => array( 'fa-solid fa-rss', 'RSS' ),
					'mailto:'         => array( 'fa-solid fa-envelope', 'Email' ),
				)
			);
		}

		/**
		 * Renders one social link.
		 *
		 * @param string   $output Menu markup, by reference.
		 * @param WP_Post  $item   Menu item.
		 * @param int      $depth  Current depth.
		 * @param stdClass $args   Menu arguments.
		 * @param int      $id     Menu item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$url   = ! empty( $item->url ) ? $item->url : '';
			$label = trim( (string) $item->title );
			$icon  = '';

			// A class set on the menu item wins: that is how these menus were
			// configured before the icon could be worked out from the address.
			foreach ( (array) $item->classes as $class ) {
				if ( '' !== $class && 0 === strpos( $class, 'fa-' ) ) {
					$icon .= ' ' . $class;
				}
			}

			if ( '' === $icon ) {
				foreach ( self::networks() as $needle => $network ) {
					if ( false !== stripos( $url, $needle ) ) {
						$icon = ' ' . $network[0];

						if ( '' === $label ) {
							$label = $network[1];
						}

						break;
					}
				}
			}

			// Anything the theme does not recognise still needs an icon: without
			// one the link renders as an empty, zero-width box that nobody can
			// click and no screen reader can describe.
			if ( '' === $icon ) {
				$icon = ' fa-solid fa-link';
			}

			if ( '' === $label ) {
				$label = esc_html__( 'Social link', 'philosophy' );
			}

			$classes = 'topbar-social-item fa' . $icon;

			$atts = array(
				'href'   => $url,
				'class'  => $classes,
				'target' => ! empty( $item->target ) ? $item->target : '',
				'rel'    => ! empty( $item->xfn ) ? $item->xfn : '',
			);

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';

			foreach ( $atts as $attr => $value ) {
				if ( '' === $value || false === $value ) {
					continue;
				}

				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . esc_attr( $attr ) . '="' . $value . '"';
			}

			// The link has no visible text, so it needs a name a screen reader
			// can announce. Before 1.2.0 these were empty anchors.
			$output .= "\n" . '<li class="menu-item menu-item-' . absint( $item->ID ) . '"><a' . $attributes . '>'
				. '<span class="screen-reader-text">' . esc_html( $label ) . '</span>'
				. '</a>';
		}

		/**
		 * Closes a social link.
		 *
		 * @param string   $output Menu markup, by reference.
		 * @param WP_Post  $item   Menu item.
		 * @param int      $depth  Current depth.
		 * @param stdClass $args   Menu arguments.
		 */
		public function end_el( &$output, $item, $depth = 0, $args = null ) {
			$output .= "</li>\n";
		}
	}
}
