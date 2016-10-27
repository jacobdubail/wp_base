/* Author: Jacob Dubail

*/
var console = (window.console = window.console || {});
(function($) {

	var BASE = {

		w         : $(window),
		main_nav  : $("#menu-main-nav"),
		hash      : window.location.hash,
		toggle    : '',

		init : function() {


		},

		accordion : function(el) {
			el.find('.accordion__toggle').on( 'click', function() {
				var $this = $(this);

				//Expand or collapse this panel
				$this.toggleClass('open').next().toggleClass('open');

				//Hide the other panels
				el.find('.open').not($this).not($this.next()).removeClass('open');

			});
		},

		back_to_top : function(e) {
			e.preventDefault();

			var dist  = Math.abs( $(window).scrollTop() - $("body").offset().top ),
					speed = ( dist / 150 ) * 100;

			$("html,body").animate({
				scrollTop: 0
			}, speed );

		},

	}; // end base

	BASE.init();



})(jQuery);



// from WP-Social-Sharing
function ss_plugin_loadpopup_js(em){
	var shareurl = em.href;
	var top      = (screen.availHeight - 500) / 2;
	var left     = (screen.availWidth - 500) / 2;
	var popup    = window.open(
			shareurl,
			'social sharing',
			'width=550,height=420,left='+ left +',top='+ top +',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1'
	);
	return false;
}


function base_lerp(position, targetPosition) {
	// update position by 20% of the distance between position and target position
	position.x += (targetPosition.x - position.x)*0.2;
	position.y += (targetPosition.y - position.y)*0.2;
}