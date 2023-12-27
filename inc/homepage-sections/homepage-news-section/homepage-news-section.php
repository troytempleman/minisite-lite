<?php
/**
 * Plugin Name: Homepage News Section
 * Plugin URI: https://getminisites.com/theme/
 * Description: Keep your content fresh and users up to date with your latest news and/or blog posts displayed in a sliding carousel.
 * Version: 1.0.0
 * Author: Troy Templeman
 * Author URI: https://troytempleman.com/
 * License: GNU General Public License v2 or later
 * License URI: LICENSE
 * Text Domain: homepage-news-section
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Homepage_News_Section to prevent the need to use globals
function Homepage_News_Section() {
	return Homepage_News_Section::instance();
} 

Homepage_News_Section();

// Homepage_News_Section Class
final class Homepage_News_Section {
	
	// The single instance of Homepage_News_Section
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

		add_action( 'init', array( $this, 'homepage_news_section_setup' ) );
	}

	// Homepage_News_Section Instance
	// Ensures only one instance of Homepage_News_Section is loaded or can be loaded
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
	public function homepage_news_section_setup() {		
		if ( get_theme_mod( 'display_news' , true ) ) :
				add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_scripts' ), 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'slick_slider_scripts' ), 100 );
			add_action( 'wp_enqueue_scripts', array( $this, 'homepage_news_section_styles' ), 100 );
		endif;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'homepage_news_section_customize_styles' ), 100 );
		add_action( 'customize_preview_init', array( $this, 'homepage_news_section_customize_live_preview' ), 100 );
		add_action( 'customize_register', array( $this, 'homepage_news_section_customize_register' ) );
		if ( get_theme_mod( 'display_news' , true ) ) :
			add_action( 'homepage', array( $this, 'homepage_news_section' ), 70 );
		endif;
	}

	// Customizer
	public function homepage_news_section_customize_register( $wp_customize ) {
		
		// News
		$wp_customize->add_section( 'news' , array(
			'title'				=> __( 'News', 'minisite-lite' ),
			'panel'				=> 'homepage', 
			'priority'			=> 70
		) );

			// Display News
			$wp_customize->add_setting( 'display_news', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news', array(
				'label'				=> __( 'Display News', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'news',
			) );
			function display_news_callback( $control ) {
				if ( $control->manager->get_setting( 'display_news' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}			

			// Title
			$wp_customize->add_setting( 'display_news_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'	=> 'display_news_callback',
			) );
			function display_news_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_news_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'news_title', array(
				'default' 			=> __( 'News', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_title_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'news_title', array(
				'selector'			=> '.news .news-title'
			) );
			
			// Slug
			$wp_customize->add_setting( 'news_slug', array(
				'default' 			=> __( 'news', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_slug', array(
				'label'				=> __( 'Slug', 'minisite-lite' ),
				'description'		=> __( '<strong>Permalink: </strong>', 'minisite-lite' ) . esc_html__( get_site_url() . '#', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_title_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'display_news_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'	=> 'display_news_callback',
			) );
			function display_news_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_news_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'news_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'news_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'news',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_news_callback( $control ) && display_news_text_callback( $control ) );
				 },
			) ) );
			
			// News Items
			$wp_customize->add_setting( 'display_news_items', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_items', array(
				'label'				=> __( 'News Items', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'	=> 'display_news_callback',
			) );
			function display_news_items_callback( $control ) {
				if ( $control->manager->get_setting( 'display_news_items' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'news_items', array(
				'default' 			=> '',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_items', array(
				'label'				=> __( 'News Items', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) );
				 },
			) );
			
			// Item Word Count
			$wp_customize->add_setting( 'news_item_word_count', array(
				'default' 			=> '50',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_item_word_count', array(
				'label'				=> __( 'Word Count', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) );
				 },
			) );
			
			// Carousel
			$wp_customize->add_setting( 'display_news_carousel', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_carousel', array(
				'label'				=> __( 'Carousel', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) );
				 },
			) );
			function display_news_carousel_callback( $control ) {
				if ( $control->manager->get_setting( 'display_news_carousel' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Slides to Show
			$wp_customize->add_setting( 'news_carousel_slides_to_show', array(
				'default' 			=> '1',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_carousel_slides_to_show', array(
				'label'				=> __( 'Slides to Show', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Slides to Scroll
			$wp_customize->add_setting( 'news_carousel_slides_to_scroll', array(
				'default' 			=> '1',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_carousel_slides_to_scroll', array(
				'label'				=> __( 'Slides to Scroll', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Speed
			$wp_customize->add_setting( 'news_carousel_speed', array(
				'default' 			=> '300',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_carousel_speed', array(
				'label'				=> __( 'Speed', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Arrows
			$wp_customize->add_setting( 'news_carousel_arrows', array(
				'default' 			=> 'true', 
				'sanitize_callback' => 'homepage_news_section_sanitize_select'
			) );	
			$wp_customize->add_control( 'news_carousel_arrows', array(
				'label'				=> __( 'Arrows', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'true' 			=> 'Yes',
					'false' 		=> 'No'									
				),
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Dots
			$wp_customize->add_setting( 'news_carousel_dots', array(
				'default' 			=> 'true', 
				'sanitize_callback' => 'homepage_news_section_sanitize_select'
			) );	
			$wp_customize->add_control( 'news_carousel_dots', array(
				'label'				=> __( 'Dots', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'true' 			=> 'Yes',
					'false' 		=> 'No'									
				),
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Autoplay
			$wp_customize->add_setting( 'news_carousel_autoplay', array(
				'default' 			=> 'false', 
				'sanitize_callback' => 'homepage_news_section_sanitize_select'
			) );	
			$wp_customize->add_control( 'news_carousel_autoplay', array(
				'label'				=> __( 'Autoplay', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'true' 			=> 'Yes',
					'false' 		=> 'No'									
				),
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Autoplay Speed
			$wp_customize->add_setting( 'news_carousel_autoplay_speed', array(
				'default' 			=> '3000',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_carousel_autoplay_speed', array(
				'label'				=> __( 'Autoplay Speed', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Center Mode
			$wp_customize->add_setting( 'news_carousel_center_mode', array(
				'default' 			=> 'false', 
				'sanitize_callback' => 'homepage_news_section_sanitize_select'
			) );	
			$wp_customize->add_control( 'news_carousel_center_mode', array(
				'label'				=> __( 'Center Mode', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'true' 			=> 'Yes',
					'false' 		=> 'No'									
				),
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Draggable
			$wp_customize->add_setting( 'news_carousel_draggable', array(
				'default' 			=> 'true', 
				'sanitize_callback' => 'homepage_news_section_sanitize_select'
			) );	
			$wp_customize->add_control( 'news_carousel_draggable', array(
				'label'				=> __( 'Draggable', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'true' 			=> 'Yes',
					'false' 		=> 'No'									
				),
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Fade
			$wp_customize->add_setting( 'news_carousel_fade', array(
				'default' 			=> 'false', 
				'sanitize_callback' => 'homepage_news_section_sanitize_select'
			) );	
			$wp_customize->add_control( 'news_carousel_fade', array(
				'label'				=> __( 'Fade', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'true' 			=> 'Yes',
					'false' 		=> 'No'									
				),
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Infinite Looping
			$wp_customize->add_setting( 'news_carousel_infinite_looping', array(
				'default' 			=> 'true', 
				'sanitize_callback' => 'homepage_news_section_sanitize_select'
			) );	
			$wp_customize->add_control( 'news_carousel_infinite_looping', array(
				'label'				=> __( 'Infinite Looping', 'minisite-lite' ),
				'type'    			=> 'select',
				'choices'    		=> array(
					'true' 			=> 'Yes',
					'false' 		=> 'No'									
				),
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Initial Slide
			$wp_customize->add_setting( 'news_carousel_initial_slide', array(
				'default' 			=> '0',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_carousel_initial_slide', array(
				'label'				=> __( 'Initial Slide', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );

			// Rows
			$wp_customize->add_setting( 'news_carousel_rows', array(
				'default' 			=> '1',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_carousel_rows', array(
				'label'				=> __( 'Rows', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );
			
			// Slides per Row
			$wp_customize->add_setting( 'news_carousel_slides_per_row', array(
				'default' 			=> '1',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_carousel_slides_per_row', array(
				'label'				=> __( 'Slides per Row', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_items_callback( $control ) && display_news_carousel_callback( $control ) );
				 },
			) );

			// News Button
			$wp_customize->add_setting( 'display_news_button', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_button', array(
				'label'				=> __( 'Button', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'   => 'display_news_callback'
			) );
			function display_news_button_callback( $control ) {
				if ( $control->manager->get_setting( 'display_news_button' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'news_button_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_button_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_button_callback( $control ) );
				}
			) );
			
			// Button URL
			$wp_customize->add_setting( 'news_button_url', array(
				'default'			=> '#',  
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'news_button_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'news',
				'active_callback'   => function( $control ) {
					return ( display_news_callback( $control ) && display_news_button_callback( $control ) );
				}
			) );
			
			// Colors
			$wp_customize->add_setting( 'display_news_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_colors', array(
				'label'				=> __( 'Colors', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Colors <a href="'. get_admin_url() . '/themes.php?page=minisite&tab=upgrade' . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'	=> 'display_news_callback',
			) );
			
			// Background
			$wp_customize->add_setting( 'display_news_background', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_background', array(
				'label'				=> __( 'Background', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Background <a href="'. get_admin_url() . '/themes.php?page=minisite&tab=upgrade' . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'	=> 'display_news_callback',
			) );
		
			// Padding
			$wp_customize->add_setting( 'display_news_padding', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_padding', array(
				'label'				=> __( 'Padding', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Padding <a href="'. get_admin_url() . '/themes.php?page=minisite&tab=upgrade' . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'	=> 'display_news_callback',
			) );
	
			// Animation
			$wp_customize->add_setting( 'display_news_animation', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_animation', array(
				'label'				=> __( 'Animation', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Animation <a href="'. get_admin_url() . '/themes.php?page=minisite&tab=upgrade' . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'	=> 'display_news_callback',
			) );
			
			// Animation
			$wp_customize->add_setting( 'display_news_widgets', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_news_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_news_widgets', array(
				'label'				=> __( 'Widgets', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Widgets <a href="'. get_admin_url() . '/themes.php?page=minisite&tab=upgrade' . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'news',
				'active_callback'	=> 'display_news_callback',
			) );
			
		// Sanitize Checkbox
		function homepage_news_section_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}

		// Sanitize File
		function homepage_news_section_sanitize_file( $file, $setting ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png'
			);
			$file_ext = wp_check_filetype( $file, $mimes );
			return ( $file_ext['ext'] ? $file : $setting->default );
		}
		
		// Sanitize Number Range
		function homepage_news_section_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 0.001 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}

		// Sanitize Select
		function homepage_news_section_sanitize_select( $input, $setting ){
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
	
	// Slick Slider
	public function slick_slider_scripts() {
		wp_enqueue_style( 'slick-slider-style', $this->plugin_url . 'css/slick.css', array(), '1.8.0' );
		wp_enqueue_style( 'slick-slider-theme-style', $this->plugin_url . 'css/slick-theme.css', array(), '1.8.0' );
		wp_enqueue_script( 'slick-slider-js', $this->plugin_url . 'js/slick.min.js', array(), '1.8.0', true );	
		wp_enqueue_script( 'homepage-news-section-slick-slider-init-js', $this->plugin_url . 'js/slick-slider-init.js', array(), '', true );
	}
	
	// Styles
	public function homepage_news_section_styles() {
		wp_enqueue_style( 'homepage-news-section-style', $this->plugin_url . 'css/style.css', array(), '' );
	}
	
	// Customizer styles
	public function homepage_news_section_customize_styles() {
		wp_enqueue_style( 'homepage-news-section-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
		
	// Customizer live preview
	public function homepage_news_section_customize_live_preview() {
		wp_enqueue_script( 'homepage-news-section-customize-live-preview', $this->plugin_url . 'js/customizer.js', array(  'jquery', 'customize-preview' ), '', true );
	}
	
	// Homepage News Section
	public static function homepage_news_section() {	
		$display_news					= get_theme_mod( 'display_news' , '' );
		$display_news_title				= get_theme_mod( 'display_news_title' , '' );
		$news_title						= get_theme_mod( 'news_title' , __( 'News', 'minisite-lite' ) );
		$news_slug						= get_theme_mod( 'news_slug' , __( 'news', 'minisite-lite' ) );
		$display_news_text				= get_theme_mod( 'display_news_text' , '' );
		$news_text						= wpautop( get_theme_mod( 'news_text' , __( '', 'minisite-lite' ) ) );	
		$display_news_items				= get_theme_mod( 'display_news_items' , '' );
		$news_items						= get_theme_mod( 'news_items' , '' );
		$news_item_word_count			= get_theme_mod( 'news_item_word_count' , '50' );
		$args 							= array(
											'post_type' => 'post',
											'posts_per_page' => $news_items,
										  );
		$query 							= new WP_Query( $args );
		$display_news_carousel			= get_theme_mod( 'display_news_carousel' , '' );
		$news_carousel_slides_to_show	= get_theme_mod( 'news_carousel_slides_to_show' , '1' );  
		$news_carousel_slides_to_scroll = get_theme_mod( 'news_carousel_slides_to_scroll' , '1' ); 
		$news_carousel_speed			= get_theme_mod( 'news_carousel_speed' , '' );	
		$news_carousel_arrows			= get_theme_mod( 'news_carousel_arrows' , '' );
		$news_carousel_dots				= get_theme_mod( 'news_carousel_dots' , 'true' );
		$news_carousel_autoplay			= get_theme_mod( 'news_carousel_autoplay' , '' );
		$news_carousel_autoplay_speed	= get_theme_mod( 'news_carousel_autoplay_speed' , '' );
		$news_carousel_center_mode		= get_theme_mod( 'news_carousel_center_mode' , '' );
		$news_carousel_draggable		= get_theme_mod( 'news_carousel_draggable' , '' );
		$news_carousel_fade				= get_theme_mod( 'news_carousel_fade' , '' );
		$news_carousel_infinite_looping	= get_theme_mod( 'news_carousel_infinite_looping' , '' );
		$news_carousel_initial_slide	= get_theme_mod( 'news_carousel_initial_slide' , '' );
		$news_carousel_rows				= get_theme_mod( 'news_carousel_rows' , '' );
		$news_carousel_slides_per_row	= get_theme_mod( 'news_carousel_slides_per_row' , '' );
		$display_news_button			= get_theme_mod( 'display_news_button' , '' );
		$news_button_url				= get_theme_mod( 'news_button_url' , '#' );
		$news_button_text				= get_theme_mod( 'news_button_text' , __( 'Button', 'minisite-lite' ) );
	?>	
		
		<?php if ( $display_news ) : ?>
			<section class="news wrapper">
				<?php if ( $display_news_title || $display_news_text || $display_news_items || is_active_sidebar( 'homepage-news' ) || $display_news_button ) : ?>	
					<div class="news-container container">
						<?php if ( $display_news_title || $display_news_text ) : ?>
							<div class="news-header row">
								<div class="col-lg-8 offset-lg-2 text-center">
									<?php if ( $display_news_title ) : ?>
										<h2 id="<?php echo $news_slug ?>" class="h1 news-title">
											<?php echo $news_title ?>
										</h2>
									<?php endif; ?>
									<?php if ( $display_news_text ) : ?>
										<div class="news-text lead">
											<?php echo $news_text ?>
										</div>
									<?php endif; ?>	
								</div>
							</div>
						<?php endif; ?>	
						<?php if ( $display_news_items ) : ?>
							<div class="news-content row">
								<?php if ( $display_news_carousel ) : ?>
									<div class="news-carousel-container">
										<div class="news-carousel" data-slick='{
											<?php if ( $news_carousel_arrows ) { echo '"arrows":' . $news_carousel_arrows . ','; } ?>
											<?php if ( $news_carousel_autoplay ) { echo '"autoplay":' . $news_carousel_autoplay . ','; } ?>
											<?php if ( $news_carousel_autoplay_speed ) { echo '"autoplaySpeed":' . $news_carousel_autoplay_speed . ','; } ?>
											<?php if ( $news_carousel_center_mode ) { echo '"centerMode":' . $news_carousel_center_mode . ','; } ?>
											<?php if ( $news_carousel_dots ) { echo '"dots":' . $news_carousel_dots . ','; } ?>
											<?php if ( $news_carousel_draggable ) { echo '"draggable":' . $news_carousel_draggable . ','; } ?>
											<?php if ( $news_carousel_fade ) { echo '"fade":' . $news_carousel_fade . ','; } ?>
											<?php if ( $news_carousel_infinite_looping ) { echo '"infinite":' . $news_carousel_infinite_looping . ','; } ?>
											<?php if ( $news_carousel_initial_slide ) { echo '"initialSlide":' . $news_carousel_initial_slide . ','; } ?>
											<?php if ( $news_carousel_rows ) { echo '"rows":' . $news_carousel_rows . ','; } ?>
											<?php if ( $news_carousel_slides_per_row ) { echo '"slidesPerRow":' . $news_carousel_slides_per_row . ','; } ?>
											<?php if ( $news_carousel_speed ) { echo '"speed":' . $news_carousel_speed . ','; } ?>
											<?php if ( $news_carousel_slides_to_show ) { echo '"slidesToShow":' . $news_carousel_slides_to_show . ','; } ?>
											<?php if ( $news_carousel_slides_to_scroll ) { echo '"slidesToScroll":' . $news_carousel_slides_to_scroll; } ?>
										}'>
										<?php endif; ?>
										<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
											<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-md' ); ?>>
												<?php echo the_post_thumbnail( 'thumbnail', array() ); ?>
												<header class="entry-header">
													<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
													<p class="entry-meta">
														<?php echo __( 'Posted', 'minisite-lite' ); ?>
														<?php the_time('F j, Y \a\t g:ia'); ?>
														<?php echo __( 'by', 'minisite-lite' ); ?>
														<?php the_author_posts_link(); ?>
														<?php if (has_category()) : ?>
														<?php echo __( 'in', 'minisite-lite' ); ?>
														<?php the_category(', ') ?>		
														<?php endif; ?>
													</p>
												</header>
							                	<div class="entry-content">
							                 		<p><?php echo wp_trim_words( get_the_content(), $news_item_word_count, '...' ); ?></p>
							                    </div>
												<footer class="entry-footer">
													<p>
														<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" >
															<?php echo __( 'Read More', 'minisite-lite' ); ?>
														</a>
													</p>
												</footer>
											</article>
										<?php endwhile; else : ?>
											<article>
												<div class="entry-content">
													<?php esc_html_e( 'Not Found', 'minisite-lite' ); ?>
												</div>
											</article>
										<?php endif; ?>
										<?php wp_reset_postdata(); ?>
										<?php if ( $display_news_carousel ) : ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if ( $display_news_button ) : ?>
							<div class="news-footer row">
								<div class="col-md text-center">
									<p><a href="<?php echo $news_button_url ?>" class="news-button btn btn-primary" role="button"><?php echo $news_button_text ?></a></p>
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
