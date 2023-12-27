<?php
/**
 * Plugin Name: Homepage Team Section
 * Plugin URI: https://getminisites.com/theme/
 * Description: Show off your expertise with pictures and bios of key team members, along with links to their social media profiles.
 * Version: 1.0.0
 * Author: Troy Templeman
 * Author URI: https://troytempleman.com/
 * License: GNU General Public License v2 or later
 * License URI: LICENSE
 * Text Domain: homepage-team-section
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Homepage_Team_Section to prevent the need to use globals
function Homepage_Team_Section() {
	return Homepage_Team_Section::instance();
} 

Homepage_Team_Section();

// Homepage_Team_Section Class
final class Homepage_Team_Section {
	
	// The single instance of Homepage_Team_Section
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
 
		add_action( 'init', array( $this, 'homepage_team_section_setup' ) );
	}

	// Homepage_Team_Section Instance
	// Ensures only one instance of Homepage_Team_Section is loaded or can be loaded
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
	public function homepage_team_section_setup() {
		if ( get_theme_mod( 'display_team' , true ) ) :
				add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_scripts' ), 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'homepage_team_section_styles' ), 100 );
		endif;	
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'homepage_team_section_customize_styles' ), 100 );
		add_action( 'customize_preview_init', array( $this, 'homepage_team_section_customize_live_preview' ), 100 );
		add_action( 'customize_register', array( $this, 'homepage_team_section_customize_register' ) );
		if ( get_theme_mod( 'display_team' , true ) ) :
			add_action( 'homepage', array( $this, 'homepage_team_section' ), 40 );
		endif;
	}

	// Customizer
	public function homepage_team_section_customize_register( $wp_customize ) {
		
		//Team
		$wp_customize->add_section( 'team' , array(
			'title'				=> __( 'Team', 'minisite-lite' ),
			'panel'				=> 'homepage',
			'priority'			=> 40
		) );

			// Display Team
			$wp_customize->add_setting( 'display_team', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team', array(
				'label'				=> __( 'Display Team', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
			) );
			function display_team_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}

			// Title
			$wp_customize->add_setting( 'display_team_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
			function display_team_title_callback( $control ) { 
				if ( $control->manager->get_setting( 'display_team_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_title', array(
				'default' 			=> __( 'Team', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_title_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'team_title', array(
				'selector'			=> '.team .team-title'
			) );
			
			// Slug
			$wp_customize->add_setting( 'team_slug', array(
				'default' 			=> __( 'team', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_slug', array(
				'label'				=> __( 'Slug', 'minisite-lite' ),
				'description'		=> __( '<strong>Permalink: </strong>', 'minisite-lite' ) . esc_html__( get_site_url() . '#', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_title_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'display_team_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_text', array(
				'label'				=> __( 'Text ', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
			function display_team_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_text',
				array(
					'default'			=> __( '', 'minisite-lite' ), 
					'transport' => 'postMessage',
					'sanitize_callback' => 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'team_text', array(
				'label' => __( 'Text', 'minisite-lite' ),
				'section' => 'team',
				'input_attrs' => array(
				'toolbar1' => 'bold italic bullist numlist alignleft aligncenter alignright link',
				'toolbar2' => 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_text_callback( $control ) );
				},
			) ) );
			
			// Bio 1
			$wp_customize->add_setting( 'display_team_bio_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_1', array(
				'label'				=> __( 'Bio 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
			function display_team_bio_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Image
			$wp_customize->add_setting( 'display_team_bio_1_image', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_1_image', array(
				'label'				=> __( 'Image', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) );
				 },
			) );
			function display_team_bio_1_image_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_1_image' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_1_image', array(
				'default'			=> '',
				'sanitize_callback' => 'absint',
			) );
			$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'team_bio_1_image', array(
				'label'       		=> __( 'Image', 'minisite-lite' ),
				'flex_width'  		=> false, 
				'flex_height' 		=> false,
				'width'       		=> 330,
				'height'      		=> 330,
				'settings'			=> 'team_bio_1_image',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) && display_team_bio_1_image_callback( $control ) );
				 },
			) ) );
		
			// Name
			$wp_customize->add_setting( 'team_bio_1_name', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_1_name', array(
				'label'				=> __( 'Name', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) );
				 },
			) );
		
			// Title
			$wp_customize->add_setting( 'display_team_bio_1_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_1_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) );
				 },
			) );
			function display_team_bio_1_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_1_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_1_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_1_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) && display_team_bio_1_title_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'display_team_bio_1_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_1_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) );
				 },
			) );
			function display_team_bio_1_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_1_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_1_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'team_bio_1_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'team',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) && display_team_bio_1_text_callback( $control ) );
				},
			) ) );
			
			
			// Link 1
			$wp_customize->add_setting( 'display_team_bio_1_link_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_1_link_1', array(
				'label'				=> __( 'Link 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) );
				}
			) );
			function display_team_bio_1_link_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_1_link_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_1_link_1_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_1_link_1_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) && display_team_bio_1_link_1_callback( $control ) );
				},
			) );
			
			// Icon
			$wp_customize->add_setting( 'team_bio_1_link_1_icon', array(
				'default'			=> '',
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_1_link_1_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) && display_team_bio_1_link_1_callback( $control ) );
				},
			) );
			
			// Link 2
			$wp_customize->add_setting( 'display_team_bio_1_link_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_1_link_2', array(
				'label'				=> __( 'Link 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) );
				}
			) );
			function display_team_bio_1_link_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_1_link_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_1_link_2_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw',
			) );	
			$wp_customize->add_control( 'team_bio_1_link_2_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) && display_team_bio_1_link_2_callback( $control ) );
				},
			) );
			
			// Icon
			$wp_customize->add_setting( 'team_bio_1_link_2_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_1_link_2_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) && display_team_bio_1_link_2_callback( $control ) );
				},
			) );
			
			// Link 3
			$wp_customize->add_setting( 'display_team_bio_1_link_3', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_1_link_3', array(
				'label'				=> __( 'Link 3', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) );
				}
			) );
			function display_team_bio_1_link_3_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_1_link_3' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_1_link_3_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_1_link_3_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) && display_team_bio_1_link_3_callback( $control ) );
				},
			) );
			
			// Icon
			$wp_customize->add_setting( 'team_bio_1_link_3_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_1_link_3_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_1_callback( $control ) && display_team_bio_1_link_3_callback( $control ) );
				},
			) );
			
			// Bio 2
			$wp_customize->add_setting( 'display_team_bio_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_2', array(
				'label'				=> __( 'Bio 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
			function display_team_bio_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}	
			
			// Image
			$wp_customize->add_setting( 'display_team_bio_2_image', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_2_image', array(
				'label'				=> __( 'Image', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) );
				 },
			) );
			function display_team_bio_2_image_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_2_image' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_2_image', array(
				'default'			=> '',
				'sanitize_callback' => 'absint',
			) );
			$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'team_bio_2_image', array(
				'label'       		=> __( 'Image', 'minisite-lite' ),
				'flex_width'  		=> false, 
				'flex_height' 		=> false,
				'width'       		=> 330,
				'height'      		=> 330,
				'settings'			=> 'team_bio_2_image',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) && display_team_bio_2_image_callback( $control ) );
				 },
			) ) );

			// Name
			$wp_customize->add_setting( 'team_bio_2_name', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_2_name', array(
				'label'				=> __( 'Name', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) );
				 },
			) );

			// Title
			$wp_customize->add_setting( 'display_team_bio_2_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_2_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) );
				 },
			) );
			function display_team_bio_2_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_2_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_2_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_2_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) && display_team_bio_2_title_callback( $control ) );
				 },
			) );
			
			// Text
			$wp_customize->add_setting( 'display_team_bio_2_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_2_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) );
				 },
			) );
			function display_team_bio_2_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_2_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_2_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'team_bio_2_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'team',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) && display_team_bio_2_text_callback( $control ) );
				},
			) ) );
			
			// Link 1
			$wp_customize->add_setting( 'display_team_bio_2_link_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_2_link_1', array(
				'label'				=> __( 'Link 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) );
				},
			) );
			function display_team_bio_2_link_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_2_link_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_2_link_1_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_2_link_1_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) && display_team_bio_2_link_1_callback( $control ) );
				},
			) );

			// Icon
			$wp_customize->add_setting( 'team_bio_2_link_1_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_2_link_1_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) && display_team_bio_2_link_1_callback( $control ) );
				},
			) );
			
			// Link 2
			$wp_customize->add_setting( 'display_team_bio_2_link_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_2_link_2', array(
				'label'				=> __( 'Link 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) );
				}
			) );
			function display_team_bio_2_link_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_2_link_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_2_link_2_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_2_link_2_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) && display_team_bio_2_link_2_callback( $control ) );
				},
			) );

			// Icon
			$wp_customize->add_setting( 'team_bio_2_link_2_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_2_link_2_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) && display_team_bio_2_link_2_callback( $control ) );
				},
			) );
			
			// Link 3
			$wp_customize->add_setting( 'display_team_bio_2_link_3', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_2_link_3', array(
				'label'				=> __( 'Link 3', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) );
				}
			) );
			function display_team_bio_2_link_3_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_2_link_3' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_2_link_3_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_2_link_3_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) && display_team_bio_2_link_3_callback( $control ) );
				},
			) );

			// Icon
			$wp_customize->add_setting( 'team_bio_2_link_3_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_2_link_3_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_2_callback( $control ) && display_team_bio_2_link_3_callback( $control ) );
				},
			) );
			
			// Bio 3
			$wp_customize->add_setting( 'display_team_bio_3', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_3', array(
				'label'				=> __( 'Bio 3', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
			function display_team_bio_3_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_3' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Image
			$wp_customize->add_setting( 'display_team_bio_3_image', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_3_image', array(
				'label'				=> __( 'Image', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) );
				 },
			) );
			function display_team_bio_3_image_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_3_image' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_3_image', array(
				'default'			=> '',
				'sanitize_callback' => 'absint',
			) );
			$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'team_bio_3_image', array(
				'label'       		=> __( 'Image', 'minisite-lite' ),
				'flex_width'  		=> false, 
				'flex_height' 		=> false,
				'width'       		=> 330,
				'height'      		=> 330,
				'settings'			=> 'team_bio_3_image',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) && display_team_bio_3_image_callback( $control ) );
				 },
			) ) );

			// Name
			$wp_customize->add_setting( 'team_bio_3_name', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_3_name', array(
				'label'				=> __( 'Name', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) );
				 },
			) );

			// Title
			$wp_customize->add_setting( 'display_team_bio_3_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_3_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) );
				 },
			) );
			function display_team_bio_3_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_3_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_3_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_3_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) && display_team_bio_3_title_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'display_team_bio_3_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_3_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) );
				 },
			) );
			function display_team_bio_3_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_3_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			// Text
			$wp_customize->add_setting( 'team_bio_3_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'team_bio_3_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'team',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) && display_team_bio_3_text_callback( $control ) );
				},
			) ) );
			
			// Link 1
			$wp_customize->add_setting( 'display_team_bio_3_link_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_3_link_1', array(
				'label'				=> __( 'Link 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) );
				}
			) );
			function display_team_bio_3_link_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_3_link_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_3_link_1_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_3_link_1_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) && display_team_bio_3_link_1_callback( $control ) );
				},
			) );
			
			// Icon
			$wp_customize->add_setting( 'team_bio_3_link_1_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_3_link_1_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) && display_team_bio_3_link_1_callback( $control ) );
				},
			) );
			
			// Link 2
			$wp_customize->add_setting( 'display_team_bio_3_link_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_3_link_2', array(
				'label'				=> __( 'Link 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) );
				}
			) );
			function display_team_bio_3_link_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_3_link_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_3_link_2_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_3_link_2_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) && display_team_bio_3_link_2_callback( $control ) );
				},
			) );

			// Icon
			$wp_customize->add_setting( 'team_bio_3_link_2_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_3_link_2_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) && display_team_bio_3_link_2_callback( $control ) );
				},
			) );

			// Link 3
			$wp_customize->add_setting( 'display_team_bio_3_link_3', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_3_link_3', array(
				'label'				=> __( 'Link 3', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) );
				}
			) );
			function display_team_bio_3_link_3_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_3_link_3' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_3_link_3_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_3_link_3_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) && display_team_bio_3_link_3_callback( $control ) );
				},
			) );
			
			// Icon
			$wp_customize->add_setting( 'team_bio_3_link_3_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_3_link_3_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_3_callback( $control ) && display_team_bio_3_link_3_callback( $control ) );
				},
			) );

			// Bio 4
			$wp_customize->add_setting( 'display_team_bio_4', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_4', array(
				'label'				=> __( 'Bio 4', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
			function display_team_bio_4_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_4' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Image
			$wp_customize->add_setting( 'display_team_bio_4_image', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_4_image', array(
				'label'				=> __( 'Image', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) );
				 },
			) );
			function display_team_bio_4_image_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_4_image' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_4_image', array(
				'default'			=> '',
				'sanitize_callback' => 'absint',
			) );
			$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'team_bio_4_image', array(
				'label'       		=> __( 'Image', 'minisite-lite' ),
				'flex_width'  		=> false, 
				'flex_height' 		=> false,
				'width'       		=> 330,
				'height'      		=> 330,
				'settings'			=> 'team_bio_4_image',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) && display_team_bio_4_image_callback( $control ) );
				 },
			) ) );

			// Name
			$wp_customize->add_setting( 'team_bio_4_name', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_4_name', array(
				'label'				=> __( 'Name', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) );
				 },
			) );

			// Title
			$wp_customize->add_setting( 'display_team_bio_4_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_4_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) );
				 },
			) );
			function display_team_bio_4_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_4_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_4_title', array(
				'default' 			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_4_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) && display_team_bio_4_title_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'display_team_bio_4_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_4_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) );
				 },
			) );
			function display_team_bio_4_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_4_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Text
			$wp_customize->add_setting( 'team_bio_4_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'team_bio_4_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'team',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) && display_team_bio_4_text_callback( $control ) );
				},
			) ) );

			// Link 1
			$wp_customize->add_setting( 'display_team_bio_4_link_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_4_link_1', array(
				'label'				=> __( 'Link 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) );
				}
			) );
			function display_team_bio_4_link_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_4_link_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_4_link_1_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_4_link_1_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) && display_team_bio_4_link_1_callback( $control ) );
				},
			) );
			
			// Icon
			$wp_customize->add_setting( 'team_bio_4_link_1_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_4_link_1_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) && display_team_bio_4_link_1_callback( $control ) );
				},
			) );
			
			// Link 2
			$wp_customize->add_setting( 'display_team_bio_4_link_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_4_link_2', array(
				'label'				=> __( 'Link 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) );
				}
			) );
			function display_team_bio_4_link_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_4_link_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_4_link_2_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_4_link_2_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) && display_team_bio_4_link_2_callback( $control ) );
				},
			) );

			// Icon
			$wp_customize->add_setting( 'team_bio_4_link_2_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_4_link_2_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: icon-heart).',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) && display_team_bio_4_link_2_callback( $control ) );
				},
			) );

			// Link 3
			$wp_customize->add_setting( 'display_team_bio_4_link_3', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_bio_4_link_3', array(
				'label'				=> __( 'Link 3', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) );
				}
			) );
			function display_team_bio_4_link_3_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_bio_4_link_3' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_bio_4_link_3_url', array(
				'default' 			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw'
			) );	
			$wp_customize->add_control( 'team_bio_4_link_3_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'url',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) && display_team_bio_4_link_3_callback( $control ) );
				},
			) );
			
			// Icon
			$wp_customize->add_setting( 'team_bio_4_link_3_icon', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_bio_4_link_3_icon', array(
				'label'				=> __( 'Icon', 'minisite-lite' ),
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and enter the code of the desired icon below (Example: Block 1-heart)',
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'	=> function( $control ) {
					return ( display_team_callback( $control ) && display_team_bio_4_callback( $control ) && display_team_bio_4_link_3_callback( $control ) );
				},
			) );
			
			// Team Button
			$wp_customize->add_setting( 'display_team_button', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_button', array(
				'label'				=> __( 'Button', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'   => 'display_team_callback'
			) );
			function display_team_button_callback( $control ) {
				if ( $control->manager->get_setting( 'display_team_button' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'team_button_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_button_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_button_callback( $control ) );
				}
			) );
			
			// Button URL
			$wp_customize->add_setting( 'team_button_url', array(
				'default'			=> '#',  
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'team_button_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'team',
				'active_callback'   => function( $control ) {
					return ( display_team_callback( $control ) && display_team_button_callback( $control ) );
				}
			) );
			
			// Colors
			$wp_customize->add_setting( 'display_team_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_colors', array(
				'label'				=> __( 'Colors', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Colors <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
			
			// Background
			$wp_customize->add_setting( 'display_team_background', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_background', array(
				'label'				=> __( 'Background', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Background <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
		
			// Padding
			$wp_customize->add_setting( 'display_team_padding', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_padding', array(
				'label'				=> __( 'Padding', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Padding <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
	
			// Animation
			$wp_customize->add_setting( 'display_team_animation', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_animation', array(
				'label'				=> __( 'Animation', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Animation <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
			
			// Animation
			$wp_customize->add_setting( 'display_team_widgets', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_team_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_team_widgets', array(
				'label'				=> __( 'Widgets', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Widgets <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'team',
				'active_callback'	=> 'display_team_callback',
			) );
			
		// Sanitize Checkbox
		function homepage_team_section_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}
		
		// Sanitize File
		function homepage_team_section_sanitize_file( $file, $setting ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png'
			);
			$file_ext = wp_check_filetype( $file, $mimes );
			return ( $file_ext['ext'] ? $file : $setting->default );
		}
		
		// Sanitize Number Range
		function homepage_team_section_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 0.001 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}

		// Sanitize Select
		function homepage_team_section_sanitize_select( $input, $setting ){
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
	public function homepage_team_section_styles() {
		wp_enqueue_style( 'homepage-team-section-style', $this->plugin_url . 'css/style.css', array(), '' );
		wp_enqueue_style( 'icon-fonts-style', $this->plugin_url . 'icons/style.css', array(), '' );
	}
	
	// Customizer styles
	public function homepage_team_section_customize_styles() {
		wp_enqueue_style( 'homepage-team-section-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
		
	// Customizer live preview
	public function homepage_team_section_customize_live_preview() {
		wp_enqueue_script( 'homepage-team-section-customize-live-preview', $this->plugin_url . 'js/customizer.js', array(  'jquery', 'customize-preview' ), '', true );
	}

	// Homepage Team Section
	public static function homepage_team_section() {
		$display_team					= get_theme_mod( 'display_team' , '' );
		$display_team_title				= get_theme_mod( 'display_team_title' , '' );
		$team_title						= get_theme_mod( 'team_title' , __( 'Team', 'minisite-lite' ) );
		$team_slug						= get_theme_mod( 'team_slug' , __( 'team', 'minisite-lite' ) );
		$display_team_text				= get_theme_mod( 'display_team_text' , '' );
		$team_text						= wpautop( get_theme_mod( 'team_text' , __( '', 'minisite-lite' ) ) );
		$display_team_bio_1				= get_theme_mod( 'display_team_bio_1' , '' );
		$display_team_bio_1_image		= get_theme_mod( 'display_team_bio_1_image' , '' );
		$team_bio_1_image				= get_theme_mod( 'team_bio_1_image' , '' );
		$team_bio_1_name				= get_theme_mod( 'team_bio_1_name' , __( '', 'minisite-lite' ) );
		$display_team_bio_1_title		= get_theme_mod( 'display_team_bio_1_title' , '' );		
		$team_bio_1_title				= get_theme_mod( 'team_bio_1_title' , __( '', 'minisite-lite' ) ); 
		$display_team_bio_1_text		= get_theme_mod( 'display_team_bio_1_text' , '' );
		$team_bio_1_text				= wpautop( get_theme_mod( 'team_bio_1_text' , __( '', 'minisite-lite' ) ) );
		$display_team_bio_1_link_1		= get_theme_mod( 'display_team_bio_1_link_1' , '' );
		$team_bio_1_link_1_url			= get_theme_mod( 'team_bio_1_link_1_url' , '' );
		$team_bio_1_link_1_icon			= get_theme_mod( 'team_bio_1_link_1_icon' , '' );
		$display_team_bio_1_link_2		= get_theme_mod( 'display_team_bio_1_link_2' , '' );
		$team_bio_1_link_2_url			= get_theme_mod( 'team_bio_1_link_2_url' , '' );
		$team_bio_1_link_2_icon			= get_theme_mod( 'team_bio_1_link_2_icon' , '' );
		$display_team_bio_1_link_3		= get_theme_mod( 'display_team_bio_1_link_3' , '' );
		$team_bio_1_link_3_url			= get_theme_mod( 'team_bio_1_link_3_url' , '' );
		$team_bio_1_link_3_icon			= get_theme_mod( 'team_bio_1_link_3_icon' , '' );
		$display_team_bio_2				= get_theme_mod( 'display_team_bio_2' , '' );
		$display_team_bio_2_image		= get_theme_mod( 'display_team_bio_2_image' , '' );
		$team_bio_2_image				= get_theme_mod( 'team_bio_2_image' , '' );
		$team_bio_2_name				= get_theme_mod( 'team_bio_2_name' , __( '', 'minisite-lite' ) );
		$display_team_bio_2_title		= get_theme_mod( 'display_team_bio_2_title' , '' );		
		$team_bio_2_title				= get_theme_mod( 'team_bio_2_title' , __( '', 'minisite-lite' ) ); 
		$display_team_bio_2_text		= get_theme_mod( 'display_team_bio_2_text' , '' );
		$team_bio_2_text				= wpautop( get_theme_mod( 'team_bio_2_text' , __( '', 'minisite-lite' ) ) );
		$display_team_bio_2_link_1		= get_theme_mod( 'display_team_bio_2_link_1' , '' );
		$team_bio_2_link_1_url			= get_theme_mod( 'team_bio_2_link_1_url' , '' );
		$team_bio_2_link_1_icon			= get_theme_mod( 'team_bio_2_link_1_icon' , '' );
		$display_team_bio_2_link_2		= get_theme_mod( 'display_team_bio_2_link_2' , '');
		$team_bio_2_link_2_url			= get_theme_mod( 'team_bio_2_link_2_url' , '' );
		$team_bio_2_link_2_icon			= get_theme_mod( 'team_bio_2_link_2_icon' , '' );
		$display_team_bio_2_link_3		= get_theme_mod( 'display_team_bio_2_link_3' , '' );
		$team_bio_2_link_3_url			= get_theme_mod( 'team_bio_2_link_3_url' , '' );
		$team_bio_2_link_3_icon			= get_theme_mod( 'team_bio_2_link_3_icon' , '' );
		$display_team_bio_3				= get_theme_mod( 'display_team_bio_3' , '' );
		$display_team_bio_3_image		= get_theme_mod( 'display_team_bio_3_image' , '' );
		$team_bio_3_image				= get_theme_mod( 'team_bio_3_image' , '' );
		$display_team_bio_3_name		= get_theme_mod( 'display_team_bio_3_name' , '' );
		$team_bio_3_name				= get_theme_mod( 'team_bio_3_name' , __( '', 'minisite-lite' ) );
		$display_team_bio_3_title		= get_theme_mod( 'display_team_bio_3_title' , '' );		
		$team_bio_3_title				= get_theme_mod( 'team_bio_3_title' , __( '', 'minisite-lite' ) ); 
		$display_team_bio_3_text		= get_theme_mod( 'display_team_bio_3_text' , '' );
		$team_bio_3_text				= wpautop( get_theme_mod( 'team_bio_3_text' , __( '', 'minisite-lite' ) ) );
		$display_team_bio_3_link_1		= get_theme_mod( 'display_team_bio_3_link_1' , '' );
		$team_bio_3_link_1_url			= get_theme_mod( 'team_bio_3_link_1_url' , '' );
		$team_bio_3_link_1_icon			= get_theme_mod( 'team_bio_3_link_1_icon' , '' );
		$display_team_bio_3_link_2		= get_theme_mod( 'display_team_bio_3_link_2' , '' );
		$team_bio_3_link_2_url			= get_theme_mod( 'team_bio_3_link_2_url' , '' );
		$team_bio_3_link_2_icon			= get_theme_mod( 'team_bio_3_link_2_icon' , '' );
		$display_team_bio_3_link_3		= get_theme_mod( 'display_team_bio_3_link_3' , '' );
		$team_bio_3_link_3_url			= get_theme_mod( 'team_bio_3_link_3_url' , '' );
		$team_bio_3_link_3_icon			= get_theme_mod( 'team_bio_3_link_3_icon' , '' );
		$display_team_bio_4				= get_theme_mod( 'display_team_bio_4' , '' );
		$display_team_bio_4_image		= get_theme_mod( 'display_team_bio_4_image' , '' );
		$team_bio_4_image				= get_theme_mod( 'team_bio_4_image' , '' );
		$team_bio_4_name				= get_theme_mod( 'team_bio_4_name' , __( '', 'minisite-lite' ) );
		$display_team_bio_4_title		= get_theme_mod( 'display_team_bio_4_title' , '' );		
		$team_bio_4_title				= get_theme_mod( 'team_bio_4_title' , __( '', 'minisite-lite' ) ); 
		$display_team_bio_4_text		= get_theme_mod( 'display_team_bio_4_text' , '' );
		$team_bio_4_text				= wpautop( get_theme_mod( 'team_bio_4_text' , __( '', 'minisite-lite' ) ) );
		$display_team_bio_4_link_1		= get_theme_mod( 'display_team_bio_4_link_1' , '' );
		$team_bio_4_link_1_url			= get_theme_mod( 'team_bio_4_link_1_url' , '' );
		$team_bio_4_link_1_icon			= get_theme_mod( 'team_bio_4_link_1_icon' , '' );
		$display_team_bio_4_link_2		= get_theme_mod( 'display_team_bio_4_link_2' , '' );
		$team_bio_4_link_2_url			= get_theme_mod( 'team_bio_4_link_2_url' , '' );
		$team_bio_4_link_2_icon			= get_theme_mod( 'team_bio_4_link_2_icon' , '' );
		$display_team_bio_4_link_3		= get_theme_mod( 'display_team_bio_4_link_3' , '' );
		$team_bio_4_link_3_url			= get_theme_mod( 'team_bio_4_link_3_url' , '' );
		$team_bio_4_link_3_icon			= get_theme_mod( 'team_bio_4_link_3_icon' , '' );
		$display_team_button			= get_theme_mod( 'display_team_button' , '' );
		$team_button_url				= get_theme_mod( 'team_button_url' , '#' );
		$team_button_text				= get_theme_mod( 'team_button_text' , __( 'Button', 'minisite-lite' ) );
	?>	
		<?php if ( $display_team ) : ?>
			<section class="team wrapper">
				<?php if ( $display_team_title || $display_team_text || $display_team_bio_1 || $display_team_bio_2 || $display_team_bio_3 || $display_team_bio_4 || is_active_sidebar( 'homepage-team' ) || $display_team_button ) : ?>	
					<div class="team-container container">
						<?php if ( $display_team_title || $display_team_text ) : ?>
							<div class="team-header row">
						    	<div class="col-lg-8 offset-lg-2 text-center">
									<?php if ( $display_team_title ) : ?>
										<h2 id="<?php echo $team_slug ?>" class="h1 team-title">
											<?php echo $team_title ?>
										</h2>
									<?php endif; ?>
									<?php if ( $display_team_text ) : ?>
										<div class="team-text lead">
											<?php echo $team_text ?>
										</div>
									<?php endif; ?>
								</div>
					    	</div>
						<?php endif; ?>
						<?php if ( $display_team_bio_1 || $display_team_bio_2 || $display_team_bio_3 || $display_team_bio_4 ) : ?>
							<div class="team-content row">
						    	<?php if ( $display_team_bio_1 ) : ?>
							    	<div class="team-block-1 team-block col-md text-center">
										<?php if ( $display_team_bio_1_image ) : ?>
											<img class="team-block-image rounded-circle img-responsive center-block" src="<?php echo wp_get_attachment_url( $team_bio_1_image ); ?>" alt="<?php echo $team_bio_1_name ?>" width="165" height="165">
										<?php endif; ?>
										<h3 class="team-block-name mb-0">
											<?php echo $team_bio_1_name ?>
										</h3>
										<?php if ( $display_team_bio_1_title ) : ?>
											<div>
												<em class="p team-block-title">
													<?php echo $team_bio_1_title ?>
												</em>
											</div>
										<?php endif; ?>
										<?php if ( $display_team_bio_1_text ) : ?>
											<div class="team-block-text">
												<?php echo $team_bio_1_text ?>
											</div>
										<?php endif; ?>
										<?php if ( $display_team_bio_1_link_1 || $display_team_bio_1_link_2 || $display_team_bio_1_link_3 ) : ?>
											<ul class="team-block-social-media list-unstyled list-inline">
												<?php if ( $display_team_bio_1_link_1 ) : ?>
													<li class="team-block-social-media-1 list-inline-item">
														<a href="<?php echo $team_bio_1_link_1_url ?>" target="_blank">
															<i class="<?php echo $team_bio_1_link_1_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if ( $display_team_bio_1_link_2 ) : ?>
													<li class="team-block-social-media-2 list-inline-item">
														<a href="<?php echo $team_bio_1_link_2_url ?>" target="_blank">
															<i class="<?php echo $team_bio_1_link_2_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if ( $display_team_bio_1_link_3 ) : ?>
													<li class="team-block-social-media-3 list-inline-item">
														<a href="<?php echo $team_bio_1_link_3_url ?>" target="_blank">
															<i class="<?php echo $team_bio_1_link_3_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
											</ul>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php if ( $display_team_bio_2 ) : ?>
							    	<div class="team-block-2 team-block col-md text-center">
										<?php if ( $display_team_bio_2_image ) : ?>
											<img class="team-block-image rounded-circle img-responsive center-block" src="<?php echo wp_get_attachment_url( $team_bio_2_image ); ?>" alt="<?php echo $team_bio_2_name ?>" width="165" height="165">
										<?php endif; ?>
										<h3 class="team-block-name mb-0">
											<?php echo $team_bio_2_name ?>
										</h3>
										<?php if ( $display_team_bio_2_title ) : ?>
											<div>
												<em class="p team-block-title">
													<?php echo $team_bio_2_title ?>
												</em>
											</div>
										<?php endif; ?>
										<?php if ( $display_team_bio_2_text ) : ?>
											<div class="team-block-text">
												<?php echo $team_bio_2_text ?>
											</div>
										<?php endif; ?>
										<?php if ( $display_team_bio_2_link_1 || $display_team_bio_2_link_2 || $display_team_bio_2_link_3 ) : ?>
											<ul class="team-block-social-media list-unstyled list-inline">
												<?php if ( $display_team_bio_2_link_1 ) : ?>
													<li class="team-block-social-media-1 list-inline-item">
														<a href="<?php echo $team_bio_2_link_1_url ?>" target="_blank">
															<i class="<?php echo $team_bio_2_link_1_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if ( $display_team_bio_2_link_2 ) : ?>
													<li class="team-block-social-media-2 list-inline-item">
														<a href="<?php echo $team_bio_2_link_2_url ?>" target="_blank">
															<i class="<?php echo $team_bio_2_link_2_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if ( $display_team_bio_2_link_3 ) : ?>
													<li class="team-block-social-media-3 list-inline-item">
														<a href="<?php echo $team_bio_2_link_3_url ?>" target="_blank">
															<i class="<?php echo $team_bio_2_link_3_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
											</ul>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php if ( $display_team_bio_3 ) : ?>
							    	<div class="team-block-3 team-block col-md text-center">
										<?php if ( $display_team_bio_3_image ) : ?>
											<img class="team-block-image rounded-circle img-responsive center-block" src="<?php echo wp_get_attachment_url( $team_bio_3_image ); ?>" alt="<?php echo $team_bio_3_name ?>" width="165" height="165">
										<?php endif; ?>
										<h3 class="team-block-name mb-0">
											<?php echo $team_bio_3_name ?>
										</h3>
										<?php if ( $display_team_bio_3_title ) : ?>
											<div>
												<em class="p team-block-title">
													<?php echo $team_bio_3_title ?>
												</em>
											</div>
										<?php endif; ?>
										<?php if ( $display_team_bio_3_text ) : ?>
											<div class="team-block-text">
												<?php echo $team_bio_3_text ?>
											</div>
										<?php endif; ?>
										<?php if ( $display_team_bio_3_link_1 || $display_team_bio_3_link_2 || $display_team_bio_3_link_3 ) : ?>
											<ul class="team-block-social-media list-unstyled list-inline">
												<?php if ( $display_team_bio_3_link_1 ) : ?>
													<li class="team-block-social-media-1 list-inline-item">
														<a href="<?php echo $team_bio_3_link_1_url ?>" target="_blank">
															<i class="<?php echo $team_bio_3_link_1_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if ( $display_team_bio_3_link_2 ) : ?>
													<li class="team-block-social-media-2 list-inline-item">
														<a href="<?php echo $team_bio_3_link_2_url ?>" target="_blank">
															<i class="<?php echo $team_bio_3_link_2_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if ( $display_team_bio_3_link_3 ) : ?>
													<li class="team-block-social-media-3 list-inline-item">
														<a href="<?php echo $team_bio_3_link_3_url ?>" target="_blank">
															<i class="<?php echo $team_bio_3_link_3_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
											</ul>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php if ( $display_team_bio_4 ) : ?>
							    	<div class="team-block-4 team-block col-md text-center">
										<?php if ( $display_team_bio_4_image ) : ?>
											<img class="team-block-image rounded-circle img-responsive center-block" src="<?php echo wp_get_attachment_url( $team_bio_4_image ); ?>" alt="<?php echo $team_bio_4_name ?>" width="165" height="165">
										<?php endif; ?>
										<h3 class="team-block-name mb-0">
											<?php echo $team_bio_4_name ?>
										</h3>
										<?php if ( $display_team_bio_4_title ) : ?>
											<div>
												<em class="p team-block-title">
													<?php echo $team_bio_4_title ?>
												</em>
											</div>
										<?php endif; ?>
										<?php if ( $display_team_bio_4_text ) : ?>
											<div class="team-block-text">
												<?php echo $team_bio_4_text ?>
											</div>
										<?php endif; ?>
										<?php if ( $display_team_bio_4_link_1 || $display_team_bio_4_link_2 || $display_team_bio_4_link_3 ) : ?>
											<ul class="team-block-social-media list-unstyled list-inline">
												<?php if ( $display_team_bio_4_link_1 ) : ?>
													<li class="team-block-social-media-1 list-inline-item">
														<a href="<?php echo $team_bio_4_link_1_url ?>" target="_blank">
															<i class="<?php echo $team_bio_4_link_1_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if ( $display_team_bio_4_link_2 ) : ?>
													<li class="team-block-social-media-2 list-inline-item">
														<a href="<?php echo $team_bio_4_link_2_url ?>" target="_blank">
															<i class="<?php echo $team_bio_1_link_2_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if ( $display_team_bio_4_link_3 ) : ?>
													<li class="team-block-social-media-3 list-inline-item">
														<a href="<?php echo $team_bio_4_link_3_url ?>" target="_blank">
															<i class="<?php echo $team_bio_4_link_3_icon ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endif; ?>
											</ul>
										<?php endif; ?>
									</div>
								<?php endif; ?>
					    	</div>
						<?php endif; ?>
						<?php if ( $display_team_button ) : ?>
							<div class="team-footer row">
								<div class="col-md text-center">
									<p><a href="<?php echo $team_button_url ?>" class="team-button btn btn-primary" role="button"><?php echo $team_button_text ?></a></p>
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
