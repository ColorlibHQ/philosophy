<?php
/**
 * Repeater Customizer control.
 *
 * Replaces Epsilon_Control_Repeater for the About and Contact info blocks. The
 * stored value keeps the shape the page templates already read:
 *
 *     array( array( 'info_title' => '…', 'info_desc' => '…' ), … )
 *
 * so existing blocks continue to render untouched.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Philosophy_Control_Repeater' ) ) {

	/**
	 * Class Philosophy_Control_Repeater
	 */
	class Philosophy_Control_Repeater extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'philosophy-repeater';

		/**
		 * Per-row field definitions, keyed by field name.
		 *
		 * Each entry accepts 'label', 'type' ('text' or 'textarea') and 'default'.
		 * The legacy Epsilon spelling "epsilon-text-editor" maps to a textarea.
		 *
		 * @var array
		 */
		public $fields = array();

		/**
		 * Label for the "add row" button.
		 *
		 * @var string
		 */
		public $button_label = '';

		/**
		 * Row heading, or an Epsilon-style array( 'type' => 'field', 'field' => … ).
		 *
		 * @var string|array
		 */
		public $row_label = '';

		/**
		 * Loads the shared control assets.
		 */
		public function enqueue() {
			philosophy_enqueue_customizer_control_assets();
		}

		/**
		 * Returns the field name whose value titles each row, if any.
		 *
		 * @return string
		 */
		protected function title_field() {
			if ( is_array( $this->row_label ) && ! empty( $this->row_label['field'] ) ) {
				return (string) $this->row_label['field'];
			}

			return '';
		}

		/**
		 * Returns the static row heading.
		 *
		 * @return string
		 */
		protected function row_heading() {
			if ( is_array( $this->row_label ) ) {
				return isset( $this->row_label['value'] ) ? (string) $this->row_label['value'] : esc_html__( 'Item', 'philosophy' );
			}

			return $this->row_label ? (string) $this->row_label : esc_html__( 'Item', 'philosophy' );
		}

		/**
		 * Normalises the stored value into a list of row arrays.
		 *
		 * @return array
		 */
		protected function rows() {
			$rows = array();

			foreach ( philosophy_decode_repeater( $this->value() ) as $row ) {
				$row = (array) $row;
				$out = array();

				foreach ( $this->fields as $name => $field ) {
					$out[ $name ] = isset( $row[ $name ] ) ? (string) $row[ $name ] : '';
				}

				$rows[] = $out;
			}

			return $rows;
		}

		/**
		 * Renders the control.
		 */
		public function render_content() {
			$rows      = $this->rows();
			$add_label = $this->button_label ? $this->button_label : esc_html__( 'Add new', 'philosophy' );
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<div class="philosophy-repeater"
				data-row-label="<?php echo esc_attr( $this->row_heading() ); ?>"
				data-title-field="<?php echo esc_attr( $this->title_field() ); ?>">

				<ul class="philosophy-repeater__rows">
					<?php foreach ( $rows as $index => $row ) : ?>
						<?php $this->render_row( $row, $index ); ?>
					<?php endforeach; ?>
				</ul>

				<button type="button" class="button philosophy-repeater__add"><?php echo esc_html( $add_label ); ?></button>

				<input type="hidden" class="philosophy-repeater__value"
					value="<?php echo esc_attr( wp_json_encode( $rows ) ); ?>"
					<?php $this->link(); ?> />

				<?php // The template stays inside the wrapper: the script looks it up from there. ?>
				<script type="text/html" class="philosophy-repeater__template">
					<?php
					$blank = array();

					foreach ( $this->fields as $name => $field ) {
						$blank[ $name ] = isset( $field['default'] ) ? (string) $field['default'] : '';
					}

					$this->render_row( $blank, '__i__' );
					?>
				</script>
			</div>
			<?php
		}

		/**
		 * Renders a single row.
		 *
		 * @param array      $row   Field values.
		 * @param int|string $index Row index, or the template placeholder.
		 */
		protected function render_row( $row, $index ) {
			$title_field = $this->title_field();
			$heading     = $this->row_heading();

			if ( $title_field && ! empty( $row[ $title_field ] ) ) {
				$heading = $row[ $title_field ];
			}
			?>
			<li class="philosophy-repeater__row" data-index="<?php echo esc_attr( $index ); ?>">
				<div class="philosophy-repeater__row-header">
					<button type="button" class="philosophy-repeater__toggle" aria-expanded="false">
						<span class="philosophy-repeater__row-title"><?php echo esc_html( $heading ); ?></span>
						<span class="dashicons dashicons-arrow-down" aria-hidden="true"></span>
					</button>
					<button type="button" class="button-link philosophy-repeater__remove" aria-label="<?php esc_attr_e( 'Remove this block', 'philosophy' ); ?>">
						<span class="dashicons dashicons-no-alt" aria-hidden="true"></span>
					</button>
				</div>

				<div class="philosophy-repeater__row-body" hidden>
					<?php foreach ( $this->fields as $name => $field ) : ?>
						<?php
						$value      = isset( $row[ $name ] ) ? $row[ $name ] : '';
						$field_type = isset( $field['type'] ) ? $field['type'] : 'text';
						$is_area    = in_array( $field_type, array( 'textarea', 'philosophy-text-editor', 'epsilon-text-editor' ), true );
						?>
						<p class="philosophy-repeater__field" data-field="<?php echo esc_attr( $name ); ?>">
							<?php if ( ! empty( $field['label'] ) ) : ?>
								<span class="philosophy-repeater__field-label"><?php echo esc_html( $field['label'] ); ?></span>
							<?php endif; ?>

							<?php if ( $is_area ) : ?>
								<textarea class="widefat philosophy-repeater__input" rows="5"><?php echo esc_textarea( $value ); ?></textarea>
							<?php else : ?>
								<input type="text" class="widefat philosophy-repeater__input" value="<?php echo esc_attr( $value ); ?>" />
							<?php endif; ?>
						</p>
					<?php endforeach; ?>
				</div>
			</li>
			<?php
		}
	}
}
