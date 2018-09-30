<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Post_Generator
 */
class Epsilon_Post_Generator {
	/**
	 * Posts array
	 *
	 * @var int
	 */
	public $posts = array();
	/**
	 * @var array
	 */
	public $specific_images = array();

	/**
	 * Epsilon_Post_Generator constructor.
	 *
	 * @param array $posts
	 */
	public function __construct(
		$posts = array(
			'post_count'      => 4,
			'image_size'      => array(),
			'image_category'  => array( 'dogs' ),
			'specific_images' => array(),
		)
	) {
		$this->posts = $posts;
		if ( ! empty( $this->posts['specific_images'] ) ) {
			$this->specific_images = $this->posts['specific_images'];
		}
	}

	/**
	 * Start adding posts to WP
	 *
	 */
	public function add_posts() {
		// Post Tags
		$set_tag = array( 'Salad', 'Recipe', 'Places', 'Tips', 'Friends', 'Travel', 'Exercise','Reading' );

		//
		$posts = array();
		for ( $i = 0; $i < $this->posts['post_count']; $i ++ ) {
			$post = $this->generate_post();
			if ( ! is_wp_error( $post ) ) {
				$posts[] = $post;

				if( !empty( $set_tag[$i] ) ){
					wp_set_post_tags( $post, $set_tag[$i], true );
				}

			}


			if ( empty( $this->specific_images ) ) {
				$this->generate_image( $post,
				                       $this->posts['image_size'],
				                       '',
				                       array(
					                       'category' => $this->posts['image_category'],
				                       ) );
			} else {
				$this->generate_specific_image(
					$post,
					$this->posts['image_size'],
					'',
					$this->specific_images[ $i ]
				);
			}

		}

		// page add
		$pages = $this->add_pages();
		if( !$pages ){
			return false;
		}


		return true;
	}

	/**
	 * Start adding pages to WP
	 *
	 */
	public function add_pages() {

		$pagenames = array( 'contact', 'about' );
		$pagetemp = array( 'page-contact.php', 'page-about.php' );

		$pages = array();
		for ( $i = 0; $i < count( $pagenames ); $i ++ ) {
			$page = $this->generate_page( $pagenames[$i] );
			if ( ! is_wp_error( $page ) ) {
				$pages[] = $page;

				update_post_meta( $page, '_wp_page_template', $pagetemp[$i] );
			}


			if ( empty( $this->specific_images ) ) {
				$this->generate_image( $page,
				                       $this->posts['image_size'],
				                       '',
				                       array(
					                       'category' => $this->posts['image_category'],
				                       ) );
			} else {
				$this->generate_specific_image(
					$page,
					$this->posts['image_size'],
					'',
					$this->specific_images[ $i ]
				);
			}

		}

		return true;
	}

	/**
	 * Run this function to generate a new post
	 *
	 */
	private function generate_post() {
		$generator = new Epsilon_Text_Generator();

		$post = array(
			'post_title'   => ucfirst( $generator->words( 5 ) ),
			'post_content' => $generator->paragraphs( 1, 'p' ) . "\n" . '<!--more-->' . "\n" . $generator->paragraphs( 3, 'p' ),
			'post_status'  => 'publish',
		);


		return wp_insert_post( $post );
	}
	/**
	 * Run this function to generate a new page
	 *
	 */
	private function generate_page( $page_name ) {
		$generator = new Epsilon_Text_Generator();

		$page = array(
			'post_title'   => $page_name,
			'post_type'	   => 'page',
			'post_content' => $generator->paragraphs( 1, 'p' ) . "\n" . '<!--more-->' . "\n" . $generator->paragraphs( 3, 'p' ),
			'post_status'  => 'publish',
		);


		return wp_insert_post( $page );
	}

	/**
	 * @param        $post_id
	 * @param array  $sizes
	 * @param string $description
	 * @param array  $options
	 */
	private function generate_specific_image( $post_id, $sizes = array(), $description = '', $options = array() ) {
		$image = new Epsilon_Image_Generator( $post_id, $sizes, $description, $options );
		$image->generate_featured_image();
	}

	/**
	 * Run this function to generate an image and assign it to a post
	 *
	 * @param        $post_id
	 * @param array  $sizes
	 * @param string $description
	 * @param array  $options
	 */
	private function generate_image( $post_id, $sizes = array(), $description = '', $options = array() ) {
		$image = new Epsilon_Image_Generator( $post_id, $sizes, $description, $options );
		$image->generate_featured_image();
	}
}
