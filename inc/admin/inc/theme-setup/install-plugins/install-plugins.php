<?php
/**
 * Install Plugins
 */

// Include the TGM_Plugin_Activation class.
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

// Register the required plugins for this theme.
function minisite_register_required_plugins() {
	
	// Array of plugin arrays.
	$plugins = array(
		array(
			'name'      			=> 'Contact Form 7',
			'slug'      			=> 'contact-form-7',
			'required'  			=> false,
		),
	);

	// Array of configuration settings. Amend each line as needed.
	$config = array(
		'id'           => 'minisite-lite',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'install-plugins', // Menu slug.
		'has_notices'  => false,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		'strings'      => array(
			'page_title'                      => __( 'Install Plugins', 'minisite-lite' ),
			'menu_title'                      => __( 'Install Plugins', 'minisite-lite' ),
			// translators: %s: plugin name.
			'installing'                      => __( 'Installing Plugin: %s', 'minisite-lite' ),
			// translators: %s: plugin name.
			'updating'                        => __( 'Updating Plugin: %s', 'minisite-lite' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'minisite-lite' ),
			'notice_can_install_required'     => _n_noop(
				// translators: 1: plugin name(s).
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'minisite-lite'
			),
			'notice_can_install_recommended'  => _n_noop(
				// translators: 1: plugin name(s).
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'minisite-lite'
			),
			'notice_ask_to_update'            => _n_noop(
				// translators: 1: plugin name(s).
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'minisite-lite'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				// translators: 1: plugin name(s).
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'minisite-lite'
			),
			'notice_can_activate_required'    => _n_noop(
				// translators: 1: plugin name(s).
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'minisite-lite'
			),
			'notice_can_activate_recommended' => _n_noop(
				// translators: 1: plugin name(s).
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'minisite-lite'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'minisite-lite'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'minisite-lite'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'minisite-lite'
			),
			'return'                          => __( 'Back', 'minisite-lite' ),
			'next'                            => __( 'Next', 'minisite-lite' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'minisite-lite' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'minisite-lite' ),
			// translators: 1: plugin name.
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'minisite-lite' ),
			// translators: 1: plugin name.
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'minisite-lite' ),
			// translators: 1: dashboard link.
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'minisite-lite' ),
			'dismiss'                         => __( 'Dismiss this notice', 'minisite-lite' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'minisite-lite' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'minisite-lite' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'minisite_register_required_plugins' );
