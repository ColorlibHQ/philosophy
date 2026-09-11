<?php
/**
 * Rich text Customizer control.
 *
 * Replaces Epsilon_Control_Text_Editor with core's wp_editor(). The stored value
 * stays an HTML string, which is what philosophy_get_textareahtml_output() reads.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Philosophy_Control_Text_Editor' ) ) {

	/**
	 * Class Philosophy_Control_Text_Editor
	 */
	class Philosophy_Control_Text_Editor extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'philosophy-text-editor';

		/**
		 * Extra wp_editor() settings.
		 *
		 * @var array
		 */
		public $editor_settings = array();

		/**
		 * Loads the editor and the shared control assets.
		 */
		public function enqueue() {
			// wp_enqueue_editor() alone does not print the TinyMCE bootstrap inside
			// the Customizer pane, so a hidden editor instance is rendered in the
			// footer to force core to enqueue everything TinyMCE needs.
			add_action( 'customize_controls_print_footer_scripts', array( __CLASS__, 'print_editor_bootstrap' ), 5 );

			philosophy_enqueue_customizer_control_assets();
		}

		/**
		 * Prints a hidden editor so TinyMCE and Quicktags are available in the pane.
		 */
		public static function print_editor_bootstrap() {
			static $printed = false;

			if ( $printed ) {
				return;
			}

			$printed = true;

			echo '<div class="philosophy-editor-bootstrap" style="display:none">';
			wp_editor(
				'',
				'philosophyeditorbootstrap',
				array(
					'tinymce'       => true,
					'quicktags'     => true,
					'media_buttons' => false,
				)
			);
			echo '</div>';
		}

		/**
		 * Renders the control.
		 */
		public function render_content() {
			$editor_id = 'philosophy-editor-' . preg_replace( '/[^a-z0-9]/', '', strtolower( $this->id ) );
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<div class="philosophy-text-editor" data-editor-id="<?php echo esc_attr( $editor_id ); ?>">
				<textarea
					id="<?php echo esc_attr( $editor_id ); ?>"
					class="philosophy-text-editor__field widefat"
					rows="8"
					<?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</div>
			<?php
		}
	}
}
