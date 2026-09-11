<?php
/**
 * Sanitize callbacks for Customizer settings.
 *
 * Every setting the theme registers routes through one of these. Before 1.2.0 most
 * settings had no sanitize callback at all, which let anything an administrator
 * pasted into the Customizer reach the front end verbatim.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! function_exists( 'philosophy_sanitize_color' ) ) {
	/**
	 * Sanitizes a colour, accepting hex, rgb() and rgba().
	 *
	 * Values stored by the old Epsilon colour picker include three digit hex
	 * ("#fff") and rgba() strings, so both have to survive the round trip or
	 * existing sites lose their colours on the first Customizer save.
	 *
	 * @param string $value Raw value.
	 *
	 * @return string Sanitized colour, or an empty string.
	 */
	function philosophy_sanitize_color( $value ) {
		$value = trim( (string) $value );

		if ( '' === $value ) {
			return '';
		}

		$hex = sanitize_hex_color( $value );

		if ( $hex ) {
			return $hex;
		}

		if ( preg_match( '/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}\s*(?:,\s*(?:0|1|0?\.\d+)\s*)?\)$/i', $value ) ) {
			return $value;
		}

		return '';
	}
}

if ( ! function_exists( 'philosophy_sanitize_checkbox' ) ) {
	/**
	 * Normalises a toggle to a boolean.
	 *
	 * @param mixed $value Raw value.
	 *
	 * @return bool
	 */
	function philosophy_sanitize_checkbox( $value ) {
		if ( is_string( $value ) ) {
			$value = strtolower( trim( $value ) );

			if ( in_array( $value, array( 'false', 'off', 'no', '0', '' ), true ) ) {
				return false;
			}
		}

		return (bool) $value;
	}
}

if ( ! function_exists( 'philosophy_sanitize_html' ) ) {
	/**
	 * Sanitizes rich text down to the markup a post author may use.
	 *
	 * @param string $value Raw value.
	 *
	 * @return string
	 */
	function philosophy_sanitize_html( $value ) {
		return wp_kses_post( (string) $value );
	}
}

if ( ! function_exists( 'philosophy_sanitize_number' ) ) {
	/**
	 * Sanitizes an integer, respecting any min/max declared on the control.
	 *
	 * @param mixed                $value   Raw value.
	 * @param WP_Customize_Setting $setting Setting instance.
	 *
	 * @return int
	 */
	function philosophy_sanitize_number( $value, $setting = null ) {
		$value = absint( $value );

		if ( $setting instanceof WP_Customize_Setting ) {
			$control = $setting->manager->get_control( $setting->id );

			if ( $control && ! empty( $control->input_attrs['min'] ) && $value < (int) $control->input_attrs['min'] ) {
				$value = (int) $control->input_attrs['min'];
			}

			if ( $control && ! empty( $control->input_attrs['max'] ) && $value > (int) $control->input_attrs['max'] ) {
				$value = (int) $control->input_attrs['max'];
			}
		}

		return $value;
	}
}

if ( ! function_exists( 'philosophy_sanitize_choice' ) ) {
	/**
	 * Keeps a select/radio value inside the choices the control offers.
	 *
	 * @param string               $value   Raw value.
	 * @param WP_Customize_Setting $setting Setting instance.
	 *
	 * @return string
	 */
	function philosophy_sanitize_choice( $value, $setting = null ) {
		$value = sanitize_text_field( (string) $value );

		if ( ! $setting instanceof WP_Customize_Setting ) {
			return $value;
		}

		$control = $setting->manager->get_control( $setting->id );

		if ( $control && ! empty( $control->choices ) && ! array_key_exists( $value, $control->choices ) ) {
			return (string) $setting->default;
		}

		return $value;
	}
}

if ( ! function_exists( 'philosophy_sanitize_repeater' ) ) {
	/**
	 * Sanitizes a repeater value into a list of row arrays.
	 *
	 * Accepts the JSON string the control posts and the plain array Epsilon used
	 * to store, so existing About/Contact info blocks keep rendering.
	 *
	 * @param mixed $value Raw value.
	 *
	 * @return array
	 */
	function philosophy_sanitize_repeater( $value ) {
		$value = philosophy_decode_repeater( $value );
		$rows  = array();

		foreach ( $value as $row ) {
			$row   = (array) $row;
			$clean = array();

			foreach ( $row as $key => $field ) {
				$key = sanitize_key( $key );

				if ( '' === $key || is_array( $field ) || is_object( $field ) ) {
					continue;
				}

				// Titles are plain text; the description fields carry post-grade HTML.
				$clean[ $key ] = ( false !== strpos( $key, 'title' ) )
					? sanitize_text_field( (string) $field )
					: wp_kses_post( (string) $field );
			}

			if ( $clean ) {
				$rows[] = $clean;
			}
		}

		return $rows;
	}
}

if ( ! function_exists( 'philosophy_decode_repeater' ) ) {
	/**
	 * Normalises a repeater value to an array of rows.
	 *
	 * @param mixed $value Stored or posted value.
	 *
	 * @return array
	 */
	function philosophy_decode_repeater( $value ) {
		if ( is_string( $value ) ) {
			$value = json_decode( $value, true );
		}

		if ( is_object( $value ) ) {
			$value = (array) $value;
		}

		if ( ! is_array( $value ) ) {
			return array();
		}

		return $value;
	}
}

if ( ! function_exists( 'philosophy_sanitize_layout' ) ) {
	/**
	 * Sanitizes the blog layout choice to "1", "2" or "3".
	 *
	 * Epsilon stored this as an array (or a JSON string) shaped
	 * array( 'columnsCount' => 2, 'columns' => … ). Sites upgrading from 1.1.x
	 * still hold that value, so it is read before being normalised.
	 *
	 * @param mixed $value Raw value.
	 *
	 * @return string
	 */
	function philosophy_sanitize_layout( $value ) {
		$value = philosophy_normalize_layout( $value );

		return in_array( $value, array( '1', '2', '3' ), true ) ? $value : '1';
	}
}

if ( ! function_exists( 'philosophy_normalize_layout' ) ) {
	/**
	 * Reduces any stored blog-layout value to a column-count string.
	 *
	 * @param mixed $value Stored value.
	 *
	 * @return string
	 */
	function philosophy_normalize_layout( $value ) {
		if ( is_string( $value ) && '' !== $value && ! is_numeric( $value ) ) {
			$decoded = json_decode( $value, true );

			if ( null !== $decoded ) {
				$value = $decoded;
			}
		}

		if ( is_object( $value ) ) {
			$value = (array) $value;
		}

		if ( is_array( $value ) ) {
			$value = isset( $value['columnsCount'] ) ? $value['columnsCount'] : '';
		}

		return (string) absint( $value );
	}
}

if ( ! function_exists( 'philosophy_sanitize_coordinate' ) ) {
	/**
	 * Sanitizes a map latitude or longitude.
	 *
	 * @param mixed $value Raw value.
	 *
	 * @return string Signed decimal number, or an empty string.
	 */
	function philosophy_sanitize_coordinate( $value ) {
		$value = trim( (string) $value );

		if ( '' === $value || ! is_numeric( $value ) ) {
			return '';
		}

		return (string) (float) $value;
	}
}
