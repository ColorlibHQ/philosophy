<?php
/**
 * @version  1.0
 * @package  Philosophy
 *
 */
 
 
/**************************************
*Creating Newsletter Widget
***************************************/
 
class philosophy_newsletter_widget extends WP_Widget {


function __construct() {

parent::__construct(
// Base ID of your widget
'philosophy_newsletter_widget',


// Widget name will appear in UI
esc_html__( 'OUR NEWSLETTER', 'philosophy' ), 

// Widget description
array( 'description' => esc_html__( 'Add footer newsletter signup form.', 'philosophy' ), ) 
);

}

// This is where the action happens
public function widget( $args, $instance ) {
	
$title 		= apply_filters( 'widget_title', $instance['title'] );
$desc 		= apply_filters( 'widget_desc', $instance['desc'] );
$actionurl 	= apply_filters( 'widget_actionurl', $instance['actionurl'] );

// mc validation
 wp_enqueue_script( 'mc-validate', '//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js' );

// before and after widget arguments are defined by themes
echo wp_kses_post( $args['before_widget'] );
if ( ! empty( $title ) )
echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
    
?>


<div class="s-footer__subscribe">
	<?php 
	//
	if( $desc ){
		echo '<p>'.wp_kses_post( $desc ).'</p>';
	}
	?>

    <div class="subscribe-form">
    <div id="mc-form">
        <form id="mc-embedded-subscribe-form" class="group validate" name="mc-embedded-subscribe-form" method="post" action="<?php echo esc_url( $actionurl ); ?>" target="_blank" novalidate>

            <input type="email" name="EMAIL" class="email required" id="mce-EMAIL" placeholder="<?php esc_html_e( 'Email Address', 'philosophy' ); ?>" required>

            <input type="submit" id="mc-embedded-subscribe" name="subscribe" value="<?php esc_html_e( 'Send', 'philosophy' ); ?>">

            <div id="mce-responses" class="clear">
                <div class="response" id="mce-error-response" style="display:none"></div>
                <div class="response" id="mce-success-response" style="display:none"></div>
            </div>
        </form>
    </div>
    </div>
</div> <!-- end s-footer__subscribe -->

<?php
echo wp_kses_post( $args['after_widget'] );
}
		
// Widget Backend 
public function form( $instance ) {
	
if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
}else {
	$title = esc_html__( 'OUR NEWSLETTER', 'philosophy' );
}


//	Url
if ( isset( $instance[ 'actionurl' ] ) ) {
	$actionurl = $instance[ 'actionurl' ];
}else {
	$actionurl = '';
}
//	Text Area
if ( isset( $instance[ 'desc' ] ) ) {
	$desc = $instance[ 'desc' ];
}else {
	$desc = '';
}


// Widget admin form
?>
<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ,'philosophy'); ?></label> 
<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>"><?php esc_html_e( 'Short Description:' ,'philosophy'); ?></label> 
<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'desc' ) ); ?>"><?php echo esc_textarea( $desc ); ?></textarea>
</p>
<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'actionurl' ) ); ?>"><?php esc_html_e( 'Action URL:' ,'philosophy'); ?></label>
<?php 
$url = 'http://docs.creativegigs.net/docs/aproch/how-to-use-optin-form/how-to-locate-mailchimp-newsletter-form-action-url/';
?>
<p><?php echo sprintf( __( 'Enter here your MailChimp action URL. %s %s %s', 'philosophy' ), '<a href="'.esc_url( $url ).'" target="_blank">', esc_html__( 'How to', 'philosophy' ), '</a>' ); ?></p>

<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'actionurl' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'actionurl' ) ); ?>" type="text" value="<?php echo esc_attr( $actionurl ); ?>" />
</p>

<?php 
}

	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {

	
$instance = array();
$instance['title'] 	  = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['actionurl'] = ( ! empty( $new_instance['actionurl'] ) ) ? strip_tags( $new_instance['actionurl'] ) : '';
$instance['desc'] = ( ! empty( $new_instance['desc'] ) ) ? strip_tags( $new_instance['desc'] ) : '';

return $instance;

}

} // Class philosophy_newsletter_widget ends here


// Register and load the widget
function philosophy_newsletter_load_widget() {
	register_widget( 'philosophy_newsletter_widget' );
}
add_action( 'widgets_init', 'philosophy_newsletter_load_widget' );