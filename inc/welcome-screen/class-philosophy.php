<?php

class Philosophy_Welcome {

	public $recommended_plugins = array(
		'elementor'  => array(
			'recommended' => false,
		),
		'contact-form-7'    => array(
			'recommended' => false,
		),
		'one-click-demo-import' => array(
			'recommended' => false,
		),
	);

	public $recommended_actions;

	public $theme_slug = 'philosophy';

	function __construct() {

		if ( ! is_admin() && ! is_customize_preview() ) {
			return;
		}

		$this->load_class();

		$this->recommended_actions = apply_filters(
			'philosophy_required_actions', array(

				array(
					'id'          => 'philosophy-req-ac-install-contact-form-7',
					'title'       => Philosophy_Notify_System::philosophy_cf7_title(),
					'description' => Philosophy_Notify_System::philosophy_cf7_description(),
					'check'       => Philosophy_Notify_System::philosophy_has_plugin( 'contact-form-7' ),
					'plugin_slug' => 'contact-form-7',
				),
				array(
					'id'          => 'philosophy-req-ac-install-oneclick',
					'title'       => Philosophy_Notify_System::philosophy_oneclick_title(),
					'description' => Philosophy_Notify_System::philosophy_oneclick_description(),
					'check'       => Philosophy_Notify_System::philosophy_has_plugin( 'one-click-demo-import' ),
					'plugin_slug' => 'one-click-demo-import',
				),
				array(
					'id'          => 'philosophy-req-import-content',
					'title'       => esc_html__( 'Import Demo Content', 'philosophy' ),
					'description' => esc_html__( 'Clicking the button below will import demo data. Before import demo data please install all recommended plugins.', 'philosophy' ),
					'help'        => $this->generate_action_html(),
					'check'       => Philosophy_Notify_System::philosophy_has_content(),
				),
			)
		);

		$this->init_epsilon();
		$this->init_welcome_screen();

		// Hooks
		add_action( 'customize_register', array( $this, 'init_customizer' ) );

	}

	public function load_class() {

		if ( ! is_admin() && ! is_customize_preview() ) {
			return;
		}

		require_once get_template_directory() . '/inc/welcome-screen/class-philosophy-notify-system.php';
		require_once get_template_directory() . '/inc/welcome-screen/class-epsilon-welcome-screen.php';

	}

	public function init_epsilon() {

		$args = array(
			'controls' => array( 'slider', 'toggle' ), // array of controls to load
			'sections' => array( 'recommended-actions', 'pro' ), // array of sections to load
			'backup'   => false,
		);

		new Epsilon_Framework( $args );

	}

	public function init_welcome_screen() {

		Epsilon_Welcome_Screen::get_instance(
			$config = array(
				'theme-name' => 'Philosophy',
				'theme-slug' => 'philosophy',
				'actions'    => $this->recommended_actions,
				'plugins'    => $this->recommended_plugins,
			)
		);

	}

	public function init_customizer( $wp_customize ) {
		$current_theme = wp_get_theme();
		$wp_customize->add_section(
			new Epsilon_Section_Recommended_Actions(
				$wp_customize, 'epsilon_recomended_section', array(
					'title'                        => esc_html__( 'Recomended Actions', 'philosophy' ),
					'social_text'                  => esc_html( $current_theme->get( 'Author' ) ) . esc_html__( ' is social :', 'philosophy' ),
					'plugin_text'                  => esc_html__( 'Recomended Plugins :', 'philosophy' ),
					'actions'                      => $this->recommended_actions,
					'plugins'                      => $this->recommended_plugins,
					'theme_specific_option'        => $this->theme_slug . '_show_required_actions',
					'theme_specific_plugin_option' => $this->theme_slug . '_show_required_plugins',
					'facebook'                     => 'https://www.facebook.com/colorlib',
					'twitter'                      => 'https://twitter.com/colorlib',
					'wp_review'                    => true,
					'priority'                     => 0,
				)
			)
		);

	}

	private function generate_action_html() {

		$import_actions = array(
			'set-frontpage'  => esc_html__( 'Set Static FrontPage', 'philosophy' ),
			'import-widgets' => esc_html__( 'Import HomePage Widgets', 'philosophy' ),
		);

		$import_plugins = array(
			'philosophy-companion' => esc_html__( 'Philosophy Companion', 'philosophy' ),
			'jetpack'           => esc_html__( 'Jetpack', 'philosophy' ),
			'contact-form-7'    => esc_html__( 'Contact Form 7', 'philosophy' ),
		);

		$plugins_html = '';

		if ( is_customize_preview() ) {
			$url  = 'themes.php?page=%1$s-welcome&tab=%2$s';
			$html = '<a class="button button-primary" id="" href="' . esc_url( admin_url( sprintf( $url, 'philosophy', 'recommended-actions' ) ) ) . '">' . __( 'Import Demo Content', 'philosophy' ) . '</a>';
		} else {
			$html  = '<p><a class="button button-primary" target="_blank" href="'.esc_url(admin_url('themes.php?page=philosophy-demo-import')).'">' . __( 'Go To Import Demo Content', 'philosophy' ) . '</a>';
			$html .= '<div class="import-content-container" id="welcome-hidden-content">';

			foreach ( $import_plugins as $id => $label ) {
				if ( ! Philosophy_Notify_System::philosophy_has_plugin( $id ) ) {
					$plugins_html .= $this->generate_checkbox( $id, $label, 'plugins' );
				}
			}

			if ( '' != $plugins_html ) {
				$html .= '<div class="plugins-container">';
				$html .= '<h4>' . __( 'Plugins', 'philosophy' ) . '</h4>';
				$html .= '<div class="checkbox-group">';
				$html .= $plugins_html;
				$html .= '</div>';
				$html .= '</div>';
			}

			$html .= '<div class="demo-content-container">';
			$html .= '<h4>' . __( 'Demo Content', 'philosophy' ) . '</h4>';
			$html .= '<div class="checkbox-group">';
			foreach ( $import_actions as $id => $label ) {
				$html .= $this->generate_checkbox( $id, $label );
			}
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}

		return $html;

	}

	private function generate_checkbox( $id, $label, $name = 'options', $block = false ) {
		$string = '<label><input checked type="checkbox" name="%1$s" class="demo-checkboxes"' . ( $block ? ' disabled ' : ' ' ) . 'value="%2$s">%3$s</label>';

		return sprintf( $string, $name, $id, $label );
	}

}

new Philosophy_Welcome();
