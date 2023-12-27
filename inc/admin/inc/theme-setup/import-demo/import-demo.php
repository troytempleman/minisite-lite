<?php
/**
 * Import Demo
 */

// One Click Demo Import
require dirname( __FILE__ ) . '/theme-demo-import.php';

// Import Files
function TDI_import_files() {
	return array(
		array(
			'import_file_name'             => 'Demo Import 1',
			'local_import_file'            => dirname( __FILE__ ) . '/import/content.xml',
			'local_import_customizer_file' => dirname( __FILE__ ) . '/import/customizer.dat',
		),
	);
}
add_filter( 'theme-demo-import/import_files', 'TDI_import_files' );
