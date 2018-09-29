<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Pro customizer section.
 *
 * @since  1.4.0
 * @access public
 */
class Epsilon_Section_Doubled extends WP_Customize_Section {

	/**
	 * @since 1.4.0
	 * @var string
	 */
	public $type = 'epsilon-section-doubled';

	/**
	 * Epsilon_Section_Doubled constructor.
	 *
	 * @since 1.4.0
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		$manager->register_section_type( 'Epsilon_Section_Doubled' );
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.4.0
	 * @access public
	 */
	public function json() {
		$json = parent::json();

		return $json;
	}

	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
			<h3 class="accordion-section-title" tabindex="0">
				{{ data.title }}
<<<<<<< HEAD
				<span class="screen-reader-text"><?php _e( 'Press return or enter to open this section', 'epsilon-framework' ); ?></span>
=======
				<span class="screen-reader-text"><?php _e( 'Press return or enter to open this section', 'philosophy' ); ?></span>
>>>>>>> 5a42a4e760d4c9695deb1c2d83070bd5fb910a24
			</h3>
			<ul class="accordion-section-content">
				<li class="customize-section-description-container section-meta <# if ( data.description_hidden ) { #>customize-info<# } #>" >
					<button type="button" class="button epsilon-close-doubled-section" aria-expanded="false" aria-controls="available-sections">
<<<<<<< HEAD
						<span class="screen-reader-text"><?php esc_html_e( 'Close', 'epsilon-framework' ); ?></span>
=======
						<span class="screen-reader-text"><?php esc_html_e( 'Close', 'philosophy' ); ?></span>
>>>>>>> 5a42a4e760d4c9695deb1c2d83070bd5fb910a24
					</button>
					<div class="customize-section-title">
						<h3>
							<span class="customize-action"> {{{ data.customizeAction }}} </span>
							{{ data.title }}
						</h3>
						<# if ( data.description && data.description_hidden ) { #>
<<<<<<< HEAD
							<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php _e( 'Help', 'epsilon-framework' ); ?></span></button>
=======
							<button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php _e( 'Help', 'philosophy' ); ?></span></button>
>>>>>>> 5a42a4e760d4c9695deb1c2d83070bd5fb910a24
							<div class="description customize-section-description">
								{{{ data.description }}}
							</div>
						<# } #>
					</div>

					<# if ( data.description && ! data.description_hidden ) { #>
						<div class="description customize-section-description">
							{{{ data.description }}}
						</div>
					<# } #>
				</li>
			</ul>
		</li>
		<?php
	}
}
