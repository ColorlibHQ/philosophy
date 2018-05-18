<?php

function philosophy_customize_register( $wp_customize ) {
   	//All our sections, settings, and controls will be added here

   	//Logo 
   	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	 
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
	    'selector' => '.header__logo',
	) );

	//Theme option Settings Panel
	$wp_customize->add_panel('philosophy_theme_options',array(
	    'title'         => esc_attr__('Theme options','philosophy'),
	    'description'   => esc_attr__('All Default Settings.','philosophy'),
	    'priority'      =>2
	));

	// General Settings section
	$wp_customize->add_section( 'philosophy_general_section' , array(
		'title' => esc_html__('General','philosophy'), 
		'panel'     =>'philosophy_theme_options',
		'priority' => 1,
	));

	 // Preloader option
	$wp_customize->add_setting( 'philosophy_preloader_setting' , array(
	    'default'        => false,
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control(
			'philosophy_preloader_control',
			array(
				'type'        	 => 'checkbox',
				'label'          => esc_html__( 'Active preloader', 'philosophy' ),
				'section'        => 'philosophy_general_section',
				'settings'       => 'philosophy_preloader_setting',
				
			)
	);


	// Go to top button option
	$wp_customize->add_setting( 'philosophy_gototop_setting' , array(
	    'default'        => false,
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 
		'philosophy_gototop_control', 
		array(
			'type'        	 => 'checkbox',
			'label'          => esc_html__( 'Display go to top button', 'philosophy' ),
			'section'        => 'philosophy_general_section',
			'settings'       => 'philosophy_gototop_setting',
			
		)
	);

	$wp_customize->add_setting( 'philosophy_header_social_setting' , array(
	    'default'        => false,
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control(
			'philosophy_header_social_control', 
			array(
				'type'        => 'checkbox',
				'label'          => __( 'Header Social Icon Show', 'philosophy' ),
				'description' => esc_html__( 'Header social icon show/hide.', 'philosophy' ),
				'section'        => 'philosophy_general_section',
				'settings'       => 'philosophy_header_social_setting',
				
			)
	);
	$wp_customize->selective_refresh->add_partial( 'philosophy_header_social_setting', array(
		'selector' => '.header__social',
	) );
		
	//Banner.

	$wp_customize->add_section( 'banner_posts_section' , array(
		'title' => esc_html__('Banner','philosophy'), 
		'panel'     =>'philosophy_theme_options',
		'priority' => 1,
	));

	$wp_customize->add_setting( 'banner_posts_setting' , array(
	    'default'        => false,
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'banner_posts_control', array(
		    'label'          => __( 'Banner Enable', 'philosophy' ),
		    'description' => esc_html__( 'Recent posts banner enable / desable.', 'philosophy' ),
		    'section'        => 'banner_posts_section',
		    'settings'       => 'banner_posts_setting',
		    'type'           => 'checkbox'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'banner_posts_setting', array(
		'selector' => '.pageheader-content',
	) );

	//About page.

	$wp_customize->add_section( 'blog_page_section' , array(
		'title' => esc_html__('Blog page','philosophy'), 
		'panel'     =>'philosophy_theme_options',
		'priority' => 2,
	));

	// Blog Layout

	$wp_customize->add_setting( 'blog_sidebar_setting' , array(
		'default'    => 'masonry',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control(
	    new WP_Customize_Control(
	        $wp_customize,
	        'blog_sidebar_control',
	        array(
	            'label'          => esc_html__( 'Blog Layout', 'philosophy' ),
	            'section'        => 'blog_page_section',
	            'settings'       => 'blog_sidebar_setting',
	            'type'           => 'select',
	            'choices'        => array(
	                'masonry'   => esc_html__( 'Masonry Grid Only', 'philosophy' ),
	                'blog_with_sidebar'  => esc_html__( 'Blog with sidebar', 'philosophy' )
	            )
	        )
	    )
	);

	// Single Blog Layout

	$wp_customize->add_setting( 'single_blog_sidebar_setting' , array(
		'default'    => 'single_without_sidebar',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control(
	    new WP_Customize_Control(
	        $wp_customize,
	        'single_blog_sidebar_control',
	        array(
	            'label'          => esc_html__( 'Single Blog Layout', 'philosophy' ),
	            'section'        => 'blog_page_section',
	            'settings'       => 'single_blog_sidebar_setting',
	            'type'           => 'select',
	            'choices'        => array(
	            	'single_without_sidebar'  => esc_html__( 'Without sidebar', 'philosophy' ),
	                'single_with_sidebar'   => esc_html__( 'With Sidebar', 'philosophy' )
	                
	            )
	        )
	    )
	);


	//About page.

	$wp_customize->add_section( 'about_page_section' , array(
		'title' => esc_html__('About page','philosophy'), 
		'panel'     =>'philosophy_theme_options',
		'priority' => 2,
	));

	// About info block #1

	$wp_customize->add_setting( 'about_block_setting_title_one' , array(
		'default'    => 'Who We Are.',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'about_block_control_title_one', array(
		  'label' 	 => '1 # About info block title',
		  'section'  => 'about_page_section',
		  'settings' => 'about_block_setting_title_one',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'about_block_setting_title_one', array(
		'selector' => '.col-block-one-title',
	) );

	$wp_customize->add_setting( 'about_block_setting_content_one' , array(
		'default'	 =>	 'Lorem ipsum Nisi amet fugiat eiusmod et aliqua ad qui ut nisi Ut aute anim mollit fugiat qui sit ex occaecat et eu mollit nisi pariatur fugiat deserunt dolor veniam reprehenderit aliquip magna nisi consequat aliqua veniam in aute ullamco Duis laborum ad non pariatur sit.',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'about_block_control_one', array(
		  'label' 	 => '1 # About info block content',
		  'section'  => 'about_page_section',
		  'settings' => 'about_block_setting_content_one',
		  'type'	 => 'textarea'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'about_block_setting_content_one', array(
		'selector' => '.col-block-one-content',
	) );

	// About info block #2

	$wp_customize->add_setting( 'about_block_setting_title_two' , array(
		'default'    => 'Our Mission.',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'about_block_control_title_two', array(
		  'label' 	 => '2 # About info block title',
		  'section'  => 'about_page_section',
		  'settings' => 'about_block_setting_title_two',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'about_block_setting_title_two', array(
		'selector' => '.col-block-two-title',
	) );

	$wp_customize->add_setting( 'about_block_setting_content_two' , array(
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'about_block_control_two', array(
		  'label' 	 => '2 # About info block content',
		  'section'  => 'about_page_section',
		  'settings' => 'about_block_setting_content_two',
		  'type'	 => 'textarea'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'about_block_setting_content_two', array(
		'selector' => '.col-block-two-content',
	) );


	// About info block #3

	$wp_customize->add_setting( 'about_block_setting_title_three' , array(
		'default'    => 'Our Vision.',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'about_block_control_title_three', array(
		  'label' 	 => '3 # About info block title',
		  'section'  => 'about_page_section',
		  'settings' => 'about_block_setting_title_three',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'about_block_setting_title_three', array(
		'selector' => '.col-block-three-title',
	) );

	$wp_customize->add_setting( 'about_block_setting_content_three' , array(
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'about_block_control_three', array(
		  'label' 	 => '3 # About info block content',
		  'section'  => 'about_page_section',
		  'settings' => 'about_block_setting_content_three',
		  'type'	 => 'textarea'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'about_block_setting_content_three', array(
		'selector' => '.col-block-three-content',
	) );


	// About info block #4

	$wp_customize->add_setting( 'about_block_setting_title_four' , array(
		'default'    => 'Our Values.',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'about_block_control_title_four', array(
		  'label' 	 => '4 # About info block title',
		  'section'  => 'about_page_section',
		  'settings' => 'about_block_setting_title_four',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'about_block_setting_title_four', array(
		'selector' => '.col-block-four-title',
	) );

	$wp_customize->add_setting( 'about_block_setting_content_four' , array(
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'about_block_control_four', array(
		  'label' 	 => '4 # About info block content',
		  'section'  => 'about_page_section',
		  'settings' => 'about_block_setting_content_four',
		  'type'	 => 'textarea'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'about_block_setting_content_four', array(
		'selector' => '.col-block-four-content',
	) );


	//Contact page.

	$wp_customize->add_section( 'contact_page_section' , array(
		'title' => esc_html__('Contact page','philosophy'), 
		'panel'     =>'philosophy_theme_options',
		'priority' => 3,
	));

	// Google map marker
	$wp_customize->add_setting( 'google_map_marker' , array(
		'default'    =>  get_template_directory_uri() . '/assest/images/icon-location@2x.png',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control(
	   new WP_Customize_Image_Control( $wp_customize, 'google_map_marker_img',
	       array(
	           'label'      => __( 'Upload a marker image', 'philosophy' ),
	           'section'    => 'contact_page_section',
	           'settings'   => 'google_map_marker'
	       )
	   )
	);

	$wp_customize->selective_refresh->add_partial( 'google_map_marker', array(
		'selector' => '.gmnoprint',
	) );

	// Google map Latitude Longitute
	$wp_customize->add_setting( 'google_map_lat_setting' , array(
		'default'    => '37.422424',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'google_map_lat_setting_control', array(
		  'label' 	 => 'Latitude',
		  'section'  => 'contact_page_section',
		  'settings' => 'google_map_lat_setting',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->add_setting( 'google_map_long_setting' , array(
		'default'    => '-122.085661',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'google_map_long_setting_control', array(
		  'label' 	 => 'Longitude',
		  'section'  => 'contact_page_section',
		  'settings' => 'google_map_long_setting',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'google_map_lat_setting', array(
		'selector' => '#map-container',
	) );


	// 1 # Contact info block
	$wp_customize->add_setting( 'contact_setting_block_title_one' , array(
		'default'    => 'Where to Find Us',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'contact_block_control_one', array(
		  'label' 	 => '1 # Contact info block title',
		  'section'  => 'contact_page_section',
		  'settings' => 'contact_setting_block_title_one',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'contact_setting_block_title_one', array(
		'selector' => '.c-block-title-one',
	) );

	$wp_customize->add_setting( 'contact_setting_block_content_one' , array(
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'contact_setting_block_control_one', array(
		  'label' 	 => '1 # Contact info block content',
		  'section'  => 'contact_page_section',
		  'settings' => 'contact_setting_block_content_one',
		  'type'	 => 'textarea'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'contact_setting_block_content_one', array(
		'selector' => '.c-block-content-one',
	) );

	// 2 # Contact info block
	$wp_customize->add_setting( 'contact_setting_block_title_two' , array(
		'default'    => 'Contact Info',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'contact_block_control_two', array(
		  'label' 	 => '2 # Contact info block title',
		  'section'  => 'contact_page_section',
		  'settings' => 'contact_setting_block_title_two',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'contact_setting_block_title_two', array(
		'selector' => '.c-block-title-two',
	) );

	$wp_customize->add_setting( 'contact_setting_block_content_two' , array(
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'contact_setting_block_control_two', array(
		  'label' 	 => '2 # Contact info block content',
		  'section'  => 'contact_page_section',
		  'settings' => 'contact_setting_block_content_two',
		  'type'	 => 'textarea'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'contact_setting_block_content_two', array(
		'selector' => '.c-block-content-two',
	) );


	// Contact form
	$wp_customize->add_setting( 'contact_form_setting' , array(
		'default' 	 => '[contact-form-7 id="108" title="Philosophy"]',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'contact_form_control', array(
		  'label' 	 => 'Contact form 7 shortcode',
		  'section'  => 'contact_page_section',
		  'settings' => 'contact_form_setting',
		  'type'	 => 'textarea'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'contact_form_setting', array(
		'selector' => '.contact-form-7',
	) );


	//Theme background color
	$wp_customize->add_section( 'philosophy_bgcolor_section' , array(
		'title' => esc_html__('Background color','philosophy'), 
		'panel'     =>'philosophy_theme_options'
	));

	// navbar background color
	$wp_customize->add_setting( 'philosophy_navbar_bgcolor_setting' , array(
	    'default'   => '#151515',
	    'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'philosophy_navbar_bgcolor_control', array(
		'label'      => __( 'Header banckground', 'philosophy' ),
		'section'    => 'philosophy_bgcolor_section',
		'settings'   => 'philosophy_navbar_bgcolor_setting',
	) ) );

	$wp_customize->selective_refresh->add_partial( 'philosophy_navbar_bgcolor_setting', array(
		'selector' => '.s-pageheader',
	) );

	// content background color
	$wp_customize->add_setting( 'philosophy_content_bgcolor_setting' , array(
	    'default'   => '#f2f2f2',
	    'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'philosophy_content_bgcolor_control', array(
		'label'      => __( 'Content banckground', 'philosophy' ),
		'section'    => 'philosophy_bgcolor_section',
		'settings'   => 'philosophy_content_bgcolor_setting',
	) ) );

	$wp_customize->selective_refresh->add_partial( 'philosophy_content_bgcolor_setting', array(
		'selector' => '.s-content',
	) );

	// Comment background color
	$wp_customize->add_setting( 'philosophy_comment_bgcolor_setting' , array(
	    'default'   => '#e5e5e5',
	    'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'philosophy_comment_bgcolor_control', array(
		'label'      => __( 'Comment form banckground', 'philosophy' ),
		'section'    => 'philosophy_bgcolor_section',
		'settings'   => 'philosophy_comment_bgcolor_setting',
	) ) );

	$wp_customize->selective_refresh->add_partial( 'philosophy_comment_bgcolor_setting', array(
		'selector' => '.comments-wrap',
	) );

	// footer background color
	$wp_customize->add_setting( 'philosophy_footer_bgcolor_setting' , array(
	    'default'   => '#19191b',
	    'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'philosophy_footer_bgcolor_control', array(
		'label'      => __( 'Footer banckground', 'philosophy' ),
		'section'    => 'philosophy_bgcolor_section',
		'settings'   => 'philosophy_footer_bgcolor_setting',
	) ) );


	$wp_customize->selective_refresh->add_partial( 'philosophy_footer_bgcolor_setting', array(
		'selector' => '.s-footer',
	) );

	// Social link section
	$wp_customize->add_section( 'philosophy_social_link_section' , array(
		'title' => esc_html__('Social Link','philosophy'), 
		'panel'     =>'philosophy_theme_options'
	));
	
	/* Facebook URL */
	$wp_customize->add_setting(
		'philosophy_header_facebook_url_setting',
		array(
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback' => 'vr_sanitize_html'
		));

	$wp_customize->add_control(
		 'philosophy_header_facebook_url',
		array(
			'label'    => esc_html__( 'Facebook URL', 'philosophy' ),
			'description' => esc_html__( 'Will be displayed in the header contact bar.', 'philosophy' ),
			'section'  => 'philosophy_social_link_section',
			'settings' => 'philosophy_header_facebook_url_setting',
			'priority' => 10,
		)
	);

	$wp_customize->selective_refresh->add_partial( 'philosophy_header_facebook_url_setting', array(
		'selector' => '.header-top-facebook',
	) );

	/* Twitter URL */

	$wp_customize->add_setting(
		 'philosophy_header_twitter_url_setting',
		    array(
			 'transport'            => 'refresh', // refresh or postMessage
	         'capability'           => 'edit_theme_options',
	         'sanitize_callback' => 'vr_sanitize_html'
			));

	$wp_customize->add_control(
		 'philosophy_header_twitter_url',
		array(
			'label'   => esc_html__( 'Twitter URL', 'philosophy' ),
			'description' => esc_html__( 'Will be displayed in the header contact bar.', 'philosophy' ),
			'section' => 'philosophy_social_link_section',
			'settings'   => 'philosophy_header_twitter_url_setting',
			'priority' => 10, 
		)
	);

	$wp_customize->selective_refresh->add_partial( 'philosophy_header_twitter_url_setting', array(
		'selector' => '.header-top-twitter',
	) );


	/* Instagram URL */

	$wp_customize->add_setting(
		'philosophy_header_instagram_url_setting',
		array(
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
	        'sanitize_callback' => 'vr_sanitize_html'
		));

	$wp_customize->add_control(
		'philosophy_header_instagram_url',
		array(
			'label'   => esc_html__( 'Instagram URL', 'philosophy' ),
			'description' => esc_html__( 'Will be displayed in the header contact bar.', 'philosophy' ),
			'section' => 'philosophy_social_link_section',
			'settings'   => 'philosophy_header_instagram_url_setting',
			'priority' => 10,
		)
	);
	
	$wp_customize->selective_refresh->add_partial( 'philosophy_header_instagram_url_setting', array(
		'selector' => '.header-top-instagram',
	) );

	/* Pinterest URL */

	$wp_customize->add_setting(
		'philosophy_header_pinterest_url_setting',
		array(
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
	        'sanitize_callback' => 'vr_sanitize_html'
		));

	$wp_customize->add_control(
		'philosophy_header_pinterest_url',
		array(
			'label'   => esc_html__( 'Pinterest URL', 'philosophy' ),
			'description' => esc_html__( 'Will be displayed in the header contact bar.', 'philosophy' ),
			'section' => 'philosophy_social_link_section',
			'settings'   => 'philosophy_header_pinterest_url_setting',
			'priority' => 10,
		)
	);

	$wp_customize->selective_refresh->add_partial( 'philosophy_header_pinterest_url_setting', array(
		'selector' => '.header-top-pinterest',
	) );

	//Footer top widget

	$wp_customize->add_section( 'footer_top_section' , array(
		'title' => esc_html__('Footer top widgets','philosophy'), 
		'panel'     =>'philosophy_theme_options',
		'priority' => 9,
	));


	// Footer top widget show/hide
	$wp_customize->add_setting( 'philosophy_footer_top_enable' , array(
	    'default'        => false,
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control(
			'philosophy_preloader_control',
			array(
				'type'        	 => 'checkbox',
				'label'          => esc_html__( 'Active footer top widgets', 'philosophy' ),
				'section'        => 'footer_top_section',
				'settings'       => 'philosophy_footer_top_enable',
				
			)
	);
	
	$wp_customize->selective_refresh->add_partial( 'philosophy_footer_top_enable', array(
		'selector' => '.footer-enable',
	) );

	// Footer top block #1

	$wp_customize->add_setting( 'footer_top_setting_title_one' , array(
		'default'    => 'Popular Posts',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'footer_top_control_title_one', array(
		  'label' 	 => 'Popular post widget title',
		  'section'  => 'footer_top_section',
		  'settings' => 'footer_top_setting_title_one',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'footer_top_setting_title_one', array(
		'selector' => '.popular-post-title',
	) );

	// Post item count
	$wp_customize->add_setting( 'footer_top_setting_content_one' , array(
		'default'    => 6,
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'footer_top_control_one', array(
		  'label' 	 => 'Popular post count',
		  'section'  => 'footer_top_section',
		  'settings' => 'footer_top_setting_content_one',
		  'type'	 => 'number'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'footer_top_setting_content_one', array(
		'selector' => '.popular__posts',
	) );

	// Footer top block #2

	// About Philosophy title

	$wp_customize->add_setting( 'footer_top_setting_title_two' , array(
		'default'    => 'About Philosophy',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'footer_top_control_title_two', array(
		  'label' 	 => 'About post widget title',
		  'section'  => 'footer_top_section',
		  'settings' => 'footer_top_setting_title_two',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'footer_top_setting_title_two', array(
		'selector' => '.about-post-title',
	) );

	// About Philosophy content

	$wp_customize->add_setting( 'footer_top_setting_content_two' , array(
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'footer_top_control_content_two', array(
		  'label' 	 => 'About post widget content',
		  'section'  => 'footer_top_section',
		  'settings' => 'footer_top_setting_content_two',
		  'type'	 => 'textarea'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'footer_top_setting_content_two', array(
		'selector' => '.about-post-content',
	) );

	// About Philosophy social link

	$wp_customize->add_setting( 'footer_top_setting_social_two' , array(
	    'default'        => false,
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control(
			'footer_top_social_control', 
			array(
				'type'        => 'checkbox',
				'label'          => __( 'About Philosophy Social Icon', 'philosophy' ),
				'description' => esc_html__( 'About Philosophy social icon show/hide.', 'philosophy' ),
				'section'        => 'footer_top_section',
				'settings'       => 'footer_top_setting_social_two',
				
			)
	);
	$wp_customize->selective_refresh->add_partial( 'footer_top_setting_social_two', array(
		'selector' => '.about__social',
	) );


	// Footer top block #3

	// Tags title

	$wp_customize->add_setting( 'footer_top_setting_title_three' , array(
		'default'    => 'Tags',
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'footer_top_control_title_three', array(
		  'label' 	 => 'Tags widget title',
		  'section'  => 'footer_top_section',
		  'settings' => 'footer_top_setting_title_three',
		  'type'	 => 'text'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'footer_top_setting_title_three', array(
		'selector' => '.tags-widget-title',
	) );

	// Tag item count
	$wp_customize->add_setting( 'footer_top_setting_tag_count' , array(
		'default'    => 11,
		'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'footer_top_control_tag_count', array(
		  'label' 	 => 'Tag count',
		  'section'  => 'footer_top_section',
		  'settings' => 'footer_top_setting_tag_count',
		  'type'	 => 'number'
	    )
	);

	$wp_customize->selective_refresh->add_partial( 'footer_top_setting_tag_count', array(
		'selector' => '.tagcloud',
	) );

	//Footer Copyright Text 

	$wp_customize->add_section( 'footer_copyright_text_section' , array(
		'title' => esc_html__('Footer copyright text', 'philosophy' ), 
		'panel'     =>'philosophy_theme_options'
	));

	$footer_default = '&copy; Copyright Philosophy 2018 Theme by <a href="#">Colorlib</a>';
	$wp_customize->add_setting( 'footer_copyright_text_setting' , array(
	    'default'     => 	$footer_default,
	    'transport'            => 'refresh', // refresh or postMessage
        'capability'           => 'edit_theme_options',
		'sanitize_callback' => 'vr_sanitize_html'
	) );

	$wp_customize->add_control( 'cd_button_display', array(
	  'label' 	 => 'Change copyright text',
	  'section'  => 'footer_copyright_text_section',
	  'settings' => 'footer_copyright_text_setting',
	  'type'	 => 'textarea'

	) );

	$wp_customize->selective_refresh->add_partial( 'footer_copyright_text_setting', array(
		'selector' => '.s-footer__copyright span',
	) );


}
add_action( 'customize_register', 'philosophy_customize_register' );


