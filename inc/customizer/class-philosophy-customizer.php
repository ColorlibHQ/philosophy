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
		 * Control types this theme implements itself, mapped to their class names.
		 *
		 * The legacy "epsilon-" spellings are accepted as aliases so stored
		 * configuration and third-party code keep resolving.
		 *
		 * @var array
		 */
		protected static $custom_controls = array(
			'philosophy-toggle'      => 'Philosophy_Control_Toggle',
			'philosophy-text-editor' => 'Philosophy_Control_Text_Editor',
			'philosophy-repeater'    => 'Philosophy_Control_Repeater',
			'philosophy-layouts'     => 'Philosophy_Control_Layout',
			'epsilon-toggle'         => 'Philosophy_Control_Toggle',
			'epsilon-text-editor'    => 'Philosophy_Control_Text_Editor',
			'epsilon-repeater'       => 'Philosophy_Control_Repeater',
			'epsilon-layouts'        => 'Philosophy_Control_Layout',
		);

		/**
		 * Control types handled by a core WP_Customize_Control subclass.
		 *
		 * @var array
		 */
		protected static $core_controls = array(
			'philosophy-color-picker' => 'WP_Customize_Color_Control',
			'epsilon-color-picker'    => 'WP_Customize_Color_Control',
			'color'                   => 'WP_Customize_Color_Control',
			'image'                   => 'WP_Customize_Image_Control',
			'upload'                  => 'WP_Customize_Upload_Control',
			'media'                   => 'WP_Customize_Media_Control',
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
			foreach ( array( 'fields', 'button_label', 'row_label', 'layouts', 'editor_settings' ) as $extra ) {
				if ( isset( $args[ $extra ] ) ) {
					$control_args[ $extra ] = $args[ $extra ];
				}
			}

			if ( isset( self::$custom_controls[ $type ] ) ) {
				$class = self::$custom_controls[ $type ];

				if ( class_exists( $class ) ) {
					$manager->add_control( new $class( $manager, $id, $control_args ) );

					return;
				}
			}

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
