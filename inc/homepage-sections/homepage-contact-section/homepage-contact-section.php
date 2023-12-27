<?php
/**
 * Plugin Name: Homepage Contact Section
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

// Returns the main instance of Homepage_Contact_Section to prevent the need to use globals
function Homepage_Contact_Section() {
	return Homepage_Contact_Section::instance();
} 

Homepage_Contact_Section();

// Homepage_Contact_Section Class
final class Homepage_Contact_Section {
	
	// The single instance of Homepage_Contact_Section
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

		add_action( 'init', array( $this, 'homepage_contact_section_setup' ) );
	}

	// Homepage_Contact_Section Instance
	// Ensures only one instance of Homepage_Contact_Section is loaded or can be loaded
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
	public function homepage_contact_section_setup() {
		if ( get_theme_mod( 'display_contact' , true ) ) :
				add_action( 'wp_enqueue_scripts', array( $this, 'bootstrap_scripts' ), 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'homepage_contact_section_styles' ), 100 );
		endif;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'homepage_contact_section_customize_styles' ), 100 );
		add_action( 'customize_preview_init', array( $this, 'homepage_contact_section_customize_live_preview' ), 100 );
		add_action( 'customize_register', array( $this, 'homepage_contact_section_customize_register' ) );
		if ( get_theme_mod( 'display_contact' , true ) ) :
			add_action( 'homepage', array( $this, 'homepage_contact_section' ), 110 );
		endif;
	}
	
	// Customizer
	public function homepage_contact_section_customize_register( $wp_customize ) {
		
		// Contact
		$wp_customize->add_section( 'contact' , array(
			'title'				=> __( 'Contact', 'minisite-lite' ),
			'panel'				=> 'homepage',
			'priority'			=> 110
		) );

			// Display Contact
			$wp_customize->add_setting( 'display_contact', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact', array(
				'label'				=> __( 'Display Contact', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'contact',
			) );
			function display_contact_callback( $control ) {
				if ( $control->manager->get_setting( 'display_contact' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}					

			// Title
			$wp_customize->add_setting( 'display_contact_title', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'contact',
				'active_callback'	=> 'display_contact_callback',
			) );
			function display_contact_title_callback( $control ) {
				if ( $control->manager->get_setting( 'display_contact_title' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'contact_title', array(
				'default' 			=> __( 'Contact', 'minisite-lite' ), 
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'contact_title', array(
				'label'				=> __( 'Title', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'contact',
				'active_callback'   => function( $control ) {
					return ( display_contact_callback( $control ) && display_contact_title_callback( $control ) );
				 },
			) );
			$wp_customize->selective_refresh->add_partial( 'contact_title', array(
				'selector'			=> '.contact .contact-title'
			) );
			
			// Slug
			$wp_customize->add_setting( 'contact_slug', array(
				'default' 			=> __( 'contact', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'contact_slug', array(
				'label'				=> __( 'Slug', 'minisite-lite' ),
				'description'		=> __( '<strong>Permalink: </strong>', 'minisite-lite' ) . esc_html__( get_site_url() . '#', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'contact',
				'active_callback'   => function( $control ) {
					return ( display_contact_callback( $control ) && display_contact_title_callback( $control ) );
				 },
			) );

			// Text
			$wp_customize->add_setting( 'display_contact_text', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'contact',
				'active_callback'	=> 'display_contact_callback',
			) );
			function display_contact_text_callback( $control ) {
				if ( $control->manager->get_setting( 'display_contact_text' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'contact_text', array(
				'default'			=> __( '', 'minisite-lite' ), 
				'transport'			=> 'postMessage',
				'sanitize_callback'	=> 'wp_kses_post'
				)
			);
			$wp_customize->add_control( new Minisite_TinyMCE_Custom_control( $wp_customize, 'contact_text', array(
				'label'				=> __( 'Text', 'minisite-lite' ), 
				'section'			=> 'contact',
				'input_attrs'		=> array(
					'toolbar1'		=> 'bold italic bullist numlist alignleft aligncenter alignright link',
					'toolbar2'		=> 'formatselect outdent indent | blockquote charmap',
				),
				'active_callback'	=> function( $control ) {
					return ( display_contact_callback( $control ) && display_contact_text_callback( $control ) );
				},
			) ) );
			
			// Contact Form 
			$wp_customize->add_setting( 'display_contact_form', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact_form', array(
				'label'				=> __( 'Contact Form', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'contact',
				'active_callback'	=> 'display_contact_callback',
			) );
			function display_contact_form_callback( $control ) {
				if ( $control->manager->get_setting( 'display_contact_form' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'contact_form', array(
				'default'			=> __( 'Contact Form 7 shortcode', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );
			$wp_customize->add_control( 'contact_form', array(
				'label'				=> __( 'Contact Form 7 Shortcode', 'minisite-lite' ),
				'description'		=> '<ol><li><a href="' . admin_url('plugin-install.php?tab=plugin-information&plugin=contact-form-7&TB_iframe=true&width=772&height=716') . '" target="_blank">Install and activate Contact Form 7</a> plugin</li><li>Go to the <a href="' . admin_url('admin.php?page=wpcf7') . '" target="_blank">Contact Forms page</a></li><li>Copy form Shortcode and paste it below (Example: [contact-form-7 id="1234" title="Contact form 1"])</li><li>Click Save & Publish button above and refresh page to see Contact Form.</li></ol>',
				'type'				=> 'text',
				'section'			=> 'contact',
				'active_callback'   => function( $control ) {
					return ( display_contact_callback( $control ) && display_contact_form_callback( $control ) );
				 },
			) );
			
			// Contact Button
			$wp_customize->add_setting( 'display_contact_button', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact_button', array(
				'label'				=> __( 'Button', 'minisite-lite' ),
				'type'				=> 'checkbox',
				'section'			=> 'contact',
				'active_callback'   => 'display_contact_callback'
			) );
			function display_contact_button_callback( $control ) {
				if ( $control->manager->get_setting( 'display_contact_button' )->value() == true ) {
					return true;
				} else {
					return false;
				}
			}
			$wp_customize->add_setting( 'contact_button_text', array(
				'default'			=> __( 'Button', 'minisite-lite' ), 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'contact_button_text', array(
				'label'				=> __( 'Button Text', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'contact',
				'active_callback'   => function( $control ) {
					return ( display_contact_callback( $control ) && display_contact_button_callback( $control ) );
				}
			) );
			
			// Button URL
			$wp_customize->add_setting( 'contact_button_url', array(
				'default'			=> '#', 
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			) );	
			$wp_customize->add_control( 'contact_button_url', array(
				'label'				=> __( 'URL', 'minisite-lite' ),
				'type'				=> 'text',
				'section'			=> 'contact',
				'active_callback'   => function( $control ) {
					return ( display_contact_callback( $control ) && display_contact_button_callback( $control ) );
				}
			) );
			
			// Colors
			$wp_customize->add_setting( 'display_contact_colors', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact_colors', array(
				'label'				=> __( 'Colors', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Colors <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'contact',
				'active_callback'	=> 'display_contact_callback',
			) );
			
			// Background
			$wp_customize->add_setting( 'display_contact_background', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact_background', array(
				'label'				=> __( 'Background', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Background <a href="' . esc_url( __('https://www.getminisite-lites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'contact',
				'active_callback'	=> 'display_contact_callback',
			) );
		
			// Padding
			$wp_customize->add_setting( 'display_contact_padding', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact_padding', array(
				'label'				=> __( 'Padding', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Padding <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'contact',
				'active_callback'	=> 'display_contact_callback',
			) );
	
			// Animation
			$wp_customize->add_setting( 'display_contact_animation', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact_animation', array(
				'label'				=> __( 'Animation', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Animation <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'contact',
				'active_callback'	=> 'display_contact_callback',
			) );
			
			// Animation
			$wp_customize->add_setting( 'display_contact_widgets', array(
				'default'			=> '',
				'sanitize_callback' => 'homepage_contact_section_sanitize_checkbox'
			) );
			$wp_customize->add_control( 'display_contact_widgets', array(
				'label'				=> __( 'Widgets', 'minisite-lite' ),
				'description'		=> '<input type="checkbox" disabled> Widgets <a href="' . esc_url( __('https://www.getminisites.com/theme/', 'minisite-lite')) . '" class="customize-control-description-link" target="_blank">Pro</a>',
				'type'				=> 'checkbox',
				'section'			=> 'contact',
				'active_callback'	=> 'display_contact_callback',
			) );
			
		// Sanitize Checkbox
		function homepage_contact_section_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}

		// Sanitize File
		function homepage_contact_section_sanitize_file( $file, $setting ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png'
			);
			$file_ext = wp_check_filetype( $file, $mimes );
			return ( $file_ext['ext'] ? $file : $setting->default );
		}
		
		// Sanitize Number Range
		function homepage_contact_section_sanitize_number_range( $number, $setting ) {
			$atts = $setting->manager->get_control( $setting->id )->input_attrs;
			$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
			$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
			$step = ( isset( $atts['step'] ) ? $atts['step'] : 0.001 );
			$number = floor($number / $atts['step']) * $atts['step'];
			return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
		}

		// Sanitize Select
		function homepage_contact_section_sanitize_select( $input, $setting ){
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
	public function homepage_contact_section_styles() {
		wp_enqueue_style( 'homepage-contact-section-style', $this->plugin_url . 'css/style.css', array(), '' );
	}
	
	// Customizer styles
	public function homepage_contact_section_customize_styles() {
		wp_enqueue_style( 'homepage-contact-section-customize-style', $this->plugin_url . 'css/customizer.css' );
	}
		
	// Customizer live preview
	public function homepage_contact_section_customize_live_preview() {
		wp_enqueue_script( 'homepage-contact-section-customize-live-preview', $this->plugin_url . 'js/customizer.js', array(  'jquery', 'customize-preview' ), '', true );
	}

	// Homepage Contact Section
	public static function homepage_contact_section() {
		$display_contact					= get_theme_mod( 'display_contact' , '' );
		$display_contact_title				= get_theme_mod( 'display_contact_title' , '' );
		$contact_title						= get_theme_mod( 'contact_title' , __( 'Contact', 'minisite-lite' ) );
		$contact_slug						= get_theme_mod( 'contact_slug' , __( 'contact', 'minisite-lite' ) );
		$display_contact_text				= get_theme_mod( 'display_contact_text' , '' );
		$contact_text						= wpautop( get_theme_mod( 'contact_text' , __( '', 'minisite-lite' ) ) );
		$display_contact_form				= get_theme_mod( 'display_contact_form' , '' );
		$contact_form						= get_theme_mod( 'contact_form' , __( 'Contact Form 7 shortcode', 'minisite-lite' ) );
		$display_contact_button				= get_theme_mod( 'display_contact_button' , '' );
		$contact_button_url					= get_theme_mod( 'contact_button_url' , '#' );
		$contact_button_text				= get_theme_mod( 'contact_button_text' , __( 'Button', 'minisite-lite' ) );
	?>	
		<?php if ( $display_contact ) : ?>
			<section class="contact wrapper">
				<?php if ( $display_contact_title || $display_contact_text || $display_contact_form || is_active_sidebar( 'homepage-contact' ) || $display_contact_button ) : ?>	
					<div class="contact-container container">
						<?php if ( $display_contact_title || $display_contact_text ) : ?>
							<div class="contact-header row">
								<div class="col-lg-8 offset-lg-2 text-center">
									<?php if ( $display_contact_title ) : ?>
										<h2 id="<?php echo $contact_slug ?>" class="h1 contact-title">
											<?php echo $contact_title ?>
										</h2>
									<?php endif; ?>
									<?php if ( $display_contact_text ) : ?>
										<div class="contact-text lead">
											<?php echo $contact_text ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( $display_contact_form ) : ?>
							<div class="contact-content row">
								<div class="contact-form col-md-6 offset-md-3 text-center">
									<?php echo do_shortcode( stripslashes( $contact_form ) ); ?>
								</div>	
							</div>
						<?php endif; ?>
						<?php if ( $display_contact_button ) : ?>
							<div class="contact-footer row">
								<div class="col-md text-center">
									<p><a href="<?php echo $contact_button_url ?>" class="contact-button btn btn-primary" role="button"><?php echo $contact_button_text ?></a></p>
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
