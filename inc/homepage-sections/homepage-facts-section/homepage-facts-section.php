<?php
/**
 * Plugin Name: Homepage Facts Section
 * Plugin URI: https://getminisites.com/theme/
 * Description: Grab users attention with fun animated facts, numbers and statistics about you and your business.
 * Version: 1.0.0
 * Author: Troy Templeman
 * Author URI: https://troytempleman.com/
 * License: GNU General Public License v2 or later
 * License URI: LICENSE
 * Text Domain: homepage-facts-section
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Homepage_Facts_Section to prevent the need to use globals
function Homepage_Facts_Section() {
	return Homepage_Facts_Section::instance();
} 

Homepage_Facts_Section();

// Homepage_Facts_Section Class
final class Homepage_Facts_Section {
	
	// The single instance of Homepage_Facts_Section
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

		add_action( 'init', array( $this, 'homepage_facts_section_setup' ) );
	}

	// Homepage_Facts_Section Instance
	// Ensures only one instance of Homepage_Facts_Section is loaded or can be loaded
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
	public function homepage_facts_section_setup() {
		if ( get_theme_mod( 'display_facts' , true ) ) :
				add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_scripts' ), 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'homepage_facts_section_scripts' ), 100 );
		endif;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'homepage_facts_section_customize_styles' ), 100 );
		add_action( 'customize_preview_init', array( $this, 'homepage_facts_section_customize_live_preview' ), 100 );
		add_action( 'customize_register', array( $this, 'homepage_facts_section_customize_register' ) );
		if ( get_theme_mod( 'display_facts' , true ) ) :
			add_action( 'wp_head' , array( $this, 'homepage_facts_section_header_output' ), 100 );
			add_action( 'homepage', array( $this, 'homepage_facts_section' ), 20 );
		endif;
	}

	// Customizer
	public function homepage_facts_section_customize_register( $wp_customize ) {
		
		// Facts
		$wp_customize->add_section( 'facts' , array(
			'title'				=> __( 'Facts', 'minisite-lite' ),
			'panel'				=> 'homepage',
			'priority'			=> 20
		) );

			// Display Facts
			$wp_customize->add_setting( 'display_facts', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts', array(
				'label'				=> __( 'Display Facts', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'facts',
			) );
			function display_facts_callback( $control ) {
				if ( $control->manager->get_setting( 'display_facts' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Title
			$wp_customize->add_setting( 'display_facts_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',				
			) );
			function display_facts_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_facts_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'facts_title', array(
				'default' 			=> __( 'Facts', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_title_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'facts_title', array(
				'selector'			=> '.facts .facts-title'
			) );
			
			// Slug
			$wp_customize->add_setting( 'facts_slug', array(
				'default' 			=> __( 'facts', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_slug', array(
				'label'				=> __( 'Slug', 'minisite-lite' ),
				'description'		=> __( '<strong>Permalink: </strong>', 'minisite-lite' ) . esc_html__( get_site_url() . '#', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_title_callback( $control ) );
				 },
			) );
				
			// Text
			$wp_customize->add_setting( 'display_facts_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
			function display_facts_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_facts_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'facts_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'facts_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'facts',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_text_callback( $control ) );
				},
			) ) );
			
			// Icons
			$wp_customize->add_setting( 'display_facts_icons', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_icons', array(
				'label'				=> __( 'Icons', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
			function display_facts_icons_callback( $control ) {
				if ( $control->manager->get_setting( 'display_facts_icons' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}

			// Icon Position
			$wp_customize->add_setting( 'facts_block_icon_position' , array(
				'default'        	=> 'top',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_facts_section_sanitize_select'
			) );
			$wp_customize->add_control( 'facts_block_icon_position', array(
				'label'   			=> __( 'Position', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'top' 			=> 'Top',
					'left' 			=> 'Left'
				),
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_icons_callback( $control ) );
				 },
			) );

			// Icon Size
			$wp_customize->add_setting( 'facts_block_icon_size' , array(
				'default'        	=> '3',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_facts_section_sanitize_number_range'
			) );
			$wp_customize->add_control( 'facts_block_icon_size', array(
				'label'   			=> __( 'Size', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 0,
					'max'   		=> 4,
					'step'  		=> 0.001
				),
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_icons_callback( $control ) );
				 },
			) );

			// Alignment
			$wp_customize->add_setting( 'facts_block_alignment' , array(
				'default'        	=> 'center',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_facts_section_sanitize_select'
			) );
			$wp_customize->add_control( 'facts_block_alignment', array(
				'label'   			=> __( 'Alignment', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'left' 			=> 'Left',
					'center' 		=> 'Center'
				),
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_icons_callback( $control ) );
				 },
			) );

			// Block 1
			$wp_customize->add_setting( 'display_facts_block_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_block_1', array(
				'label'				=> __( 'Fact 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
			function display_facts_block_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_facts_block_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'facts_block_1_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_1_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_1_callback( $control ) && display_facts_icons_callback( $control ) );
				}
			) );
			
			// Prefix
			$wp_customize->add_setting( 'facts_block_1_title_prefix', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_1_title_prefix', array(
				'label'				=> __( 'Prefix', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_1_callback( $control ) );
				 },
			) );

			// Title
			$wp_customize->add_setting( 'facts_block_1_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_1_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_1_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'facts_block_1_title', array(
				'selector'			=> '.facts-block-1 .facts-block-title'
			) );
			
			// Suffix
			$wp_customize->add_setting( 'facts_block_1_title_suffix', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_1_title_suffix', array(
				'label'				=> __( 'Suffix', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_1_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'facts_block_1_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'facts_block_1_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'facts',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_1_callback( $control ) );
				 },
			) ) );
			
			// Block 2
			$wp_customize->add_setting( 'display_facts_block_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_block_2', array(
				'label'				=> __( 'Fact 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
			function display_facts_block_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_facts_block_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'facts_block_2_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_2_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_2_callback( $control ) && display_facts_icons_callback( $control ) );
				}
			) );
			
			// Prefix
			$wp_customize->add_setting( 'facts_block_2_title_prefix', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_2_title_prefix', array(
				'label'				=> __( 'Prefix', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_2_callback( $control ) );
				 },
			) );

			// Title
			$wp_customize->add_setting( 'facts_block_2_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_2_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_2_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'facts_block_2_title', array(
				'selector'			=> '.facts-block-2 .facts-block-title'
			) );
			
			// Suffix
			$wp_customize->add_setting( 'facts_block_2_title_suffix', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_2_title_suffix', array(
				'label'				=> __( 'Suffix', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_2_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'facts_block_2_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'facts_block_2_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'facts',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_2_callback( $control ) );
				 },
			) ) );
			
			// Block 3
			$wp_customize->add_setting( 'display_facts_block_3', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_block_3', array(
				'label'				=> __( 'Fact 3', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
			function display_facts_block_3_callback( $control ) {
				if ( $control->manager->get_setting( 'display_facts_block_3' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'facts_block_3_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_3_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_3_callback( $control ) && display_facts_icons_callback( $control ) );
				}
			) );
			
			// Prefix
			$wp_customize->add_setting( 'facts_block_3_title_prefix', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_3_title_prefix', array(
				'label'				=> __( 'Prefix', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_3_callback( $control ) );
				 },
			) );

			// Title
			$wp_customize->add_setting( 'facts_block_3_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_3_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_3_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'facts_block_3_title', array(
				'selector'			=> '.facts-block-3 .facts-block-title'
			) );
			
			// Suffix
			$wp_customize->add_setting( 'facts_block_3_title_suffix', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_3_title_suffix', array(
				'label'				=> __( 'Suffix', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_3_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'facts_block_3_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'facts_block_3_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'facts',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_3_callback( $control ) );
				 },
			) ) );
			
			// Block 4
			$wp_customize->add_setting( 'display_facts_block_4', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_block_4', array(
				'label'				=> __( 'Fact 4', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
			function display_facts_block_4_callback( $control ) {
				if ( $control->manager->get_setting( 'display_facts_block_4' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Icon
			$wp_customize->add_setting( 'facts_block_4_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_4_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_4_callback( $control ) && display_facts_icons_callback( $control ) );
				}
			) );
			
			// Prefix
			$wp_customize->add_setting( 'facts_block_4_title_prefix', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_4_title_prefix', array(
				'label'				=> __( 'Prefix', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_4_callback( $control ) );
				 },
			) );

			// Title
			$wp_customize->add_setting( 'facts_block_4_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_4_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_4_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'facts_block_4_title', array(
				'selector'			=> '.facts-block-4 .facts-block-title'
			) );
			
			// Suffix
			$wp_customize->add_setting( 'facts_block_4_title_suffix', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_block_4_title_suffix', array(
				'label'				=> __( 'Suffix', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_4_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'facts_block_4_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'facts_block_4_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'facts',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_block_4_callback( $control ) );
				 },
			) ) );
			
			// Facts Button
			$wp_customize->add_setting( 'display_facts_button', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_button', array(
				'label'				=> __( 'Button', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'   => 'display_facts_callback'
			) );
			function display_facts_button_callback( $control ) {
				if ( $control->manager->get_setting( 'display_facts_button' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'facts_button_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_button_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_button_callback( $control ) );
				}
			) );
			
			// Button URL
			$wp_customize->add_setting( 'facts_button_url', array(
				'default'			=> '#', 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'facts_button_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'facts',
				'active_callback'   => function( $control ) {
					return ( display_facts_callback( $control ) && display_facts_button_callback( $control ) );
				}
			) );
			
			// Colors
			$wp_customize->add_setting( 'display_facts_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_colors', array(
				'label'				=> __( 'Colors', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Colors <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
			
			// Background
			$wp_customize->add_setting( 'display_facts_background', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_background', array(
				'label'				=> __( 'Background', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Background <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
		
			// Padding
			$wp_customize->add_setting( 'display_facts_padding', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_padding', array(
				'label'				=> __( 'Padding', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Padding <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
	
			// Animation
			$wp_customize->add_setting( 'display_facts_animation', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_animation', array(
				'label'				=> __( 'Animation', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Animation <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
			
			// Animation
			$wp_customize->add_setting( 'display_facts_widgets', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_facts_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_facts_widgets', array(
				'label'				=> __( 'Widgets', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Widgets <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'facts',
				'active_callback'	=> 'display_facts_callback',
			) );
		
		// Sanitize Checkbox
		function homepage_facts_section_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}

		// Sanitize File
		function homepage_facts_section_sanitize_file( $file, $setting ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png'
			);
			$file_ext = wp_check_filetype( $file, $mimes );
			return ( $file_ext['ext'] ? $file : $setting->default );
		}
		
		// Sanitize Number Range
		function homepage_facts_section_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 0.001 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}

		// Sanitize Select
		function homepage_facts_section_sanitize_select( $input, $setting ){
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

	// Scripts
	public function homepage_facts_section_scripts() {
		wp_enqueue_style( 'icon-fonts-style', $this->plugin_url . 'icons/style.css', array(), '' );
		wp_enqueue_script( 'waypoints-js', $this->plugin_url . 'js/jquery.waypoints.min.js', array(), '4.0.0', true );
		wp_enqueue_script( 'counterup-js', $this->plugin_url . 'js/jquery.counterup.js', array(), '2.1.0', true );
		wp_enqueue_script( 'counterup-init-js', $this->plugin_url . 'js/jquery.counterup.init.js', array(), '', true );
	}
	
	// Customizer styles
	public function homepage_facts_section_customize_styles() {
		wp_enqueue_style( 'homepage-facts-section-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
		
	// Customizer live preview
	public function homepage_facts_section_customize_live_preview() {
		wp_enqueue_script( 'homepage-facts-section-customize-live-preview', $this->plugin_url . 'js/customizer.js', array(  'jquery', 'customize-preview' ), '', true );
	}
	
	// Customizer header output
	public function homepage_facts_section_header_output() { 
		$display_facts						= get_theme_mod( 'display_facts', true );
		$display_facts_icons				= get_theme_mod( 'display_facts_icons' , '' );
		$facts_block_icon_size				= get_theme_mod( 'facts_block_icon_size' , '3' );
 	
		echo '<style type="text/css">';
		if ( $display_facts ) :
			if ( $display_facts_icons ) :
				self::generate_css('.facts-block-icon i', 'font-size', $facts_block_icon_size	, '', 'rem' );
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

	// Homepage Facts Section
	public static function homepage_facts_section() {
		$display_facts					= get_theme_mod( 'display_facts' , '' );
		$display_facts_title			= get_theme_mod( 'display_facts_title' , '' );
		$facts_title					= get_theme_mod( 'facts_title' , __( 'Facts', 'minisite-lite' ) );
		$facts_slug						= get_theme_mod( 'facts_slug' , __( 'facts', 'minisite-lite' ) );
		$display_facts_text				= get_theme_mod( 'display_facts_text' , '' );
		$facts_text						= wpautop( get_theme_mod( 'facts_text' , __( '', 'minisite-lite' ) ) );
		$display_facts_icons			= get_theme_mod( 'display_facts_icons' , '' );
		$facts_block_icon_position		= get_theme_mod( 'facts_block_icon_position' , 'top' );
		$facts_block_alignment			= get_theme_mod( 'facts_block_alignment' , 'center' );
		$display_facts_block_1			= get_theme_mod( 'display_facts_block_1' , '' );
		$facts_block_1_icon				= get_theme_mod( 'facts_block_1_icon' , '' );
		$facts_block_1_title_prefix		= get_theme_mod( 'facts_block_1_title_prefix' , __( '', 'minisite-lite' ) );
		$facts_block_1_title			= get_theme_mod( 'facts_block_1_title' , __( '', 'minisite-lite' ) );
		$facts_block_1_title_suffix		= get_theme_mod( 'facts_block_1_title_suffix' , __( '', 'minisite-lite' ) );
		$facts_block_1_text				= wpautop( get_theme_mod( 'facts_block_1_text' , __( '', 'minisite-lite' ) ) );
		$display_facts_block_2			= get_theme_mod( 'display_facts_block_2' , '' );
		$facts_block_2_icon				= get_theme_mod( 'facts_block_2_icon' , '' );
		$facts_block_2_title_prefix		= get_theme_mod( 'facts_block_2_title_prefix' , __( '', 'minisite-lite' ) );
		$facts_block_2_title			= get_theme_mod( 'facts_block_2_title' , __( '', 'minisite-lite' ) );
		$facts_block_2_title_suffix		= get_theme_mod( 'facts_block_2_title_suffix' , __( '', 'minisite-lite' ) );
		$facts_block_2_text				= wpautop( get_theme_mod( 'facts_block_2_text' , __( '', 'minisite-lite' ) ) );
		$display_facts_block_3			= get_theme_mod( 'display_facts_block_3' , '' );
		$facts_block_3_icon				= get_theme_mod( 'facts_block_3_icon' , '' );
		$facts_block_3_title_prefix		= get_theme_mod( 'facts_block_3_title_prefix' , __( '', 'minisite-lite' ) );
		$facts_block_3_title			= get_theme_mod( 'facts_block_3_title' , __( '', 'minisite-lite' ) );
		$facts_block_3_title_suffix		= get_theme_mod( 'facts_block_3_title_suffix' , __( '', 'minisite-lite' ) );
		$facts_block_3_text				= wpautop( get_theme_mod( 'facts_block_3_text' , __( '', 'minisite-lite' ) ) );
		$display_facts_block_4			= get_theme_mod( 'display_facts_block_4' , '' );
		$facts_block_4_icon				= get_theme_mod( 'facts_block_4_icon' , '' );
		$facts_block_4_title_prefix		= get_theme_mod( 'facts_block_4_title_prefix' , __( '', 'minisite-lite' ) );
		$facts_block_4_title			= get_theme_mod( 'facts_block_4_title' , __( '', 'minisite-lite' ) );
		$facts_block_4_title_suffix		= get_theme_mod( 'facts_block_4_title_suffix' , __( '', 'minisite-lite' ) );
		$facts_block_4_text				= wpautop( get_theme_mod( 'facts_block_4_text' , __( '', 'minisite-lite' ) ) );
		$display_facts_button			= get_theme_mod( 'display_facts_button' , '' );
		$facts_button_url				= get_theme_mod( 'facts_button_url' , '#' );
		$facts_button_text				= get_theme_mod( 'facts_button_text' , __( 'Button', 'minisite-lite' ) );
	?>
		<?php if ( $display_facts ) : ?>
			<section class="facts wrapper">
				<?php if ( $display_facts_title || $display_facts_text || $display_facts_block_1 || $display_facts_block_2 || $display_facts_block_3 || $display_facts_block_4 || is_active_sidebar( 'homepage-facts' ) || $display_facts_button ) : ?>	
					<div class="facts-container container">
						<?php if ( $display_facts_title || $display_facts_text ) : ?>
							<div class="facts-header row">
								<div class="col-lg-8 offset-lg-2 text-center">
									<?php if ( $display_facts_title ) : ?>
										<h2 id="<?php echo $facts_slug ?>" class="h1 facts-title">
											<?php echo $facts_title ?>
										</h2>
									<?php endif; ?>
									<?php if ( $display_facts_text ) : ?>
										<div class="facts-text lead">
											<?php echo $facts_text ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( $display_facts_block_1 || $display_facts_block_2 || $display_facts_block_3 || $display_facts_block_4 ) : ?>
							<div class="facts-content row">
								<?php if ( $display_facts_block_1 ) : ?>
							    	<div class="facts-block-1 facts-block col-md">
										<div class="row">
											<?php if ( $display_facts_icons ) : ?>
												<div class="facts-block-icon <?php if ( $facts_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $facts_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $facts_block_1_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="facts-block-title-text <?php if ( $facts_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $facts_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="h1">
													<?php if ( !empty( $facts_block_1_title_prefix ) ) : ?>	
														<span class="facts-block-title-prefix"><?php echo $facts_block_1_title_prefix ?></span>
													<?php endif; ?>
													<span class="facts-block-title counter"><?php echo $facts_block_1_title ?></span>
													<?php if ( !empty( $facts_block_1_title_suffix ) ) : ?>		
														<span class="facts-block-title-suffix"><?php echo $facts_block_1_title_suffix ?></span>
													<?php endif; ?>
												</h3>
												<div class="facts-block-text lead"><?php echo $facts_block_1_text ?></div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ( $display_facts_block_2 ) : ?>
							    	<div class="facts-block-2 facts-block col-md">
										<div class="row">
											<?php if ( $display_facts_icons ) : ?>
												<div class="facts-block-icon <?php if ( $facts_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $facts_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $facts_block_2_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="facts-block-title-text <?php if ( $facts_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $facts_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="h1">
													<?php if ( !empty( $facts_block_2_title_prefix ) ) : ?>	
														<span class="facts-block-title-prefix"><?php echo $facts_block_2_title_prefix ?></span>
													<?php endif; ?>
													<span class="facts-block-title counter"><?php echo $facts_block_2_title ?></span>
													<?php if ( !empty( $facts_block_2_title_suffix ) ) : ?>		
														<span class="facts-block-title-suffix"><?php echo $facts_block_2_title_suffix ?></span>
													<?php endif; ?>
												</h3>
												<div class="facts-block-text lead"><?php echo $facts_block_2_text ?></div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ( $display_facts_block_3 ) : ?>
							    	<div class="facts-block-3 facts-block col-md">
										<div class="row">
											<?php if ( $display_facts_icons ) : ?>
												<div class="facts-block-icon <?php if ( $facts_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $facts_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $facts_block_3_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="facts-block-title-text <?php if ( $facts_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $facts_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="h1">
													<?php if ( !empty( $facts_block_3_title_prefix ) ) : ?>	
														<span class="facts-block-title-prefix"><?php echo $facts_block_3_title_prefix ?></span>
													<?php endif; ?>
													<span class="facts-block-title counter"><?php echo $facts_block_3_title ?></span>
													<?php if ( !empty( $facts_block_3_title_suffix ) ) : ?>		
														<span class="facts-block-title-suffix"><?php echo $facts_block_3_title_suffix ?></span>
													<?php endif; ?>
												</h3>
												<div class="facts-block-text lead"><?php echo $facts_block_3_text ?></div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ( $display_facts_block_4 ) : ?>
							    	<div class="facts-block-4 facts-block col-md">
										<div class="row">
											<?php if ( $display_facts_icons ) : ?>
												<div class="facts-block-icon <?php if ( $facts_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-3<?php endif; ?><?php if ( $facts_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
													<i class="p <?php echo $facts_block_4_icon ?>" aria-hidden="true"></i>
												</div>
											<?php endif; ?>
											<div class="facts-block-title-text <?php if ( $facts_block_icon_position === 'top' ) : ?>col-md-12<?php else : ?>col-md-9<?php endif; ?><?php if ( $facts_block_alignment === 'center' ) : ?> text-center<?php endif; ?>">
												<h3 class="h1">
													<?php if ( !empty( $facts_block_4_title_prefix ) ) : ?>	
														<span class="facts-block-title-prefix"><?php echo $facts_block_4_title_prefix ?></span>
													<?php endif; ?>
													<span class="facts-block-title counter"><?php echo $facts_block_4_title ?></span>
													<?php if ( !empty( $facts_block_4_title_suffix ) ) : ?>		
														<span class="facts-block-title-suffix"><?php echo $facts_block_4_title_suffix ?></span>
													<?php endif; ?>
												</h3>
												<div class="facts-block-text lead"><?php echo $facts_block_4_text ?></div>
											</div>
										</div>
									</div>
								<?php endif; ?>
					    	</div>
						<?php endif; ?>
						<?php if ( $display_facts_button ) : ?>
							<div class="facts-footer row">
								<div class="col-md text-center">
									<p><a href="<?php echo $facts_button_url ?>" class="facts-button btn btn-primary" role="button"><?php echo $facts_button_text ?></a></p>
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
