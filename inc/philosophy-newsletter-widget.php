<?php
/**
 * Newsletter sign-up widget.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'philosophy_newsletter_widget' ) ) {

	/**
	 * Class philosophy_newsletter_widget
	 */
	class philosophy_newsletter_widget extends WP_Widget {

		/**
		 * Registers the widget.
		 */
		public function __construct() {
			parent::__construct(
				'philosophy_newsletter_widget',
				esc_html__( '[ Philosophy ] Newsletter', 'philosophy' ),
				array(
					'description' => esc_html__( 'A newsletter sign-up form that posts to your mailing list provider.', 'philosophy' ),
					'classname'   => 'philosophy-newsletter-widget',
				)
			);
		}

		/**
		 * Renders the widget.
		 *
		 * @param array $args     Sidebar arguments.
		 * @param array $instance Widget settings.
		 */
		public function widget( $args, $instance ) {
			$title      = isset( $instance['title'] ) ? $instance['title'] : '';
			$desc       = isset( $instance['desc'] ) ? $instance['desc'] : '';
			$action_url = isset( $instance['actionurl'] ) ? $instance['actionurl'] : '';

			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

			if ( ! $action_url ) {
				if ( current_user_can( 'edit_theme_options' ) ) {
					echo wp_kses_post( $args['before_widget'] );
					echo '<p>' . esc_html__( 'Add your mailing list form action URL to this widget to show the sign-up form.', 'philosophy' ) . '</p>';
					echo wp_kses_post( $args['after_widget'] );
				}

				return;
			}

			$field_id = 'philosophy-newsletter-' . esc_attr( $this->id );

			echo wp_kses_post( $args['before_widget'] );

			if ( $title ) {
				echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
			}
			?>
			<div class="s-footer__subscribe">
				<?php if ( $desc ) : ?>
					<p><?php echo wp_kses_post( $desc ); ?></p>
				<?php endif; ?>

				<div class="subscribe-form">
					<div id="mc-form">
						<form class="group validate" method="post" action="<?php echo esc_url( $action_url ); ?>" target="_blank">
							<label for="<?php echo esc_attr( $field_id ); ?>" class="screen-reader-text">
								<?php esc_html_e( 'Email Address', 'philosophy' ); ?>
							</label>

							<input
								type="email"
								name="EMAIL"
								class="email required"
								id="<?php echo esc_attr( $field_id ); ?>"
								placeholder="<?php esc_attr_e( 'Email Address', 'philosophy' ); ?>"
								autocomplete="email"
								required>

							<input type="submit" name="subscribe" value="<?php esc_attr_e( 'Send', 'philosophy' ); ?>">
						</form>
					</div>
				</div>
			</div> <!-- end s-footer__subscribe -->
			<?php
			echo wp_kses_post( $args['after_widget'] );
		}

		/**
		 * Renders the widget settings form.
		 *
		 * @param array $instance Widget settings.
		 */
		public function form( $instance ) {
			$title      = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Our Newsletter', 'philosophy' );
			$desc       = isset( $instance['desc'] ) ? $instance['desc'] : '';
			$action_url = isset( $instance['actionurl'] ) ? $instance['actionurl'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'philosophy' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>"><?php esc_html_e( 'Short description:', 'philosophy' ); ?></label>
				<textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'desc' ) ); ?>"><?php echo esc_textarea( $desc ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'actionurl' ) ); ?>"><?php esc_html_e( 'Form action URL:', 'philosophy' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'actionurl' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'actionurl' ) ); ?>" type="url" value="<?php echo esc_attr( $action_url ); ?>">
				<span class="description">
					<?php esc_html_e( 'The URL your mailing list provider gives you for an embedded form, for example the action attribute of a Mailchimp embed.', 'philosophy' ); ?>
				</span>
			</p>
			<?php
		}

		/**
		 * Sanitizes the settings.
		 *
		 * @param array $new_instance Submitted settings.
		 * @param array $old_instance Previous settings.
		 *
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {
			return array(
				'title'     => isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '',
				'desc'      => isset( $new_instance['desc'] ) ? wp_kses_post( $new_instance['desc'] ) : '',
				'actionurl' => isset( $new_instance['actionurl'] ) ? esc_url_raw( $new_instance['actionurl'] ) : '',
			);
		}
	}
}

if ( ! function_exists( 'philosophy_newsletter_load_widget' ) ) {
	/**
	 * Registers the widget.
	 */
	function philosophy_newsletter_load_widget() {
		register_widget( 'philosophy_newsletter_widget' );
	}
}
add_action( 'widgets_init', 'philosophy_newsletter_load_widget' );
