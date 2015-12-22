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

			var that  = this;
			var doc   = document.body || document.documentElement;
			var style = doc.style;

			if ( !style.webkitFlexWrap == '' ||
			    !style.msFlexWrap == '' ||
			    !style.flexWrap == '' ) {
			  doc.className += " no-flex-support";
			}


			this.setup_resp_nav();


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

		setup_resp_nav : function() {
			var label = "<span></span>";

			responsiveNav( "#menu-main-nav", {
				label      : label,
				animate    : false,
				transition : 300,
				insert     : 'before',
				openPos    : 'relative',
			});

			BASE.main_nav.on('click','span.nav-arrow',function(e) {
				var $this = $(this);

				e.stopPropagation();
				e.preventDefault();

				$this.parent().parent().toggleClass('open');
				$this.parent().next().toggleClass('open');
				return false;
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