<?php 
// Block direct access
if( !defined( 'ABSPATH' ) ){
	exit( 'Direct script access denied.' );
}
/**
 * @Packge 	   : Philosophy
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
	
	function themeslug_customize_register( $wp_customize ) {
	
		// Add Theme option panel
		$wp_customize->add_panel( 'philosophy_options_panel',
		  array(
			  'priority'       => 24,
			  'capability'     => 'edit_theme_options',
			  'theme_supports' => '',
			  'title'          => esc_html__( 'Theme options', 'philosophy' )
		  )
		);
	   	   
		/**************************
			General Section
		***************************/
		
		$wp_customize->add_section( 'philosophy_general_options_section', 
			array(
				'title'       => esc_html__( 'General', 'philosophy' ), 
				'priority'    => 35,
				'capability'  => 'edit_theme_options', 
				'panel'    	  => 'philosophy_options_panel',
			) 
		);
         		
		// Preloader option add settings
		$wp_customize->add_setting( 'philosophy-preloader-toggle-settings',
			array(
				'default'    => '', 
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'refresh',
				'sanitize_callback'	=> 'philosophy_sanitize_checkbox' 
			) 
		); 
		// Preloader option add control
		$wp_customize->add_control(
			new Epsilon_Control_Toggle(
				$wp_customize,
				'philosophy_enable_preloader',
				array(
					'type'        => 'epsilon-toggle',
					'label'       => esc_html__( 'Preloader On/Off', 'philosophy' ),
					'settings'   => 'philosophy-preloader-toggle-settings',
					'description' => esc_html__( 'Toggle the preloader active.', 'philosophy' ),
					'section'     => 'philosophy_general_options_section',
				)
			)
		);
        
       	//  = Preloader Background Color Picker
		
		$wp_customize->add_setting('philosophy_preloaderbgcolor', array(
			'default'           => '#211b31',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
			$wp_customize, 
			'philosophy_preloaderbgcolor_ctrl', 
			array(
			'label'    => esc_html__('Preloader Background Color', 'philosophy'),
			'section'  => 'philosophy_general_options_section',
			'settings' => 'philosophy_preloaderbgcolor',
		)));

       	//  = Preloader boder Color Picker
		$wp_customize->add_setting('philosophy_preloaderbordercolor', array(
			'default'           => '#211b31',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
			$wp_customize, 
			'philosophy_preloaderbordercolor_ctrl', 
			array(
			'label'    => esc_html__('Preloader Color', 'philosophy'),
			'section'  => 'philosophy_general_options_section',
			'settings' => 'philosophy_preloaderbordercolor',
		)));
      	
      	// Back to top option add settings
		$wp_customize->add_setting( 'philosophy-backtop-toggle-settings',
			array(
				'default'    => '', 
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'refresh',
				'sanitize_callback'	=> 'philosophy_sanitize_checkbox' 
			) 
		); 
		// Back to top option add control
		$wp_customize->add_control(
			new Epsilon_Control_Toggle(
				$wp_customize,
				'philosophy_enable_backtop',
				array(
					'type'        => 'epsilon-toggle',
					'label'       => esc_html__( 'Back to top Button Show/Hide', 'philosophy' ),
					'settings'   => 'philosophy-backtop-toggle-settings',
					'description' => esc_html__( 'Toggle the Back to top button show.', 'philosophy' ),
					'section'     => 'philosophy_general_options_section',
				)
			)
		);
        
       	//  = Back to top button Background Color Picker
		
		$wp_customize->add_setting('philosophy_backtopbgcolor', array(
			'default'           => '#000000',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
			$wp_customize, 
			'philosophy_backtopbgcolor_ctrl',
			array(
			'label'    => esc_html__('Back To Top Background Color', 'philosophy'),
			'section'  => 'philosophy_general_options_section',
			'settings' => 'philosophy_backtopbgcolor',
		)));

       	//  = Back to top hover background Color Picker
		$wp_customize->add_setting('philosophy_backtophovbgcolor', array(
			'default'           => '#0054a5',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
			$wp_customize, 
			'philosophy_backtophovbgcolor_ctrl', 
			array(
			'label'    => esc_html__('Back Top Hover Background Color', 'philosophy'),
			'section'  => 'philosophy_general_options_section',
			'settings' => 'philosophy_backtophovbgcolor',
		)));
      	
		// Map Api option add settings
		$wp_customize->add_setting('philosophy_map_apikey', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'theme_mod',
			'transport'  	 => 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_nohtml'
	 
		));
		
		// Map Api control
		$wp_customize->add_control('philosophy_map_apikey_ctrl', array(
			'label'      => esc_html__( 'Google Map Api Key', 'philosophy' ),
			'section'    => 'philosophy_general_options_section',
			'settings'   => 'philosophy_map_apikey',
		));		
		/**************************
			Header Menu Section
		***************************/
		
		$wp_customize->add_section( 'philosophy_headertop_options_section', 
			array(
				'title'       => esc_html__( 'Header Settings', 'philosophy' ), 
				'priority'    => 35,
				'capability'  => 'edit_theme_options', 
				'panel'    	  => 'philosophy_options_panel',
				'description' => esc_html__('Allows you to settings header top elements.', 'philosophy'), 
			) 
		);
		
		//  ======+++++=================================
		//  = Header top search form show / Hide opt =
		//  =================+++++======================
		
		$wp_customize->add_setting( 'philosophy-searchopt-toggle-settings',
			array(
				'default'    => false, 
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'refresh',
				'sanitize_callback' => 'philosophy_sanitize_checkbox'
			) 
		); 
		
		$wp_customize->add_control(
			new Epsilon_Control_Toggle(
				$wp_customize,
				'philosophy_enable_searchopt',
				array(
					'type'        => 'epsilon-toggle',
					'label'       => esc_html__( 'Header Search Option Show/Hide', 'philosophy' ),
					'settings'   => 'philosophy-searchopt-toggle-settings',
					'section'     => 'philosophy_headertop_options_section',
				)
			)
		);
		
		//  ======+++++=================================
		//  = Header top social icon show/Hide opt =
		//  =================+++++======================
		
		$wp_customize->add_setting( 'philosophy-socialicon-toggle-settings',
			array(
				'default'    => false, 
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'refresh',
				'sanitize_callback' => 'philosophy_sanitize_checkbox'
			) 
		); 
		
		$wp_customize->add_control(
			new Epsilon_Control_Toggle(
				$wp_customize,
				'philosophy_enable_socialicon',
				array(
					'type'        => 'epsilon-toggle',
					'label'       => esc_html__( 'Header Social Icon Show/Hide', 'philosophy' ),
					'settings'   => 'philosophy-socialicon-toggle-settings',
					'section'     => 'philosophy_headertop_options_section',
				)
			)
		);
		
		//  =====================================================
		//  = Header Nav Bar Background Color Picker   =
		//  =====================================================
		$wp_customize->add_setting('philosophy_header_navbar_bgColor', array(
			'default'           => '#151515',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_navbar_bgColor', 
			array(
			'label'    => esc_html__('Header Background Color', 'philosophy'),
			'section'  => 'philosophy_headertop_options_section',
			'settings' => 'philosophy_header_navbar_bgColor',
		)));
		
		//  ==============================================
		//  	= Header Top Color Picker   =
		//  ==============================================
		$wp_customize->add_setting('philosophy_header_top_color', array(
			'default'           => '#fff',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_top_color', 
			array(
			'label'    => esc_html__('Header Top Color', 'philosophy'),
			'section'  => 'philosophy_headertop_options_section',
			'settings' => 'philosophy_header_top_color',
		)));

		
		//  ==============================================
		//  	= Header Nav Bar Menu Color Picker   =
		//  ==============================================
		$wp_customize->add_setting('philosophy_header_navbar_menuColor', array(
			'default'           => '#b5b3b3',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_navbar_menuColor', 
			array(
			'label'    => esc_html__('Header Nav Bar Menu Color', 'philosophy'),
			'section'  => 'philosophy_headertop_options_section',
			'settings' => 'philosophy_header_navbar_menuColor',
		)));

		//  ===================================================
		//  	= Header Nav Bar Menu Hover Color Picker   =
		//  ===================================================
		$wp_customize->add_setting('philosophy_header_navbar_menuHovColor', array(
			'default'           => '#ffffff',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_navbar_menuHoverColor', 
			array(
			'label'    => esc_html__('Header Nav Bar Menu Hover Color', 'philosophy'),
			'section'  => 'philosophy_headertop_options_section',
			'settings' => 'philosophy_header_navbar_menuHovColor',
		)));
		
		//  ===================================================
		//  	= Header Dropdown Menu bg Color Picker   =
		//  ===================================================
		$wp_customize->add_setting('philosophy_header_drop_menubg_color', array(
			'default'           => '#050505',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_drop_menubg_color', 
			array(
			'label'    => esc_html__('Dropdown Menu Background Color', 'philosophy'),
			'section'  => 'philosophy_headertop_options_section',
			'settings' => 'philosophy_header_drop_menubg_color',
		)));

		//  ===================================================
		//  	= Header Dropdown Menu Color Picker   =
		//  ===================================================
		$wp_customize->add_setting('philosophy_header_drop_menu_color', array(
			'default'           => '#b5b3b3',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_drop_menu_ctrl', 
			array(
			'label'    => esc_html__(' Dropdown Menu Color', 'philosophy'),
			'section'  => 'philosophy_headertop_options_section',
			'settings' => 'philosophy_header_drop_menu_color',
		)));

		//  ===================================================
		//  	= Header Dropdown Menu Hover Color Picker =
		//  ===================================================
		$wp_customize->add_setting('philosophy_header_drop_menuhov_color', array(
			'default'           => '#ffffff',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
	 
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_drop_menuohver_ctrl', 
			array(
			'label'    => esc_html__(' Dropdown Menu Hover Color', 'philosophy'),
			'section'  => 'philosophy_headertop_options_section',
			'settings' => 'philosophy_header_drop_menuhov_color',
		)));
	        	

		/**************************
			Blog Section
		***************************/

		$wp_customize->add_section( 'philosophy_blog_options_section', 
			array(
				'title'       => esc_html__( 'Blog', 'philosophy' ), 
				'priority'    => 36,
				'capability'  => 'edit_theme_options', 
				'panel'    	  => 'philosophy_options_panel',
				'description' => esc_html__('Allows you to settings for blog post excerpt and sidebar position.', 'philosophy'), 
			) 
		);

		// Features section option add settings
		$wp_customize->add_setting( 'philosophy-featureblog-toggle-settings',
			array(
				'default'    => '', 
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'refresh',
				'sanitize_callback'	=> 'philosophy_sanitize_checkbox' 
			) 
		); 
		// Features section option add control
		$wp_customize->add_control(
			new Epsilon_Control_Toggle(
				$wp_customize,
				'philosophy_enable_featureblog',
				array(
					'type'        => 'epsilon-toggle',
					'label'       => esc_html__( 'Home Features Blog Section Show/Hide', 'philosophy' ),
					'settings'   => 'philosophy-featureblog-toggle-settings',
					'section'     => 'philosophy_blog_options_section',
				)
			)
		);

        // Post excerpt	settings
		$wp_customize->add_setting('philosophy_post_excerpt', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'theme_mod',
			'sanitize_callback' => 'philosophy_sanitize_number_absint'
	 
		));
		// Post excerpt	control
		$wp_customize->add_control('philosophy_post_excerpt_ctrl', array(
			'label'      => esc_html__('Set Post Excerpt', 'philosophy'),
			'section'    => 'philosophy_blog_options_section',
			'settings'   => 'philosophy_post_excerpt',
		));	
		// blog sidebar settings
		$wp_customize->add_setting( 'philosophy-blog-sidebar-settings',
			array(
				'default'    => '', 
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'refresh',
				'sanitize_callback' => 'wp_kses_post'
			) 
		); 
		// Blog sidebar control
		$wp_customize->add_control(
			new Epsilon_Control_Layouts(
				$wp_customize,
				'philosophy_blog_sidebar_position',
				array(
					'type'        => 'epsilon-layouts',
					'label'       => esc_html__( 'Blog Sidebar Layout', 'philosophy' ),
					'settings'    => 'philosophy-blog-sidebar-settings',
					'section'     => 'philosophy_blog_options_section',
					'layouts'  => array(
						1 => PHILOSOPHY_DIR_URI . 'inc/philosophy-framework/epsilon-framework/assets/img/one-column.png',
						2 => PHILOSOPHY_DIR_URI . 'inc/philosophy-framework/epsilon-framework/assets/img/epsilon-section-titleright.jpg',
						3 => PHILOSOPHY_DIR_URI . 'inc/philosophy-framework/epsilon-framework/assets/img/epsilon-section-titleleft.jpg',
					),
					'default'  => array(
						'columnsCount' => 2,
					),
					'min_span' => 4,
					'fixed'    => true,
				)
			)
		);
		$wp_customize->add_setting( 'philosophy_archive_pageheader_content' , array(
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'philosophy_sanitize_html'
		) );

		$wp_customize->add_control( 
			new Epsilon_Control_Text_Editor( 
				$wp_customize, 
				'philosophy_archive_pageheader_content_ctrl', 
				array(
					'label' 	 => esc_html__( 'Archive page header content', 'philosophy' ),
					'section'  	 => 'philosophy_blog_options_section',
					'settings' 	 => 'philosophy_archive_pageheader_content',
					'type'       => 'epsilon-text-editor',
				)
		));
		$wp_customize->add_setting( 'philosophy_search_pageheader_content' , array(
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'philosophy_sanitize_html'
		) );

		$wp_customize->add_control( 
			new Epsilon_Control_Text_Editor( 
				$wp_customize, 
				'philosophy_search_pageheader_content_ctrl', 
				array(
					'label' 	 => esc_html__( 'Search page header content', 'philosophy' ),
					'section'  	 => 'philosophy_blog_options_section',
					'settings' 	 => 'philosophy_search_pageheader_content',
					'type'       => 'epsilon-text-editor',
				)
		));
		/**************************
			About Page
		***************************/

		$wp_customize->add_section( 'philosophy_about_page_section' , array(
			'title' 		=> esc_html__( 'About page','philosophy' ), 
			'panel'     	=>'philosophy_options_panel',
			'priority' 		=> 37,
		));
		// Title #1
		$wp_customize->add_setting( 'philosophy_about_page_top_title' , array(
			'default'    		   => esc_html__( 'Learn More About Us.', 'philosophy' ),
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'philosophy_about_page_top_title_ctrl', array(
			  'label' 	 => esc_html__( 'Page Top Title', 'philosophy' ),
			  'section'  => 'philosophy_about_page_section',
			  'settings' => 'philosophy_about_page_top_title',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_about_block_setting_title_one', array(
			'selector' => '.col-block-one-title',
		) );

		// About info block #1

		$wp_customize->add_setting( 'philosophy_about_block_setting_title_one' , array(
			'default'    			=> esc_html__( 'Who We Are.', 'philosophy' ),
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'philosophy_about_block_control_title_one', array(
			  'label' 	 => esc_html__( '1 # About info block title', 'philosophy' ),
			  'section'  => 'philosophy_about_page_section',
			  'settings' => 'philosophy_about_block_setting_title_one',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_about_block_setting_title_one', array(
			'selector' => '.col-block-one-title',
		) );

		$wp_customize->add_setting( 'philosophy_about_block_setting_content_one' , array(
			'default'	 		=>	 'Lorem ipsum Nisi amet fugiat eiusmod et aliqua ad qui ut nisi Ut aute anim mollit fugiat qui sit ex occaecat et eu mollit nisi pariatur fugiat deserunt dolor veniam reprehenderit aliquip magna nisi consequat aliqua veniam in aute ullamco Duis laborum ad non pariatur sit.',
			'transport'         => 'refresh', // refresh or postMessage
	        'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'philosophy_sanitize_html'
		) );

		$wp_customize->add_control( new Epsilon_Control_Text_Editor( 
			$wp_customize, 
			'philosophy_about_block_control_one', 
			array(
				'label'    => esc_html__( '1 # About info block content', 'philosophy' ),
				'section'  => 'philosophy_about_page_section',
				'settings' => 'philosophy_about_block_setting_content_one',
				'type'     => 'epsilon-text-editor',
		    )
		));

		$wp_customize->selective_refresh->add_partial( 'philosophy_about_block_setting_content_one', array(
			'selector' => '.col-block-one-content',
		) );

		// About info block #2

		$wp_customize->add_setting( 'philosophy_about_block_setting_title_two' , array(
			'default'    		   => 'Our Mission.',
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'philosophy_about_block_control_title_two', array(
			  'label' 	 => esc_html__( '2 # About info block title', 'philosophy' ),
			  'section'  => 'philosophy_about_page_section',
			  'settings' => 'philosophy_about_block_setting_title_two',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_about_block_setting_title_two', array(
			'selector' => '.col-block-two-title',
		) );

		$wp_customize->add_setting( 'philosophy_about_block_setting_content_two' , array(
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback' => 'philosophy_sanitize_html'
		) );

		$wp_customize->add_control( new Epsilon_Control_Text_Editor( 
			$wp_customize, 
			'philosophy_about_block_control_two', 
			array(
					'label'    => esc_html__( '2 # About info block content', 'philosophy' ),
					'section'  => 'philosophy_about_page_section',
					'settings' => 'philosophy_about_block_setting_content_two',
					'type'     => 'epsilon-text-editor',
				)
		));


		$wp_customize->selective_refresh->add_partial( 'philosophy_about_block_setting_content_two', array(
			'selector' => '.col-block-two-content',
		) );


		// About info block #3

		$wp_customize->add_setting( 'philosophy_about_block_setting_title_three' , array(
			'default'    			=> 'Our Vision.',
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'about_block_control_title_three', array(
			  'label' 	 => esc_html__( '3 # About info block title', 'philosophy' ),
			  'section'  => 'philosophy_about_page_section',
			  'settings' => 'philosophy_about_block_setting_title_three',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_about_block_setting_title_three', array(
			'selector' => '.col-block-three-title',
		) );

		$wp_customize->add_setting( 'philosophy_about_block_setting_content_three' , array(
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_html'
		) );

		$wp_customize->add_control( new Epsilon_Control_Text_Editor( 
			$wp_customize,
			'philosophy_about_block_control_three', 
			array(
				'label' 	 => esc_html__( '3 # About info block content', 'philosophy' ),
				'section'  	 => 'philosophy_about_page_section',
				'settings' 	 => 'philosophy_about_block_setting_content_three',
				'type'	 	 => 'epsilon-text-editor'
		    )
		));

		$wp_customize->selective_refresh->add_partial( 'philosophy_about_block_setting_content_three', array(
			'selector' => '.col-block-three-content',
		) );


		// About info block #4

		$wp_customize->add_setting( 'philosophy_about_block_setting_title_four' , array(
			'default'    			=> 'Our Values.',
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'philosophy_about_block_control_title_four', array(
			  'label' 	 => esc_html__( '4 # About info block title', 'philosophy' ),
			  'section'  => 'philosophy_about_page_section',
			  'settings' => 'philosophy_about_block_setting_title_four',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_about_block_setting_title_four', array(
			'selector' => '.col-block-four-title',
		) );

		$wp_customize->add_setting( 'philosophy_about_block_setting_content_four' , array(
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_html'
		) );

		$wp_customize->add_control( new Epsilon_Control_Text_Editor( 
			$wp_customize, 
			'about_block_control_four', 
			array(
				'label' 	=> esc_html__( '4 # About info block content', 'philosophy' ),
				'section'  	=> 'philosophy_about_page_section',
				'settings' 	=> 'philosophy_about_block_setting_content_four',
				'type'     	=> 'epsilon-text-editor',
		    )
		));

		$wp_customize->selective_refresh->add_partial( 'philosophy_about_block_setting_content_four', array(
			'selector' => '.col-block-four-content',
		) );


		/**************************
			Contact Page
		***************************/

		$wp_customize->add_section( 'philosophy_contact_page_section' , array(
			'title' 	=> esc_html__('Contact page','philosophy'), 
			'panel'     =>'philosophy_options_panel',
			'priority' 	=> 38,
		));
		// 1 # Contact info block
		$wp_customize->add_setting( 'philosophy_contact_setting_page_title' , array(
			'default'    			=> 'Feel Free To Contact Us.',
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'philosophy_contact_pagetitle_control', array(
			  'label' 	 => esc_html__( 'Page Top Title', 'philosophy' ),
			  'section'  => 'philosophy_contact_page_section',
			  'settings' => 'philosophy_contact_setting_page_title',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_contact_setting_page_title', array(
			'selector' => '.c-block-title-one',
		) );
		// Google map marker
		$wp_customize->add_setting( 'philosophy_google_map_marker' , array(
			'default'    			=>  esc_url( PHILOSOPHY_DIR_URI . '/img/icon-location@2x.png' ),
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_image'
		) );

		$wp_customize->add_control(
		   new WP_Customize_Image_Control( $wp_customize, 'google_map_marker_img',
		       array(
		           'label'      => esc_html__( 'Upload a marker image', 'philosophy' ),
		           'section'    => 'philosophy_contact_page_section',
		           'settings'   => 'philosophy_google_map_marker'
		       )
		   )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_google_map_marker', array(
			'selector' => '.gmnoprint',
		) );

		// Google map Latitude Longitute
		$wp_customize->add_setting( 'philosophy_google_map_lat_setting' , array(
			'default'    			=> '37.422424',
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'philosophy_google_map_lat_setting_control', array(
			  'label' 	 => esc_html__( 'Latitude', 'philosophy' ),
			  'section'  => 'philosophy_contact_page_section',
			  'settings' => 'philosophy_google_map_lat_setting',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->add_setting( 'philosophy_google_map_long_setting' , array(
			'default'    		   => '-122.085661',
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'philosophy_google_map_long_setting_control', array(
			  'label' 	 => esc_html__( 'Longitude', 'philosophy' ),
			  'section'  => 'philosophy_contact_page_section',
			  'settings' => 'philosophy_google_map_long_setting',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_google_map_lat_setting', array(
			'selector' => '#map-container',
		) );


		// 1 # Contact info block
		$wp_customize->add_setting( 'philosophy_contact_setting_block_title_one' , array(
			'default'    			=> 'Where to Find Us',
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'philosophy_contact_block_control_one', array(
			  'label' 	 => esc_html__( '1 # Contact info block title', 'philosophy' ),
			  'section'  => 'philosophy_contact_page_section',
			  'settings' => 'philosophy_contact_setting_block_title_one',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_contact_setting_block_title_one', array(
			'selector' => '.c-block-title-one',
		) );

		$wp_customize->add_setting( 'philosophy_contact_setting_block_content_one' , array(
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'philosophy_sanitize_html'
		) );

		$wp_customize->add_control( 
			new Epsilon_Control_Text_Editor( 
				$wp_customize, 
				'contact_setting_block_control_one', 
				array(
					'label' 	 => esc_html__( '1 # Contact info block content', 'philosophy' ),
					'section'  	 => 'philosophy_contact_page_section',
					'settings' 	 => 'philosophy_contact_setting_block_content_one',
					'type'       => 'epsilon-text-editor',
				)
		));

		$wp_customize->selective_refresh->add_partial( 'philosophy_contact_setting_block_content_one', array(
			'selector' => '.c-block-content-one',
		) );

		// 2 # Contact info block
		$wp_customize->add_setting( 'philosophy_contact_setting_block_title_two' , array(
			'default'    			=> 'Contact Info',
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'philosophy_contact_block_control_two', array(
			  'label' 	 => esc_html__( '2 # Contact info block title', 'philosophy'),
			  'section'  => 'philosophy_contact_page_section',
			  'settings' => 'philosophy_contact_setting_block_title_two',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_contact_setting_block_title_two', array(
			'selector' => '.c-block-title-two',
		) );

		$wp_customize->add_setting( 'philosophy_contact_setting_block_content_two' , array(
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_html'
		) );

		$wp_customize->add_control( 
			new Epsilon_Control_Text_Editor( 
				$wp_customize,
				'philosophy_contact_setting_block_control_two', 
				array(
					'label' 	 => esc_html__( '2 # Contact info block content', 'philosophy' ),
					'section'  	 => 'philosophy_contact_page_section',
					'settings' 	 => 'philosophy_contact_setting_block_content_two',
					'type'     	 => 'epsilon-text-editor',
				)
		));

		$wp_customize->selective_refresh->add_partial( 'philosophy_contact_setting_block_content_two', array(
			'selector' => '.c-block-content-two',
		) );

		// Form title
		$wp_customize->add_setting( 'philosophy_contact_setting_form_title' , array(
			'default'    		=> 'Say Hello',
			'transport'         => 'refresh', // refresh or postMessage
	        'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'philosophy_sanitize_nohtml'
		) );
		// Form title control
		$wp_customize->add_control( 'philosophy_contact_form_title_ctrl', array(
			  'label' 	 => esc_html__( 'Form title', 'philosophy' ),
			  'section'  => 'philosophy_contact_page_section',
			  'settings' => 'philosophy_contact_setting_form_title',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'philosophy_contact_setting_form_title', array(
			'selector' => '.form-title',
		) );

		// Contact form
		$wp_customize->add_setting( 'philosophy_contact_form_setting' , array(
			'default' 	 			=> '',
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'wp_kses_post'
		) );


		$wp_customize->add_control( 
			new Epsilon_Control_Text_Editor( 
				$wp_customize,
				'philosophy_contact_form_control', 
				array(
					'label' 	 => esc_html__( 'Contact form 7 shortcode', 'philosophy' ),
			  		'section'  	 => 'philosophy_contact_page_section',
			  		'settings' 	 => 'philosophy_contact_form_setting',
					'type'     	 => 'epsilon-text-editor',
				)
		));

		$wp_customize->selective_refresh->add_partial( 'philosophy_contact_form_setting', array(
			'selector' => '.contact-form-7',
		) );

		/**************************
			404 Page
		***************************/

		$wp_customize->add_section( 'philosophy_fof_options_section', 
			array(
				'title'       => esc_html__( '404 Page Settings', 'philosophy' ), 
				'priority'    => 39,
				'capability'  => 'edit_theme_options', 
				'panel'    	  => 'philosophy_options_panel',
				'description' => esc_html__('Allows you to settings for 404 page element.', 'philosophy'), 
			) 
		);
         		
		// 404 text one option add settings
		$wp_customize->add_setting('philosophy_fof_text_one', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'theme_mod',
			'transport'  	 => 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_nohtml'
	 
		));
		
		// 404 text one control
		$wp_customize->add_control('philosophy_fof_text_one_ctrl', array(
			'label'      => esc_html__( '404 Text #1', 'philosophy' ),
			'section'    => 'philosophy_fof_options_section',
			'settings'   => 'philosophy_fof_text_one',
		));	
         		
		// 404 text one option add settings
		$wp_customize->add_setting('philosophy_fof_text_two', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'theme_mod',
			'transport'  	 => 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_nohtml'
	 
		));
		
		// 404 text one control
		$wp_customize->add_control('philosophy_fof_text_two_ctrl', array(
			'label'      => esc_html__( '404 Text #2', 'philosophy' ),
			'section'    => 'philosophy_fof_options_section',
			'settings'   => 'philosophy_fof_text_two',
		));	
		// 404 page text 1 color setting
		$wp_customize->add_setting('philosophy_fof_textonecolor_settings', array(
			'default'           => '#fff',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
		// 404 page text 1 color control
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'philosophy_fof_textonecolor_ctrl', 
			array(
			'label'    => esc_html__('404 Page Text #1 Color', 'philosophy'),
			'section'  => 'philosophy_fof_options_section',
			'settings' => 'philosophy_fof_textonecolor_settings',
		)));
		// 404 page text 2 color setting
		$wp_customize->add_setting('philosophy_fof_texttwocolor_settings', array(
			'default'           => '#fff',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
		// 404 page text 2 color control
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'philosophy_fof_texttwocolor_ctrl', 
			array(
			'label'    => esc_html__('404 Page Text #2 Color', 'philosophy'),
			'section'  => 'philosophy_fof_options_section',
			'settings' => 'philosophy_fof_texttwocolor_settings',
		)));
		// 404 page background color setting
		$wp_customize->add_setting('philosophy_fof_bgcolor_settings', array(
			'default'           => '#fff',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
		// 404 page background color control
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'philosophy_fof_bgcolor_ctrl', 
			array(
			'label'    => esc_html__('404 Page Background Color', 'philosophy'),
			'section'  => 'philosophy_fof_options_section',
			'settings' => 'philosophy_fof_bgcolor_settings',
		)));
		/**************************
			Footer Top Section
		***************************/

		$wp_customize->add_section( 'footer_top_section' , array(
			'title' 	=> esc_html__('Footer top widgets','philosophy'), 
			'panel'     =>'philosophy_options_panel',
			'priority' 	=> 40,
		));


		// Footer top widget show/hide
		$wp_customize->add_setting( 'philosophy_footer_top_enable' , array(
		    'default'        	 => false,
			'transport'          => 'refresh', // refresh or postMessage
	        'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'philosophy_sanitize_checkbox'
		) );
		

		$wp_customize->add_control( new Epsilon_Control_Toggle( 
				$wp_customize,
				'philosophy_footer_top_control', 
				array(
					'type'        => 'epsilon-toggle',
					'label'       => esc_html__( 'Active footer top widgets', 'philosophy' ),
					'section'     => 'footer_top_section',
					'settings'    => 'philosophy_footer_top_enable',
					
				)
		));

		$wp_customize->selective_refresh->add_partial( 'philosophy_footer_top_enable', array(
			'selector' => '.footer-enable',
		) );

		// Footer top block #1

		$wp_customize->add_setting( 'footer_top_setting_title_one' , array(
			'default'    		   => 'Popular Posts',
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'footer_top_control_title_one', array(
			  'label' 	 => esc_html__( 'Popular post widget title', 'philosophy' ),
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
			'default'    		=> 6,
			'transport'         => 'refresh', // refresh or postMessage
	        'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'footer_top_control_one', array(
			  'label' 	 => esc_html__( 'Popular post count', 'philosophy' ),
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
			'default'    		=> 'About Philosophy',
			'transport'         => 'refresh', // refresh or postMessage
	        'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'footer_top_control_title_two', array(
			  'label' 	 => esc_html__( 'About post widget title', 'philosophy' ),
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
			'sanitize_callback'    => 'philosophy_sanitize_html'
		) );


		$wp_customize->add_control( new Epsilon_Control_Text_Editor( 
			$wp_customize,
			'footer_top_control_content_two',
			array(
			  'label' 	 => esc_html__( 'About post widget content', 'philosophy' ),
			  'section'  => 'footer_top_section',
			  'settings' => 'footer_top_setting_content_two',
			  'type'     => 'epsilon-text-editor',

			) 
		));

		$wp_customize->selective_refresh->add_partial( 'footer_top_setting_content_two', array(
			'selector' => '.about-post-content',
		) );

		// About Philosophy social link

		$wp_customize->add_setting( 'footer_top_setting_social_two' , array(
		    'default'        		=> false,
			'transport'            	=> 'refresh', // refresh or postMessage
	        'capability'           	=> 'edit_theme_options',
			'sanitize_callback' 	=> 'philosophy_sanitize_checkbox'
		) );

		$wp_customize->add_control( new Epsilon_Control_Toggle( 
				$wp_customize,
				'footer_top_social_control', 
				array(
					'type'        	 => 'epsilon-toggle',
					'label'          => esc_html__( 'About Philosophy Social Icon', 'philosophy' ),
					'description' 	 => esc_html__( 'About Philosophy social icon show/hide.', 'philosophy' ),
					'section'        => 'footer_top_section',
					'settings'       => 'footer_top_setting_social_two',
					
				)
		));

		$wp_customize->selective_refresh->add_partial( 'footer_top_setting_social_two', array(
			'selector' => '.about__social',
		) );


		// Footer top block #3

		// Tags title

		// Tag widget show/hide
		$wp_customize->add_setting( 'philosophy_footer_tag_enable' , array(
		    'default'        	 => false,
			'transport'          => 'refresh', // refresh or postMessage
	        'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'philosophy_sanitize_checkbox'
		) );
		
		$wp_customize->add_control( new Epsilon_Control_Toggle( 
				$wp_customize,
				'philosophy_footer_tag_control', 
				array(
					'type'        => 'epsilon-toggle',
					'label'       => esc_html__( 'Active footer tag widgets', 'philosophy' ),
					'section'     => 'footer_top_section',
					'settings'    => 'philosophy_footer_tag_enable',
				)
		));

		$wp_customize->selective_refresh->add_partial( 'philosophy_footer_top_enable', array(
			'selector' => '.footer-enable',
		) );
		//
		$wp_customize->add_setting( 'footer_top_setting_title_three' , array(
			'default'    		   => 'Tags',
			'transport'            => 'refresh', // refresh or postMessage
	        'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'philosophy_sanitize_nohtml'
		) );

		$wp_customize->add_control( 'footer_top_control_title_three', array(
			  'label' 	 => esc_html__( 'Tags widget title', 'philosophy' ),
			  'section'  => 'footer_top_section',
			  'settings' => 'footer_top_setting_title_three',
			  'type'	 => 'text'
		    )
		);

		$wp_customize->selective_refresh->add_partial( 'footer_top_setting_title_three', array(
			'selector' => '.tags-widget-title',
		) );
		/**************************
			Footer Section
		***************************/

		$wp_customize->add_section( 'philosophy_footer_options_section', 
			array(
				'title'       => esc_html__( 'Footer', 'philosophy' ), 
				'priority'    => 40,
				'capability'  => 'edit_theme_options', 
				'panel'    	  => 'philosophy_options_panel',
				'description' => esc_html__('Allows you to settings for footer widget and footer widget bottom.', 'philosophy'), 
			) 
		);
         		
		// Footer Widget Show/Hide option add settings
		$wp_customize->add_setting( 'philosophy-widget-toggle-settings',
			array(
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'refresh',
				'sanitize_callback' => 'philosophy_sanitize_checkbox'
			) 
		); 
		// Footer widget show/hide option add control
		$wp_customize->add_control(
			new Epsilon_Control_Toggle(
				$wp_customize,
				'philosophy_widget_enable_preloader',
				array(
					'type'        => 'epsilon-toggle',
					'label'       => esc_html__( 'Footer Widget show/hide', 'philosophy' ),
					'settings'   => 'philosophy-widget-toggle-settings',
					'section'     => 'philosophy_footer_options_section',
				)
			)
		);
		
		// Footer copy right text add settings
		$wp_customize->add_setting( 'philosophy-copyright-text-settings',
			array(
				'default'    => '', 
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'refresh',
				'sanitize_callback' => 'philosophy_sanitize_html' 
			) 
		); 
		// Footer copy right text add control
		$wp_customize->add_control(
			new Epsilon_Control_Text_Editor(
				$wp_customize,
				'philosophy_copyright_text',
				array(
					'type'        => 'epsilon-text-editor',
					'label'       => esc_html__( 'Footer Copy Right Text', 'philosophy' ),
					'settings'   => 'philosophy-copyright-text-settings',
					'section'     => 'philosophy_footer_options_section',
				)
			)
		);
		
		$wp_customize->selective_refresh->add_partial( 'philosophy-copyright-text-settings', 
		array( 'selector' => '.copyright-text' ) );
		
		// Footer widget background color 
		$wp_customize->add_setting('philosophy_footer_bgColor_settings', array(
			'default'           => '#19191b',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
		// Footer widget background color ctrl
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_footer_bgColor', 
			array(
			'label'    => esc_html__('Footer Widget Background Color', 'philosophy'),
			'section'  => 'philosophy_footer_options_section',
			'settings' => 'philosophy_footer_bgColor_settings',
		)));
		
		// Footer widget text Color 
		$wp_customize->add_setting('philosophy_footer_wtcolor_settings', array(
			'default'           => '#656565',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
		// Footer widget text color ctrl
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'philosophy_footer_wtextColor', 
			array(
			'label'    => esc_html__('Footer Widget Text Color', 'philosophy'),
			'section'  => 'philosophy_footer_options_section',
			'settings' => 'philosophy_footer_wtcolor_settings',
		)));
		
		// Footer widget title color setting
		$wp_customize->add_setting('philosophy_footer_widgettitlecolor_settings', array(
			'default'           => '#FFFFFF',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
		// Footer widget title color control
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_footer_widgettitlecolor', 
			array(
			'label'    => esc_html__('Footer Widget Title Color', 'philosophy'),
			'section'  => 'philosophy_footer_options_section',
			'settings' => 'philosophy_footer_widgettitlecolor_settings',
		)));
		
		// Footer widget anchor Color 
		$wp_customize->add_setting('philosophy_footer_wanchorcolor_settings', array(
			'default'           => '#888888',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
		// Footer widget anchor Color
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_footer_wanchorcolor', 
			array(
			'label'    => esc_html__('Footer Widget Anchor Color', 'philosophy'),
			'section'  => 'philosophy_footer_options_section',
			'settings' => 'philosophy_footer_wanchorcolor_settings',
		)));
		
		// Footer widget anchor hover Color 
		$wp_customize->add_setting('philosophy_footer_wanchorhovcolor_settings', array(
			'default'           => '#888888',
			'capability'        => 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'transport'  		=> 'refresh',
			'sanitize_callback' => 'philosophy_sanitize_hex_color'
	 
		));
		// Footer widget anchor hover Color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
			$wp_customize, 
			'header_footer_anchorhovcolor', 
			array(
			'label'    => esc_html__('Footer Widget Anchor Hover Color', 'philosophy'),
			'section'  => 'philosophy_footer_options_section',
			'settings' => 'philosophy_footer_wanchorhovcolor_settings',
		)));
				
		
		
	}
	add_action( 'customize_register', 'themeslug_customize_register' );
	
	
?>