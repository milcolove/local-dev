
(function($, Drupal, drupalSettings){
	// externalLink
	Drupal.behaviors.externalLink = {
		attach: function (context, settings){
			$("a[href^='http']", context).attr('target', '_blank').addClass('external');
		}
	}

// blockCollapsable
Drupal.behaviors.blockCollapsable = {
		attach: function (context, settings){
			$(".sidebar .block h2",context).click(function() {
				$(this).siblings('.content').slideToggle('fast');
		});
		
	}
}
}) (jQuery, Drupal, drupalSettings);


