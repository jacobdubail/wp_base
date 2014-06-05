/* Author: Jacob Dubail

*/
(function($) {

	$(window).load(function() {
    $("html").removeClass("preload");
  });


	var BASE = {

		w         : $(window),
		main_nav  : $("#main-nav"),
		hash      : window.location.hash,

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
			var label = "<span class='icon-bar'></span><span class='icon-bar'></span><span class='icon-bar'></span>";
			
			responsiveNav( "#menu-main-nav", {
				label      : label,
				animate    : false,
				transition : 300,
				insert     : 'before'
			});
		}

	}; // end base

	BASE.init();



})(jQuery);