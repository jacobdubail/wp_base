/* Author: Jacob Dubail

*/
var console = (window.console = window.console || {});
(function($) {

	var BASE = {

		w         : $(window),
		main_nav  : $("#menu-main-nav"),
		hash      : window.location.hash,
		toggle    : '',


		boot : function() {
			if ( BASE.browserSupportsAllFeatures() ) {
				BASE.init();
			} else {
				BASE.loadScript('/wp-content/themes/BASE/js/polyfills.min.js', BASE.init);
			}
		},

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

		loadScript : function(src, done) {
		  var js = document.createElement('script');
		  js.src = src;
		  js.onload = function() {
		    done();
		  };
		  js.onerror = function() {
		    done(new Error('Failed to load script ' + src));
		  };
		  document.head.appendChild(js);
		},


		browserSupportsAllFeatures : function() {
			//var d = document.documentElement.style;
			var supportsCSS = !!((window.CSS && window.CSS.supports) || false);

			return supportsCSS && CSS.supports("display", "flex");

		  //return ( 'flexWrap' in d || 'WebkitFlexWrap' in d || 'msFlexWrap' in d );
		},

	}; // end base

	BASE.boot();



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