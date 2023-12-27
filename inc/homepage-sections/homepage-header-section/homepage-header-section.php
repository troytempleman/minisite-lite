<?php
/**
 * Plugin Name: Homepage Header Section
 * Plugin URI: https://getminisites.com/theme/
 * Description: 
 * Version: 1.0.0
 * Author: Troy Templeman
 * Author URI: https://troytempleman.com/
 * License: GNU General Public License v2 or later
 * License URI: LICENSE
 * Text Domain: homepage-header-section
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Homepage_Header_Section to prevent the need to use globals
function Homepage_Header_Section() {
	return Homepage_Header_Section::instance();
} 

Homepage_Header_Section();

// Homepage_Header_Section Class
final class Homepage_Header_Section {
	
	// The single instance of Homepage_Header_Section
	private static $_instance = null;
	
	// Constructor
	public function __construct() {

		// Plugin URL
		$dir = __DIR__;
		$wp_content_url = untrailingslashit( dirname( dirname( get_stylesheet_directory_uri() ) ) );
		$wp_content_dir = untrailingslashit( WP_CONTENT_DIR );
		$dir = wp_normalize_path( $dir );
		$wp_content_dir = wp_normalize_path( $wp_content_dir );
		$this->plugin_url = trailingslashit( str_replace( $wp_content_dir, $wp_content_url, $dir ) );
		
		// Plugin Path
		$this->plugin_path = trailingslashit( dirname( __FILE__ ) );

		add_action( 'init', array( $this, 'homepage_header_section_setup' ) );
	}

	// Homepage_Header_Section Instance
	// Ensures only one instance of Homepage_Header_Section is loaded or can be loaded
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	}

	// Cloning is forbidden
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'minisite-lite' ), '1.0.0' );
	}

	// Unserializing instances of this class is forbidden
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'minisite-lite' ), '1.0.0' );
	}
	
	// Setup
	public function homepage_header_section_setup() {
		add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_scripts' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'homepage_header_section_styles' ), 100 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'homepage_header_section_customize_styles' ), 100 );
		add_action( 'customize_preview_init', array( $this, 'homepage_header_section_customize_live_preview' ), 100 );
		add_action( 'customize_register', array( $this, 'homepage_header_section_customize_register' ) );
		add_action( 'wp_head' , array( $this, 'homepage_header_section_header_output' ), 100 );
		//add_action( 'homepage', array( $this, 'homepage_header_section' ), 5 );
	}

	// Customizer
	public function homepage_header_section_customize_register( $wp_customize ) {
		
		// Header	
		$wp_customize->add_section( 'homepage_header' , array(
			'title'				=> __( 'Header', 'minisite-lite' ),
			'description'		=> 'By default, the homepage inherits the main <a href="' . admin_url() . '/customize.php?autofocus[section]=title_tagline" target="_blank">Header</a> settings. These settings will override those settings for the homepage only.',
			'panel'				=> 'homepage',
			'priority' 			=> 3
		) );
			
			// Navbar
			$wp_customize->add_setting( 'display_homepage_navbar', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'	
			) );
			$wp_customize->add_control( 'display_homepage_navbar', array(
				'label'				=> __( 'Navbar', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
			) );
			function display_homepage_navbar_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_navbar' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Logo
			$wp_customize->add_setting( 'display_homepage_logo', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox',	
			) );
			$wp_customize->add_control( 'display_homepage_logo', array(
				'label'				=> __( 'Logo', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
 					return ( display_logo_callback( $control ) && display_homepage_navbar_callback( $control ) );
 				 }
			) );
			$wp_customize->selective_refresh->add_partial( 'display_homepage_logo', array(
				'selector'			=> '.site-logo'
			) );
			function display_homepage_logo_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_logo' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_site_logo', array(
				'default'			=> '',
				'sanitize_callback' => 'absint',
			) );  	
			$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'homepage_site_logo', array(
				'label'				=> __( 'Logo', 'minisite-lite' ),
				'flex_width'  		=> true, 
				'flex_height' 		=> true,
				'width'       		=> 100,
				'height'      		=> 100,
				'settings'			=> 'homepage_site_logo',
				'section'			=> 'homepage_header',
 				'active_callback'   => function( $control ) {
 					return ( display_homepage_navbar_callback( $control ) && display_homepage_logo_callback( $control ) );
 				 }
			) ) );
		
			// Logo Size
			$wp_customize->add_setting( 'homepage_site_logo_size' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_number_range'
			) );
			$wp_customize->add_control( 'homepage_site_logo_size', array(
				'label'   			=> __( 'Logo Size', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 10,
					'step'  		=> 0.001
				),
				'section'			=> 'homepage_header',
 				'active_callback'   => function( $control ) {
 					return ( display_homepage_navbar_callback( $control ) && display_homepage_logo_callback( $control ) );
 				 }
			) );
		
			// Icon
			$wp_customize->add_setting( 'display_homepage_site_logo_icon', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_site_logo_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
 				'active_callback'   => function( $control ) {
 					return ( display_site_logo_icon_callback( $control ) && display_homepage_navbar_callback( $control ) );
 				 }
			) );
			function display_homepage_site_logo_icon_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_site_logo_icon' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}

			// Icon Color
			$wp_customize->add_setting( 'homepage_site_logo_icon_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'homepage_site_logo_icon_color', array(
				'label' 			=> __( 'Icon Color', 'minisite-lite' ),
				'section'		 	=> 'homepage_header',
				'settings' 			=> 'homepage_site_logo_icon_color',
				'active_callback'   => function( $control ) {
					return ( display_homepage_navbar_callback( $control )  && display_homepage_site_logo_icon_callback( $control ) );
				 }
			) ) );	
			
			// Icon Size
			$wp_customize->add_setting( 'homepage_site_logo_icon_size', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_number_range'
			) ); 
			$wp_customize->add_control( 'homepage_site_logo_icon_size', array(
				'label' 			=> __( 'Icon Size', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 4,
					'step'  		=> 0.001
				),
				'section'		 	=> 'homepage_header',
 				'active_callback'   => function( $control ) {
 					return ( display_homepage_navbar_callback( $control ) && display_homepage_site_logo_icon_callback( $control ) );
 				 }
			) ) ;
			
			// Site Title
			$wp_customize->add_setting( 'display_homepage_site_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_site_title', array(
				'label'				=> __( 'Site Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
 					return ( display_site_title_callback( $control ) && display_homepage_navbar_callback( $control ) );
				}
			) );
			function display_homepage_site_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_site_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}

			// Site Title Color
			$wp_customize->add_setting( 'homepage_site_title_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'homepage_site_title_color', array(
				'label' 			=> __( 'Site Title Color', 'minisite-lite' ),
				'section'		 	=> 'homepage_header',
				'settings' 			=> 'homepage_site_title_color',
				'active_callback'   => function( $control ) {
					return ( display_homepage_navbar_callback( $control ) && display_homepage_site_title_callback( $control ) );
				 }
			) ) );
			
			// Site Title Size
			$wp_customize->add_setting( 'homepage_site_title_size' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_number_range'
			) );
			$wp_customize->add_control( 'homepage_site_title_size', array(
				'label'   			=> __( 'Site Title Size', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 5,
					'step'  		=> 0.001
				),
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
 					return ( display_navbar_callback( $control ) && display_homepage_site_title_callback( $control ) );
 				 }
			) );
			
			// Navbar Colors
			$wp_customize->add_setting( 'display_homepage_navbar_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'		
			) );
			$wp_customize->add_control( 'display_homepage_navbar_colors', array(
				'label'				=> __( 'Navbar Colors', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => 'display_homepage_navbar_callback',
			) );
			function display_homepage_navbar_colors_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_navbar_colors' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
		
			// Navbar Font Color
			$wp_customize->add_setting( 'homepage_navbar_font_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'			
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'homepage_navbar_font_color', array(
				'label' 			=> __( 'Navbar Font Color', 'minisite-lite' ),
				'section'			=> 'homepage_header',
				'settings' 			=> 'homepage_navbar_font_color',
				'active_callback'   => function( $control ) {
 					return ( display_homepage_navbar_callback( $control ) && display_homepage_navbar_colors_callback( $control ) );
 				 }
			) ) );
			
			// Navbar Background Color
		   	$wp_customize->add_setting( 'homepage_navbar_background_color', array(
		   		'default'    		=> '',
				'type'        		=> 'theme_mod',
				'capability'  		=> 'edit_theme_options',
		   		//'transport'  		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
		   	) );
		   	$wp_customize->add_control( new Minisite_Customize_Alpha_Color_Control( $wp_customize, 'homepage_navbar_background_color', array(
		   		'label'        		=> __( 'Navbar Background Color', 'minisite-lite' ),
		   		'settings'     		=> 'homepage_navbar_background_color',
				'section'			=> 'homepage_header',
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
				'active_callback'   => function( $control ) {
 					return ( display_homepage_navbar_callback( $control ) && display_homepage_navbar_colors_callback( $control ) );
 				}	
		   	) ) );	
				
			// Sticky Navbar
			$wp_customize->add_setting( 'sticky_homepage_navbar', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'		
			) );
			$wp_customize->add_control( 'sticky_homepage_navbar', array(
				'label'				=> __( 'Sticky Navbar', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => 'display_homepage_navbar_callback',
			) );
			function sticky_homepage_navbar_callback( $control ) {
				if ( $control->manager->get_setting( 'sticky_homepage_navbar' )->value() == true ) {
					return true; 
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'sticky_homepage_navbar_description', array(
		    	'default'			=> '',
		   		'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );
			$wp_customize->add_control( new Minisite_Simple_Notice_Custom_control( $wp_customize, 'sticky_homepage_navbar_description', array(
				'description'		=> 'A sticky navbar sticks to the top of the browser window so that it doesn&#39;t disappear when scrolling. This option enables a sticky navbar on the homepage and allows you to customize it&#39;s appearance after scrolling.',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
 					return ( display_homepage_navbar_callback( $control ) && sticky_homepage_navbar_callback( $control ) );
 				}
			) ) );	
			
			// Sticky Navbar Logo
			$wp_customize->add_setting( 'display_sticky_homepage_navbar_logo', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox',	
			) );
			$wp_customize->add_control( 'display_sticky_homepage_navbar_logo', array(
				'label'				=> __( 'Sticky Navbar Logo', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_logo_callback( $control ) && display_homepage_navbar_callback( $control ) && display_homepage_logo_callback( $control ) && sticky_homepage_navbar_callback( $control ) );
				 },
			) );
			function display_sticky_homepage_navbar_logo_callback( $control ) {
				if ( $control->manager->get_setting( 'display_sticky_homepage_navbar_logo' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}	
			$wp_customize->add_setting( 'sticky_homepage_navbar_logo', array(
				'default'			=> '',
				'sanitize_callback' => 'absint',
			) );  	
			$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'sticky_homepage_navbar_logo', array(
				'label'				=> __( 'Sticky Navbar Logo', 'minisite-lite' ),
				'flex_width'  		=> true, 
				'flex_height' 		=> true,
				'width'       		=> 100,
				'height'      		=> 100,
				'settings'			=> 'sticky_homepage_navbar_logo',
				'section'			=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_logo_callback( $control ) && display_homepage_navbar_callback( $control ) && display_homepage_logo_callback( $control ) && sticky_homepage_navbar_callback( $control ) && display_sticky_homepage_navbar_logo_callback( $control ) );
				}	
			) ) );	
		
			// Sticky Navbar Icon Color
			$wp_customize->add_setting( 'sticky_homepage_navbar_icon_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sticky_homepage_navbar_icon_color', array(
				'label' 			=> __( 'Sticky Navbar Icon Color', 'minisite-lite' ),
				'section'		 	=> 'homepage_header',
				'settings' 			=> 'sticky_homepage_navbar_icon_color',
				'active_callback'   => function( $control ) {
					return ( display_site_logo_icon_callback( $control ) && display_homepage_navbar_callback( $control ) && sticky_homepage_navbar_callback( $control ) );
				}
			) ) );	
			
			// Sticky Navbar Site Title Color
			$wp_customize->add_setting( 'sticky_homepage_navbar_site_title_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sticky_homepage_navbar_site_title_color', array(
				'label' 			=> __( 'Sticky Navbar Site Title Color', 'minisite-lite' ),
				'section'		 	=> 'homepage_header',
				'settings' 			=> 'sticky_homepage_navbar_site_title_color',
				'active_callback'   => function( $control ) {
					return ( display_site_title_callback( $control ) && display_homepage_navbar_callback( $control ) && sticky_homepage_navbar_callback( $control ) );
				}
			) ) );	
			
			// Sticky Navbar Colors
			$wp_customize->add_setting( 'display_sticky_homepage_navbar_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'		
			) );
			$wp_customize->add_control( 'display_sticky_homepage_navbar_colors', array(
				'label'				=> __( 'Sticky Navbar Colors', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_navbar_callback( $control ) && sticky_homepage_navbar_callback( $control ) );
				}
			) );
			function display_sticky_homepage_navbar_colors_callback( $control ) {
				if ( $control->manager->get_setting( 'display_sticky_homepage_navbar_colors' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Sticky Navbar Font Color
			$wp_customize->add_setting( 'sticky_homepage_navbar_font_color', array(
				'default'			=> '',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sticky_homepage_navbar_font_color', array(
				'label' 			=> __( 'Sticky Navbar Font Color', 'minisite-lite' ),
				'section'			=> 'homepage_header',
				'settings' 			=> 'sticky_homepage_navbar_font_color',
				'active_callback'   => function( $control ) {
   					return ( display_homepage_navbar_callback( $control ) && sticky_homepage_navbar_callback( $control )  && display_sticky_homepage_navbar_colors_callback( $control ) );
				}
			) ) );

			// Sticky Navbar Background Color
			$wp_customize->add_setting( 'sticky_homepage_navbar_background_color', array(
				'default'    		=> '',
				'type'        		=> 'theme_mod',
				'capability'  		=> 'edit_theme_options',
				//'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_rgba'
			) );
			$wp_customize->add_control( new Minisite_Customize_Alpha_Color_Control( $wp_customize, 'sticky_homepage_navbar_background_color', array(
				'label'        		=> __( 'Sticky Navbar Background Color', 'minisite-lite' ),
				'settings'     		=> 'sticky_homepage_navbar_background_color',
				'section'			=> 'homepage_header',
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
				'active_callback'   => function( $control ) {
   					return ( display_homepage_navbar_callback( $control ) && sticky_homepage_navbar_callback( $control )  && display_sticky_homepage_navbar_colors_callback( $control ) );
				}
			) ) );	

			// Header
			$wp_customize->add_setting( 'display_homepage_header', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header', array(
				'label'				=> __( 'Header', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
			) );
			function display_homepage_header_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Header Height
			$wp_customize->add_setting( 'display_homepage_header_height', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_height', array(
				'label'				=> __( 'Header Height', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'	=> 'display_homepage_header_callback'
			) );
			function display_homepage_header_height_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_height' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_height', array(
				'default' 			=> '', 	
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_number_range'
			) );	
			$wp_customize->add_control( 'homepage_header_height', array(
				'label'				=> __( 'Header Height (px)', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 1000,
					'step'  		=> 1
				),
				'section'			=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_height_callback( $control ) );
				}
			) );
			
			// Header Position
			$wp_customize->add_setting( 'display_homepage_header_position', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_position', array(
				'label'				=> __( 'Header Position', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'	=> 'display_homepage_header_callback'
			) );
			function display_homepage_header_position_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_position' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_position', array(
				'default' 			=> '', 	
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_number_range'
			) );	
			$wp_customize->add_control( 'homepage_header_position', array(
				'label'				=> __( 'Header Position', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 1000,
					'step'  		=> 1
				),
				'section'			=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control )  && display_homepage_header_position_callback( $control ) );
				}
			) );
			
			// Full Screen Header
			$wp_customize->add_setting( 'full_screen_homepage_header', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'full_screen_homepage_header', array(
				'label'				=> __( 'Full Screen Header', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => 'display_homepage_header_callback',
			) );
			function full_screen_homepage_header_callback( $control ) {
				if ( $control->manager->get_setting( 'full_screen_homepage_header' )->value() == false ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Scroll Down Arrow
			$wp_customize->add_setting( 'homepage_header_scroll_down_arrow', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'homepage_header_scroll_down_arrow', array(
				'label'				=> __( 'Scroll Down Arrow', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => 'display_homepage_header_callback',
			) );
			function homepage_header_scroll_down_arrow_callback( $control ) {
				if ( $control->manager->get_setting( 'homepage_header_scroll_down_arrow' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Scroll Down Arrow Link
			$wp_customize->add_setting( 'homepage_header_scroll_down_arrow_link', array(
				'default' 			=> '',  	
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'homepage_header_scroll_down_arrow_link', array(
				'label'				=> __( 'Scroll Down Arrow Link', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && homepage_header_scroll_down_arrow_callback( $control ) );
				 },
			) );
				
			// Image
			
			// Title
			$wp_customize->add_setting( 'display_homepage_header_image_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => 'display_homepage_header_callback'
			) );
			function display_homepage_header_image_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_image_title', array(
				'default' 			=> __( 'Header', 'minisite-lite' ),  	
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'homepage_header_image_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_title_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'homepage_header_image_title', array(
				'selector'			=> '.homepage-header-image-title'
			) );
			
			// Text
			$wp_customize->add_setting( 'display_homepage_header_image_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => 'display_homepage_header_callback'
			) );
			function display_homepage_header_image_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_image_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'homepage_header_image_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'homepage_header',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_text_callback( $control ) );
				 },
			) ) );
			
			// Button 
			$wp_customize->add_setting( 'display_homepage_header_image_button_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_button_1', array(
				'label'				=> __( 'Button 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => 'display_homepage_header_callback'
			) );
			function display_homepage_header_image_button_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_button_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_image_button_1_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'homepage_header_image_button_1_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_button_1_callback( $control ) );
				}
			) );

			// URL
			$wp_customize->add_setting( 'homepage_header_image_button_1_url', array(
				'default'			=>  '#', 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'homepage_header_image_button_1_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_button_1_callback( $control ) );
				}
			) );		
			
			// Button 
			$wp_customize->add_setting( 'display_homepage_header_image_button_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_button_2', array(
				'label'				=> __( 'Button 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => 'display_homepage_header_callback'
			) );
			function display_homepage_header_image_button_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_button_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_image_button_2_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'homepage_header_image_button_2_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_button_2_callback( $control ) );
				}
			) );

			// URL
			$wp_customize->add_setting( 'homepage_header_image_button_2_url', array(
				'default'			=>  '#', 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'homepage_header_image_button_2_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_button_2_callback( $control ) );
				}
			) );
			
			// Colors
			$wp_customize->add_setting( 'display_homepage_header_image_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_colors', array(
				'label'				=> __( 'Colors', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'	=> 'display_homepage_header_callback',
				'active_callback'	=> 'display_homepage_header_callback'
			) );
			function display_homepage_header_image_colors_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_colors' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Heading Color
			$wp_customize->add_setting( 'display_homepage_header_image_heading_color', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_heading_color', array(
				'label'				=> __( 'Heading Color', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control )  && display_homepage_header_image_colors_callback( $control ) );
				}
			) );
			function display_homepage_header_image_heading_color_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_heading_color' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_image_heading_color', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'homepage_header_image_heading_color', array(
				'label' 			=> __( 'Heading Color', 'minisite-lite' ),
				'settings' 			=> 'homepage_header_image_heading_color',
				'section'		 	=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_colors_callback( $control ) && display_homepage_header_image_heading_color_callback( $control ) );
				}
			) ) );	

			// Font Color
			$wp_customize->add_setting( 'display_homepage_header_image_font_color', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_font_color', array(
				'label'				=> __( 'Font Color', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_colors_callback( $control ) );
				}
			) );
			function display_homepage_header_image_font_color_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_font_color' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_image_font_color', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'homepage_header_image_font_color', array(
				'label' 			=> __( 'Font Color', 'minisite-lite' ),
				'settings' 			=> 'homepage_header_image_font_color',
				'section'		 	=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_colors_callback( $control ) && display_homepage_header_image_font_color_callback( $control ) );
				}
			) ) );
			
			// Background
			$wp_customize->add_setting( 'display_homepage_header_image_background', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_background', array(
				'label'				=> __( 'Background', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'   => 'display_homepage_header_callback'
			) );
			function display_homepage_header_image_background_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_background' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
		
			// Background Color
			$wp_customize->add_setting( 'display_homepage_header_image_background_color', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_background_color', array(
				'label'				=> __( 'Background Color', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) );
				}
			) );
			function display_homepage_header_image_background_color_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_background_color' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_image_background_color', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'homepage_header_image_background_color', array(
				'label' 			=> __( 'Background Color', 'minisite-lite' ),
				'settings' 			=> 'homepage_header_image_background_color',
				'section'		 	=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control )&& display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_color_callback( $control ) );
				}
			) ) );
				
			// Background Image
			$wp_customize->add_setting( 'display_homepage_header_image_background_image', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_image_background_image', array(
				'label'				=> __( 'Background Image', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) );
				}
			) );
			function display_homepage_header_image_background_image_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_image_background_image' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'homepage_header_image_background_image', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_file'	
			) );  	
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'homepage_header_image_background_image', array(
				'label'				=> __( 'Background Image', 'minisite-lite' ),
				'settings'			=> 'homepage_header_image_background_image',
				'section'			=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_image_callback( $control ) );
				}	
			) ) );
			
			// Background Image Attachment
			$wp_customize->add_setting( 'homepage_header_image_background_attachment' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_select'
			) );
			$wp_customize->add_control( 'homepage_header_image_background_attachment', array(
				'label'   			=> __( 'Background Image Attachment', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'scroll' 		=> 'Scroll',
					'fixed' 		=> 'Fixed',
					'local' 		=> 'Local',
					'initial' 		=> 'Initial',
					'inherit' 		=> 'Inherit'
				),
				'section'		 	=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_image_callback( $control ) );
				}
			) );

			// Background Image Position
			$wp_customize->add_setting( 'homepage_header_image_background_position' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_select'
			) );
			$wp_customize->add_control( 'homepage_header_image_background_position', array(
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
				'section'		 	=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_image_callback( $control ) );
				}
			) );

			// Background Image Size
			$wp_customize->add_setting( 'homepage_header_image_background_size' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_select'
			) );
			$wp_customize->add_control( 'homepage_header_image_background_size', array(
				'label'   			=> __( 'Background Image Size', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'auto' 			=> 'Auto',
					'cover' 		=> 'Cover',
					'contain' 		=> 'Contain',
					'initial' 		=> 'Initial',
					'inherit' 		=> 'Inherit'
				),
				'section'		 	=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_image_callback( $control ) );
				}
			) );

			// Background Image Repeat
			$wp_customize->add_setting( 'homepage_header_image_background_repeat' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_select'
			) );
			$wp_customize->add_control( 'homepage_header_image_background_repeat', array(
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
				'section'		 	=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_image_callback( $control ) );
				}
			) );
					
			// Background Image Opacity
			$wp_customize->add_setting( 'homepage_header_image_background_image_opacity', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_number_range'
			) );
			$wp_customize->add_control( 'homepage_header_image_background_image_opacity', array(
				'label'       		=> __( 'Background Image Opacity', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 1.000,
					'step'  		=> 0.001,
				),
				'section'		 	=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_image_callback( $control ) );
				}		
			) );

			// Background Image Overlay Color
			$wp_customize->add_setting( 'homepage_header_image_overlay_color', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			) ); 
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'homepage_header_image_overlay_color', array(
				'label' 			=> __( 'Background Image Overlay Color', 'minisite-lite' ),
				'settings' 			=> 'homepage_header_image_overlay_color',
				'section'		 	=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_image_callback( $control ) );
				}
			) ) );	

			// Background Image Overlay Color Opacity
			$wp_customize->add_setting( 'homepage_header_image_overlay_color_opacity', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_number_range'
			) );
			$wp_customize->add_control( 'homepage_header_image_overlay_color_opacity', array(
				'label'       		=> __( 'Background Image Overlay Color Opacity', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 1.000,
					'step'  		=> 0.001,
				),
				'section'		 	=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_image_callback( $control ) );
				}
			) );	

			// Background Image Blend Mode
			$wp_customize->add_setting( 'homepage_header_image_blend_mode' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_select'
			) );
			$wp_customize->add_control( 'homepage_header_image_blend_mode', array(
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
				'section'		 	=> 'homepage_header',
				'active_callback'	=> function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_image_background_callback( $control ) && display_homepage_header_image_background_image_callback( $control ) );
				}
			) );
			
			// Padding
			$wp_customize->add_setting( 'display_homepage_header_padding', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_padding', array(
				'label'				=> __( 'Padding', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'	=> 'display_homepage_header_callback',
			) );
			function display_homepage_header_padding_callback( $control ) {
				if ( $control->manager->get_setting( 'display_homepage_header_padding' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
		
			// Top Padding
			$wp_customize->add_setting( 'homepage_header_top_padding', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_number_range'				
			) );
			$wp_customize->add_control( 'homepage_header_top_padding', array(
				'label'       		=> __( 'Top Padding', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 10.000,
					'step'  		=> 0.001,
				),
				'section'		 	=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_padding_callback( $control ) );
				}
			) );
		
			// Bottom Padding
			$wp_customize->add_setting( 'homepage_header_bottom_padding', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_header_section_sanitize_number_range'				
			) );
			$wp_customize->add_control( 'homepage_header_bottom_padding', array(
				'label'       		=> __( 'Bottom Padding', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 10.000,
					'step'  		=> 0.001,
				),
				'section'		 	=> 'homepage_header',
				'active_callback'   => function( $control ) {
					return ( display_homepage_header_callback( $control ) && display_homepage_header_padding_callback( $control ) );
				}
			) );
			
			// Carousel
			$wp_customize->add_setting( 'display_homepage_header_carousel', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_carousel', array(
				'label'				=> __( 'Carousel', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Carousel <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'	=> 'display_homepage_header_callback',
			) );
			
			// Animation
			$wp_customize->add_setting( 'display_homepage_header_animation', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_homepage_header_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_homepage_header_animation', array(
				'label'				=> __( 'Animation', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Animation <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'homepage_header',
				'active_callback'	=> 'display_homepage_header_callback',
			) );
		
		// Sanitize RGBA Color
		function homepage_header_section_sanitize_rgba( $input, $setting ) {
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
		function homepage_header_section_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}

		// Sanitize File
		function homepage_header_section_sanitize_file( $file, $setting ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png'
			);
			$file_ext = wp_check_filetype( $file, $mimes );
			return ( $file_ext['ext'] ? $file : $setting->default );
		}
		
		// Sanitize Radio
		function homepage_header_section_sanitize_radio( $input, $setting ){
			$input = sanitize_key($input);
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
		}
		
		// Sanitize Number Range
		function homepage_header_section_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 0.001 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}
		
		// Sanitize Select
		function homepage_header_section_sanitize_select( $input, $setting ){
			$input = sanitize_key($input);
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                  
		}
		
	}

	
	// Bootstrap
	public function bootstrap_scripts() {
		
		// Bootstrap core CSS 
		wp_enqueue_style( 'bootstrap-style', $this->plugin_url . 'css/bootstrap.min.css', array(), '4.3.1' );
		
		// Bootstrap core JavaScript 
		wp_enqueue_script( 'bootstrap-popper-js', $this->plugin_url . 'js/popper.min.js', array(), '1.14.7', true );  
		wp_enqueue_script( 'bootstrap-js', $this->plugin_url . 'js/bootstrap.min.js', array(), '4.3.1', true );  
	}
	
	// Styles
	public function homepage_header_section_styles() {
		wp_enqueue_style( 'homepage-header-section-style', $this->plugin_url . 'css/style.css', array(), '' );
	}
	
	// Customizer styles
	public function homepage_header_section_customize_styles() {
		wp_enqueue_style( 'homepage-header-section-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
		
	// Customizer live preview
	public function homepage_header_section_customize_live_preview() {
		wp_enqueue_script( 'homepage-header-section-customize-live-preview', $this->plugin_url . 'js/customizer.js', array(  'jquery', 'customize-preview' ), '', true );
	}
	
	// Customizer header output
	public function homepage_header_section_header_output() { 
		$display_homepage_navbar										= get_theme_mod( 'display_homepage_navbar' , '' );		
		$display_homepage_logo											= get_theme_mod( 'display_homepage_logo' , '' );
		$homepage_site_logo 											= wp_get_attachment_url( get_theme_mod( 'homepage_site_logo' , '' ) );
		$homepage_site_logo_size										= get_theme_mod( 'homepage_site_logo_size' , '' );
		$display_homepage_site_logo_icon								= get_theme_mod( 'display_homepage_site_logo_icon' , '' );
		$display_site_logo_icon											= get_theme_mod( 'display_site_logo_icon' , '' );		
		$homepage_site_logo_icon_color									= get_theme_mod( 'homepage_site_logo_icon_color' , '' );
		$homepage_site_logo_icon_size									= get_theme_mod( 'homepage_site_logo_icon_size' , '' );
		$display_homepage_site_title									= get_theme_mod( 'display_homepage_site_title' , '' ); 
		$display_site_title												= get_theme_mod( 'display_site_title' , '' ); 
		$homepage_site_title_color										= get_theme_mod( 'homepage_site_title_color' , '' );
		$homepage_site_title_size										= get_theme_mod( 'homepage_site_title_size' , '' );				
		$display_homepage_navbar_colors									= get_theme_mod( 'display_homepage_navbar_colors', '' );
		$homepage_navbar_font_color										= get_theme_mod( 'homepage_navbar_font_color' , '' );
		$homepage_navbar_background_color								= get_theme_mod( 'homepage_navbar_background_color' , '' );			
		$sticky_homepage_navbar											= get_theme_mod( 'sticky_homepage_navbar' , '' );
		$display_sticky_homepage_navbar_logo							= get_theme_mod( 'display_sticky_homepage_navbar_logo' , '' );
		$sticky_homepage_navbar_logo 									= wp_get_attachment_url( get_theme_mod( 'sticky_homepage_navbar_logo' , '' ) );
		$sticky_homepage_navbar_icon_color								= get_theme_mod( 'sticky_homepage_navbar_icon_color' , '' );
		$sticky_homepage_navbar_site_title_color						= get_theme_mod( 'sticky_homepage_navbar_site_title_color' , '' );	
		$display_sticky_homepage_navbar_colors							= get_theme_mod( 'display_sticky_homepage_navbar_colors' , '' );
		$sticky_homepage_navbar_font_color								= get_theme_mod( 'sticky_homepage_navbar_font_color' , '' );
		$sticky_homepage_navbar_background_color						= get_theme_mod( 'sticky_homepage_navbar_background_color' , '' );
		$display_homepage_header										= get_theme_mod( 'display_homepage_header' , '' );
		$homepage_header_displays										= get_theme_mod( 'homepage_header_displays' , 'homepage_header_displays_header_image' );
		$display_homepage_header_position								= get_theme_mod( 'display_homepage_header_position' , '' );
		$homepage_header_position										= get_theme_mod( 'homepage_header_position' , '' );			
		$display_homepage_header_height									= get_theme_mod( 'display_homepage_header_height' , '' );
		$homepage_header_height											= get_theme_mod( 'homepage_header_height' , '' );	
		$full_screen_homepage_header									= get_theme_mod( 'full_screen_homepage_header' , '' );
		$display_homepage_header_image_background						= get_theme_mod( 'display_homepage_header_image_background' , '' );
		$display_homepage_header_image_background_color					= get_theme_mod( 'display_homepage_header_image_background_color' , '' );
		$homepage_header_image_background_color							= get_theme_mod( 'homepage_header_image_background_color' , '' );
		$display_homepage_header_image_background_image					= get_theme_mod( 'display_homepage_header_image_background_image' , '' );
		$homepage_header_image_background_image							= get_theme_mod( 'homepage_header_image_background_image' , '' );
		$homepage_header_image_background_attachment					= get_theme_mod( 'homepage_header_image_background_attachment' , '' );
		$homepage_header_image_background_position						= get_theme_mod( 'homepage_header_image_background_position' , '' );
		$homepage_header_image_background_size							= get_theme_mod( 'homepage_header_image_background_size' , '' );
		$homepage_header_image_background_repeat						= get_theme_mod( 'homepage_header_image_background_repeat' , '' );	
		$homepage_header_image_background_image_opacity					= get_theme_mod( 'homepage_header_image_background_image_opacity' , '' );
		$homepage_header_image_overlay_color							= get_theme_mod( 'homepage_header_image_overlay_color' , '' );
		$homepage_header_image_overlay_color_opacity					= get_theme_mod( 'homepage_header_image_overlay_color_opacity' , '' );
		$homepage_header_image_blend_mode								= get_theme_mod( 'homepage_header_image_blend_mode' , '' );
		$display_homepage_header_image_colors							= get_theme_mod( 'display_homepage_header_image_colors' , '' );
		$display_homepage_header_image_heading_color					= get_theme_mod( 'display_homepage_header_image_heading_color' , '' );
		$homepage_header_image_heading_color							= get_theme_mod( 'homepage_header_image_heading_color' , '' );
		$display_homepage_header_image_font_color						= get_theme_mod( 'display_homepage_header_image_font_color' , '' );
		$homepage_header_image_font_color								= get_theme_mod( 'homepage_header_image_font_color' , '' );
		$display_homepage_header_padding								= get_theme_mod( 'display_homepage_header_padding' , '' );
		$homepage_header_top_padding									= get_theme_mod( 'homepage_header_top_padding' , '' );
		$homepage_header_bottom_padding									= get_theme_mod( 'homepage_header_bottom_padding' , '' );

		echo '<style type="text/css">';
		if ( $display_homepage_navbar ) :	
			if ( $display_homepage_navbar_colors ) :	
				self::generate_css( '.home .navbar, .home .navbar .navbar-nav .nav-item.show, .home .navbar .navbar-nav .nav-item.show .nav-item' , 'background-color', $homepage_navbar_background_color );
				self::generate_css( '.home .site-logo-icon i, .home .site-title a, .home .site-title a:hover, .home .site-description, .home .navbar .navbar-nav .nav-item a, .home .navbar .navbar-nav a[title="Add a menu"], .home .navbar .navbar-collapse.show .search-form .search-field' , 'color', $homepage_navbar_font_color );
				self::generate_css( '.home .navbar .navbar-toggler .navbar-toggler-icon' , 'background-color', $homepage_navbar_font_color );
				self::generate_css( '.home .navbar .navbar-nav .nav-item.show a' , 'color' , $homepage_navbar_font_color );
				self::generate_css( '.home .navbar .search-form .search-submit' , 'background-color', $homepage_navbar_font_color );
				self::generate_css( '.home .navbar .search-form .search-submit.search-collapse' , 'background-color', $homepage_navbar_font_color );					
			endif;		
			if ( $display_homepage_logo ) :
				self::generate_css( '.home .navbar .site-logo-img' , 'content', $homepage_site_logo, 'url(', ')' );
				self::generate_css( '.home .navbar .site-logo-img' , 'width', $homepage_site_logo_size , '', 'rem' );
			endif;
			if ( $display_homepage_site_logo_icon ) :
				self::generate_css( '.home .navbar .site-logo-icon i' , 'color' , $homepage_site_logo_icon_color );	
				self::generate_css( '.home .navbar .site-logo-icon i' , 'font-size' , $homepage_site_logo_icon_size, '', 'rem' );	
			endif;	
			if ( $display_homepage_site_title ) :
				self::generate_css( '.home .navbar .site-title a' , 'color' , $homepage_site_title_color );
				self::generate_css( '.home .navbar .site-title a' , 'font-size' , $homepage_site_title_size, '', 'rem' );
			endif;		
			if ( $sticky_homepage_navbar ) :
				if ( $display_sticky_homepage_navbar_colors ) :
					self::generate_css( '.home .navbar.navbar-scroll, .home .navbar.navbar-scroll .navbar-nav .nav-item.show, .home .navbar.navbar-scroll .navbar-nav .nav-item.show .nav-item' , 'background-color' , $sticky_homepage_navbar_background_color );
					self::generate_css( '.home .navbar.navbar-scroll .site-logo-icon i, .home .navbar.navbar-scroll .site-title a, .home .navbar.navbar-scroll .site-title a:hover, .home .navbar.navbar-scroll .site-description, .home .navbar.navbar-scroll .navbar-nav .nav-item a, .home .navbar.navbar-scroll .navbar-nav a[title="Add a menu"], .home .navbar.navbar-scroll .navbar-collapse.show .search-form .search-field', 'color', $sticky_homepage_navbar_font_color );
					self::generate_css( '.home .navbar.navbar-scroll .navbar-toggler .navbar-toggler-icon' , 'background-color', $sticky_homepage_navbar_font_color );
					self::generate_css( '.home .navbar.navbar-scroll .search-form .search-submit, .home .navbar.navbar-scroll .search-form .search-submit.search-collapse ' , 'background-color' ,  $sticky_homepage_navbar_font_color );	
				endif;	
				if ( $display_sticky_homepage_navbar_logo ) :
					self::generate_css( '.home .navbar.navbar-scroll .site-logo-img' , 'content', $sticky_homepage_navbar_logo, 'url(', ')' );
				endif;
				if ( $display_homepage_site_logo_icon ) :
					self::generate_css( '.home .navbar.navbar-scroll .site-logo-icon i' , 'color' , $sticky_homepage_navbar_icon_color );	
				endif;	
				if ( $display_homepage_site_title ) :
					self::generate_css( '.home .navbar.navbar-scroll .site-title a' , 'color' , $sticky_homepage_navbar_site_title_color );
				endif;
			endif;
		endif;
		if ( $display_homepage_header ) :
			if ( $display_homepage_header_height ) :
				self::generate_css( '#homepage-header-image, #homepage-header-image .container, #homepage-header-carousel .slide, #homepage-header-carousel .container' , 'min-height' , $homepage_header_height, '', 'px' );
			endif;
			if ( $display_homepage_header_position ) :
				self::generate_css( '.home' , 'padding-top' , '0px' );
				self::generate_css( '.home' , 'padding-top' , $homepage_header_position, '', 'px' );
			endif;
			if ( $full_screen_homepage_header ) :
				self::generate_css( '#homepage-header-image, #homepage-header-image .container, #homepage-header-image .homepage-header-image-caption, #homepage-header-carousel .slide, #homepage-header-carousel .container, #homepage-header-carousel .homepage-header-carousel-caption' ,  'min-height' , '100vh' );
			endif;
			if ( $homepage_header_displays == 'homepage_header_displays_header_image' ) :
				if ( $display_homepage_header_image_colors ) :
					if ( $display_homepage_header_image_font_color ) :
						self::generate_css('#homepage-header-image', 'color', $homepage_header_image_font_color );
					endif;
					if ( $display_homepage_header_image_heading_color ) :
						self::generate_css('#homepage-header-image h1, #homepage-header-image h2, #homepage-header-image h3, #homepage-header-image h4, #homepage-header-image h5, #homepage-header-image h6', 'color', $homepage_header_image_heading_color );
					endif;
				endif;
				if ( $display_homepage_header_image_background ) :
					if ( $display_homepage_header_image_background_color ) :
						self::generate_css( '#homepage-header-image' , 'background-color' , $homepage_header_image_background_color );	
					endif;
					if ( $display_homepage_header_image_background_image ) :
						self::generate_css( '#homepage-header-image .homepage-header-image-background-image' , 'background-image' , $homepage_header_image_background_image );
						self::generate_css( '#homepage-header-image .homepage-header-image-background-image' , 'background-attachment' , $homepage_header_image_background_attachment );
						self::generate_css( '#homepage-header-image .homepage-header-image-background-image' , 'background-position' , $homepage_header_image_background_position );
						self::generate_css( '#homepage-header-image .homepage-header-image-background-image' , 'background-size' , $homepage_header_image_background_size );
						self::generate_css( '#homepage-header-image .homepage-header-image-background-image' , 'background-repeat' , $homepage_header_image_background_repeat );		
						self::generate_css( '#homepage-header-image .homepage-header-image-background-image' , 'opacity' , $homepage_header_image_background_image_opacity );
						self::generate_css( '#homepage-header-image .homepage-header-image-overlay-color' , 'background-color' , $homepage_header_image_overlay_color );	
						self::generate_css( '#homepage-header-image .homepage-header-image-overlay-color' , 'opacity' , $homepage_header_image_overlay_color_opacity );	
						self::generate_css( '#homepage-header-image .homepage-header-image-overlay-color' , 'mix-blend-mode' , $homepage_header_image_blend_mode );	
					endif;	
				endif;	
			endif;
			if ( $display_homepage_header_padding ) :			
				self::generate_css( '#homepage-header-image .homepage-header-image-caption', 'padding-top', $homepage_header_top_padding, '', 'rem' );
				self::generate_css( '#homepage-header-image .homepage-header-image-caption', 'padding-bottom', $homepage_header_bottom_padding, '', 'rem' );
			endif;
		endif;
	 	echo '</style>';
	}
	
	// Generate CSS to be used in Customizer header output above
	public function generate_css( $selector, $style, $mod, $prefix='', $postfix='', $echo=true ) {
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

	// Homepage Header Section
	public static function homepage_header_section() { 
		$display_homepage_header									= get_theme_mod( 'display_homepage_header' , '' );
		$homepage_header_displays									= get_theme_mod( 'homepage_header_displays' , 'homepage_header_displays_header_image' );
		$homepage_header_scroll_down_arrow							= get_theme_mod( 'homepage_header_scroll_down_arrow' , '' );
		$homepage_header_scroll_down_arrow_link						= get_theme_mod( 'homepage_header_scroll_down_arrow_link' , '' );
		$display_homepage_header_image_title						= get_theme_mod( 'display_homepage_header_image_title' , '' );
		$homepage_header_image_title								= get_theme_mod( 'homepage_header_image_title' , __( 'Header', 'minisite-lite' ) );
		$display_homepage_header_image_text							= get_theme_mod( 'display_homepage_header_image_text' , '' );
		$homepage_header_image_text									= wpautop( get_theme_mod( 'homepage_header_image_text' , __( '', 'minisite-lite' ) ) );
		$display_homepage_header_image_button_1						= get_theme_mod( 'display_homepage_header_image_button_1' , '' );
		$homepage_header_image_button_1_url							= get_theme_mod( 'homepage_header_image_button_1_url' ,  '#' );
		$homepage_header_image_button_1_text						= get_theme_mod( 'homepage_header_image_button_1_text' , __( 'Button', 'minisite-lite' ) );
		$display_homepage_header_image_button_2						= get_theme_mod( 'display_homepage_header_image_button_2' , '' );
		$homepage_header_image_button_2_url							= get_theme_mod( 'homepage_header_image_button_2_url' ,  '#' );
		$homepage_header_image_button_2_text						= get_theme_mod( 'homepage_header_image_button_2_text' , __( 'Button', 'minisite-lite' ) );
		$display_homepage_header_image_background					= get_theme_mod( 'display_homepage_header_image_background' , '' );
		$display_homepage_header_image_background_image				= get_theme_mod( 'display_homepage_header_image_background_image' , '' );		
	?>
		<?php if ( $display_homepage_header ) : ?>
			<?php if ( $homepage_header_displays == 'homepage_header_displays_header_image' ) : ?>
				<div id="homepage-header-image">
					<?php if ( $display_homepage_header_image_background && $display_homepage_header_image_background_image ) : ?>
						<div class="homepage-header-image-background-image"></div>
						<div class="homepage-header-image-overlay-color"></div>
					<?php endif; ?>
					<div class="container">
						<div class="homepage-header-image-caption row no-gutters">
							<?php if ( $display_homepage_header_image_title || $display_homepage_header_image_text || $display_homepage_header_image_button_1 || $display_homepage_header_image_button_2 ) : ?>
								<div class="col-lg-10 offset-lg-1 col-md-12">
									<?php if ( $display_homepage_header_image_title ) : ?>
										<h2 class="h1 homepage-header-image-title"><?php echo $homepage_header_image_title ?></h2>
									<?php endif; ?>
									<?php if ( $display_homepage_header_image_text ) : ?>
										<div class="homepage-header-image-text lead"><?php echo $homepage_header_image_text ?></div>
									<?php endif; ?>
									<?php if ( $display_homepage_header_image_button_1 || $display_homepage_header_image_button_2 ) : ?>
										<div class="homepage-header-image-buttons">
											<?php if ( $display_homepage_header_image_button_1 ) : ?>
												<a href="<?php echo $homepage_header_image_button_1_url ?>" class="homepage-header-image-button-1 btn btn-primary btn-lg" role="button"><?php echo $homepage_header_image_button_1_text ?></a>
											<?php endif; ?>
											<?php if ( $display_homepage_header_image_button_2 ) : ?>
												<a href="<?php echo $homepage_header_image_button_2_url ?>" class="homepage-header-image-button-2 btn btn-outline-light btn-lg" role="button"><?php echo $homepage_header_image_button_2_text ?></a>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<?php if ( $homepage_header_scroll_down_arrow ) : ?>
								<div class="scroll-down-arrow col-md-12">
									<p><a href="<?php echo $homepage_header_scroll_down_arrow_link ?>" class="scroll-down-arrow-link col-md-12"><?php __( 'Scroll Down', 'minisite-lite' )?></a></p>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>			
		<?php endif; ?>
	<?php
	}
} // End Class
