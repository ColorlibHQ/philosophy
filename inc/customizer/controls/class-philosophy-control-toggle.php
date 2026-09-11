<?php
/**
 * On/off toggle Customizer control.
 *
 * Replaces Epsilon_Control_Toggle. It is a checkbox underneath, so the stored
 * value stays the boolean the front end has always read.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Philosophy_Control_Toggle' ) ) {

	/**
	 * Class Philosophy_Control_Toggle
	 */
	class Philosophy_Control_Toggle extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'philosophy-toggle';

		/**
		 * Renders the control.
		 */
		public function render_content() {
			$id = '_customize-input-' . $this->id;
			?>
			<span class="customize-control-title philosophy-toggle-wrap">
				<label class="philosophy-toggle">
					<input
						id="<?php echo esc_attr( $id ); ?>"
						type="checkbox"
						class="philosophy-toggle__input"
						value="1"
						<?php checked( (bool) $this->value() ); ?>
						<?php $this->link(); ?> />
					<span class="philosophy-toggle__track" aria-hidden="true"></span>
					<span class="philosophy-toggle__label"><?php echo esc_html( $this->label ); ?></span>
				</label>
			</span>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>
			<?php
		}
	}
}
