/* Author: Jacob Dubail

*/
(function($) {

	responsiveNav( "#nav-wrap", {
    label      : "&#9776;",
    animate    : true,
    transition : 300,
    insert     : 'before'
  } );

  $(window).load(function() {
    $("html").removeClass("preload");
  });



})(jQuery);