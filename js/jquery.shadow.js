(function($) {
	var settings;
	
	$.shadow = function(callerSettings) {
		settings = $.extend({
			width: '100%',
			leftCoordinate: 0,
			topCoordinate: 0,
			darkness: 1
		}, callerSettings || {} );
	
		var height = $(document).height();
		for (i = 0; i < settings.darkness; i++) {
			var element = $('<div>')
				.attr('id', 'shadow')
				.css({
					position: 'absolute',
					width: settings.width,
					height: height,
					'z-index': 4000,
					left: settings.leftCoordinate,
					top: settings.topCoordinate,
					backgroundColor: "#000",
					opacity: 0.80
				});
				
			/*if ($.browser.msie && $.browser.version == "6.0") {
				element.css({
					filter: "alpha(opacity=80)"
				});
			}*/
			
			$(document.body).prepend(element);	
		}
	}
	
	$.unshadow = function() {
		$('#shadow').remove();
	}
	
})(jQuery);