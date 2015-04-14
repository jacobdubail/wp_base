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

			var that = this;

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
