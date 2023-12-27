<?php
/**
 * Plugin Name: Homepage Map Section
 * Plugin URI: https://getminisites.com/theme/
 * Description: Quickly pin point your location on a map, providing satellite and street imagery with turn by turn directions to your door.
 * Version: 1.0.0
 * Author: Troy Templeman
 * Author URI: https://troytempleman.com/
 * License: GNU General Public License v2 or later
 * License URI: LICENSE
 * Text Domain: homepage-map-section
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Homepage_Map_Section to prevent the need to use globals
function Homepage_Map_Section() {
	return Homepage_Map_Section::instance();
} 

Homepage_Map_Section();

// Homepage_Map_Section Class
final class Homepage_Map_Section {
	
	// The single instance of Homepage_Map_Section
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

		add_action( 'init', array( $this, 'homepage_map_section_setup' ) );
	}

	// Homepage_Map_Section Instance
	// Ensures only one instance of Homepage_Map_Section is loaded or can be loaded
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
	public function homepage_map_section_setup() {
		if ( get_theme_mod( 'display_map' , true ) ) :
			add_action( 'wp_enqueue_scripts', array( $this, 'homepage_map_section_styles' ), 100 );
		endif;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'homepage_map_section_customize_styles' ), 100 );
		add_action( 'customize_register', array( $this, 'homepage_map_section_customize_register' ) );
		if ( get_theme_mod( 'display_map' , true ) ) :
			add_action( 'homepage', array( $this, 'homepage_map_section' ), 140 );
		endif;
	}

	// Customizer
	public function homepage_map_section_customize_register( $wp_customize ) {
		
		// Map
		$wp_customize->add_section( 'map' , array(
			'title'				=> __( 'Map', 'minisite-lite' ),
			'description'		=> __( 'To change the location of the marker on the map, edit the information below, click <Strong>Publish</strong> and refresh the page to see the new location.', 'minisite-lite' ),
			'panel'				=> 'homepage',
			'priority'			=> 140
		) );

			// Display Map
			$wp_customize->add_setting( 'display_map', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_map_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_map', array(
				'label'				=> __( 'Display Map', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'map',
			) );
			function display_map_callback( $control ) {
				if ( $control->manager->get_setting( 'display_map' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Title
			$wp_customize->add_setting( 'map_title', array(
				'default' 			=> __( 'Cabot Tower', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'map_title', array(
				'label'				=> __( 'Map Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'map',
				'active_callback'	=> 'display_map_callback',
			) );
			
			// Address
			$wp_customize->add_setting( 'map_address', array(
				'default' 			=> __( '250 Signal Hill Road', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'map_address', array(
				'label'				=> __( 'Address', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'map',
				'active_callback'	=> 'display_map_callback',
			) );
			
			// City / Town
			$wp_customize->add_setting( 'map_city_town', array(
				'default' 			=> __( 'St. Johns', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'map_city_town', array(
				'label'				=> __( 'City / Town', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'map',
				'active_callback'	=> 'display_map_callback',
			) );
			
			// State / Province
			$wp_customize->add_setting( 'map_state_province', array(
				'default' 			=> __( 'NL', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'map_state_province', array(
				'label'				=> __( 'State / Province', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'map',
				'active_callback'	=> 'display_map_callback',
			) );
			
			// Country
			$wp_customize->add_setting( 'map_country', array(
				'default' 			=> __( 'Canada', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'map_country', array(
				'label'				=> __( 'Country', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'map',
				'active_callback'	=> 'display_map_callback',
			) );
			
			// Zip / Postal Code
			$wp_customize->add_setting( 'map_zip_postal_code', array(
				'default' 			=> __( 'A1A 1B2', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'map_zip_postal_code', array(
				'label'				=> __( 'Zip / Postal Code', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'map',
				'active_callback'	=> 'display_map_callback',
			) );
			
			// Zoom Level
			$wp_customize->add_setting( 'map_zoom_level' , array(
				'default'        	=> '14',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'homepage_map_section_sanitize_number_range'
			) );
			$wp_customize->add_control( 'map_zoom_level', array(
				'label'   			=> __( 'Zoom Level', 'minisite-lite' ),
				'type'        		=> 'range',
				'input_attrs' 		=> array(
					'min'   		=> 1,
					'max'   		=> 20,
					'step'  		=> 1
				),
				'section'			=> 'map',
				'active_callback'	=> 'display_map_callback',
			) );
			
		// Sanitize Checkbox
		function homepage_map_section_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}
		
		// Sanitize Number Range
		function homepage_map_section_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}
		
	}

	// Styles
	public function homepage_map_section_styles() {
		wp_enqueue_style( 'homepage-map-section-style', $this->plugin_url . 'css/style.css', array(), '' );
	}
	
	// Customizer styles
	public function homepage_map_section_customize_styles() {
		wp_enqueue_style( 'homepage-map-section-customize-style', $this->plugin_url . 'css/customizer.css' );
	}


	// Homepage Map Section
	public static function homepage_map_section() {
		$display_map					= get_theme_mod( 'display_map' , '' );
		$map_address					= get_theme_mod( 'map_address' , __( '250 Signal Hill Road', 'minisite-lite' ) );
		$map_city_town					= get_theme_mod( 'map_city_town' , __( 'St. John&#8217;s', 'minisite-lite' ) );
		$map_state_province				= get_theme_mod( 'map_state_province' , __( 'NL', 'minisite-lite' ) );
		$map_country					= get_theme_mod( 'map_country' , __( 'Canada', 'minisite-lite' ) );
		$map_zip_postal_code			= get_theme_mod( 'map_zip_postal_code' , __( 'A1A 1B2', 'minisite-lite' ) );
		$map_title						= get_theme_mod( 'map_title' , __( 'Cabot Tower', 'minisite-lite' ) );
		$map_zoom_level					= get_theme_mod( 'map_zoom_level' , __( '14', 'minisite-lite' ) );
	?>
		<?php if ( $display_map ) : ?>
			<section class="map wrapper">
				<div class="map-overlay" onClick="style.pointerEvents='none'"></div><iframe width="100%" height="400" src="https://maps.google.com/maps?width=100%&amp;height=400&amp;hl=en&amp;q=<?php echo rawurlencode( $map_address ); ?>%2C%20<?php echo rawurlencode( $map_city_town ); ?>%20<?php echo rawurlencode( $map_state_province ); ?>%2C%20<?php echo rawurlencode( $map_country ); ?>%20<?php echo rawurlencode( $map_zip_postal_code ); ?>+(<?php echo rawurlencode( $map_title ); ?>)&amp;ie=UTF8&amp;t=&amp;z=<?php echo rawurlencode( $map_zoom_level ); ?>&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>	
			</section>
		<?php endif; ?>	
	<?php
	}
} // End Class
