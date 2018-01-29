(function($, Drupal, drupalSettings){
	// tabs
	Drupal.behaviors.tabs = {
		attach: function (context, settings){
			 $( "#tabs", context ).tabs();
		}
	}
})(jQuery, Drupal, drupalSettings);


