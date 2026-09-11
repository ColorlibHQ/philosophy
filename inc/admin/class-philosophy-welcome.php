<?php
/**
 * The "About Philosophy" screen.
 *
 * Rebuilt on core admin markup in 1.2.0. The previous screen came from the
 * Epsilon theme dashboard, which shipped its own React bundle, an onboarding
 * wizard, a licensing panel and an opt-out tracking system — none of which had a
 * working upstream any more.
 *
 * @package Philosophy
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Philosophy_Welcome' ) ) {

	/**
	 * Class Philosophy_Welcome
	 */
	final class Philosophy_Welcome {

		/**
		 * Menu slug.
		 */
		const PAGE = 'philosophy-welcome';

		/**
		 * User meta key recording that the welcome notice was dismissed.
		 */
		const DISMISSED = 'philosophy_welcome_notice_dismissed';

		/**
		 * Hooks the screen up.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'register_page' ) );
			add_action( 'admin_notices', array( $this, 'render_notice' ) );
			add_action( 'admin_init', array( $this, 'maybe_dismiss_notice' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		}

		/**
		 * Adds the page under Appearance.
		 */
		public function register_page() {
			add_theme_page(
				esc_html__( 'About Philosophy', 'philosophy' ),
				esc_html__( 'About Philosophy', 'philosophy' ),
				'edit_theme_options',
				self::PAGE,
				array( $this, 'render_page' )
			);
		}

		/**
		 * Loads the admin stylesheet on the theme's own screens.
		 *
		 * @param string $hook Current admin page.
		 */
		public function enqueue( $hook ) {
			if ( 'appearance_page_' . self::PAGE !== $hook ) {
				return;
			}

			wp_enqueue_style(
				'philosophy-admin',
				PHILOSOPHY_DIR_CSS_URI . 'philosophy_admin.css',
				array(),
				PHILOSOPHY_VERSION
			);
		}

		/**
		 * Stores the dismissal when the notice's dismiss link is followed.
		 */
		public function maybe_dismiss_notice() {
			if ( ! isset( $_GET['philosophy-dismiss-welcome'] ) ) {
				return;
			}

			check_admin_referer( 'philosophy-dismiss-welcome' );

			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}

			update_user_meta( get_current_user_id(), self::DISMISSED, 1 );

			wp_safe_redirect( remove_query_arg( array( 'philosophy-dismiss-welcome', '_wpnonce' ) ) );
			exit;
		}

		/**
		 * Shows a one-time pointer at the welcome screen.
		 */
		public function render_notice() {
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}

			if ( get_user_meta( get_current_user_id(), self::DISMISSED, true ) ) {
				return;
			}

			$screen = get_current_screen();

			if ( $screen && 'appearance_page_' . self::PAGE === $screen->id ) {
				return;
			}

			$dismiss = wp_nonce_url(
				add_query_arg( 'philosophy-dismiss-welcome', '1' ),
				'philosophy-dismiss-welcome'
			);
			?>
			<div class="notice notice-info philosophy-welcome-notice">
				<h2><?php esc_html_e( 'Welcome to Philosophy', 'philosophy' ); ?></h2>
				<p>
					<?php esc_html_e( 'Thanks for choosing Philosophy. The About page walks through setting up the menus, the featured area and the theme options.', 'philosophy' ); ?>
				</p>
				<p>
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=' . self::PAGE ) ); ?>" class="button button-primary">
						<?php esc_html_e( 'Get started', 'philosophy' ); ?>
					</a>
					<a href="<?php echo esc_url( $dismiss ); ?>" class="button button-secondary">
						<?php esc_html_e( 'Dismiss', 'philosophy' ); ?>
					</a>
				</p>
			</div>
			<?php
		}

		/**
		 * Renders the welcome screen.
		 */
		public function render_page() {
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}

			$theme = wp_get_theme( get_template() );
			?>
			<div class="wrap philosophy-welcome">
				<h1>
					<?php
					printf(
						/* translators: 1: theme name, 2: theme version. */
						esc_html__( 'About %1$s %2$s', 'philosophy' ),
						esc_html( $theme->get( 'Name' ) ),
						esc_html( $theme->get( 'Version' ) )
					);
					?>
				</h1>

				<p class="about-text">
					<?php echo esc_html( $theme->get( 'Description' ) ); ?>
				</p>

				<hr />

				<h2><?php esc_html_e( 'Getting started', 'philosophy' ); ?></h2>

				<div class="philosophy-welcome__steps">
					<?php
					$steps = array(
						array(
							'title' => esc_html__( 'Set up your menus', 'philosophy' ),
							'text'  => esc_html__( 'Philosophy has two menu locations: Primary Menu for the site navigation and Social Menu for the icons in the header. Social icons are picked from each link\'s address, so a link to your Instagram profile shows the Instagram icon without any extra setup.', 'philosophy' ),
							'url'   => admin_url( 'nav-menus.php' ),
							'label' => esc_html__( 'Edit menus', 'philosophy' ),
						),
						array(
							'title' => esc_html__( 'Choose the featured category', 'philosophy' ),
							'text'  => esc_html__( 'The three large panels at the top of the blog come from one category. Pick which one under Theme Options, then Blog.', 'philosophy' ),
							'url'   => admin_url( 'customize.php?autofocus[section]=philosophy_blog_section' ),
							'label' => esc_html__( 'Open blog options', 'philosophy' ),
						),
						array(
							'title' => esc_html__( 'Make it yours', 'philosophy' ),
							'text'  => esc_html__( 'Colours, the header, the footer, the 404 page and the About and Contact page templates are all set from the Customizer under Theme Options.', 'philosophy' ),
							'url'   => admin_url( 'customize.php?autofocus[panel]=philosophy_theme_options_panel' ),
							'label' => esc_html__( 'Open the Customizer', 'philosophy' ),
						),
						array(
							'title' => esc_html__( 'Add your widgets', 'philosophy' ),
							'text'  => esc_html__( 'The sidebar and the seven footer areas take any widget. Philosophy adds two of its own: a popular posts list and a newsletter sign-up form.', 'philosophy' ),
							'url'   => admin_url( 'widgets.php' ),
							'label' => esc_html__( 'Edit widgets', 'philosophy' ),
						),
					);

					foreach ( $steps as $step ) :
						?>
						<div class="philosophy-welcome__step">
							<h3><?php echo esc_html( $step['title'] ); ?></h3>
							<p><?php echo esc_html( $step['text'] ); ?></p>
							<p>
								<a href="<?php echo esc_url( $step['url'] ); ?>" class="button button-secondary">
									<?php echo esc_html( $step['label'] ); ?>
								</a>
							</p>
						</div>
					<?php endforeach; ?>
				</div>

				<hr />

				<h2><?php esc_html_e( 'Recommended plugin', 'philosophy' ); ?></h2>

				<p>
					<?php esc_html_e( 'The Contact page template renders a contact form. Philosophy ships a ready-made form layout for Contact Form 7; any other form plugin works too by pasting its shortcode into the theme options.', 'philosophy' ); ?>
				</p>

				<?php $this->render_plugin_card(); ?>

				<hr />

				<h2><?php esc_html_e( 'Support', 'philosophy' ); ?></h2>

				<p>
					<?php
					printf(
						/* translators: 1: opening anchor tag, 2: closing anchor tag. */
						esc_html__( 'Found a bug or need a hand? %1$sOpen an issue on GitHub%2$s.', 'philosophy' ),
						'<a href="https://github.com/ColorlibHQ/philosophy/issues" target="_blank" rel="noopener noreferrer">',
						'</a>'
					);
					?>
				</p>
			</div>
			<?php
		}

		/**
		 * Renders a core-styled plugin card for Contact Form 7.
		 */
		private function render_plugin_card() {
			$slug      = 'contact-form-7';
			$file      = 'contact-form-7/wp-contact-form-7.php';
			$installed = file_exists( WP_PLUGIN_DIR . '/' . $file );
			$active    = defined( 'WPCF7_VERSION' );

			if ( $active ) {
				$action = '<span class="philosophy-plugin-card__done">' . esc_html__( 'Installed and active', 'philosophy' ) . '</span>';
			} elseif ( $installed && current_user_can( 'activate_plugins' ) ) {
				$action = '<a class="button button-primary" href="' . esc_url(
					wp_nonce_url(
						self_admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $file ) ),
						'activate-plugin_' . $file
					)
				) . '">' . esc_html__( 'Activate', 'philosophy' ) . '</a>';
			} elseif ( current_user_can( 'install_plugins' ) ) {
				$action = '<a class="button button-primary" href="' . esc_url(
					wp_nonce_url(
						self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ),
						'install-plugin_' . $slug
					)
				) . '">' . esc_html__( 'Install now', 'philosophy' ) . '</a>';
			} else {
				$action = '';
			}
			?>
			<div class="philosophy-plugin-card">
				<h3>Contact Form 7</h3>
				<p><?php esc_html_e( 'Just another contact form plugin. Simple but flexible.', 'philosophy' ); ?></p>
				<p><?php echo wp_kses_post( $action ); ?></p>
			</div>
			<?php
		}
	}
}

new Philosophy_Welcome();
