<?php
/**
 * One-time data migrations.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Option recording which migrations have run.
 */
const PHILOSOPHY_MIGRATIONS_OPTION = 'philosophy_migrations';

if ( ! function_exists( 'philosophy_migration_done' ) ) {
	/**
	 * Whether a migration has already run on this site.
	 *
	 * @param string $key Migration key.
	 *
	 * @return bool
	 */
	function philosophy_migration_done( $key ) {
		$done = get_option( PHILOSOPHY_MIGRATIONS_OPTION, array() );

		return is_array( $done ) && ! empty( $done[ $key ] );
	}
}

if ( ! function_exists( 'philosophy_migration_complete' ) ) {
	/**
	 * Records that a migration has run.
	 *
	 * @param string $key Migration key.
	 */
	function philosophy_migration_complete( $key ) {
		$done = get_option( PHILOSOPHY_MIGRATIONS_OPTION, array() );

		if ( ! is_array( $done ) ) {
			$done = array();
		}

		$done[ $key ] = gmdate( 'c' );

		update_option( PHILOSOPHY_MIGRATIONS_OPTION, $done, false );
	}
}

if ( ! function_exists( 'philosophy_info_blocks_to_content' ) ) {
	/**
	 * Moves the About and Contact info blocks into their pages.
	 *
	 * Up to 1.2.0 these were a Customizer repeater: a heading and a body of
	 * rich text, repeated, stored in a theme_mod and rendered underneath the
	 * page content. That is page content wearing a costume. It belongs in the
	 * editor, where it can be reordered, styled, translated and searched like
	 * anything else a page says.
	 *
	 * Each stored row is appended to its page as a heading block and a
	 * paragraph, inside a two-column group that reproduces the old layout. The
	 * theme_mod is left in place rather than deleted, so nothing is lost if a
	 * site rolls back, and the templates keep rendering it until the migration
	 * has run.
	 *
	 * @return array Keys 'about' and 'contact', each the page ID written to, or 0.
	 */
	function philosophy_info_blocks_to_content() {
		$written = array(
			'about'   => 0,
			'contact' => 0,
		);

		$sources = array(
			'about'   => array(
				'template' => 'page-about.php',
				'mod'      => 'philosophy_about_infoblock',
				'body'     => 'info_desc',
			),
			'contact' => array(
				'template' => 'page-contact.php',
				'mod'      => 'philosophy_contact_infoblock',
				'body'     => 'contact_info',
			),
		);

		foreach ( $sources as $key => $source ) {
			$rows = philosophy_decode_repeater( get_theme_mod( $source['mod'], array() ) );

			if ( ! $rows ) {
				continue;
			}

			$pages = get_posts(
				array(
					'post_type'      => 'page',
					'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
					'posts_per_page' => 1,
					'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
					'meta_value'     => $source['template'], // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				)
			);

			if ( ! $pages ) {
				continue;
			}

			$page   = $pages[0];
			$blocks = philosophy_info_blocks_markup( $rows, $source['body'] );

			if ( '' === $blocks ) {
				continue;
			}

			// Never append twice, however the migration is triggered.
			if ( false !== strpos( $page->post_content, 'philosophy-info-blocks' ) ) {
				$written[ $key ] = $page->ID;
				continue;
			}

			$content = rtrim( $page->post_content );
			$content = ( '' === $content ) ? $blocks : $content . "\n\n" . $blocks;

			$result = wp_update_post(
				array(
					'ID'           => $page->ID,
					'post_content' => $content,
				),
				true
			);

			if ( ! is_wp_error( $result ) ) {
				$written[ $key ] = $page->ID;
			}
		}

		return $written;
	}
}

if ( ! function_exists( 'philosophy_info_blocks_markup' ) ) {
	/**
	 * Renders stored info-block rows as block markup.
	 *
	 * @param array  $rows      Stored rows.
	 * @param string $body_key  Field name holding the body copy.
	 *
	 * @return string Block markup, or an empty string.
	 */
	function philosophy_info_blocks_markup( $rows, $body_key ) {
		$columns = '';

		foreach ( $rows as $row ) {
			$row   = (array) $row;
			$title = isset( $row['info_title'] ) ? trim( (string) $row['info_title'] ) : '';
			$body  = isset( $row[ $body_key ] ) ? trim( (string) $row[ $body_key ] ) : '';

			if ( '' === $title && '' === $body ) {
				continue;
			}

			$column = '<!-- wp:column --><div class="wp-block-column">';

			if ( '' !== $title ) {
				$column .= '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">'
					. esc_html( $title )
					. '</h2><!-- /wp:heading -->';
			}

			if ( '' !== $body ) {
				$column .= philosophy_body_to_blocks( $body );
			}

			$column .= '</div><!-- /wp:column -->';

			$columns .= $column;
		}

		if ( '' === $columns ) {
			return '';
		}

		return '<!-- wp:columns {"className":"philosophy-info-blocks"} -->'
			. '<div class="wp-block-columns philosophy-info-blocks">'
			. $columns
			. '</div><!-- /wp:columns -->';
	}
}

if ( ! function_exists( 'philosophy_body_to_blocks' ) ) {
	/**
	 * Converts a stored HTML fragment into block markup.
	 *
	 * The stored bodies came from a rich-text field, so most are one or more
	 * paragraphs of simple inline markup. Those become real paragraph blocks,
	 * which the editor can split, move and restyle. Anything with structure the
	 * conversion cannot account for — a list, a table, an embed — is wrapped in
	 * a classic block instead, which preserves it exactly rather than guessing.
	 *
	 * @param string $body Stored HTML.
	 *
	 * @return string Block markup.
	 */
	function philosophy_body_to_blocks( $body ) {
		$body = wp_kses_post( $body );
		$html = trim( wpautop( $body ) );

		// Split on top-level paragraphs. Anything left over means the fragment
		// is not simply a run of paragraphs.
		$paragraphs = array();
		$remainder  = preg_replace_callback(
			'#<p>(.*?)</p>#is',
			static function ( $matches ) use ( &$paragraphs ) {
				$paragraphs[] = trim( $matches[1] );

				return '';
			},
			$html
		);

		$only_inline = true;

		foreach ( $paragraphs as $paragraph ) {
			if ( preg_match( '#<(?!/?(?:a|b|strong|i|em|u|s|br|span|code|sub|sup|small|mark|abbr|cite|q|time)\b)[a-z]#i', $paragraph ) ) {
				$only_inline = false;
				break;
			}
		}

		if ( $paragraphs && $only_inline && '' === trim( (string) $remainder ) ) {
			$blocks = '';

			foreach ( $paragraphs as $paragraph ) {
				if ( '' === $paragraph ) {
					continue;
				}

				$blocks .= '<!-- wp:paragraph --><p>' . $paragraph . '</p><!-- /wp:paragraph -->';
			}

			if ( '' !== $blocks ) {
				return $blocks;
			}
		}

		return '<!-- wp:freeform -->' . $html . '<!-- /wp:freeform -->';
	}
}

if ( ! function_exists( 'philosophy_run_migrations' ) ) {
	/**
	 * Runs any migration this site has not seen.
	 *
	 * Hooked to admin_init rather than an activation hook: a theme has no
	 * activation hook that fires on update, only on switch, and a site that
	 * updates in place would otherwise never migrate.
	 */
	function philosophy_run_migrations() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		if ( philosophy_migration_done( 'info_blocks_to_content' ) ) {
			return;
		}

		philosophy_info_blocks_to_content();
		philosophy_migration_complete( 'info_blocks_to_content' );
	}
}
add_action( 'admin_init', 'philosophy_run_migrations' );
add_action( 'after_switch_theme', 'philosophy_run_migrations' );

if ( ! function_exists( 'philosophy_legacy_info_blocks' ) ) {
	/**
	 * Renders info-block rows that have not been migrated into page content yet.
	 *
	 * From 1.2.0 these live in the page itself, edited like any other content.
	 * This keeps rendering the old theme_mod until inc/philosophy-migrate.php
	 * has moved it, so nothing disappears between updating the theme and the
	 * next time an administrator loads the admin.
	 *
	 * @param string $mod      theme_mod holding the rows.
	 * @param string $body_key Field name holding the body copy.
	 * @param string $class    Class for each column.
	 */
	function philosophy_legacy_info_blocks( $mod, $body_key, $class ) {
		if ( philosophy_migration_done( 'info_blocks_to_content' ) ) {
			return;
		}

		$rows = philosophy_decode_repeater( get_theme_mod( $mod, array() ) );

		if ( ! $rows ) {
			return;
		}

		echo '<div class="row">';

		foreach ( $rows as $row ) {
			$row = (array) $row;

			echo '<div class="' . esc_attr( $class ) . '">';

			if ( ! empty( $row['info_title'] ) ) {
				echo '<h2>' . esc_html( $row['info_title'] ) . '</h2>';
			}

			if ( ! empty( $row[ $body_key ] ) ) {
				echo philosophy_get_textareahtml_output( $row[ $body_key ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- run through wp_kses_post().
			}

			echo '</div>';
		}

		echo '</div>';
	}
}
