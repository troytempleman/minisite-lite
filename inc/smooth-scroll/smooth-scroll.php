<?php
/**
 * Smooth Scroll
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Smooth_Scroll to prevent the need to use globals.
function Smooth_Scroll() {
	return Smooth_Scroll::instance();
} 

Smooth_Scroll();

// Smooth_Scroll Class
final class Smooth_Scroll {
	
	// The single instance of Smooth_Scroll
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

		add_action( 'init', array( $this, 'smooth_scroll_setup' ) );
	}

	// Smooth_Scroll Instance
	// Ensures only one instance of Smooth_Scroll is loaded or can be loaded.
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
	public function smooth_scroll_setup() {
		//add_action( 'wp_enqueue_scripts', array( $this, 'smooth_scroll_scripts' ), 1 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'smooth_scroll_customize_styles' ), 100 );
		add_action( 'customize_preview_init', array( $this, 'smooth_scroll_customize_live_preview' ), 100 );
		add_action( 'customize_register', array( $this, 'smooth_scroll_customize_register' ) );
		if ( get_theme_mod( 'activate_smooth_scroll' , true ) ) :
			add_action( 'wp_footer', array( $this, 'smooth_scroll' ), 100 );
		endif;
	}
						
	// Customizer
	public function smooth_scroll_customize_register( $wp_customize ) {
		
		// Settings
		$wp_customize->add_panel( 'theme_settings', array(
			'title'				=> __( 'Settings', 'minisite-lite' ),
			'priority'			=> 1000
		) );
		
		// Smooth Scroll
		$wp_customize->add_section( 'smooth_scroll' , array(
			'title'				=> __( 'Smooth Scroll', 'minisite-lite' ),
			'panel'				=> 'theme_settings',
			'priority'			=> 70
		) );
			
		if( function_exists( 'smooth_scroll_callback' ) ) {
			$wp_customize->get_section( 'smooth_scroll' )->active_callback = 'smooth_scroll_callback';
		}
			
			// Activate Smooth Scroll
			$wp_customize->add_setting( 'activate_smooth_scroll', array(
				'default'			=> true,
				'sanitize_callback' => 'smooth_scroll_sanitize_checkbox',	
			) );
			$wp_customize->add_control( 'activate_smooth_scroll', array(
				'label'				=> __( 'Activate Smooth Scroll', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'smooth_scroll',
			) );
			function activate_smooth_scroll_callback( $control ) {
				if ( $control->manager->get_setting( 'activate_smooth_scroll' )->value() ) {
					return true;
				} else {
					return false;
				}
			}
			
			// Offset
			$wp_customize->add_setting( 'smooth_scroll_offset', array(
				'default' 			=> __( '0', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'smooth_scroll_offset', array(
				'label'				=> __( 'Offset (pixels)', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'smooth_scroll',
				'active_callback'   => 'activate_smooth_scroll_callback'
			) );
				
			// Scroll Speed
			$wp_customize->add_setting( 'smooth_scroll_speed', array(
				'default' 			=> __( '500', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'smooth_scroll_speed', array(
				'label'				=> __( 'Scroll Speed (ms)', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'smooth_scroll',
				'active_callback'   => 'activate_smooth_scroll_callback'
			) );
	
		// Sanitize Checkbox
		function smooth_scroll_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}

		// Sanitize Select
		function smooth_scroll_sanitize_select( $input, $setting ){
			$input = sanitize_key($input);
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                  
		}
	
	}
	
	// Scripts
	// public function smooth_scroll_scripts() {
		// wp_enqueue_script( 'smooth-scroll-js', $this->plugin_url . 'js/smooth-scroll.js', array(), '16.1.0', true );
	//}
	
	// Customizer styles
	public function smooth_scroll_customize_styles() {
		wp_enqueue_style( 'smooth-scroll-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
		
	// Customizer live preview
	public function smooth_scroll_customize_live_preview() {
		wp_enqueue_script( 'smooth-scroll-customize-live-preview', $this->plugin_url . 'js/customizer.js', array(  'jquery', 'customize-preview' ), '', true );
	}

	// Smooth Scroll
	public function smooth_scroll() {
		$activate_smooth_scroll					= get_theme_mod( 'activate_smooth_scroll' , true );
		$smooth_scroll_offset					= get_theme_mod( 'smooth_scroll_offset' , __( '0', 'minisite-lite' ) );
		$smooth_scroll_speed					= get_theme_mod( 'smooth_scroll_speed' , __( '500', 'minisite-lite' ) );
	?>	
		<?php if ( $activate_smooth_scroll ) : ?>
			<script type='text/javascript' src='<?php echo $this->plugin_url . 'js/smooth-scroll.js' ?>'></script>
			<script>
				var scroll = new SmoothScroll('a[href*="#"]:not([data-toggle="modal"]):not([data-toggle="lightbox"]):not([data-toggle="tab"]):not([data-toggle="collapse"]):not([data-slide="prev"]):not([data-slide="next"])', {
					// Selectors
					// ignore: '[data-scroll-ignore]', // Selector for links to ignore (must be a valid CSS selector)
					// header: null, // Selector for fixed headers (must be a valid CSS selector)
					// topOnEmptyHash: true, // Scroll to the top of the page for links with href="#"

					// Speed & Duration
					speed: <?php echo $smooth_scroll_speed ?>, // Integer. Amount of time in milliseconds it should take to scroll 1000px
					// speedAsDuration: false, // If true, use speed as the total duration of the scroll animation
					// durationMax: null, // Integer. The maximum amount of time the scroll animation should take
					// durationMin: null, // Integer. The minimum amount of time the scroll animation should take
					// clip: true, // If true, adjust scroll distance to prevent abrupt stops near the bottom of the page
					offset: <?php echo $smooth_scroll_offset ?>,

					// Easing
					easing: 'easeInOutCubic', // Easing pattern to use
					// customEasing: function (time) {

						// Function. Custom easing pattern
						// If this is set to anything other than null, will override the easing option above

						// return <your formulate with time as a multiplier>

						// Example: easeInOut Quad
						// return time < 0.5 ? 2 * time * time : -1 + (4 - 2 * time) * time;

					// },

					// History
					updateURL: true, // Update the URL on scroll
					// popstate: true, // Animate scrolling with the forward/backward browser buttons (requires updateURL to be true)

					// Custom Events
					// emitEvents: true // Emit custom events
				});
			</script>
		<?php endif; ?>
	<?php
	}
} // End Class
