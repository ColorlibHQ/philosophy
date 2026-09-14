<?php
/**
 * Popular posts widget.
 *
 * @package Philosophy
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'philosophy_popular_post_widget' ) ) {

	/**
	 * Class philosophy_popular_post_widget
	 */
	class philosophy_popular_post_widget extends WP_Widget {

		/**
		 * Registers the widget.
		 */
		public function __construct() {
			parent::__construct(
				'philosophy_popular_post_widget',
				esc_html__( '[ Philosophy ] Popular Blog Post', 'philosophy' ),
				array(
					'description' => esc_html__( 'Shows the most viewed posts.', 'philosophy' ),
					'classname'   => 'philosophy-popular-post-widget',
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
			$title = isset( $instance['sectiontitle'] ) ? $instance['sectiontitle'] : '';
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

			$number = isset( $instance['postnumber'] ) ? absint( $instance['postnumber'] ) : 3;

			if ( ! $number ) {
				$number = 3;
			}

			/*
			 * A bare `meta_key` restricts the query to posts that already carry
			 * the view counter, so a site where three posts had ever been read
			 * showed three posts and no more, however many the widget asked
			 * for. The OR clause keeps the unread ones in, after the read ones.
			 */
			$query = new WP_Query(
				array(
					'posts_per_page'      => $number,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
					'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
						'relation' => 'OR',
						'viewed'   => array(
							'key'     => 'philosophy_post_views_count',
							'compare' => 'EXISTS',
							'type'    => 'NUMERIC',
						),
						'unviewed' => array(
							'key'     => 'philosophy_post_views_count',
							'compare' => 'NOT EXISTS',
						),
					),
					'orderby'             => array(
						'viewed' => 'DESC',
						'date'   => 'DESC',
					),
				)
			);

			if ( ! $query->have_posts() ) {
				return;
			}

			echo wp_kses_post( $args['before_widget'] );

			if ( $title ) {
				echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
			}
			?>
			<div class="block-1-2 block-m-full popular__posts">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					?>
					<article class="col-block popular__post">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="popular__thumb" tabindex="-1" aria-hidden="true">
								<?php the_post_thumbnail( 'medium' ); ?>
							</a>
						<?php endif; ?>

						<?php the_title( sprintf( '<h3 class="popular__title"><a href="%s">', esc_url( get_the_permalink() ) ), '</a></h3>' ); ?>

						<div class="popular__meta">
							<span class="popular__author">
								<span><?php esc_html_e( 'By', 'philosophy' ); ?></span>
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
							</span>
							<span class="popular__date">
								<span><?php esc_html_e( 'on', 'philosophy' ); ?></span>
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</span>
						</div>
					</article>
					<?php
				endwhile;

				wp_reset_postdata();
				?>
			</div> <!-- end popular_posts -->
			<?php
			echo wp_kses_post( $args['after_widget'] );
		}

		/**
		 * Renders the widget settings form.
		 *
		 * @param array $instance Widget settings.
		 */
		public function form( $instance ) {
			$title  = isset( $instance['sectiontitle'] ) ? $instance['sectiontitle'] : '';
			$number = isset( $instance['postnumber'] ) ? absint( $instance['postnumber'] ) : 3;
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'sectiontitle' ) ); ?>"><?php esc_html_e( 'Title:', 'philosophy' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sectiontitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sectiontitle' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'postnumber' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'philosophy' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'postnumber' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'postnumber' ) ); ?>" type="number" min="1" max="20" step="1" value="<?php echo esc_attr( $number ); ?>">
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
			$number = isset( $new_instance['postnumber'] ) ? absint( $new_instance['postnumber'] ) : 3;

			return array(
				'sectiontitle' => isset( $new_instance['sectiontitle'] ) ? sanitize_text_field( $new_instance['sectiontitle'] ) : '',
				'postnumber'   => min( 20, max( 1, $number ) ),
			);
		}
	}
}

if ( ! function_exists( 'philosophy_popular_post_load_widget' ) ) {
	/**
	 * Registers the widget.
	 */
	function philosophy_popular_post_load_widget() {
		register_widget( 'philosophy_popular_post_widget' );
	}
}
add_action( 'widgets_init', 'philosophy_popular_post_load_widget' );
