<?php
/**
 * Blog layout picker.
 *
 * Replaces Epsilon_Control_Layouts. Epsilon stored a whole column descriptor
 * array; this control stores the column count as a string, and reads the old
 * array so sites upgrading from 1.1.x keep the layout they chose.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Philosophy_Control_Layout' ) ) {

	/**
	 * Class Philosophy_Control_Layout
	 */
	class Philosophy_Control_Layout extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'philosophy-layouts';

		/**
		 * Layout choices: value => array( 'label' => string, 'image' => url ).
		 *
		 * @var array
		 */
		public $layouts = array();

		/**
		 * Loads the shared control assets.
		 */
		public function enqueue() {
			philosophy_enqueue_customizer_control_assets();
		}

		/**
		 * Renders the control.
		 */
		public function render_content() {
			if ( empty( $this->layouts ) ) {
				return;
			}

			$current = philosophy_normalize_layout( $this->value() );

			if ( ! isset( $this->layouts[ $current ] ) ) {
				$current = (string) key( $this->layouts );
			}

			$name = '_customize-radio-' . $this->id;
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<div class="philosophy-layouts">
				<?php foreach ( $this->layouts as $value => $layout ) : ?>
					<?php
					$value = (string) $value;
					$label = isset( $layout['label'] ) ? $layout['label'] : $value;
					$image = isset( $layout['image'] ) ? $layout['image'] : '';
					$id    = $name . '-' . $value;
					?>
					<label class="philosophy-layouts__item<?php echo ( $current === $value ) ? ' is-selected' : ''; ?>" for="<?php echo esc_attr( $id ); ?>">
						<input
							id="<?php echo esc_attr( $id ); ?>"
							type="radio"
							name="<?php echo esc_attr( $name ); ?>"
							value="<?php echo esc_attr( $value ); ?>"
							<?php checked( $current, $value ); ?>
							<?php $this->link(); ?> />

						<?php if ( $image ) : ?>
							<img src="<?php echo esc_url( $image ); ?>" alt="" />
						<?php endif; ?>

						<span class="philosophy-layouts__label"><?php echo esc_html( $label ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
			<?php
		}
	}
}
