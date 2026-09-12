<?php
/**
 * Declarative helper for registering Customizer panels, sections and fields.
 *
 * Replaces Epsilon_Customizer. The call signatures are deliberately identical to
 * Epsilon's so the field definitions in inc/customizer/fields/ read the same way
 * they always did, and so a child theme that called Epsilon_Customizer::add_field()
 * keeps working through the deprecation shim in inc/philosophy-deprecated.php.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Philosophy_Customizer' ) ) {

	/**
	 * Class Philosophy_Customizer
	 */
	class Philosophy_Customizer {

		/**
		 * The Customizer manager, captured while customize_register runs.
		 *
		 * @var WP_Customize_Manager|null
		 */
		protected static $manager = null;

		/**
		 * Field types that need a core control class rather than a type string.
		 *
		 * Everything else is a plain WP_Customize_Control type: checkbox, radio,
		 * select, text, textarea, number, url, email.
		 *
		 * The "epsilon-" spellings are the ones Epsilon used, kept so a child
		 * theme calling add_field() with them keeps resolving. Each maps to the
		 * core control that replaced it.
		 *
		 * @var array
		 */
		protected static $core_controls = array(
			'color'                   => 'WP_Customize_Color_Control',
			'image'                   => 'WP_Customize_Image_Control',
			'upload'                  => 'WP_Customize_Upload_Control',
			'media'                   => 'WP_Customize_Media_Control',
			'epsilon-color-picker'    => 'WP_Customize_Color_Control',
			'philosophy-color-picker' => 'WP_Customize_Color_Control',
		);

		/**
		 * Field types that are now a plain core control type.
		 *
		 * @var array
		 */
		protected static $aliases = array(
			'epsilon-toggle'         => 'checkbox',
			'philosophy-toggle'      => 'checkbox',
			'epsilon-text-editor'    => 'textarea',
			'philosophy-text-editor' => 'textarea',
			'epsilon-layouts'        => 'radio',
			'philosophy-layouts'     => 'radio',
			'epsilon-repeater'       => 'textarea',
			'philosophy-repeater'    => 'textarea',
		);

		/**
		 * Stores the manager for the duration of the customize_register hook.
		 *
		 * @param WP_Customize_Manager $wp_customize Customizer manager.
		 */
		public static function set_manager( $wp_customize ) {
			self::$manager = $wp_customize;
		}

		/**
		 * Returns the Customizer manager.
		 *
		 * @return WP_Customize_Manager|null
		 */
		public static function manager() {
			if ( null === self::$manager && isset( $GLOBALS['wp_customize'] ) ) {
				self::$manager = $GLOBALS['wp_customize'];
			}

			return self::$manager;
		}

		/**
		 * Registers panels and sections from a collection.
		 *
		 * @param array $collection Keys 'panel' and/or 'section', each a list of
		 *                          array( 'id' => string, 'args' => array ).
		 */
		public static function add_multiple( $collection = array() ) {
			$manager = self::manager();

			if ( ! $manager ) {
				return;
			}

			foreach ( array( 'panel', 'section' ) as $kind ) {
				if ( empty( $collection[ $kind ] ) || ! is_array( $collection[ $kind ] ) ) {
					continue;
				}

				foreach ( $collection[ $kind ] as $entry ) {
					if ( empty( $entry['id'] ) ) {
						continue;
					}

					$args = isset( $entry['args'] ) ? (array) $entry['args'] : array();

					if ( 'panel' === $kind ) {
						$manager->add_panel( $entry['id'], $args );
					} else {
						$manager->add_section( $entry['id'], $args );
					}
				}
			}
		}

		/**
		 * Registers one setting and its control.
		 *
		 * @param string $id   Setting id (a theme_mod key).
		 * @param array  $args Field definition.
		 */
		public static function add_field( $id, $args = array() ) {
			$manager = self::manager();

			if ( ! $manager || '' === $id ) {
				return;
			}

			$type = isset( $args['type'] ) ? $args['type'] : 'text';

			if ( isset( self::$aliases[ $type ] ) ) {
				$type = self::$aliases[ $type ];
			}

			$setting_args = array(
				'default'           => isset( $args['default'] ) ? $args['default'] : '',
				'type'              => isset( $args['setting_type'] ) ? $args['setting_type'] : 'theme_mod',
				'capability'        => isset( $args['capability'] ) ? $args['capability'] : 'edit_theme_options',
				'transport'         => isset( $args['transport'] ) ? $args['transport'] : 'refresh',
				'sanitize_callback' => isset( $args['sanitize_callback'] )
					? $args['sanitize_callback']
					: self::default_sanitizer( $type ),
			);

			$manager->add_setting( $id, $setting_args );

			$control_args = array(
				'label'       => isset( $args['label'] ) ? $args['label'] : '',
				'description' => isset( $args['description'] ) ? $args['description'] : '',
				'section'     => isset( $args['section'] ) ? $args['section'] : '',
				'settings'    => $id,
				'priority'    => isset( $args['priority'] ) ? $args['priority'] : 10,
			);

			if ( isset( $args['active_callback'] ) ) {
				$control_args['active_callback'] = $args['active_callback'];
			}

			if ( isset( $args['input_attrs'] ) ) {
				$control_args['input_attrs'] = $args['input_attrs'];
			}

			if ( isset( $args['choices'] ) ) {
				$control_args['choices'] = $args['choices'];
			}

			// Field definitions this theme owns (repeater rows, layout thumbnails…).
			if ( isset( self::$core_controls[ $type ] ) ) {
				$class = self::$core_controls[ $type ];

				if ( class_exists( $class ) ) {
					$manager->add_control( new $class( $manager, $id, $control_args ) );

					return;
				}
			}

			$control_args['type'] = $type;
			$manager->add_control( $id, $control_args );
		}

		/**
		 * Picks a sanitize callback for a field type.
		 *
		 * Every setting gets one: an unsanitized Customizer setting is a stored-XSS
		 * vector and a Theme Check failure.
		 *
		 * @param string $type Field type.
		 *
		 * @return string|callable
		 */
		public static function default_sanitizer( $type ) {
			switch ( $type ) {
				case 'philosophy-color-picker':
				case 'epsilon-color-picker':
				case 'color':
					return 'philosophy_sanitize_color';

				case 'philosophy-toggle':
				case 'epsilon-toggle':
				case 'checkbox':
					return 'philosophy_sanitize_checkbox';

				case 'philosophy-text-editor':
				case 'epsilon-text-editor':
				case 'textarea':
					return 'philosophy_sanitize_html';

				case 'philosophy-repeater':
				case 'epsilon-repeater':
					return 'philosophy_sanitize_repeater';

				case 'philosophy-layouts':
				case 'epsilon-layouts':
					return 'philosophy_sanitize_layout';

				case 'image':
				case 'upload':
				case 'url':
					return 'esc_url_raw';

				case 'number':
					return 'philosophy_sanitize_number';

				case 'select':
				case 'radio':
					return 'philosophy_sanitize_choice';

				default:
					return 'sanitize_text_field';
			}
		}
	}
}
