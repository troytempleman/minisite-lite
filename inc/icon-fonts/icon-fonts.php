<?php
/**
 * Plugin Name: Icon Fonts
 * Plugin URI: https://getminisites.com/theme/
 * Description: Add over 1,500 icon fonts to your site from Font Awesome, packaged with IcoMoon.
 * Version: 1.0.0
 * Author: Troy Templeman
 * Author URI: https://troytempleman.com/
 * License: GNU General Public License v2 or later
 * License URI: LICENSE
 * Text Domain: icon-fonts
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Icon_Fonts to prevent the need to use globals.
function Icon_Fonts() {
	return Icon_Fonts::instance();
} 

Icon_Fonts();

// Icon_Fonts Class
final class Icon_Fonts {
	
	// The single instance of Icon_Fonts
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

		add_action( 'init', array( $this, 'icon_fonts_setup' ) );
		add_filter( 'widget_title', 'do_shortcode' );
	}

	// Icon_Fonts Instance
	// Ensures only one instance of Icon_Fonts is loaded or can be loaded.
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
	public function icon_fonts_setup() {
		if ( get_theme_mod( 'activate_icon_fonts' , '' ) ) :
			add_action( 'wp_enqueue_scripts', array( $this, 'icon_fonts_styles' ), 100 );
		endif;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'icon_fonts_customize_styles' ), 100 );
		add_action( 'customize_register', array( $this, 'icon_fonts_customize_register' ) );	
		//add_shortcode('i', array( $this, 'icon_fonts_shortcode') );
	}
				
	// Customizer
	public function icon_fonts_customize_register( $wp_customize ) {
		
		// Settings
		$wp_customize->add_panel( 'theme_settings', array(
			'title'				=> __( 'Settings', 'minisite-lite' ),
			'priority'			=> 1000
		) );
		
		// Icon Fonts
		$wp_customize->add_section( 'icon_fonts' , array(
			'title'				=> __( 'Icon Fonts', 'minisite-lite' ),
			'panel'				=> 'theme_settings',
			'priority'			=> 40
		) );
			
		if( function_exists( 'icon_fonts_callback' ) ) {
			$wp_customize->get_section( 'icon_fonts' )->active_callback = 'icon_fonts_callback';
		}
			
			// Activate Icon Fonts
			$wp_customize->add_setting( 'activate_icon_fonts', array(
				'default'			=> true,
				'sanitize_callback' => 'icon_fonts_sanitize_checkbox',	
			) );
			$wp_customize->add_control( 'activate_icon_fonts', array(
				'label'				=> __( 'Activate Icon Fonts', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'icon_fonts',
			) );
			function activate_icon_fonts_callback( $control ) {
				if ( $control->manager->get_setting( 'activate_icon_fonts' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			$wp_customize->add_setting( 'icon_fonts', array(
		    	'default'			=> '',
		   		'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );
			$wp_customize->add_control( new Minisite_Simple_Notice_Custom_control( $wp_customize, 'icon_fonts', array(
				'description'		=> '<a href="' . $this->plugin_url . 'icons/demo.html" target="_blank">Browse icons</a> and copy the code of the desired icon (Example: <strong>icon-heart</strong>). Add <strong>&lt;i class="icon-heart"&gt;&lt;/i&gt;</strong> as HTML where you would like the icon to appear (where <strong>icon-heart</strong> is the name of icon you chose.) <a href="' . admin_url( 'themes.php?page=upgrade' ) . '" target="_blank">Upgrade to PRO </a>to add icons anywhere as shortcodes.',
				'section'			=> 'icon_fonts',
				'active_callback'   => 'activate_icon_fonts_callback'
			) ) );	
		// Sanitize Checkbox
		function icon_fonts_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}
		
	}

	// Styles
	public function icon_fonts_styles() {
		wp_enqueue_style( 'icon-fonts-style', $this->plugin_url . 'icons/style.css', array(), '' );
	}	
	
	// Customizer styles
	public function icon_fonts_customize_styles() {
		wp_enqueue_style( 'icon-fonts-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
	
	// Shortcode [i class=icon-name]
	public function icon_fonts_shortcode( $atts ) { 
		extract( shortcode_atts ( array (
			'class'  => '',
		), $atts ) );        
		return '<i class="' . $atts['class'] . '"></i>';
	}

} // End Class
