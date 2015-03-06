/* Author: Jacob Dubail

*/
var console = (window.console = window.console || {});
(function($) {

	$(window).load(function() {
    $("html").removeClass("preload");
  });


	var BASE = {

		w         : $(window),
		main_nav  : $("#menu-main-nav"),
		hash      : window.location.hash,
		toggle    : '',

		init : function() {

			var that = this;

			this.setup_resp_nav();

			that.main_nav.on('click','span.nav-arrow',function(e) {
				var $this = $(this);

				e.stopPropagation();
				e.preventDefault();

				$this.parent().parent().toggleClass('open');
				$this.parent().next().toggleClass('open');
				return false;
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
				init       : function() {
					BASE.toggle = $(".nav-toggle");
				},
				open       : function() {
					BASE.toggle.addClass('open');
				},
				close      : function() {
					BASE.toggle.removeClass('open');
				}
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
