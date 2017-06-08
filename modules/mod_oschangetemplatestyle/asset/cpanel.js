!function($){
	$(document).ready( function() {
		$('#cpanel_btn').click( function() {
			if ($('#cpanel_btn i').attr('class') == 'icon-hand-left') {
				$('#cpanel_wrapper').animate( {
					'right' : '-331px'
				}, 200, function() {
					$('#cpanel_wrapper').show().animate( {
						'right' : '0px'
					});
				});
				$('#cpanel_btn i').attr('class', 'icon-hand-right');
			} else if ($('#cpanel_btn i').attr('class') == 'icon-hand-right') {
				$('#cpanel_wrapper').animate( {
					'right' : '0px'
				}, 200, function() {
					$('#cpanel_wrapper').show().animate( {
						'right' : '-331px'
					});
				});
				$('#cpanel_btn i').attr('class', 'icon-hand-left');
			}
		});
	});
	$(document).ready( function() {
		$('.theme-color').click( function() {
			$('#os_theme').attr('value',$(this).attr('title'));
		});
	});
	$(document).ready( function() {		
		$('ul.nav li a').click (function(e) {			
			var target = this.href.replace(/.*(?=#[^\s]+$)/, '');
			if (target && ($(target).length)) {			  
			  $('html,body').animate({scrollTop: Math.max(0, $(target).offset().top - $('#t3-header').height() + 2)}, {
				queue: false,
				duration:2000
			  });
			}
		});
	});
}(jQuery);