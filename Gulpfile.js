var gulp         = require('gulp');
var sass         = require('gulp-sass');
var sourcemaps   = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
//var nodemon      = require('gulp-nodemon');
var browserSync  = require('browser-sync');
var sequence     = require('run-sequence');
//var notifier     = require('node-notifier');
var util         = require('gulp-util');
var svgstore     = require('gulp-svgstore');
var rename       = require('gulp-rename');
var svgmin       = require('gulp-svgmin');
var cheerio      = require('gulp-cheerio');

//var concat       = require('gulp-concat');
//var uglify       = require('gulp-uglify');

var BROWSER_SYNC_RELOAD_DELAY = 1000;


var input = './scss/main.scss';
var output = './';

var sassOptions = {
	errLogToConsole: true,
	outputStyle: 'expanded'
};

var autoprefixerOptions = {
	browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
};



// Standard error handler
function standardHandler(err) {
  // Notification
  notifier.notify({
    message: 'Error: ' + err.message
  });
  // Log to console
  util.log(util.colors.red('Error'), err.message);
}

function sassErrorHandler(err) {
  standardHandler({
    message: err
  });
}


/*
STYLES Task
 */
gulp.task('styles', function() {
  util.log('Building Styles');

  return gulp.src(input)
		.pipe(sourcemaps.init())
    .pipe(sass({
      onError: sassErrorHandler
    }))
    .pipe(autoprefixer(autoprefixerOptions))
    .pipe(sourcemaps.write())
    .pipe(rename("./style.css"))
    .pipe(gulp.dest(output))
    .pipe(browserSync.stream());
});




/*
SCRIPTS Task
 */
gulp.task('plugins', function () {
	return gulp.src(['./js/plugins/*.js'])
		.pipe(concat('plugins.min.js')) //the name of the resulting file
		.pipe(uglify())
		.pipe(gulp.dest('public/js'))
		.pipe(browserSync.stream());

	util.log('Finished minifying Plugins');
});


gulp.task('js', function () {
	return gulp.src('./main.js')
		.pipe(concat('main.min.js')) //the name of the resulting file
		.pipe(uglify())
		.pipe(gulp.dest('public/js'))
		.pipe(browserSync.stream());

	util.log('Finished minifying Scripts');
});

/*
SVG Task
 */
gulp.task('svg', function() {
	return gulp.src('./svg/*.svg')
		.pipe(rename({prefix: 'icon-'}))
		.pipe(svgmin({
			plugins: [
				{
					removeDoctype: true
				},
				{
					removeComments: true
				},
				{
					removeTitle: true
				},
				{
					removeUselessStrokeAndFill: true
				},
				{
					addClassesToSVGElement: 'hidden'
				},
				{
					cleanupNumericValues: {
						floatPrecision: 2
					}
				},
				{
				convertColors:
					{
						names2hex: false,
						rgb2hex: false
					}
				}
			]
		}))
		.pipe(cheerio({
			run: function ($) {
				$('[fill]').removeAttr('fill');
				$('[stroke]').removeAttr('stroke');
				$('style').remove();
			},
			parserOptions: { xmlMode: true }
		}))
		.pipe(svgstore({ inlineSvg: true }))
		.pipe(cheerio(function ($) {
			$('svg').attr('style', 'display:none');
		}))
		.pipe(rename(function (path) {
			path.basename = "svg-defs",
			path.extname = ".php"
		}))
		.pipe(gulp.dest('./lib/'))
});



/*
WATCH Task
 */
gulp.task('watch', function() {

  util.log('watching sass')
  gulp.watch('./scss/**/*.scss', ['styles'], browserSync.reload);

  util.log('watching svg')
  gulp.watch('./svg/*.svg', ['svg'], browserSync.reload);

  util.log('watching js')
  gulp.watch('./js/plugins/*.js', ['plugins'], browserSync.reload);
  gulp.watch('./js/main.js', ['js'], browserSync.reload);

  browserSync.reload({
    stream: false
  });
});






/*
BROWSER-SYNC Task
 */
// Make sure `nodemon` is started before running `browser-sync`.
gulp.task('browser-sync', ['styles'], function() {

  browserSync.init({
   proxy: "carte.dev"
  });

  util.log('watching browser')

  gulp.watch("./*.php").on('change', browserSync.reload);

});



/*
DEFAULT Task to kick things off
 */
gulp.task('default', function(done) {
  sequence('browser-sync', 'watch', done);
});