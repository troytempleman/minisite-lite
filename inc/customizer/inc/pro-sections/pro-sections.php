<?php

// Singleton class for handling the theme's customizer integration.
final class Minisite_Pro_Customize {

	// Returns the instance.
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	// Constructor method.
	private function __construct() {}

	// Sets up initial actions.
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	// Sets up the customizer sections.
	public function sections( $manager ) {

		// Load custom sections.
		require trailingslashit( get_template_directory() ) . 'inc/customizer/inc/pro-sections/pro-section.php' ;

		// Register custom section types.
		$manager->register_section_type( 'Minisite_Pro_Section' );

		// Register sections.
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'minisite_pro',
				array(
					'title'   	=> esc_html__( 'Minisite', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'priority'	=> 2000
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'gallery',
				array(
					'title'   	=> esc_html__( 'Gallery', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'homepage',
					'priority'	=> 50
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'testimonials',
				array(
					'title'   	=> esc_html__( 'Testimonials', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'homepage',
					'priority'	=> 60
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'pricing',
				array(
					'title'   	=> esc_html__( 'Pricing', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'homepage',
					'priority'	=> 90
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'faq',
				array(
					'title'   	=> esc_html__( 'FAQ', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'homepage',
					'priority'	=> 100
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'newsletter',
				array(
					'title'   	=> esc_html__( 'Newsletter', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'homepage',
					'priority'	=> 120
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'logos',
				array(
					'title'   	=> esc_html__( 'Logos', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'homepage',
					'priority'	=> 130
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'footer_contact',
				array(
					'title'   	=> esc_html__( 'Contact', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'footer',
					'priority'	=> 2
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'footer_about',
				array(
					'title'   	=> esc_html__( 'About', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'footer',
					'priority'	=> 3
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'footer_hours',
				array(
					'title'   	=> esc_html__( 'Hours', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'footer',
					'priority'	=> 4
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'footer_newsletter',
				array(
					'title'   	=> esc_html__( 'Newsletter', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'footer',
					'priority'	=> 5
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'footer_logo',
				array(
					'title'   	=> esc_html__( 'Logo', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'footer',
					'priority'	=> 8
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'footer_social_media',
				array(
					'title'   	=> esc_html__( 'Social Media', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'footer',
					'priority'	=> 10
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'minify',
				array(
					'title'   	=> esc_html__( 'Minify', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'theme_settings',
					'priority'	=> 50
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'notification_bar',
				array(
					'title'   	=> esc_html__( 'Notification Bar', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'theme_settings',
					'priority'	=> 60
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'social_sharing',
				array(
					'title'   	=> esc_html__( 'Social Sharing', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'theme_settings',
					'priority'	=> 80
				)
			)
		);
		$manager->add_section(
			new Minisite_Pro_Section(
				$manager,
				'typography',
				array(
					'title'   	=> esc_html__( 'Typography', 'minisite-lite' ),
					'pro_text' 	=> esc_html__( 'Pro', 'minisite-lite' ),
					'pro_url'  	=> 'https://www.getminisites.com/theme/',
					'panel'		=> 'theme_settings',
					'priority'	=> 90
				)
			)
		);
	}

	// Loads theme customizer CSS.
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'minisite-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/inc/pro-sections/js/customizer.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'minisite-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/inc/pro-sections/css/customizer.css' );
	}
}

// Doing this customizer thang!
Minisite_Pro_Customize::get_instance();
