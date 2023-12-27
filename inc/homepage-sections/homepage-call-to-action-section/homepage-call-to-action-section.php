<?php
/**
 * Plugin Name: Homepage Call to Action Section
 * Plugin URI: https://getminisites.com/theme/
 * Description: Encourage users to take a specific action to help create leads, drive conversions and increase return on investment.
 * Version: 1.0.0
 * Author: Troy Templeman
 * Author URI: https://troytempleman.com/
 * License: GNU General Public License v2 or later
 * License URI: LICENSE
 * Text Domain: homepage-call-to-action-section
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Returns the main instance of Homepage_Call_to_Action_Section to prevent the need to use globals
function Homepage_Call_to_Action_Section() {
	return Homepage_Call_to_Action_Section::instance();
} 

Homepage_Call_to_Action_Section();

// Homepage_Call_to_Action_Section Class
final class Homepage_Call_to_Action_Section {
	
	// The single instance of Homepage_Call_to_Action_Section
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

		add_action( 'init', array( $this, 'homepage_call_to_action_section_setup' ) );
	}

	// Homepage_Call_to_Action_Section Instance
	// Ensures only one instance of Homepage_Call_to_Action_Section is loaded or can be loaded
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
	public function homepage_call_to_action_section_setup() {
		if ( get_theme_mod( 'display_call_to_action' , true ) ) :
				add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_scripts' ), 1 );
		endif;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'homepage_call_to_action_section_customize_styles' ), 100 );
		add_action( 'customize_preview_init', array( $this, 'homepage_call_to_action_section_customize_live_preview' ), 100 );
		add_action( 'customize_register', array( $this, 'homepage_call_to_action_section_customize_register' ) );
		if ( get_theme_mod( 'display_call_to_action' , true ) ) :
			add_action( 'homepage', array( $this, 'homepage_call_to_action_section' ), 80 );
		endif;
	}

	// Customizer
	public function homepage_call_to_action_section_customize_register( $wp_customize ) {
		
		// Call to Action
		$wp_customize->add_section( 'call_to_action' , array(
			'title'				=> __( 'Call to Action', 'minisite-lite' ),
			'panel'				=> 'homepage',
			'priority' 			=> 80
		) );
			
			// Display Call to Action
			$wp_customize->add_setting( 'display_call_to_action', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action', array(
				'label'				=> __( 'Display Call to Action', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
			) );
			function display_call_to_action_callback( $control ) {
				if ( $control->manager->get_setting( 'display_call_to_action' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}

			// Title
			$wp_customize->add_setting( 'display_call_to_action_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
				'active_callback'	=> 'display_call_to_action_callback',
			) );
			function display_call_to_action_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_call_to_action_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'call_to_action_title', array(
				'default' 			=> __( 'Call to Action', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'call_to_action_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'call_to_action',
				'active_callback'   => function( $control ) {
					return ( display_call_to_action_callback( $control ) && display_call_to_action_title_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'call_to_action_title', array(
				'selector'			=> '.call-to-action .call-to-action-title'
			) );
			
			// Slug
			$wp_customize->add_setting( 'call_to_action_slug', array(
				'default' 			=> __( 'call-to-action', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'call_to_action_slug', array(
				'label'				=> __( 'Slug', 'minisite-lite' ),
				'description'		=> __( '<strong>Permalink: </strong>', 'minisite-lite' ) . esc_html__( get_site_url() . '#', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'call_to_action',
				'active_callback'   => function( $control ) {
					return ( display_call_to_action_callback( $control ) && display_call_to_action_title_callback( $control ) );
				 },
			) );			

			// Text
			$wp_customize->add_setting( 'display_call_to_action_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
				'active_callback'	=> 'display_call_to_action_callback',
			) );
			function display_call_to_action_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_call_to_action_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'call_to_action_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'call_to_action_text', array( 
				'label' 			=> __( 'Text', 'minisite-lite' ), 
				'section' 			=> 'call_to_action',
				'input_attrs' 		=> array(
				'toolbar1' 			=> 'bold italic bullist numlist alignleft aligncenter alignright link',
				'toolbar2' 			=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'   => function( $control ) {
					return ( display_call_to_action_callback( $control ) && display_call_to_action_text_callback( $control ) );
				},
			) ) );
			
			// Call to Action Button 1
			$wp_customize->add_setting( 'display_call_to_action_button_1', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action_button_1', array(
				'label'				=> __( 'Button 1', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
				'active_callback'   => 'display_call_to_action_callback'
			) );
			function display_call_to_action_button_1_callback( $control ) {
				if ( $control->manager->get_setting( 'display_call_to_action_button_1' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'call_to_action_button_1_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'call_to_action_button_1_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'call_to_action',
				'active_callback'   => function( $control ) {
					return ( display_call_to_action_callback( $control ) && display_call_to_action_button_1_callback( $control ) );
				}
			) );
			
			// Button URL
			$wp_customize->add_setting( 'call_to_action_button_1_url', array(
				'default'			=> '#',  
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'call_to_action_button_1_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'call_to_action',
				'active_callback'   => function( $control ) {
					return ( display_call_to_action_callback( $control ) && display_call_to_action_button_1_callback( $control ) );
				}
			) );
			
			// Call to Action Button 2
			$wp_customize->add_setting( 'display_call_to_action_button_2', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action_button_2', array(
				'label'				=> __( 'Button 2', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
				'active_callback'   => 'display_call_to_action_callback'
			) );
			function display_call_to_action_button_2_callback( $control ) {
				if ( $control->manager->get_setting( 'display_call_to_action_button_2' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'call_to_action_button_2_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'call_to_action_button_2_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'call_to_action',
				'active_callback'   => function( $control ) {
					return ( display_call_to_action_callback( $control ) && display_call_to_action_button_2_callback( $control ) );
				}
			) );
			
			// Button URL
			$wp_customize->add_setting( 'call_to_action_button_2_url', array(
				'default'			=> '#',  
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'call_to_action_button_2_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'call_to_action',
				'active_callback'   => function( $control ) {
					return ( display_call_to_action_callback( $control ) && display_call_to_action_button_2_callback( $control ) );
				}
			) );
			
			// Colors
			$wp_customize->add_setting( 'display_call_to_action_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action_colors', array(
				'label'				=> __( 'Colors', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Colors <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
				'active_callback'	=> 'display_call_to_action_callback',
			) );
			
			// Background
			$wp_customize->add_setting( 'display_call_to_action_background', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action_background', array(
				'label'				=> __( 'Background', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Background <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
				'active_callback'	=> 'display_call_to_action_callback',
			) );
		
			// Padding
			$wp_customize->add_setting( 'display_call_to_action_padding', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action_padding', array(
				'label'				=> __( 'Padding', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Padding <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
				'active_callback'	=> 'display_call_to_action_callback',
			) );
	
			// Animation
			$wp_customize->add_setting( 'display_call_to_action_animation', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action_animation', array(
				'label'				=> __( 'Animation', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Animation <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
				'active_callback'	=> 'display_call_to_action_callback',
			) );
			
			// Animation
			$wp_customize->add_setting( 'display_call_to_action_widgets', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_call_to_action_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_call_to_action_widgets', array(
				'label'				=> __( 'Widgets', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Widgets <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'call_to_action',
				'active_callback'	=> 'display_call_to_action_callback',
			) );
			
		// Sanitize Checkbox
		function homepage_call_to_action_section_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}

		// Sanitize File
		function homepage_call_to_action_section_sanitize_file( $file, $setting ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png'
			);
			$file_ext = wp_check_filetype( $file, $mimes );
			return ( $file_ext['ext'] ? $file : $setting->default );
		}

		// Sanitize Number Range
		function homepage_call_to_action_section_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 0.001 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}

		// Sanitize Select
		function homepage_call_to_action_section_sanitize_select( $input, $setting ){
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
	public function homepage_call_to_action_section_customize_styles() {
		wp_enqueue_style( 'homepage-call-to-action-section-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
		
	// Customizer live preview
	public function homepage_call_to_action_section_customize_live_preview() {
		wp_enqueue_script( 'homepage-call-to-action-section-customize-live-preview', $this->plugin_url . 'js/customizer.js', array(  'jquery', 'customize-preview' ), '', true );
	}

	// Homepage Call to Action Section
	public static function homepage_call_to_action_section() {
		$display_call_to_action						= get_theme_mod( 'display_call_to_action' , '' );
		$display_call_to_action_title				= get_theme_mod( 'display_call_to_action_title' , '' );
		$call_to_action_title						= get_theme_mod( 'call_to_action_title' , __( 'Call to Action', 'minisite-lite' ) );
		$call_to_action_slug						= get_theme_mod( 'call_to_action_slug' , __( 'call-to-action', 'minisite-lite' ) );
		$display_call_to_action_text				= get_theme_mod( 'display_call_to_action_text' , '' );
		$call_to_action_text						= wpautop( get_theme_mod( 'call_to_action_text' , __( '', 'minisite-lite' ) ) );
		$display_call_to_action_button_1			= get_theme_mod( 'display_call_to_action_button_1' , '' );
		$call_to_action_button_1_url				= get_theme_mod( 'call_to_action_button_1_url' , '#' );
		$call_to_action_button_1_text				= get_theme_mod( 'call_to_action_button_1_text' , __( 'Button', 'minisite-lite' ) );
		$display_call_to_action_button_2			= get_theme_mod( 'display_call_to_action_button_2' , '' );
		$call_to_action_button_2_url				= get_theme_mod( 'call_to_action_button_2_url' , '#' );
		$call_to_action_button_2_text				= get_theme_mod( 'call_to_action_button_2_text' , __( 'Button', 'minisite-lite' ) );	
	?>	
		<?php if ( $display_call_to_action ) : ?>
			<section class="call-to-action wrapper">
				<?php if ( $display_call_to_action_title || $display_call_to_action_text || $display_call_to_action_button_1 || is_active_sidebar( 'homepage-call-to-action' ) || $display_call_to_action_button_1 ) : ?>	
					<div class="call-to-action-container container">
						<?php if ( $display_call_to_action_title || $display_call_to_action_text ) : ?>
							<div class="call-to-action-header row">
						    	<?php if ( $display_call_to_action_title || $display_call_to_action_text ) : ?>
							    	<div class="call-to-action-block-1 call-to-action-block col-md-9 text-center text-md-left">
										<?php if ( $display_call_to_action_title ) : ?>
											<h2 id="<?php echo $call_to_action_slug ?>" class="h1 call-to-action-title">
												<?php echo $call_to_action_title ?>
											</h2>
										<?php endif; ?>
										<?php if ( $display_call_to_action_text ) : ?>
											<div class="call-to-action-text lead">
												<?php echo $call_to_action_text ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php if ( $display_call_to_action_button_1 ) : ?>
							    	<div class="call-to-action-block-2 call-to-action-block col-md-3 text-center text-md-right">
										<div class="call-to-action-block-text">
											<p><a href="<?php echo $call_to_action_button_1_url ?>" class="call-to-action-button-1 btn btn-primary btn-lg" role="button"><?php echo $call_to_action_button_1_text ?></a></p>
										</div>
									</div>
								<?php endif; ?>
					    	</div>
						<?php endif; ?>
						<?php if ( $display_call_to_action_button_2 ) : ?>
							<div class="call-to-action-footer row">
								<div class="col-md text-center">
									<p><a href="<?php echo $call_to_action_button_2_url ?>" class="call-to-action-button-2 btn btn-primary" role="button"><?php echo $call_to_action_button_2_text ?></a></p>
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
