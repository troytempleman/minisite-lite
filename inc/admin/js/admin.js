/**
 * Admin scripts
 */

jQuery(document).ready(function($){
	
	// Header
	$
	
	// Theme Setup

	$('.nav-tab-1-content').each(function() {
		$('.admin-nav .nav-tab-1').addClass("nav-tab-active"); 
   	});
	$('.nav-tab-2-content').each(function() {
		$('.admin-nav .nav-tab-2').addClass("nav-tab-active"); 
   	});
	$('.nav-tab-3-content').each(function() {
		$('.admin-nav .nav-tab-3').addClass("nav-tab-active"); 
   	});
	
	
	
	// Install Plugins
	
		// Remove Update | Activate
		$('.tgmpa-table .plugin .update:contains("|")').each(function() {
			$(this).closest('div').addClass("update-activate"); 
			$('.update-activate .activate').remove();
			$('.tgmpa-table .plugin .update').html($('.tgmpa-table .plugin .update').html().replace('|',''))
	   	});
	
		// Install Plugins
		if($('.tgmpa-table .plugin .install a:contains("Install")').length > 0){ 
		
			// Remove Update Plugins
			if($('.tgmpa-table .plugin .update a:contains("Update")').length > 0){
				$('.tgmpa-table .plugin .update a:contains("Update")').each(function() {
					$(this).closest('tr').addClass("update-plugin"); 
			   	});
				$('.tgmpa-table .update-plugin').remove();
			}
		
			// Remove Activate Plugins
			if($('.tgmpa-table .plugin .activate a:contains("Activate")').length > 0){
				$('.tgmpa-table .plugin .activate a:contains("Activate")').each(function() {
					$(this).closest('tr').addClass("activate-plugin"); 
			   	});
				$('.tgmpa-table .activate-plugin').remove();
			}
	
			// Install Plugins
			$('.tgmpa-table .plugin .install a:contains("Install")').each(function() {
				$(this).closest('tr').addClass("install-plugin"); 
		   	});
			$('.tgmpa-table .install-plugin input').trigger('click');
			$('.tgmpa-table .install-plugins-button').click(function(){ 
				$('.tgmpa-table #bulk-action-selector-top').val("tgmpa-bulk-install").click();
				$('.tgmpa-table #doaction').trigger('click'); 	
			});	
		}
	
		// Update Plugins
		if($('.tgmpa-table .plugin .update a:contains("Update")').length > 0){ 
		
			// Remove Install Plugins
			if($('.tgmpa-table .plugin .install a:contains("Install")').length > 0){
				$('.tgmpa-table .plugin .install a:contains("Install")').each(function() {
					$(this).closest('tr').addClass("install-plugin"); 
			   	});
				$('.tgmpa-table .install-plugin').remove();
			}
		
			// Remove Activate Plugins
			if($('.tgmpa-table .plugin .activate a:contains("Activate")').length > 0){
				$('.tgmpa-table .plugin .activate a:contains("Activate")').each(function() {
					$(this).closest('tr').addClass("activate-plugin"); 
			   	});
				$('.tgmpa-table .activate-plugin').remove();
			}
		
			// Update Plugins
			$('.tgmpa-table .plugin .update a:contains("Update")').each(function() {
				$(this).closest('tr').addClass("update-plugin"); 
		   	});
			$('.tgmpa-table .update-plugin input').trigger('click');
			$('.tgmpa-table .install-plugins-button').html($('.tgmpa-table .install-plugins-button').html().replace('Install','Update'));
			$('.tgmpa-table .install-plugins-button').click(function(){ 
				$('.tgmpa-table #bulk-action-selector-top').val("tgmpa-bulk-update").click();
				$('.tgmpa-table #doaction').trigger('click'); 	
			});	
		}
	
		// Activate Plugins
		if($('.tgmpa-table .plugin .activate a:contains("Activate")').length > 0){
		
			// Remove Install Plugins
			if($('.tgmpa-table .plugin .install a:contains("Install")').length > 0){
				$('.tgmpa-table .plugin .install a:contains("Install")').each(function() {
					$(this).closest('tr').addClass("install-plugin"); 
			   	});
				$('.tgmpa-table .install-plugin').remove();
			}

			// Remove Update Plugins
			if($('.tgmpa-table .plugin .update a:contains("Update")').length > 0){
				$('.tgmpa-table .plugin .update a:contains("Update")').each(function() {
					$(this).closest('tr').addClass("update-plugin"); 
			   	});
				$('.tgmpa-table .update-plugin').remove();
			}
		
			// Activate Plugins
			$('.tgmpa-table .plugin .activate a:contains("Activate")').each(function() {
				$(this).closest('tr').addClass("activate-plugin"); 
		   	});
			$('.tgmpa-table .activate-plugin input').trigger('click');
			$('.tgmpa-table .install-plugins-button').html($('.tgmpa-table .install-plugins-button').html().replace('Install','Activate'));
			$('.tgmpa-table .install-plugins-button').click(function(){ 
				$('.tgmpa-table #bulk-action-selector-top').val("tgmpa-bulk-activate").click();
				$('.tgmpa-table #doaction').trigger('click'); 
			});	
		}
	
		// Remove unnecessary elements 		
		$('.tgmpa-table .subsubsub').remove();
		$('.tgmpa-table thead').remove();
		$('.tgmpa-table tfoot').remove();
		$('.tgmpa-table .tablenav.bottom').remove();
		$('.tgmpa-table .column-source').remove();
		$('.tgmpa-table .column-type').remove();
		$('.tgmpa-table .column-version').remove();
		$('.tgmpa-table .column-status').remove();
	   
		// Redirect if no plugins to install, update or activate
		$('body:contains("There are no plugins to install, update or activate.")').each(function() {
			// var url = $('.next-button').attr('href');
			// $(location).attr('href',url);
			$('.install-plugins-link').remove();
			$('.install-plugins-button').remove();
		});
		
	// Import Content
	$('body').on('DOMSubtreeModified', '.TDI__response', function() {
	    $('.TDI__response p').addClass("import-complete"); 
		$('.next-button').click();
		$('.next-button').click(function(){ 
			var url = $(this).attr('href');
			$(location).attr('href',url);
		});	
	});
	
	// Set Homepage
	$('.set-homepage-notice:contains("Homepage set!")').each(function() {
		var url = $('.next-button').attr('href');
		$(location).attr('href',url);
	});
	// $('body').on('DOMSubtreeModified', '.button-primary', function() {
	//     $('.button-primary').addClass("import-complete");
	// 	$('.next-button').click();
	// 	$('.next-button').click(function(){
	// 		var url = $(this).attr('href');
	// 		$(location).attr('href',url);
	// 	});
	// });
	
});