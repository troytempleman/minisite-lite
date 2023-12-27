<?php
/**
 * Plugin Name: Homepage About Section
 * Plugin URI: https://getminisites.com/theme/
 * Description: Let users know who you are, what you do and how you can help them with introductory text and picture or video.
 * Version: 1.0.0
 * Author: Troy Templeman
 * Author URI: https://troytempleman.com/
 * License: GNU General Public License v2 or later
 * License URI: LICENSE
 * Text Domain: homepage-about-section
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Homepage_About_Section to prevent the need to use globals
function Homepage_About_Section() {
	return Homepage_About_Section::instance();
} 

Homepage_About_Section();

// Homepage_About_Section Class
final class Homepage_About_Section {
	
	// The single instance of Homepage_About_Section
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

		add_action( 'init', array( $this, 'homepage_about_section_setup' ) );
	}

	// Homepage_About_Section Instance
	// Ensures only one instance of Homepage_About_Section is loaded or can be loaded
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
	public function homepage_about_section_setup() {
		if ( get_theme_mod( 'display_about' , true ) ) :
				add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_scripts' ), 1 );
		endif;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'homepage_about_section_customize_styles' ), 100 );
		add_action( 'customize_preview_init', array( $this, 'homepage_about_section_customize_live_preview' ), 100 );
		add_action( 'customize_register', array( $this, 'homepage_about_section_customize_register' ) );
		if ( get_theme_mod( 'display_about' , true ) ) :
			add_action( 'homepage', array( $this, 'homepage_about_section' ), 10 );
		endif;
	}

	// Customizer
	public function homepage_about_section_customize_register( $wp_customize ) {
		
		// About
		$wp_customize->add_section( 'about' , array(
			'title'				=> __( 'About', 'minisite-lite' ),
			'panel'				=> 'homepage',
			'priority' 			=> 10
		) );

			// Display About
			$wp_customize->add_setting( 'display_about', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about', array(
				'label'				=> __( 'Display About', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'about',
			) );
			function display_about_callback( $control ) {
				if ( $control->manager->get_setting( 'display_about' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Title
			$wp_customize->add_setting( 'display_about_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'	=> 'display_about_callback',				
			) );
			function display_about_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_about_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'about_title', array(
				'default' 			=> __( 'About', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'about_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'about',
				'active_callback'   => function( $control ) {
					return ( display_about_callback( $control ) && display_about_title_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'about_title', array(
				'selector'			=> '.about .about-title'
			) );
			
			// Slug
			$wp_customize->add_setting( 'about_slug', array(
				'default' 			=> __( 'about', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'about_slug', array(
				'label'				=> __( 'Slug', 'minisite-lite' ),
				'description'		=> __( '<strong>Permalink: </strong>', 'minisite-lite' ) . esc_html__( get_site_url() . '#', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'about',
				'active_callback'   => function( $control ) {
					return ( display_about_callback( $control ) && display_about_title_callback( $control ) );
				 },
			) );
				
			// Text
			$wp_customize->add_setting( 'display_about_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'	=> 'display_about_callback',
			) );
			function display_about_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_about_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'about_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'about_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'about',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_about_callback( $control ) && display_about_text_callback( $control ) );
				},
			) ) );
			
			// About 1
			$wp_customize->add_setting( 'display_about_block_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_block_1', array(
				'label'				=> __( 'About 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'	=> 'display_about_callback',
			) );
			function display_about_block_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_about_block_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'about_block_1_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'about_block_1_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'about',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_about_callback( $control ) && display_about_block_1_callback( $control ) );
				},
			) ) );
			
			// Button
			$wp_customize->add_setting( 'display_about_block_1_button', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_block_1_button', array(
				'label'				=> __( 'Button', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'   => function( $control ) {
					return ( display_about_callback( $control ) && display_about_block_1_callback( $control ) );
				 },
			) );
			function display_about_block_1_button_callback( $control ) {
				if ( $control->manager->get_setting( 'display_about_block_1_button' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'about_block_1_button_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'about_block_1_button_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'about',
				'active_callback'   => function( $control ) {
					return ( display_about_callback( $control ) && display_about_block_1_callback( $control ) && display_about_block_1_button_callback( $control ) );
				}
			) );
			
			// Button URL
			$wp_customize->add_setting( 'about_block_1_button_url', array(
				'default'			=> '#', 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'about_block_1_button_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'about',
				'active_callback'   => function( $control ) {
					return ( display_about_callback( $control ) && display_about_block_1_callback( $control ) && display_about_block_1_button_callback( $control ) );
				}
			) );
			
			// About 2
			$wp_customize->add_setting( 'display_about_block_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_block_2', array(
				'label'				=> __( 'About 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'	=> 'display_about_callback',
			) );
			function display_about_block_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_about_block_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Display
			$wp_customize->add_setting( 'about_2_displays', array( 
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'about_2_displays', array(
				'label'      		=> __( 'Block 2', 'minisite-lite' ),
				'section'    		=> 'about',
				'type'       		=> 'radio',
				'choices'   		=> array(
					'display_about_2_image' 	=> 'Image',
					'display_about_2_video' 	=> 'Video'
				),
				'active_callback'   => function( $control ) {
					return ( display_about_callback( $control ) && display_about_block_2_callback( $control ) );
				}
			) );
			function display_about_2_image_callback( $control ) {
				if ( $control->manager->get_setting( 'about_2_displays' )->value() == 'display_about_2_image' ) {
					return true;
				} else {
					return false;
				}
			}
			function display_about_2_video_callback( $control ) {
				if ( $control->manager->get_setting( 'about_2_displays' )->value() == 'display_about_2_video' ) {
					return true;
				} else {
					return false;
				}
			}

			// Image
			$wp_customize->add_setting( 'about_block_2_image', array(
				'default'			=> '',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_about_section_sanitize_file'	
			) );  	
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'about_block_2_image', array(
				'label'				=> __( 'Image', 'minisite-lite' ),
				'settings'			=> 'about_block_2_image',
				'section'			=> 'about',
				'active_callback'	=> function( $control ) {
					return ( display_about_callback( $control ) && display_about_block_2_callback( $control ) && display_about_2_image_callback( $control ) );
				}	
			) ) );
			
			// Video
			$wp_customize->add_setting( 'about_block_2_video', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_kses_post'
			) );	
			$wp_customize->add_control( 'about_block_2_video', array(
				'label'				=> __( 'YouTube Embed Code', 'minisite-lite' ),
				'description'		=> '<ol><li>On the <a href="' . esc_url( __('http://www.youtube.com/', 'minisite-lite')) . '" target="_blank">YouTube</a> video page, click the <strong>Share</strong> link</li><li>Click on <strong>Embed</strong></li><li>Copy the <strongEmbed</strong> code and paste it below</li></ol>',
				'type'				=> 'text',
				'section'			=> 'about',
				'active_callback'	=> function( $control ) {
					return ( display_about_callback( $control ) && display_about_block_2_callback( $control ) && display_about_2_video_callback( $control ) );
				}
			) );
					
			// About Button
			$wp_customize->add_setting( 'display_about_button', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_button', array(
				'label'				=> __( 'Button', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'   => 'display_about_callback'
			) );
			function display_about_button_callback( $control ) {
				if ( $control->manager->get_setting( 'display_about_button' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'about_button_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'about_button_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'about',
				'active_callback'   => function( $control ) {
					return ( display_about_callback( $control ) && display_about_button_callback( $control ) );
				}
			) );
			
			// Button URL
			$wp_customize->add_setting( 'about_button_url', array(
				'default'			=> '#', 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'about_button_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'about',
				'active_callback'   => function( $control ) {
					return ( display_about_callback( $control ) && display_about_button_callback( $control ) );
				}
			) );
			
			// Colors
			$wp_customize->add_setting( 'display_about_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_colors', array(
				'label'				=> __( 'Colors', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Colors <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'	=> 'display_about_callback',
			) );
			
			// Background
			$wp_customize->add_setting( 'display_about_background', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_background', array(
				'label'				=> __( 'Background', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Background <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'	=> 'display_about_callback',
			) );
		
			// Padding
			$wp_customize->add_setting( 'display_about_padding', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_padding', array(
				'label'				=> __( 'Padding', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Padding <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'	=> 'display_about_callback',
			) );
	
			// Animation
			$wp_customize->add_setting( 'display_about_animation', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_animation', array(
				'label'				=> __( 'Animation', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Animation <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'	=> 'display_about_callback',
			) );
			
			// Widgets
			$wp_customize->add_setting( 'display_about_widgets', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_about_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_about_widgets', array(
				'label'				=> __( 'Widgets', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Widgets <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'about',
				'active_callback'	=> 'display_about_callback',
			) );
	
		// Sanitize Checkbox
		function homepage_about_section_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}

		// Sanitize File
		function homepage_about_section_sanitize_file( $file, $setting ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png'
			);
			$file_ext = wp_check_filetype( $file, $mimes );
			return ( $file_ext['ext'] ? $file : $setting->default );
		}
		
		// Sanitize Number Range
		function homepage_about_section_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 0.001 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}
		
		// Sanitize Select
		function homepage_about_section_sanitize_select( $input, $setting ){
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
	
	// Customizer styles
	public function homepage_about_section_customize_styles() {
		wp_enqueue_style( 'homepage-about-section-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
		
	// Customizer live preview
	public function homepage_about_section_customize_live_preview() {
		wp_enqueue_script( 'homepage-about-section-customize-live-preview', $this->plugin_url . 'js/customizer.js', array(  'jquery', 'customize-preview' ), '', true );
	}

	// Homepage About Section
	public static function homepage_about_section() {
		$display_about						= get_theme_mod( 'display_about' , '' );
		$display_about_title				= get_theme_mod( 'display_about_title' , '' );
		$about_title						= get_theme_mod( 'about_title' , __( 'About', 'minisite-lite' ) );
		$about_slug							= get_theme_mod( 'about_slug' , __( 'about', 'minisite-lite' ) );
		$display_about_text					= get_theme_mod( 'display_about_text' , '' );
		$about_text							= wpautop( get_theme_mod( 'about_text' , __( '', 'minisite-lite' ) ) );
		$display_about_block_1				= get_theme_mod( 'display_about_block_1' , '' );
		$about_block_1_text					= wpautop( get_theme_mod( 'about_block_1_text' , __( '', 'minisite-lite' ) ) );
		$display_about_block_1_button		= get_theme_mod( 'display_about_block_1_button' , '' );
		$about_block_1_button_url			= get_theme_mod( 'about_block_1_button_url' , '#' );
		$about_block_1_button_text			= get_theme_mod( 'about_block_1_button_text' , __( 'Button', 'minisite-lite' ) );
		$display_about_block_2				= get_theme_mod( 'display_about_block_2' , '' );
		$about_2_displays					= get_theme_mod( 'about_2_displays' , '' );
		$about_block_2_image				= get_theme_mod( 'about_block_2_image' , '' );
		$about_block_2_video				= get_theme_mod( 'about_block_2_video' , __( '', 'minisite-lite' ) );
		$display_about_button				= get_theme_mod( 'display_about_button' , '' );
		$about_button_url					= get_theme_mod( 'about_button_url' , '#' );
		$about_button_text					= get_theme_mod( 'about_button_text' , __( 'Button', 'minisite-lite' ) );
	?>	
		<?php if ( $display_about ) : ?>
			<section class="about wrapper">
				<?php if ( $display_about_title || $display_about_text || $display_about_block_1 || $display_about_block_2 || is_active_sidebar( 'homepage-about' ) || $display_about_button ) : ?>	
					<div class="about-container container">
						<?php if ( $display_about_title || $display_about_text ) : ?>
							<div class="about-header row">
								<div class="col-lg-8 offset-lg-2 text-center">
									<?php if ( $display_about_title ) : ?>
										<h2 id="<?php echo $about_slug ?>" class="h1 about-title">
											<?php echo $about_title ?>
										</h2>
									<?php endif; ?>
									<?php if ( $display_about_text ) : ?>
										<div class="about-text lead">
											<?php echo $about_text ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( $display_about_block_1 || $display_about_block_2 ) : ?>
							<div class="about-content row">
								<?php if ( $display_about_block_1 ) : ?>
							    	<div class="about-block-1 about-block col-md">
										<div class="about-block-text">
											<?php echo $about_block_1_text ?>
										</div>
										<?php if ( $display_about_block_1_button ) : ?>
											<p><a href="<?php echo $about_block_1_button_url ?>" class="about-block-button btn btn-primary" role="button"><?php echo $about_block_1_button_text ?></a></p>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php if ( $display_about_block_2 ) : ?>
									<div class="about-block-2 about-block col-md">
										<?php if ( $about_2_displays == 'display_about_2_image' ) : ?>
											<div class="about-block-image">
												<img src="<?php echo $about_block_2_image ?>">
											</div>
										<?php endif; ?>
										<?php if ( $about_2_displays == 'display_about_2_video' ) : ?>
											<div class="about-block-video">
												<?php echo $about_block_2_video ?>
											</div>		
										<?php endif; ?>
									</div>
								<?php endif; ?>	
							</div>
						<?php endif; ?>
						<?php if ( $display_about_button ) : ?>
							<div class="about-footer row">
								<div class="col-md text-center">
									<p><a href="<?php echo $about_button_url ?>" class="about-button btn btn-primary" role="button"><?php echo $about_button_text ?></a></p>
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
