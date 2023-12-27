<?php
/**
 * Plugin Name: Homepage Services Section
 * Plugin URI: https://getminisites.com/theme/
 * Description: Profile all your products or services with icons, titles and descriptions.
 * Version: 1.0.0
 * Author: Troy Templeman
 * Author URI: https://troytempleman.com/
 * License: GNU General Public License v2 or later
 * License URI: LICENSE
 * Text Domain: homepage-services-section
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Homepage_Services_Section to prevent the need to use globals
function Homepage_Services_Section() {
	return Homepage_Services_Section::instance();
} 

Homepage_Services_Section();

// Homepage_Services_Section Class
final class Homepage_Services_Section {
	
	// The single instance of Homepage_Services_Section
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

		add_action( 'init', array( $this, 'homepage_services_section_setup' ) );
	}

	// Homepage_Services_Section Instance
	// Ensures only one instance of Homepage_Services_Section is loaded or can be loaded
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
	public function homepage_services_section_setup() {
		if ( get_theme_mod( 'display_services' , true ) ) :
				add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_scripts' ), 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'homepage_services_section_styles' ), 100 );
		endif;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'homepage_services_section_customize_styles' ), 100 );
		add_action( 'customize_preview_init', array( $this, 'homepage_services_section_customize_live_preview' ), 100 );
		add_action( 'customize_register', array( $this, 'homepage_services_section_customize_register' ) );
		if ( get_theme_mod( 'display_services' , true ) ) :
			add_action( 'wp_head' , array( $this, 'homepage_services_section_header_output' ), 100 );
			add_action( 'homepage', array( $this, 'homepage_services_section' ), 30 );
		endif;
	}

	// Customizer
	public function homepage_services_section_customize_register( $wp_customize ) {
		
		// Services
		$wp_customize->add_section( 'services' , array(
			'title'				=> __( 'Services', 'minisite-lite' ),
			'panel'				=> 'homepage',
			'priority' 			=> 30
		) );
			
			// Display Services
			$wp_customize->add_setting( 'display_services', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services', array(
				'label'				=> __( 'Display Services', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
			) );
			function display_services_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}

			// Title
			$wp_customize->add_setting( 'display_services_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'services_title', array(
				'default' 			=> __( 'Services', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_title_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'services_title', array(
				'selector'			=> '.services .services-title'
			) );
			
			// Slug
			$wp_customize->add_setting( 'services_slug', array(
				'default' 			=> __( 'services', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_slug', array(
				'label'				=> __( 'Slug', 'minisite-lite' ),
				'description'		=> __( '<strong>Permalink: </strong>', 'minisite-lite' ) . esc_html__( get_site_url() . '#', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_title_callback( $control ) );
				 },
			) );			

			// Text
			$wp_customize->add_setting( 'display_services_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'services_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'services_text', array( 
				'label' 			=> __( 'Text', 'minisite-lite' ),
				'section' 			=> 'services',
				'input_attrs' 		=> array(
				'toolbar1' 			=> 'bold italic bullist numlist alignleft aligncenter alignright link',
				'toolbar2' 			=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_text_callback( $control ) );
				},
			) ) );
			
			// Icons
			$wp_customize->add_setting( 'display_services_icons', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_icons', array(
				'label'				=> __( 'Icons', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_icons_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_icons' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}

			// Icon Position
			$wp_customize->add_setting( 'services_block_icon_position' , array(
				'default'        	=> 'top',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_services_section_sanitize_select'
			) );
			$wp_customize->add_control( 'services_block_icon_position', array(
				'label'   			=> __( 'Position', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'top' 			=> 'Top',
					'left' 			=> 'Left'
				),
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_icons_callback( $control ) );
				 },
			) );

			// Icon Size
			$wp_customize->add_setting( 'services_block_icon_size' , array(
				'default'        	=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_services_section_sanitize_number_range'
			) );
			$wp_customize->add_control( 'services_block_icon_size', array(
				'label'   			=> __( 'Size', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 4,
					'step'  		=> 0.001
				),
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_icons_callback( $control ) );
				 },
			) );

			// Alignment
			$wp_customize->add_setting( 'display_services_block_alignment', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_block_alignment', array(
				'label'				=> __( 'Alignment', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_block_alignment_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_block_alignment' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'services_block_alignment' , array(
				'default'        	=> 'left',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_services_section_sanitize_select'
			) );
			$wp_customize->add_control( 'services_block_alignment', array(
				'label'   			=> __( 'Alignment', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'left' 			=> 'Left',
					'center' 		=> 'Center'
				),
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_alignment_callback( $control ) );
				 },
			) );

			// Block 1
			$wp_customize->add_setting( 'display_services_block_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_block_1', array(
				'label'				=> __( 'Service 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_block_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_block_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'services_block_1_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_1_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_1_callback( $control ) && display_services_icons_callback( $control ) );
				}
			) );

			// Title
			$wp_customize->add_setting( 'services_block_1_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_1_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_1_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'services_block_1_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'services_block_1_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'services',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_1_callback( $control ) );
				 },
			) ) );
			
			// Block 2
			$wp_customize->add_setting( 'display_services_block_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_block_2', array(
				'label'				=> __( 'Service 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_block_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_block_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'services_block_2_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_2_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_2_callback( $control ) && display_services_icons_callback( $control ) );
				}
			) );

			// Title
			$wp_customize->add_setting( 'services_block_2_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_2_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_2_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'services_block_2_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'services_block_2_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'services',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_2_callback( $control ) );
				 },
			) ) );
			
			// Block 3
			$wp_customize->add_setting( 'display_services_block_3', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_block_3', array(
				'label'				=> __( 'Service 3', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_block_3_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_block_3' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'services_block_3_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_3_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_3_callback( $control ) && display_services_icons_callback( $control ) );
				}
			) );

			// Title
			$wp_customize->add_setting( 'services_block_3_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_3_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_3_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'services_block_3_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'services_block_3_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'services',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_3_callback( $control ) );
				 },
			) ) );
			
			// Block 4
			$wp_customize->add_setting( 'display_services_block_4', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_block_4', array(
				'label'				=> __( 'Service 4', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_block_4_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_block_4' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'services_block_4_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_4_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_4_callback( $control ) && display_services_icons_callback( $control ) );
				}
			) );

			// Title
			$wp_customize->add_setting( 'services_block_4_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_4_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_4_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'services_block_4_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'services_block_4_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'services',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_4_callback( $control ) );
				 },
			) ) );
			
			// Block 5
			$wp_customize->add_setting( 'display_services_block_5', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_block_5', array(
				'label'				=> __( 'Service 5', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_block_5_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_block_5' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'services_block_5_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_5_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_5_callback( $control ) && display_services_icons_callback( $control ) );
				}
			) );

			// Title
			$wp_customize->add_setting( 'services_block_5_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_5_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_5_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'services_block_5_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'services_block_5_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'services',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_5_callback( $control ) );
				 },
			) ) );
			
			// Block 6
			$wp_customize->add_setting( 'display_services_block_6', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_block_6', array(
				'label'				=> __( 'Service 6', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			function display_services_block_6_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_block_6' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'services_block_6_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_6_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_6_callback( $control ) && display_services_icons_callback( $control ) );
				}
			) );

			// Title
			$wp_customize->add_setting( 'services_block_6_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_block_6_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_6_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'services_block_6_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'services_block_6_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'services',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_services_callback( $control ) && display_services_block_6_callback( $control ) );
				 },
			) ) );
			
			// Services Button
			$wp_customize->add_setting( 'display_services_button', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_button', array(
				'label'				=> __( 'Button', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'   => 'display_services_callback'
			) );
			function display_services_button_callback( $control ) {
				if ( $control->manager->get_setting( 'display_services_button' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'services_button_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_button_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_button_callback( $control ) );
				}
			) );
			
			// Button URL
			$wp_customize->add_setting( 'services_button_url', array(
				'default'			=> '#',  
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'services_button_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'services',
				'active_callback'   => function( $control ) {
					return ( display_services_callback( $control ) && display_services_button_callback( $control ) );
				}
			) );
			
			// Colors
			$wp_customize->add_setting( 'display_services_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_colors', array(
				'label'				=> __( 'Colors', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Colors <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			
			// Background
			$wp_customize->add_setting( 'display_services_background', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_background', array(
				'label'				=> __( 'Background', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Background <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
		
			// Padding
			$wp_customize->add_setting( 'display_services_padding', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_padding', array(
				'label'				=> __( 'Padding', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Padding <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
	
			// Animation
			$wp_customize->add_setting( 'display_services_animation', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_animation', array(
				'label'				=> __( 'Animation', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Animation <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
			
			// Animation
			$wp_customize->add_setting( 'display_services_widgets', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_services_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_services_widgets', array(
				'label'				=> __( 'Widgets', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Widgets <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'services',
				'active_callback'	=> 'display_services_callback',
			) );
	
		// Sanitize Checkbox
		function homepage_services_section_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}

		// Sanitize File
		function homepage_services_section_sanitize_file( $file, $setting ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png'
			);
			$file_ext = wp_check_filetype( $file, $mimes );
			return ( $file_ext['ext'] ? $file : $setting->default );
		}

		// Sanitize Number Range
		function homepage_services_section_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 0.001 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}

		// Sanitize Select
		function homepage_services_section_sanitize_select( $input, $setting ){
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
	public function homepage_services_section_styles() {
		wp_enqueue_style( 'icon-fonts-style', $this->plugin_url . 'icons/style.css', array(), '' );
	}
	
	// Customizer styles
	public function homepage_services_section_customize_styles() {
		wp_enqueue_style( 'homepage-services-section-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
		
	// Customizer live preview
	public function homepage_services_section_customize_live_preview() {
		wp_enqueue_script( 'homepage-services-section-customize-live-preview', $this->plugin_url . 'js/customizer.js', array(  'jquery', 'customize-preview' ), '', true );
	}
	
	// Customizer header output
	public function homepage_services_section_header_output() {
		$display_services							= get_theme_mod( 'display_services', true );
		$display_services_icons						= get_theme_mod( 'display_services_icons' , '' );
		$services_block_icon_size					= get_theme_mod( 'services_block_icon_size' , '3' );
	 	
		echo '<style type="text/css">';
		if ( $display_services ) :
			if ( $display_services_icons ) :
				self::generate_css('.services-block-icon i', 'font-size', $services_block_icon_size , '', 'rem' );
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

	// Homepage Services Section
	public static function homepage_services_section() {
		$display_services					= get_theme_mod( 'display_services' , '' );
		$display_services_title				= get_theme_mod( 'display_services_title' , '' );
		$services_title						= get_theme_mod( 'services_title' , __( 'Services', 'minisite-lite' ) );
		$services_slug						= get_theme_mod( 'services_slug' , __( 'services', 'minisite-lite' ) );
		$display_services_text				= get_theme_mod( 'display_services_text' , '' );
		$services_text						= wpautop( get_theme_mod( 'services_text' , __( '', 'minisite-lite' ) ) );
		$services_block_icon_position		= get_theme_mod( 'services_block_icon_position' , 'top' );
		$services_block_alignment			= get_theme_mod( 'services_block_alignment' , 'left' );			
		$display_services_block_1			= get_theme_mod( 'display_services_block_1' , '' );
		$display_services_icons				= get_theme_mod( 'display_services_icons' , '' );
		$services_block_1_icon				= get_theme_mod( 'services_block_1_icon' , '' );
		$services_block_1_title				= get_theme_mod( 'services_block_1_title' , __( '', 'minisite-lite' ) );
		$services_block_1_text				= wpautop( get_theme_mod( 'services_block_1_text' , __( '', 'minisite-lite' ) ) );		
		$display_services_block_2			= get_theme_mod( 'display_services_block_2' , '');
		$services_block_2_icon				= get_theme_mod( 'services_block_2_icon' , '' );
		$services_block_2_title				= get_theme_mod( 'services_block_2_title' , __( '', 'minisite-lite' ) );
		$services_block_2_text				= wpautop( get_theme_mod( 'services_block_2_text' , __( '', 'minisite-lite' ) ) );		
		$display_services_block_3			= get_theme_mod( 'display_services_block_3' , '' );
		$services_block_3_icon				= get_theme_mod( 'services_block_3_icon' , '' );
		$services_block_3_title				= get_theme_mod( 'services_block_3_title' , __( '', 'minisite-lite' ) );
		$services_block_3_text				= wpautop( get_theme_mod( 'services_block_3_text' , __( '', 'minisite-lite' ) ) );	
		$display_services_block_4			= get_theme_mod( 'display_services_block_4' , '' );
		$services_block_4_icon				= get_theme_mod( 'services_block_4_icon' , '' );
		$services_block_4_title				= get_theme_mod( 'services_block_4_title' , __( '', 'minisite-lite' ) );
		$services_block_4_text				= wpautop( get_theme_mod( 'services_block_4_text' , __( '', 'minisite-lite' ) ) );	
		$display_services_block_5			= get_theme_mod( 'display_services_block_5' , '' );
		$services_block_5_icon				= get_theme_mod( 'services_block_5_icon' , '' );
		$services_block_5_title				= get_theme_mod( 'services_block_5_title' , __( '', 'minisite-lite' ) );
		$services_block_5_text				= wpautop( get_theme_mod( 'services_block_5_text' , __( '', 'minisite-lite' ) ) );	
		$display_services_block_6			= get_theme_mod( 'display_services_block_6' , '' );
		$services_block_6_icon				= get_theme_mod( 'services_block_6_icon' , '' );
		$services_block_6_title				= get_theme_mod( 'services_block_6_title' , __( '', 'minisite-lite' ) );
		$services_block_6_text				= wpautop( get_theme_mod( 'services_block_6_text' , __( '', 'minisite-lite' ) ) );
		$display_services_button			= get_theme_mod( 'display_services_button' , '' );
		$services_button_url				= get_theme_mod( 'services_button_url' , '#' );
		$services_button_text				= get_theme_mod( 'services_button_text' , __( 'Button', 'minisite-lite' ) );
	?>	
		<?php if ( $display_services ) : ?>
			<section class="services wrapper">
				<?php if ( $display_services_title || $display_services_text || $display_services_block_1 || $display_services_block_2 || $display_services_block_3 || $display_services_block_4 || $display_services_block_5  || $display_services_block_6 || is_active_sidebar( 'homepage-services' ) || $display_services_button ) : ?>	
					<div class="services-container container">
						<?php if ( $display_services_title || $display_services_text ) : ?>
							<div class="services-header row">
						    	<div class="col-lg-8 offset-lg-2 text-center">
									<?php if ( $display_services_title ) : ?>
										<h2 id="<?php echo $services_slug ?>" class="h1 services-title">
											<?php echo $services_title ?>
										</h2>
									<?php endif; ?>
									<?php if ( $display_services_text ) : ?>
										<div class="services-text lead">
											<?php echo $services_text ?>
										</div>
									<?php endif; ?>
								</div>
					    	</div>
						<?php endif; ?>
						<?php if ( $display_services_block_1 || $display_services_block_2 || $display_services_block_3 || $display_services_block_4 || $display_services_block_5  || $display_services_block_6 ) : ?>
							<div class="services-content row">
								<?php if ( $display_services_block_1 ) : ?>
							    	<div class="services-block-1 services-block col-md-4">
										<div class="row">
											<?php if ( $display_services_icons ) : ?>
												<div class="services-block-icon <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $services_block_1_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="services-block-title-text <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="services-block-title">
													<?php echo $services_block_1_title ?>
												</h3>
												<div class="services-block-text">
													<?php echo $services_block_1_text ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ( $display_services_block_2 ) : ?>
							    	<div class="services-block-2 services-block col-md-4">
										<div class="row">
											<?php if ( $display_services_icons ) : ?>
												<div class="services-block-icon <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $services_block_2_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="services-block-title-text <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="services-block-title">
													<?php echo $services_block_2_title ?>
												</h3>
												<div class="services-block-text">
													<?php echo $services_block_2_text ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ( $display_services_block_3 ) : ?>
							    	<div class="services-block-3 services-block col-md-4">
										<div class="row">
											<?php if ( $display_services_icons ) : ?>
												<div class="services-block-icon <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $services_block_3_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="services-block-title-text <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="services-block-title">
													<?php echo $services_block_3_title ?>
												</h3>
												<div class="services-block-text">
													<?php echo $services_block_3_text ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ( $display_services_block_4 ) : ?>
							    	<div class="services-block-4 services-block col-md-4">
										<div class="row">
											<?php if ( $display_services_icons ) : ?>
												<div class="services-block-icon <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $services_block_4_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="services-block-title-text <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="services-block-title">
													<?php echo $services_block_4_title ?>
												</h3>
												<div class="services-block-text">
													<?php echo $services_block_4_text ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ( $display_services_block_5 ) : ?>
							    	<div class="services-block-5 services-block col-md-4">
										<div class="row">
											<?php if ( $display_services_icons ) : ?>
												<div class="services-block-icon <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $services_block_5_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="services-block-title-text <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="services-block-title">
													<?php echo $services_block_5_title ?>
												</h3>
												<div class="services-block-text">
													<?php echo $services_block_5_text ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ( $display_services_block_6 ) : ?>
							    	<div class="services-block-6 services-block col-md-4">
										<div class="row">
											<?php if ( $display_services_icons ) : ?>
												<div class="services-block-icon <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $services_block_6_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="services-block-title-text <?php if ( $services_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $services_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="services-block-title">
													<?php echo $services_block_6_title ?>
												</h3>
												<div class="services-block-text">
													<?php echo $services_block_6_text ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
					    	</div>
						<?php endif; ?>
						<?php if ( $display_services_button ) : ?>
							<div class="services-footer row">
								<div class="col-md text-center">
									<p><a href="<?php echo $services_button_url ?>" class="services-button btn btn-primary" role="button"><?php echo $services_button_text ?></a></p>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</section>
		<?php endif; ?>	
	<?php
	}
} // End Class
