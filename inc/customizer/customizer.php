<?php
/**
 * Minisite Customizer
 */

// Customizer custom controls
require dirname( __FILE__ ) . '/inc/custom-controls/custom-controls.php';

// Pro Sections 
require dirname( __FILE__ ) . '/inc/pro-sections/pro-sections.php';


class Minisite_Customizer {

	// Customizer
	public static function minisite_customize_register( $wp_customize ) {

		// Header
		$wp_customize->get_section( 'title_tagline' )->title = __( 'Header', 'minisite-lite' );		
			
			// Navbar
			$wp_customize->add_setting( 'display_navbar', array(
				'default'			=> true,
				'sanitize_callback' => 'minisite_sanitize_checkbox',	
			) );
			$wp_customize->add_control( 'display_navbar', array(
				'label'				=> __( 'Navbar', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 1	
			) );
			function display_navbar_callback( $control ) {
				if ( $control->manager->get_setting( 'display_navbar' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Logo
			$wp_customize->add_setting( 'display_logo', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox',	
			) );
			$wp_customize->add_control( 'display_logo', array(
				'label'				=> __( 'Logo', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 2,
				'active_callback'   => 'display_navbar_callback',
			) );
			$wp_customize->selective_refresh->add_partial( 'display_logo', array(
				'selector'			=> '.site-logo'
			) );
			function display_logo_callback( $control ) {
				if ( $control->manager->get_setting( 'display_logo' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'site_logo', array(
				'default'			=> '',
				'sanitize_callback' => 'absint',
			) );  	
			$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'site_logo', array(
				'label'				=> __( 'Logo', 'minisite-lite' ),
				'flex_width'  		=> true, 
				'flex_height' 		=> true,
				'width'       		=> 100,
				'height'      		=> 100,
				'settings'			=> 'site_logo',
				'extensions'		=> array( 'jpg', 'jpeg', 'gif', 'png', 'svg' ),
				'section'			=> 'title_tagline',
				'priority' 			=> 3,
 				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_logo_callback( $control ) );
 				 }
			) ) );
		
			// Logo Size
			$wp_customize->add_setting( 'site_logo_size' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_number_range'
			) );
			$wp_customize->add_control( 'site_logo_size', array(
				'label'   			=> __( 'Logo Size', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 20,
					'step'  		=> 0.001
				),
				'section'			=> 'title_tagline',
				'priority' 			=> 4,
 				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_logo_callback( $control ) );
 				 }
			) );

			// Icon
			$wp_customize->add_setting( 'display_site_logo_icon', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_site_logo_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority' 			=> 5,
 				'active_callback'   => 'display_navbar_callback'
			) );
			function display_site_logo_icon_callback( $control ) {
				if ( $control->manager->get_setting( 'display_site_logo_icon' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'site_logo_icon', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'site_logo_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . get_template_directory_uri() . '/inc/icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'title_tagline',
				'priority' 			=> 6,
 				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_site_logo_icon_callback( $control ) );
 				 }
			) );
		
			// Icon Color
			$wp_customize->add_setting( 'site_logo_icon_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_logo_icon_color', array(
				'label' 			=> __( 'Icon Color', 'minisite-lite' ),
				'section'		 	=> 'title_tagline',
				'settings' 			=> 'site_logo_icon_color',
				'priority'			=> 7,
 				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_site_logo_icon_callback( $control ) );
 				 }
			) ) );	
			
			// Icon Size
			$wp_customize->add_setting( 'site_logo_icon_size', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_number_range'
			) ); 
			$wp_customize->add_control( 'site_logo_icon_size', array(
				'label' 			=> __( 'Icon Size', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 4,
					'step'  		=> 0.001
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 8,
 				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_site_logo_icon_callback( $control ) );
 				 }
			) ) ;
			
			// Remove Display Header Text
			$wp_customize->remove_control( 'display_header_text' );

			// Site Title
			$wp_customize->add_setting( 'display_site_title', array(
				'default'			=> true,
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_site_title', array(
				'label'				=> __( 'Site Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 9,
				'active_callback'   => 'display_navbar_callback',
			) );
			function display_site_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_site_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
			$wp_customize->get_control( 'blogname' )->priority = '10';
			$wp_customize->get_control( 'blogname' )->active_callback = function( $control ) {
				return ( display_navbar_callback( $control ) && display_site_title_callback( $control ) );
			};

			// Site Title Color
			$wp_customize->add_setting( 'site_title_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_title_color', array(
				'label' 			=> __( 'Site Title Color', 'minisite-lite' ),
				'section'		 	=> 'title_tagline',
				'settings' 			=> 'site_title_color',
				'priority'			=> 11,
				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_site_title_callback( $control ) );
 				 }
			) ) );	
			
			// Site Title Size
			$wp_customize->add_setting( 'site_title_size' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_number_range'
			) );
			$wp_customize->add_control( 'site_title_size', array(
				'label'   			=> __( 'Site Title Size', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 5,
					'step'  		=> 0.001
				),
				'section'			=> 'title_tagline',
				'priority' 			=> 12,
				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_site_title_callback( $control ) );
 				 }
			) );

			// Tagline
			$wp_customize->add_setting( 'display_tagline', array(
				'default'			=> true,
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_tagline', array(
				'label'				=> __( 'Tagline', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 13,
				'active_callback'   => 'display_navbar_callback',
			) );
			function display_tagline_callback( $control ) {
				if ( $control->manager->get_setting( 'display_tagline' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
			$wp_customize->get_control( 'blogdescription' )->priority = '14';
			$wp_customize->get_control( 'blogdescription' )->active_callback = function( $control ) {
				return ( display_navbar_callback( $control ) && display_tagline_callback( $control ) );
			};

			// Search
			$wp_customize->add_setting( 'display_search', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_search', array(
				'label'				=> __( 'Search', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 15,
				'active_callback'   => 'display_navbar_callback'
			) );
			function display_search_callback( $control ) {
				if ( $control->manager->get_setting( 'display_search' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Menu
			$wp_customize->add_setting( 'display_menu', array(
				'default'			=> true,
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_menu', array(
				'label'				=> __( 'Menu', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 16,
				'active_callback'   => 'display_navbar_callback',
			) );
			function display_menu_callback( $control ) {
				if ( $control->manager->get_setting( 'display_menu' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
		
			// Display Hamburger Menu
			$wp_customize->add_setting( 'display_hamburger_menu' , array(
				'default'        		=> 'navbar-expand-lg',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'wp_filter_nohtml_kses'
			) );
			$wp_customize->add_control( 'display_hamburger_menu', array(
				'label'   				=> __( 'Display Hamburger Menu', 'minisite-lite' ),
				'type'    				=> 'select',
				'choices'    			=> array(
					'navbar-expand'		=> 'Never',
					'navbar-expand-sm'	=> 'Small screens only',
					'navbar-expand-md'	=> 'Small to medium screens',
					'navbar-expand-lg'	=> 'Small to large screens',
					'navbar-expand-xl'	=> 'Small to extra large screens',
					''					=> 'Always',
				),
				'section'				=> 'title_tagline',
				'priority' 				=> 17,
				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_menu_callback( $control ) );
 				 }
			) );
			
			// Full Width Navbar
			$wp_customize->add_setting( 'full_width_navbar', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'full_width_navbar', array(
				'label'				=> __( 'Full Width Navbar', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 17,
				'active_callback'   => 'display_navbar_callback',
			) );
			
			// Navbar Colors
			$wp_customize->add_setting( 'display_navbar_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox',	
			) );
			$wp_customize->add_control( 'display_navbar_colors', array(
				'label'				=> __( 'Navbar Colors', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'		 	=> 'title_tagline',
				'priority' 			=> 18,
				'active_callback'   => 'display_navbar_callback',
			) );
			function display_navbar_colors_callback( $control ) {
				if ( $control->manager->get_setting( 'display_navbar_colors' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
		
			// Navbar Font Color
			$wp_customize->add_setting( 'navbar_font_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'			
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navbar_font_color', array(
				'label' 			=> __( 'Navbar Font Color', 'minisite-lite' ),
				'section'		 	=> 'title_tagline',
				'settings' 			=> 'navbar_font_color',
				'priority'			=> 19,
				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_navbar_colors_callback( $control ) );
 				 }
			) ) );
			
			// Navbar Background Color
		   	$wp_customize->add_setting( 'navbar_background_color', array(
		   		'default'    		=> '',
				'type'        		=> 'theme_mod',
				'capability'  		=> 'edit_theme_options',
		   		//'transport'  		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_rgba'
		   	) );
		   	$wp_customize->add_control( new Minisite_Customize_Alpha_Color_Control( $wp_customize, 'navbar_background_color', array(
		   		'label'        		=> __( 'Navbar Background Color', 'minisite-lite' ),
		   		'settings'     		=> 'navbar_background_color',
				'section'		 	=> 'title_tagline',
		   		'show_opacity' 		=> true,
		   		'palette'      		=> array(
			       	'#000000',
					'#ffffff',
			       	'#dd3333',
					'#dd9933',
			       	'#eeee22',
					'#81d742',
					'#1e73be',
					'#8224e3'
		        ),
		   		'priority'			=> 20,
				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_navbar_colors_callback( $control ) );
 				}	
		   	) ) );	
		
			// Sticky Navbar
			$wp_customize->add_setting( 'sticky_navbar', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'sticky_navbar', array(
				'label'				=> __( 'Sticky Navbar', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 21,
				'active_callback'   => 'display_navbar_callback',
			) );
			function sticky_navbar_callback( $control ) {
				if ( $control->manager->get_setting( 'sticky_navbar' )->value() == true ) {
					return true; 
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'sticky_navbar_description', array(
		    	'default'			=> '',
		   		'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );
			$wp_customize->add_control( new Minisite_Simple_Notice_Custom_control( $wp_customize, 'sticky_navbar_description', array(
				'description'		=> 'A sticky navbar sticks to the top of the browser window so that it doesn&#39;t disappear when scrolling. This option enables a sticky navbar and allows you to customize it&#39;s appearance after scrolling.',
				'section'			=> 'title_tagline',
				'priority'			=> 22,
				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && sticky_navbar_callback( $control ) );
 				}
			) ) );
			
			// Sticky Navbar Logo
			$wp_customize->add_setting( 'display_sticky_navbar_logo', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox',	
			) );
			$wp_customize->add_control( 'display_sticky_navbar_logo', array(
				'label'				=> __( 'Sticky Navbar Logo', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 23,
				'active_callback'   => function( $control ) {
					return ( display_navbar_callback( $control ) && display_logo_callback( $control ) && sticky_navbar_callback( $control ) );
				 },
			) );
			function display_sticky_navbar_logo_callback( $control ) {
				if ( $control->manager->get_setting( 'display_sticky_navbar_logo' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}	
			$wp_customize->add_setting( 'sticky_navbar_logo', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_file'
			) );  	
			$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'sticky_navbar_logo', array(
				'label'				=> __( 'Sticky Navbar Logo', 'minisite-lite' ),
				'flex_width'  		=> true, 
				'flex_height' 		=> true,
				'width'       		=> 100,
				'height'      		=> 100,
				'settings'			=> 'sticky_navbar_logo',
				'section'			=> 'title_tagline',
				'priority' 			=> 24,
				'active_callback'	=> function( $control ) {
					return ( display_navbar_callback( $control ) && display_logo_callback( $control ) && sticky_navbar_callback( $control ) && display_sticky_navbar_logo_callback( $control ) );
				}	
			) ) );	
		
			// Sticky Navbar Icon Color
			$wp_customize->add_setting( 'sticky_navbar_icon_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sticky_navbar_icon_color', array(
				'label' 			=> __( 'Sticky Navbar Icon Color', 'minisite-lite' ),
				'section'		 	=> 'title_tagline',
				'settings' 			=> 'sticky_navbar_icon_color',
				'priority'			=> 25,
				'active_callback'	=> function( $control ) {
					return ( display_navbar_callback( $control ) && display_site_logo_icon_callback( $control ) && sticky_navbar_callback( $control ) );
				}
			) ) );	
			
			// Sticky Navbar Site Title Color
			$wp_customize->add_setting( 'sticky_navbar_site_title_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sticky_navbar_site_title_color', array(
				'label' 			=> __( 'Sticky Navbar Site Title Color', 'minisite-lite' ),
				'section'		 	=> 'title_tagline',
				'settings' 			=> 'sticky_navbar_site_title_color',
				'priority'			=> 26,
				'active_callback'	=> function( $control ) {
					return ( display_navbar_callback( $control ) && display_site_title_callback( $control ) && sticky_navbar_callback( $control ) );
				}
			) ) );
			
			// Sticky Navbar Colors
			$wp_customize->add_setting( 'display_sticky_navbar_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox',	
			) );
			$wp_customize->add_control( 'display_sticky_navbar_colors', array(
				'label'				=> __( 'Sticky Navbar Colors', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'		 	=> 'title_tagline',
				'priority' 			=> 27,
				'active_callback'	=> function( $control ) {
					return ( display_navbar_callback( $control ) && sticky_navbar_callback( $control ) );
				}
			) );
			function display_sticky_navbar_colors_callback( $control ) {
				if ( $control->manager->get_setting( 'display_sticky_navbar_colors' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}

			// Sticky Navbar Background Color
			$wp_customize->add_setting( 'sticky_navbar_background_color', array(
				'default'    		=> '',
				'type'        		=> 'theme_mod',
				'capability'  		=> 'edit_theme_options',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_rgba'
			) );
			$wp_customize->add_control( new Minisite_Customize_Alpha_Color_Control( $wp_customize, 'sticky_navbar_background_color', array(
				'label'        		=> __( 'Sticky Navbar Background Color', 'minisite-lite' ),
				'settings'     		=> 'sticky_navbar_background_color',
				'section'		 	=> 'title_tagline',
				'show_opacity' 		=> true,
				'palette'      		=> array(
				   	'#000000',
					'#ffffff',
				   	'#dd3333',
					'#dd9933',
				   	'#eeee22',
					'#81d742',
					'#1e73be',
					'#8224e3'
			    ),
				'priority'			=> 28,
				'active_callback'	=> function( $control ) {
					return ( display_navbar_callback( $control ) && sticky_navbar_callback( $control ) && display_sticky_navbar_colors_callback( $control ) );
				}
			) ) );

			// Sticky Navbar Font Color
			$wp_customize->add_setting( 'sticky_navbar_font_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sticky_navbar_font_color', array(
				'label' 			=> __( 'Sticky Navbar Font Color', 'minisite-lite' ),
				'section'		 	=> 'title_tagline',
				'settings' 			=> 'sticky_navbar_font_color',
				'priority'			=> 29,
				'active_callback'	=> function( $control ) {
					return ( display_navbar_callback( $control ) && sticky_navbar_callback( $control ) && display_sticky_navbar_colors_callback( $control ) );
				}
			) ) );	
			
			// Header
			$wp_customize->add_setting( 'display_header', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header', array(
				'label'				=> __( 'Header', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 30,
			) );
			function display_header_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Display
			$wp_customize->add_setting( 'header_displays', array( 
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'header_displays', array(
				'label'      		=> __( 'Header Displays', 'minisite-lite' ),
				'section'    		=> 'title_tagline',
				'type'    			=> 'select',
				'choices'   		=> array(
					'' 							=> 'Nothing',
					'display_page_title'		=> 'Page Title',
					'display_header_title_text'	=> 'Custom Text'
				),
				'priority' 			=> 31,
				'active_callback'   => 'display_header_callback'
			) );
			function header_displays_page_title_callback( $control ) {
				if ( $control->manager->get_setting( 'header_displays' )->value() == 'display_page_title' ) {
					return true;
				} else {
					return false;
				}
			}
			function header_displays_title_text_callback( $control ) {
				if ( $control->manager->get_setting( 'header_displays' )->value() == 'display_header_title_text' ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Title
			$wp_customize->add_setting( 'display_header_image_title', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_image_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 32,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && header_displays_title_text_callback( $control ) );
				 },
			) );
			function display_header_image_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_image_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'header_image_title', array(
				'default' 			=> __( '', 'minisite-lite' ),  	
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'header_image_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'title_tagline',
				'priority' 			=> 33,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && header_displays_title_text_callback( $control ) && display_header_image_title_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'header_image_title', array(
				'selector'			=> '.header-image-title'
			) );
			
			// Text
			$wp_customize->add_setting( 'display_header_image_text', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_image_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority' 			=> 34,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && header_displays_title_text_callback( $control ) );
				 },
			) );
			function display_header_image_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_image_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'header_image_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'header_image_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'title_tagline',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'priority'			=> 35,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && header_displays_title_text_callback( $control ) && display_header_image_text_callback( $control ) );
				 },
			) ) );
			
			// Header Height
			$wp_customize->add_setting( 'display_header_height', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_height', array(
				'label'				=> __( 'Header Height', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 36,
				'active_callback'	=> 'display_header_callback'
			) );
			function display_header_height_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_height' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'header_height', array(
				'default' 			=> '255', 	
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_number_range'
			) );	
			$wp_customize->add_control( 'header_height', array(
				'label'				=> __( 'Header Height (px)', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 1000,
					'step'  		=> 1
				),
				'section'			=> 'title_tagline',
				'priority' 			=> 37,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_height_callback( $control ) );
				}
			) );
			
			// Header Position
			$wp_customize->add_setting( 'display_header_position', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_position', array(
				'label'				=> __( 'Header Position', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 38,
				'active_callback'	=> 'display_header_callback'
			) );
			function display_header_position_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_position' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'header_position', array(
				'default' 			=> '', 	
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_number_range'
			) );	
			$wp_customize->add_control( 'header_position', array(
				'label'				=> __( 'Header Position', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> -1,
					'max'   		=> 1000,
					'step'  		=> 1
				),
				'section'			=> 'title_tagline',
				'priority' 			=> 39,
				'active_callback'	=> function( $control ) {
					return (display_header_callback( $control )  && display_header_position_callback( $control ) );
				}
			) );
			
			// Full Screen Header
			$wp_customize->add_setting( 'full_screen_header', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'full_screen_header', array(
				'label'				=> __( 'Full Screen Header', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 40,
				'active_callback'   => 'display_header_callback',
			) );
			function full_screen_header_callback( $control ) {
				if ( $control->manager->get_setting( 'full_screen_header' )->value() == false ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Header Colors
			$wp_customize->add_setting( 'display_header_image_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_image_colors', array(
				'label'				=> __( 'Header Colors', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority' 			=> 41,
				'active_callback'	=> 'display_header_callback',
			) );
			function display_header_image_colors_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_image_colors' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Heading Color
			$wp_customize->add_setting( 'display_header_image_heading_color', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_image_heading_color', array(
				'label'				=> __( 'Heading Color', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority' 			=> 42,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_colors_callback( $control ) );
				}
			) );
			function display_header_image_heading_color_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_image_heading_color' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'header_image_heading_color', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_heading_color', array(
				'label' 			=> __( 'Heading Color', 'minisite-lite' ),
				'settings' 			=> 'header_image_heading_color',
				'section'		 	=> 'title_tagline',
				'priority' 			=> 43,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_colors_callback( $control ) && display_header_image_heading_color_callback( $control ) );
				}
			) ) );	

			// Font Color
			$wp_customize->add_setting( 'display_header_image_font_color', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_image_font_color', array(
				'label'				=> __( 'Font Color', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority' 			=> 44,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_colors_callback( $control ) );
				}
			) );
			function display_header_image_font_color_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_image_font_color' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'header_image_font_color', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_font_color', array(
				'label' 			=> __( 'Font Color', 'minisite-lite' ),
				'settings' 			=> 'header_image_font_color',
				'section'		 	=> 'title_tagline',
				'priority' 			=> 45,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_colors_callback( $control ) && display_header_image_font_color_callback( $control ) );
				}
			) ) );
			
			// Header Background
			$wp_customize->add_setting( 'display_header_image_background', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_image_background', array(
				'label'				=> __( 'Header Background', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority' 			=> 46,
				'active_callback'   => 'display_header_callback',
			) );
			function display_header_image_background_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_image_background' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
		
			// Header Background Color
			$wp_customize->add_setting( 'display_header_image_background_color', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_image_background_color', array(
				'label'				=> __( 'Header Background Color', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 47,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) );
				}
			) );
			function display_header_image_background_color_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_image_background_color' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'header_image_background_color', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_background_color', array(
				'label' 			=> __( 'Header Background Color', 'minisite-lite' ),
				'settings' 			=> 'header_image_background_color',
				'section'		 	=> 'title_tagline',
				'priority'			=> 48,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_color_callback( $control ) );
				}
			) ) );
				
			// Header Background Image
			$wp_customize->add_setting( 'display_header_image_background_image', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_image_background_image', array(
				'label'				=> __( 'Header Background Image', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 49,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) );
				}
			) );
			function display_header_image_background_image_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_image_background_image' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			//$wp_customize->get_control( 'header_image' )->default = '';
			$wp_customize->get_control( 'header_image' )->section = 'title_tagline';
			$wp_customize->get_control( 'header_image' )->priority = '50';
			$wp_customize->get_control( 'header_image' )->active_callback = function( $control ) {
				return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_image_callback( $control ) );
			};
				
			// Background Image Attachment
			$wp_customize->add_setting( 'header_image_background_attachment' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_select'
			) );
			$wp_customize->add_control( 'header_image_background_attachment', array(
				'label'   			=> __( 'Background Image Attachment', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'scroll' 		=> 'Scroll',
					'fixed' 		=> 'Fixed',
					'local' 		=> 'Local',
					'initial' 		=> 'Initial',
					'inherit' 		=> 'Inherit'
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 51,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_image_callback( $control ) );
				}
			) );
			
			// Background Image Position
			$wp_customize->add_setting( 'header_image_background_position' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_select'
			) );
			$wp_customize->add_control( 'header_image_background_position', array(
				'label'   			=> __( 'Background Image Position', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'left top' 		=> 'Left Top',
					'left center' 	=> 'Left Center',
					'left bottom' 	=> 'Left Bottom',
					'right top' 	=> 'Right Top',
					'right center' 	=> 'Right Center',
					'right bottom' 	=> 'Right Bottom',
					'center top' 	=> 'Center Top',
					'center center' => 'Center Center',
					'center bottom' => 'Center Bottom',
					'initial' 		=> 'Initial',
					'inherit' 		=> 'Inherit'
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 52,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_image_callback( $control ) );
				}
			) );
			
			// Background Image Size
			$wp_customize->add_setting( 'header_image_background_size' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_select'
			) );
			$wp_customize->add_control( 'header_image_background_size', array(
				'label'   			=> __( 'Background Image Size', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'auto' 			=> 'Auto',
					'cover' 		=> 'Cover',
					'contain' 		=> 'Contain',
					'initial' 		=> 'Initial',
					'inherit' 		=> 'Inherit'
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 53,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_image_callback( $control ) );
				}
			) );
			
			// Background Image Repeat
			$wp_customize->add_setting( 'header_image_background_repeat' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_select'
			) );
			$wp_customize->add_control( 'header_image_background_repeat', array(
				'label'   			=> __( 'Background Image Repeat', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'no-repeat' 	=> 'No Repeat',
					'repeat' 		=> 'Repeat',
					'repeat-x' 		=> 'Repeat Horizontally',
					'repeat-y' 		=> 'Repeat Vertically',
					'space' 		=> 'Space',
					'round' 		=> 'Round',
					'initial' 		=> 'Initial',
					'inherit' 		=> 'Inherit'
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 54,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_image_callback( $control ) );
				}
			) );
			
			// Background Image Opacity
			$wp_customize->add_setting( 'header_image_background_image_opacity', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_number_range'
			) );
			$wp_customize->add_control( 'header_image_background_image_opacity', array(
				'label'       		=> __( 'Background Image Opacity', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 1.000,
					'step'  		=> 0.001,
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 55,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_image_callback( $control ) );
				}		
			) );

			// Background Image Overlay Color
			$wp_customize->add_setting( 'header_image_overlay_color', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_overlay_color', array(
				'label' 			=> __( 'Background Image Overlay Color', 'minisite-lite' ),
				'settings' 			=> 'header_image_overlay_color',
				'section'		 	=> 'title_tagline',
				'priority'			=> 56,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_image_callback( $control ) );
				}
			) ) );	

			// Background Image Overlay Color Opacity
			$wp_customize->add_setting( 'header_image_overlay_color_opacity', array(
				'default'			=> '0.95',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_number_range'
			) );
			$wp_customize->add_control( 'header_image_overlay_color_opacity', array(
				'label'       		=> __( 'Background Image Overlay Color Opacity', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 1.000,
					'step'  		=> 0.001,
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 57,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_image_callback( $control ) );
				}
			) );	

			// Background Image Blend Mode
			$wp_customize->add_setting( 'header_image_blend_mode' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_select'
			) );
			$wp_customize->add_control( 'header_image_blend_mode', array(
				'label'   			=> __( 'Background Image Blend Mode', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'normal' 		=> 'Normal',
					'multiply' 		=> 'Multiply',
					'screen' 		=> 'Screen',
					'overlay' 		=> 'Overlay',
					'darken' 		=> 'Darken',
					'lighten' 		=> 'Lighten',
					'color-dodge' 	=> 'Color Dodge',
					'saturation' 	=> 'Saturation',
					'color' 		=> 'Color',
					'luminosity' 	=> 'Luminosity'
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 58,
				'active_callback'	=> function( $control ) {
					return ( display_header_callback( $control ) && display_header_image_background_callback( $control ) && display_header_image_background_image_callback( $control ) );
				}
			) );
			
			// Padding
			$wp_customize->add_setting( 'display_header_padding', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_header_padding', array(
				'label'				=> __( 'Padding', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 59,
				'active_callback'	=> 'display_header_callback',
			) );
			function display_header_padding_callback( $control ) {
				if ( $control->manager->get_setting( 'display_header_padding' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
		
			// Top Padding
			$wp_customize->add_setting( 'header_top_padding', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_number_range'				
			) );
			$wp_customize->add_control( 'header_top_padding', array(
				'label'       		=> __( 'Top Padding', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 10.000,
					'step'  		=> 0.001,
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 59,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && display_header_padding_callback( $control ) );
				}
			) );
		
			// Bottom Padding
			$wp_customize->add_setting( 'header_bottom_padding', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'minisite_sanitize_number_range'				
			) );
			$wp_customize->add_control( 'header_bottom_padding', array(
				'label'       		=> __( 'Bottom Padding', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 10.000,
					'step'  		=> 0.001,
				),
				'section'		 	=> 'title_tagline',
				'priority'			=> 59,
				'active_callback'   => function( $control ) {
					return ( display_header_callback( $control ) && display_header_padding_callback( $control ) );
				}
			) );
			
			// Site Icon
			$wp_customize->add_setting( 'display_site_icon', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_site_icon', array(
				'label'				=> __( 'Site Icon', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'title_tagline',
				'priority'			=> 59,
			) );
			function display_site_icon_callback( $control ) {
				if ( $control->manager->get_setting( 'display_site_icon' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->get_control( 'site_icon' )->active_callback = 'display_site_icon_callback';	
	
		// Homepage
		$wp_customize->add_panel( 'homepage', array(
			'title'				=> __( 'Homepage', 'minisite-lite' ),
			'priority'			=> 105
		) );

			// Homepage Settings
			$wp_customize->add_section( 'front_page_settings' , array(
				'title'				=> __( 'Homepage Settings', 'minisite-lite' ),
				'panel'				=> 'homepage',
				'priority' 			=> 1
			) );
	
				// Homepage displays					
				$wp_customize->add_setting( 'show_on_front', array(
					'default'			=> get_option( 'show_on_front', 'minisite' ),
					'capability'     	=> 'manage_options',
					'type'           	=> 'option',
					'sanitize_callback' => 'minisite_sanitize_radio'
				) );
				$wp_customize->add_control( 'show_on_front', array(
					'label'   			=> __( 'Homepage displays', 'minisite-lite' ),
					'section' 			=> 'front_page_settings',
					'type'    			=> 'radio',
					'choices' 			=> array(
						'posts' 			=> __( 'Your latest posts', 'minisite-lite' ),
						'page'  			=> __( 'A static page', 'minisite-lite' ),
					),
					'priority'          => 1,
				) );
			
				// Homepage	
				$wp_customize->add_setting( 'page_on_front', array(
					'type'       		=> 'option',
					'capability' 		=> 'manage_options',
					'sanitize_callback' => 'absint'
				) );
				$wp_customize->add_control( 'page_on_front', array(
					'label'     	 	=> __( 'Front page', 'minisite-lite' ),
					'section'   	 	=> 'front_page_settings',
					'type'      	 	=> 'dropdown-pages',
					'priority'          => 2,
				) );
		
				// Posts page	
				$wp_customize->add_setting( 'page_for_posts', array(
					'type'				=> 'option',
					'capability'     	=> 'manage_options',
					'sanitize_callback' => 'absint'
				) );
				$wp_customize->add_control( 'page_for_posts', array(
					'label'      		=> __( 'Posts page', 'minisite-lite' ),
					'section'    		=> 'front_page_settings',
					'type'       		=> 'dropdown-pages',
					'priority'          => 3,
				) );
				
				// Section Ordering & Visibility
				$wp_customize->add_setting( 'homepage_section_ordering_visibility', array(
					'default'			=> '',
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'homepage_section_ordering_visibility', array(
					'label'				=> __( 'Section Ordering & Visibility', 'minisite-lite' ),
					'description'		=> 'Section Ordering & Visibility <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
					'type'				=> 'checkbox',
					'section'    		=> 'front_page_settings',
					'priority'          => 3,
				) );
		
		// Footer
		$wp_customize->add_panel( 'footer', array(
			'title'				=> __( 'Footer', 'minisite-lite' ),
			'priority'			=> 999
		) );
			
			// Footer Settings
			$wp_customize->add_section( 'footer_settings' , array(
				'title'				=> __( 'Footer Settings', 'minisite-lite' ),
				'panel'				=> 'footer',
				'priority'			=> 1
			) );

				// Display Footer
				$wp_customize->add_setting( 'display_footer', array(
					'default'			=> true,
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer', array(
					'label'				=> __( 'Display Footer', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_settings',
				) );
				
				// Colors
				$wp_customize->add_setting( 'display_footer_colors', array(
					'default'			=> '',
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_colors', array(
					'label'				=> __( 'Colors', 'minisite-lite' ),
					'description'		=> '<input type="checkbox" disabled> Colors <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
					'type'				=> 'checkbox',
					'section'			=> 'footer_settings',
				) );
			
				// Background
				$wp_customize->add_setting( 'display_footer_background', array(
					'default'			=> '',
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_background', array(
					'label'				=> __( 'Background', 'minisite-lite' ),
					'description'		=> '<input type="checkbox" disabled> Background <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
					'type'				=> 'checkbox',
					'section'			=> 'footer_settings',
				) );
		
				// Padding
				$wp_customize->add_setting( 'display_footer_padding', array(
					'default'			=> '',
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_padding', array(
					'label'				=> __( 'Padding', 'minisite-lite' ),
					'description'		=> '<input type="checkbox" disabled> Padding <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
					'type'				=> 'checkbox',
					'section'			=> 'footer_settings',
				) );
	
				// Animation
				$wp_customize->add_setting( 'display_footer_animation', array(
					'default'			=> '',
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_animation', array(
					'label'				=> __( 'Animation', 'minisite-lite' ),
					'description'		=> '<input type="checkbox" disabled> Animation <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
					'type'				=> 'checkbox',
					'section'			=> 'footer_settings',
				) );
				
			// Widgets
			$wp_customize->add_section( 'footer_widgets' , array(
				'title'				=> __( 'Footer Widgets', 'minisite-lite' ),
				'panel'				=> 'footer',
				'priority'			=> 6
			) );

				// Widgets
				$footer_section = $wp_customize->get_section( 'sidebar-widgets-footer' );
				if ( ! empty( $footer_section ) ) {
				$footer_section->panel = 'footer';
				$footer_section->title = __( 'Widgets', 'minisite-lite' );
				$footer_section->priority = 6;
				}
				
			// Separator
			$wp_customize->add_section( 'footer_separator' , array(
				'title'				=> __( 'Separator', 'minisite-lite' ),
				'panel'				=> 'footer',
				'priority'			=> 7
			) );

				// Separator
				$wp_customize->add_setting( 'display_footer_separator', array(
					'default'			=> '',
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_separator', array(
					'label'				=> __( 'Display Separator', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_separator',
				) );
				
			// Colophon
			$wp_customize->add_section( 'footer_block_colophon' , array(
				'title'				=> __( 'Colophon', 'minisite-lite' ),
				'panel'				=> 'footer',
				'priority'			=> 8
			) );
				
				// Display Colophon
				$wp_customize->add_setting( 'display_footer_block_colophon', array(
					'default'			=> true,
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_block_colophon', array(
					'label'				=> __( 'Display Colophon', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_block_colophon',
				) );
				function display_footer_block_colophon_callback( $control ) {
					if ( $control->manager->get_setting( 'display_footer_block_colophon' )->value() == true ) {
						return true;
					} else {
						return false;
					}
				}
				
				// Copyright
				$wp_customize->add_setting( 'display_footer_block_colophon_copyright', array(
					'default'			=> true,
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_block_colophon_copyright', array(
					'label'				=> __( 'Copyright', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_block_colophon',
					'active_callback'	=> 'display_footer_block_colophon_callback'
				) );
				function display_footer_block_colophon_copyright_callback( $control ) {
					if ( $control->manager->get_setting( 'display_footer_block_colophon_copyright' )->value() == true ) {
						return true;
					} else {
						return false;
					}
				}
				
				// Copyright Owner
				$wp_customize->add_setting( 'display_footer_block_colophon_copyright_owner', array(
					'default'			=> true,
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_block_colophon_copyright_owner', array(
					'label'				=> __( 'Copyright Owner', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_block_colophon',
					'active_callback'	=> function( $control ) {
						return ( display_footer_block_colophon_callback( $control ) && display_footer_block_colophon_copyright_callback( $control ) );
					}
				) );
				function display_footer_block_colophon_copyright_owner_callback( $control ) {
					if ( $control->manager->get_setting( 'display_footer_block_colophon_copyright_owner' )->value() == true ) {
						return true;
					} else {
						return false;
					}
				}
				$wp_customize->add_setting( 'footer_block_colophon_copyright_owner', array(
					'default' 			=> get_bloginfo( 'name', 'display' ),
					'transport' 		=> 'postMessage',
					'sanitize_callback' => 'wp_filter_nohtml_kses'
				) );	
				$wp_customize->add_control( 'footer_block_colophon_copyright_owner', array(
					'label'				=> __( 'Copyright Owner', 'minisite-lite' ),
					'type'				=> 'text',
					'section'			=> 'footer_block_colophon',
					'active_callback'	=> function( $control ) {
						return ( display_footer_block_colophon_callback( $control ) && display_footer_block_colophon_copyright_callback( $control ) && display_footer_block_colophon_copyright_owner_callback( $control ) );
					}
				) );
				
				// Copyright Link
				$wp_customize->add_setting( 'display_footer_block_colophon_copyright_link', array(
					'default'			=> true,
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_block_colophon_copyright_link', array(
					'label'				=> __( 'Copyright Link', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_block_colophon',
					'active_callback'	=> function( $control ) {
						return ( display_footer_block_colophon_callback( $control ) && display_footer_block_colophon_copyright_callback( $control ) && display_footer_block_colophon_copyright_owner_callback( $control ) );
					}
				) );
				function display_footer_block_colophon_copyright_link_callback( $control ) {
					if ( $control->manager->get_setting( 'display_footer_block_colophon_copyright_link' )->value() == true ) {
						return true;
					} else {
						return false;
					}
				}
				$wp_customize->add_setting( 'footer_block_colophon_copyright_link', array(
					'default' 			=> esc_url( home_url( '/' ) ),
					'transport' 		=> 'postMessage',
					'sanitize_callback' => 'wp_filter_nohtml_kses'
				) );	
				$wp_customize->add_control( 'footer_block_colophon_copyright_link', array(
					'label'				=> __( 'Copyright Link', 'minisite-lite' ),
					'type'				=> 'text',
					'section'			=> 'footer_block_colophon',
					'active_callback'	=> function( $control ) {
						return ( display_footer_block_colophon_callback( $control ) && display_footer_block_colophon_copyright_callback( $control ) && display_footer_block_colophon_copyright_owner_callback( $control ) && display_footer_block_colophon_copyright_link_callback( $control ) );
					}
				) );
				
				// Admin
				$wp_customize->add_setting( 'display_footer_block_colophon_admin', array(
					'default'			=> '',
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_block_colophon_admin', array(
					'label'				=> __( 'Admin', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_block_colophon',
					'active_callback'   => 'display_footer_block_colophon_callback'
				) );
				
				// Terms of Use
				$wp_customize->add_setting( 'display_footer_block_colophon_terms_of_use', array(
					'default'			=> true,
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_block_colophon_terms_of_use', array(
					'label'				=> __( 'Terms of Use', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_block_colophon',
					'active_callback'   => 'display_footer_block_colophon_callback'
				) );
				function display_footer_block_colophon_terms_of_use_callback( $control ) {
					if ( $control->manager->get_setting( 'display_footer_block_colophon_terms_of_use' )->value() == true ) {
						return true;
					} else {
						return false;
					}
				}
				$wp_customize->add_setting( 'footer_block_colophon_terms_of_use', array(
					'default'			=> wpautop( __( '', 'minisite-lite' ) ), 
					'transport'			=> 'postMessage',
					'sanitize_callback'	=> 'wp_kses_post'
					)
				);
				$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'footer_block_colophon_terms_of_use', array(
					'label'				=> __( 'Terms of Use', 'minisite-lite' ), 
					'section'			=> 'footer_block_colophon',
					'input_attrs'		=> array(
						'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
						'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
					),
					'active_callback'	=> function( $control ) {
						return ( display_footer_block_colophon_callback( $control ) && display_footer_block_colophon_terms_of_use_callback( $control ) );
					}
				) ) );
					
				// Privacy Policy
				$wp_customize->add_setting( 'display_footer_block_colophon_privacy_policy', array(
					'default'			=> true,
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_block_colophon_privacy_policy', array(
					'label'				=> __( 'Privacy Policy', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_block_colophon',
					'active_callback'   => 'display_footer_block_colophon_callback'
				) );
				function display_footer_block_colophon_privacy_policy_callback( $control ) {
					if ( $control->manager->get_setting( 'display_footer_block_colophon_privacy_policy' )->value() == true ) {
						return true;
					} else {
						return false;
					}
				}
				$wp_customize->add_setting( 'footer_block_colophon_privacy_policy', array(
					'default'			=> wpautop( __( '', 'minisite-lite' ) ), 
					'transport'			=> 'postMessage',
					'sanitize_callback'	=> 'wp_kses_post'
				) );
				$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'footer_block_colophon_privacy_policy', array(
					'label'				=> __( 'Privacy Policy', 'minisite-lite' ), 
					'section'			=> 'footer_block_colophon',
					'input_attrs'		=> array(
						'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
						'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
					),
					'active_callback'	=> function( $control ) {
						return ( display_footer_block_colophon_callback( $control ) && display_footer_block_colophon_privacy_policy_callback( $control ) );
					}
				) ) );
				
				// Credits
				$wp_customize->add_setting( 'display_footer_block_colophon_credits', array(
					'default'			=> true,
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_footer_block_colophon_credits', array(
					'label'				=> __( 'Credits', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'footer_block_colophon',
					'active_callback'   => 'display_footer_block_colophon_callback'
				) );
				function display_footer_block_colophon_credits_callback( $control ) {
					if ( $control->manager->get_setting( 'display_footer_block_colophon_credits' )->value() == true ) {
						return true;
					} else {
						return false;
					}
				}
				$wp_customize->add_setting( 'footer_block_colophon_credits', array(
					'default'			=> sprintf( __( '<h3>Technical</h3><ul><li>Proudly powered by %1$s.</li><li>%2$s WordPress theme by %3$s, based on %4$s starter theme for WordPress.</li><li>Built with %5$s front-end framework.</li></ul><br><h3>Typography</h3><ul><li>%6$s by %7$s</li></ul><br><h3>Icons</h3><ul><li>%8$s</li><ul>', 'minisite-lite' ), '<a href="https://wordpress.org/" target="_blank">WordPress</a>', '<a href="https://www.getminisites.com/" target="_blank">Minisite</a>', '<a href="https://www.troytempleman.com/" target="_blank">Troy Templeman</a>', '<a href="https://underscores.me/" target="_blank">Underscores</a>', '<a href="https://getbootstrap.com/" target="_blank">Bootstrap</a>', '<a href="https://github.com/chrismsimpson/Metropolis/" target="_blank">Metropolis</a>', '<a href="https://github.com/chrismsimpson/" target="_blank">Chris Simpson</a>', '<a href="https://fontawesome.com/" target="_blank">Font Awesome</a>' ),  
					'transport'			=> 'postMessage',
					'sanitize_callback'	=> 'wp_kses_post'
					)
				);
				$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'footer_block_colophon_credits', array(
					'label'				=> __( 'Credits', 'minisite-lite' ), 
					'section'			=> 'footer_block_colophon',
					'input_attrs'		=> array(
						'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
						'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
					),
					'active_callback'	=> function( $control ) {
						return ( display_footer_block_colophon_callback( $control ) && display_footer_block_colophon_credits_callback( $control ) );
					}
				) ) );
	
		// Options
		$wp_customize->add_section( 'theme_options' , array(
			'title'				=> __( 'Options', 'minisite-lite' ),
			'description'		=> __( 'For these options to take effect, please click the <strong>Publish</strong> button and <strong>Reload</strong> your browser.', 'minisite-lite' ),
			'priority' 			=> 999
		) );
			
			// Admin
			$wp_customize->add_setting( 'admin', array(
				'default'			=> true,
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'admin', array(
				'label'				=> __( 'Admin', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );

			// Background
			$wp_customize->add_setting( 'custom_background_image', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'custom_background_image', array(
				'label'				=> __( 'Background', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			function custom_background_image_callback( $control ) {
				if ( $control->manager->get_setting( 'custom_background_image' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}

			// Colors
			$wp_customize->add_setting( 'custom_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'custom_colors', array(
				'label'				=> __( 'Colors', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			function custom_colors_callback( $control ) {
				if ( $control->manager->get_setting( 'custom_colors' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// CSS
			$wp_customize->add_setting( 'css', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'css', array(
				'label'				=> __( 'CSS', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			function css_callback( $control ) {
				if ( $control->manager->get_setting( 'css' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Footer Section
			$wp_customize->add_setting( 'footer_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'footer_section', array(
				'label'				=> __( 'Footer Section', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Footer Section <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			
			// Homepage Sections
			$wp_customize->add_setting( 'homepage_sections', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_sections', array(
				'label'				=> __( 'Homepage Sections', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			function homepage_sections_callback( $control ) {
				if ( $control->manager->get_setting( 'homepage_sections' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Homepage About Section
			$wp_customize->add_setting( 'homepage_about_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_about_section', array(
				'label'				=> __( 'Homepage About Section', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
			
			// Homepage Call to Action Section
			$wp_customize->add_setting( 'homepage_call_to_action_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_call_to_action_section', array(
				'label'				=> __( 'Homepage Call to Action Section', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
					
			// Homepage Contact Section
			$wp_customize->add_setting( 'homepage_contact_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_contact_section', array(
				'label'				=> __( 'Homepage Contact Section', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
			
			// Homepage Facts Section
			$wp_customize->add_setting( 'homepage_facts_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_facts_section', array(
				'label'				=> __( 'Homepage Facts Section', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
				
			// Homepage FAQ Section
			$wp_customize->add_setting( 'homepage_faq_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_faq_section', array(
				'label'				=> __( 'Homepage FAQ Section', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Homepage FAQ Section <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
				
			// Homepage Gallery Section
			$wp_customize->add_setting( 'homepage_gallery_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_gallery_section', array(
				'label'				=> __( 'Homepage Gallery Section', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Homepage Gallery Section <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
			
			// Homepage Header Section
			$wp_customize->add_setting( 'homepage_header_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_header_section', array(
				'label'				=> __( 'Homepage Header Section', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
				
			// Homepage Logos Section
			$wp_customize->add_setting( 'homepage_logos_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_logos_section', array(
				'label'				=> __( 'Homepage Logos Section', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Homepage Logos Section <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
			
				
			// Homepage Map Section
			$wp_customize->add_setting( 'homepage_map_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_map_section', array(
				'label'				=> __( 'Homepage Map Section', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
			
			// Homepage News Section
			$wp_customize->add_setting( 'homepage_news_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_news_section', array(
				'label'				=> __( 'Homepage News Section', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
				
			// Homepage Newsletter Section
			$wp_customize->add_setting( 'homepage_newsletter_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_newsletter_section', array(
				'label'				=> __( 'Homepage Newsletter Section', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Homepage Newsletter Section <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );

			// Homepage Pricing Section
			$wp_customize->add_setting( 'homepage_pricing_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_pricing_section', array(
				'label'				=> __( 'Homepage Pricing Section', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Homepage Pricing Section <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );

			// Homepage Services Section
			$wp_customize->add_setting( 'homepage_services_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_services_section', array(
				'label'				=> __( 'Homepage Services Section', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );

			// Homepage Team Section
			$wp_customize->add_setting( 'homepage_team_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_team_section', array(
				'label'				=> __( 'Homepage Team Section', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
				
			// Homepage Testimonials Section
			$wp_customize->add_setting( 'homepage_testimonials_section', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_testimonials_section', array(
				'label'				=> __( 'Homepage Testimonials Section', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Homepage Testimonials Section <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
				'active_callback'	=> 'homepage_sections_callback'
			) );
			
			// Icon Fonts
			$wp_customize->add_setting( 'icon_fonts', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'icon_fonts', array(
				'label'				=> __( 'Icon Fonts', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			function icon_fonts_callback( $control ) {
				if ( $control->manager->get_setting( 'icon_fonts' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Minify
			$wp_customize->add_setting( 'minify', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'minify', array(
				'label'				=> __( 'Minify', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Minify <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			
			// Navbar Scroll
			$wp_customize->add_setting( 'navbar_scroll', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'navbar_scroll', array(
				'label'				=> __( 'Navbar Scroll', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			
			// Notification Bar
			$wp_customize->add_setting( 'notification_bar', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'notification_bar', array(
				'label'				=> __( 'Notification Bar', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Notification Bar <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			
			// Right to Left Language
			$wp_customize->add_setting( 'right_to_left_language', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'right_to_left_language', array(
				'label'				=> __( 'Right to Left Language', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			
			// Search Collapse
			$wp_customize->add_setting( 'search_collapse', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'search_collapse', array(
				'label'				=> __( 'Search Collapse', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			
			// Smooth Scroll
			$wp_customize->add_setting( 'smooth_scroll', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'smooth_scroll', array(
				'label'				=> __( 'Smooth Scroll', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			function smooth_scroll_callback( $control ) {
				if ( $control->manager->get_setting( 'smooth_scroll' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Social Sharing
			$wp_customize->add_setting( 'social_sharing', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'social_sharing', array(
				'label'				=> __( 'Social Sharing', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Social Sharing <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			
			// Typography
			$wp_customize->add_setting( 'typography', array(
				'default'			=> '',
				'sanitize_callback' => 'minisite_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'typography', array(
				'label'				=> __( 'Typography', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Typography <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'theme_options',
			) );
			
		// Settings
		$wp_customize->add_panel( 'theme_settings', array(
			'title'				=> __( 'Settings', 'minisite-lite' ),
			'priority'			=> 1000
		) );
			
			// Background
			$wp_customize->get_control( 'background_color' )->section = 'background_image';
			$wp_customize->get_section( 'background_image' )->title = __( 'Background', 'minisite-lite' );
			$wp_customize->get_section( 'background_image' )->panel = 'theme_settings';
			$wp_customize->get_section( 'background_image' )->priority = 10;
			$wp_customize->get_section( 'background_image' )->active_callback = 'custom_background_image_callback';
			
			// Colors
			$wp_customize->get_section( 'colors' )->panel = 'theme_settings';
			$wp_customize->get_section( 'colors' )->priority = 20;
			$wp_customize->get_section( 'colors' )->active_callback = 'custom_colors_callback';
			
				// Remove Header Text Color
				$wp_customize->remove_control( 'header_textcolor' );
			
				// Link Color
				$wp_customize->add_setting( 'display_link_color', array(
					'default'			=> '',
					'sanitize_callback' => 'minisite_sanitize_checkbox'
				) );
				$wp_customize->add_control( 'display_link_color', array(
					'label'				=> __( 'Link Color', 'minisite-lite' ),
					'type'				=> 'checkbox',
					'section'			=> 'colors',
				) );
				function display_link_color_callback( $control ) {
					if ( $control->manager->get_setting( 'display_link_color' )->value() == true ) {
						return true;
					} else {
						return false;
					}
				}
				$wp_customize->add_setting( 'link_color', array(
					'default'			=> '',
					'transport' 		=> 'postMessage',
					'sanitize_callback' => 'sanitize_hex_color'
				) ); 
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
					'label' 			=> __( 'Link Color', 'minisite-lite' ),
					'settings' 			=> 'link_color',
					'section'		 	=> 'colors',
					'active_callback'   => 'display_link_color_callback'
				) ) );
		
			// Additional CSS
			$wp_customize->get_section( 'custom_css' )->title = __( 'CSS', 'minisite-lite' );
			$wp_customize->get_section( 'custom_css' )->panel = 'theme_settings';
			$wp_customize->get_section( 'custom_css' )->priority = 30;	
			$wp_customize->get_section( 'custom_css' )->active_callback = 'css_callback';
		
		
		// Sanitize RGBA Color
		function minisite_sanitize_rgba( $input, $setting ) {
			if ( empty( $input ) || is_array( $input ) ) {
				return $setting->default;
			}
			if ( false === strpos( $input, 'rgba' ) ) {
				$input = sanitize_hex_color( $input );
			} else {
				$input = str_replace( ' ', '', $input );
				sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
				$input = 'rgba(' . minisite_in_range( $red, 0, 255 ) . ',' . minisite_in_range( $green, 0, 255 ) . ',' . minisite_in_range( $blue, 0, 255 ) . ',' . minisite_in_range( $alpha, 0, 1 ) . ')';
			}
			return $input;
		}

		// Sanitize Checkbox
		function minisite_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}

		// Sanitize File
		function minisite_sanitize_file( $file, $setting ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png',
				'svg'		   => 'image/svg+xml',
				'svgz'         => 'image/svg+xml',
			);
			$file_ext = wp_check_filetype( $file, $mimes );
			return ( $file_ext['ext'] ? $file : $setting->default );
		}

		// Sanitize Number Range
		function minisite_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 0.001 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}

		// Sanitize Select
		function minisite_sanitize_select( $input, $setting ){
			$input = sanitize_key($input);
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                  
		}

		// Sanitize Radio
		function minisite_sanitize_radio( $input, $setting ){
			$input = sanitize_key($input);
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
		}
	}
	
	// Customizer styles
	public static function minisite_customize_styles() {
		wp_enqueue_style( 'minisite-customize-style', get_template_directory_uri() . '/inc/customizer/css/customizer.css' );
	}
	
	// Customizer live preview
	public static function minisite_customize_preview_js() {
		wp_enqueue_script( 'minisite-customizer', get_template_directory_uri() . '/inc/customizer/js/customizer.js', array( 'customize-preview' ), '20151215', true );
	}

	// Customizer header output
	public static function minisite_header_output() { 
		$display_navbar								= get_theme_mod( 'display_navbar' , true );	
		$display_logo								= get_theme_mod( 'display_logo' , '' );
		$site_logo 									= wp_get_attachment_url( get_theme_mod( 'site_logo' , '' ) );
		$site_logo_size								= get_theme_mod( 'site_logo_size' , '' );
		$display_site_logo_icon						= get_theme_mod( 'display_site_logo_icon' , '' );
		$site_logo_icon_color						= get_theme_mod( 'site_logo_icon_color' , '' );
		$site_logo_icon_size						= get_theme_mod( 'site_logo_icon_size' , '' );
		$display_site_title							= get_theme_mod( 'display_site_title' , true ); 
		$site_title_color							= get_theme_mod( 'site_title_color' , '' );
		$site_title_size							= get_theme_mod( 'site_title_size' , '' );		
		$display_tagline							= get_theme_mod( 'display_tagline' , true );
		$display_search								= get_theme_mod( 'display_search' , '' );
		$display_menu								= get_theme_mod( 'display_menu' , true );
		$full_width_navbar							= get_theme_mod( 'full_width_navbar' , '' );
		$display_hamburger_menu						= get_theme_mod( 'display_hamburger_menu' , 'navbar-expand-lg' );		
		$display_navbar_colors						= get_theme_mod( 'display_navbar_colors' , '' );
		$navbar_background_color					= get_theme_mod( 'navbar_background_color' , '' );
		$navbar_font_color							= get_theme_mod( 'navbar_font_color' , '' ); 
		$sticky_navbar								= get_theme_mod( 'sticky_navbar' , '' );
		$display_sticky_navbar_logo					= get_theme_mod( 'display_sticky_navbar_logo' , '' );
		$sticky_navbar_logo 						= wp_get_attachment_url( get_theme_mod( 'sticky_navbar_logo' , '' ) );
		$sticky_navbar_icon_color					= get_theme_mod( 'sticky_navbar_icon_color' , '' );
		$sticky_navbar_site_title_color				= get_theme_mod( 'sticky_navbar_site_title_color' , '' );
		$display_sticky_navbar_colors				= get_theme_mod( 'display_sticky_navbar_colors' , '' );   
		$sticky_navbar_background_color				= get_theme_mod( 'sticky_navbar_background_color' , '' );
		$sticky_navbar_font_color					= get_theme_mod( 'sticky_navbar_font_color' , '' );		
		$display_header								= get_theme_mod( 'display_header' , '' ); 
		$display_header_height						= get_theme_mod( 'display_header_height' , '' );
		$header_height								= get_theme_mod( 'header_height' , '255' );	
		$display_header_position					= get_theme_mod( 'display_header_position' , '' );
		$header_position							= get_theme_mod( 'header_position' , '' );	
		$full_screen_header							= get_theme_mod( 'full_screen_header' , '' );
		$display_header_colors						= get_theme_mod( 'display_header_colors', '' );
		$display_header_font_color					= get_theme_mod( 'display_header_font_color', '' );
		$header_font_color							= get_theme_mod( 'header_font_color', '' );
		$display_header_heading_color				= get_theme_mod( 'display_header_heading_color', '' );
		$header_heading_color						= get_theme_mod( 'header_heading_color', '' );	
		$display_header_image_background 			= get_theme_mod( 'display_header_image_background' , '' );	
		$display_header_image_background_color 		= get_theme_mod( 'display_header_image_background_color' , '' );
		$header_image_background_color				= get_theme_mod( 'header_image_background_color' , '' );
		$display_header_image_background_image		= get_theme_mod( 'display_header_image_background_image' , '' );
		$header_image								= get_header_image(); 
		$header_image_background_attachment			= get_theme_mod( 'header_image_background_attachment' , '' );
		$header_image_background_position			= get_theme_mod( 'header_image_background_position' , '' );
		$header_image_background_size				= get_theme_mod( 'header_image_background_size' , '' );
		$header_image_background_repeat				= get_theme_mod( 'header_image_background_repeat' , '' );	
		$header_image_background_image_opacity		= get_theme_mod( 'header_image_background_image_opacity' , '' );
		$header_image_overlay_color					= get_theme_mod( 'header_image_overlay_color' , '' );
		$header_image_overlay_color_opacity			= get_theme_mod( 'header_image_overlay_color_opacity' , '' );
		$header_image_blend_mode					= get_theme_mod( 'header_image_blend_mode' , '' );
		$display_header_padding						= get_theme_mod( 'display_header_padding' , '' );
		$header_top_padding							= get_theme_mod( 'header_top_padding' , '' );
		$header_bottom_padding						= get_theme_mod( 'header_bottom_padding' , '' );
		$display_link_color							= get_theme_mod( 'display_link_color' , '' );
		$link_color									= get_theme_mod( 'link_color' , '' );
		$display_button_color						= get_theme_mod( 'display_button_color' , '' );
		$button_color								= get_theme_mod( 'button_color' , '' );
			
		echo '<style type="text/css">';
		if ( $display_navbar == true ) :
			if ( $display_navbar_colors == true ) :
				self::generate_css( '.navbar, .navbar .navbar-nav .nav-item.show, .navbar .navbar-nav .nav-item.show .nav-item' , 'background-color', $navbar_background_color );
				self::generate_css( '.site-logo-icon i, .site-title a, .site-title a:hover, .site-description, .navbar .navbar-nav .nav-item a, .navbar .navbar-nav a[title="Add a menu"], .navbar .navbar-collapse.show .search-form .search-field' , 'color' , $navbar_font_color );	
				self::generate_css( '.navbar .navbar-toggler .navbar-toggler-icon', 'background-color' , $navbar_font_color );		
				self::generate_css( '.navbar .navbar-nav .nav-item.show a' , 'color' , $navbar_font_color );
				self::generate_css( '.navbar .search-form .search-submit' , 'background-color', $navbar_font_color );
				self::generate_css( '.navbar .search-form .search-submit.search-collapse' , 'background-color', $navbar_font_color );
			endif;
			if ( $display_logo == true ) :
				self::generate_css( '.site-logo-img' , 'content', $site_logo, 'url(', ')' );
				self::generate_css( '.site-logo-img' , 'width', $site_logo_size , '', 'rem' );
			endif;
			if ( $display_site_logo_icon == true ) :
				self::generate_css( '.site-logo-icon i' , 'color' , $site_logo_icon_color );	
				self::generate_css( '.site-logo-icon i' , 'font-size' , $site_logo_icon_size, '', 'rem' );	
			endif;	
			if ( $display_site_title == true ) :
				self::generate_css( '.site-title a' , 'color' , $site_title_color );
				self::generate_css( '.site-title a' , 'font-size' , $site_title_size, '', 'rem' );
			endif;
			if ( $sticky_navbar == true ) :
				if ( $display_sticky_navbar_colors == true ) :
					self::generate_css( '.navbar.navbar-scroll, .navbar.navbar-scroll .navbar-nav .nav-item.show, .navbar.navbar-scroll .navbar-nav .nav-item.show .nav-item' , 'background-color' , $sticky_navbar_background_color );
					self::generate_css( '.navbar.navbar-scroll .site-logo-icon i, .navbar.navbar-scroll .site-title a, .navbar.navbar-scroll .site-title a:hover, .navbar.navbar-scroll .site-description, .navbar.navbar-scroll .navbar-toggler-icon, .navbar.navbar-scroll .navbar-nav .nav-item a, .navbar.navbar-scroll .navbar-nav a[title="Add a menu"], .navbar.navbar-scroll .navbar-collapse.show .search-form .search-field' , 'color' , $sticky_navbar_font_color );
					self::generate_css( '.navbar.navbar-scroll .navbar-toggler .navbar-toggler-icon' , 'background-color' , $sticky_navbar_font_color );
					self::generate_css( '.navbar.navbar-scroll .navbar-nav .nav-item.show a' , 'color' , $sticky_navbar_font_color );
					self::generate_css( '.navbar.navbar-scroll .search-form .search-submit, .navbar.navbar-scroll .search-form .search-submit.search-collapse' , 'background-color' , $sticky_navbar_font_color ); 
				endif;
				if ( $display_sticky_navbar_logo == true ) :
					self::generate_css( '.navbar.navbar-scroll .site-logo-img' , 'content' , $sticky_navbar_logo, 'url(', ')' );
				endif;
				if ( $display_site_logo_icon == true ) :
					self::generate_css( '.navbar.navbar-scroll .site-logo-icon i' , 'color' , $sticky_navbar_icon_color );
				endif;
				if ( $display_site_title == true ) :
					self::generate_css( '.navbar.navbar-scroll .site-title a' , 'color' , $sticky_navbar_site_title_color );
				endif;
			endif;
		endif;
		if ( $display_header == true ) :
			if ( $display_header_height == true ) :
				self::generate_css( '#header-image, #header-image .container' , 'min-height' , $header_height, '', 'px' );
			endif;
			if ( $display_header_position == true ) :
				self::generate_css( 'body' , 'padding-top' , $header_position, '', 'px' );
			endif;
			if ( $full_screen_header == true ) :
				self::generate_css( '#header-image, #header-image .container' , 'min-height' , '100vh' );
			endif;
			if ( $display_header_colors == true ) :
				if ( $display_header_font_color == true ) :
					self::generate_css('#header-image', 'color', $header_font_color );
				endif;
				if ( $display_header_heading_color == true ) :
					self::generate_css('#header-image h1, #header-image h2, #header-image h3, #header-image h4, #header-image h5, #header-image h6', 'color', $header_heading_color );
				endif;
			endif;
			if ( $display_header_image_background == true ) :
				if ( $display_header_image_background_color == true ) :
					self::generate_css( '#header-image' , 'background-color' , $header_image_background_color );
				endif;
				if ( $display_header_image_background_image == true ) :
					self::generate_css( '#header-image .header-image-background-image' , 'background-image' , $header_image );
					self::generate_css( '#header-image .header-image-background-image' , 'background-attachment' , $header_image_background_attachment );
					self::generate_css( '#header-image .header-image-background-image' , 'background-position' , $header_image_background_position );
					self::generate_css( '#header-image .header-image-background-image' , 'background-size' , $header_image_background_size );
					self::generate_css( '#header-image .header-image-background-image' , 'background-repeat' , $header_image_background_repeat );
					self::generate_css( '#header-image .header-image-background-image' , 'opacity' , $header_image_background_image_opacity );
					self::generate_css( '#header-image .header-image-overlay-color' , 'background-color' , $header_image_overlay_color );
					self::generate_css( '#header-image .header-image-overlay-color' , 'opacity' , $header_image_overlay_color_opacity );
					self::generate_css( '#header-image .header-image-overlay-color' , 'mix-blend-mode' , $header_image_blend_mode );
				endif;		
			endif;
			if ( $display_header_padding ) :			
				self::generate_css( '#header-image', 'padding-top', $header_top_padding, '', 'rem' );
				self::generate_css( '#header-image', 'padding-bottom', $header_bottom_padding, '', 'rem' );
			endif;	
		endif;
		if ( $display_link_color == true ) :
			self::generate_css( 'a, a:active, a:focus, a:hover, a:visited' , 'color' , $link_color );
		endif;
	 	echo '</style>';
	}

	// Generate CSS to be used in Customizer header output above
	public static function generate_css( $selector, $style, $mod, $prefix='', $postfix='', $echo=true ) {
		$return = '';
		if ( $style=='background-image' ) {
			$mod = 'url("'.$mod.'")';
		}
		if ( ! empty( $mod ) ) {
			$return = sprintf('%s { %s:%s; }',
				$selector,
				$style,
				$prefix.$mod.$postfix
			);
			if ( $echo ) {
				echo $return;
			}
		}
		return $return;
    }
} // End Class

// Customizer
add_action( 'customize_register' , array( 'Minisite_Customizer' , 'minisite_customize_register' ) );

// Customizer styles
add_action( 'customize_controls_enqueue_scripts' , array( 'Minisite_Customizer' , 'minisite_customize_styles' ) );

// Customizer live preview
add_action( 'customize_preview_init', array( 'Minisite_Customizer' , 'minisite_customize_preview_js' ) );

// Customizer header output
add_action( 'wp_head' , array( 'Minisite_Customizer' , 'minisite_header_output' ) );
