<?php
/**
 * Block editor integration: block styles and block patterns.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! function_exists( 'philosophy_register_block_styles' ) ) {
	/**
	 * Registers the theme's block styles.
	 *
	 * Each one has matching CSS in assets/css/main.css and in the editor
	 * stylesheet, so what the editor shows is what the front end renders.
	 */
	function philosophy_register_block_styles() {
		if ( ! function_exists( 'register_block_style' ) ) {
			return;
		}

		register_block_style(
			'core/quote',
			array(
				'name'  => 'philosophy-pull',
				'label' => esc_html__( 'Pull quote', 'philosophy' ),
			)
		);

		register_block_style(
			'core/image',
			array(
				'name'  => 'philosophy-framed',
				'label' => esc_html__( 'Framed', 'philosophy' ),
			)
		);

		register_block_style(
			'core/separator',
			array(
				'name'  => 'philosophy-asterisks',
				'label' => esc_html__( 'Asterisks', 'philosophy' ),
			)
		);

		register_block_style(
			'core/list',
			array(
				'name'  => 'philosophy-checked',
				'label' => esc_html__( 'Checked', 'philosophy' ),
			)
		);
	}
}
add_action( 'init', 'philosophy_register_block_styles' );

if ( ! function_exists( 'philosophy_register_block_patterns' ) ) {
	/**
	 * Registers a pattern category and the theme's patterns.
	 */
	function philosophy_register_block_patterns() {
		if ( ! function_exists( 'register_block_pattern' ) || ! function_exists( 'register_block_pattern_category' ) ) {
			return;
		}

		register_block_pattern_category(
			'philosophy',
			array( 'label' => esc_html__( 'Philosophy', 'philosophy' ) )
		);

		register_block_pattern(
			'philosophy/article-intro',
			array(
				'title'      => esc_html__( 'Article intro', 'philosophy' ),
				'categories' => array( 'philosophy', 'text' ),
				'content'    => '<!-- wp:paragraph {"className":"lead"} --><p class="lead">'
					. esc_html__( 'Open with the one sentence a reader needs before anything else makes sense.', 'philosophy' )
					. '</p><!-- /wp:paragraph -->'
					. '<!-- wp:separator {"className":"is-style-philosophy-asterisks"} --><hr class="wp-block-separator is-style-philosophy-asterisks"/><!-- /wp:separator -->',
			)
		);

		register_block_pattern(
			'philosophy/pull-quote',
			array(
				'title'      => esc_html__( 'Pull quote', 'philosophy' ),
				'categories' => array( 'philosophy', 'text' ),
				'content'    => '<!-- wp:quote {"className":"is-style-philosophy-pull"} --><blockquote class="wp-block-quote is-style-philosophy-pull"><!-- wp:paragraph --><p>'
					. esc_html__( 'The sentence worth lifting out of the paragraph it came from.', 'philosophy' )
					. '</p><!-- /wp:paragraph --><cite>'
					. esc_html__( 'Attribution', 'philosophy' )
					. '</cite></blockquote><!-- /wp:quote -->',
			)
		);

		register_block_pattern(
			'philosophy/two-column-note',
			array(
				'title'      => esc_html__( 'Two column note', 'philosophy' ),
				'categories' => array( 'philosophy', 'columns' ),
				'content'    => '<!-- wp:columns --><div class="wp-block-columns">'
					. '<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3>'
					. esc_html__( 'What happened', 'philosophy' )
					. '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>'
					. esc_html__( 'A short paragraph of context.', 'philosophy' )
					. '</p><!-- /wp:paragraph --></div><!-- /wp:column -->'
					. '<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3>'
					. esc_html__( 'What it means', 'philosophy' )
					. '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>'
					. esc_html__( 'A short paragraph of interpretation.', 'philosophy' )
					. '</p><!-- /wp:paragraph --></div><!-- /wp:column -->'
					. '</div><!-- /wp:columns -->',
			)
		);
	}
}
add_action( 'init', 'philosophy_register_block_patterns' );
