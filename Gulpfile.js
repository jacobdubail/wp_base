var
	gulp         = require('gulp'),
	sass         = require('gulp-sass'),
	sourcemaps   = require('gulp-sourcemaps'),
	autoprefixer = require('autoprefixer'),
	browserSync  = require('browser-sync'),
	sequence     = require('run-sequence'),
	util         = require('gulp-util'),
	svgstore     = require('gulp-svgstore'),
	rename       = require('gulp-rename'),
	svgmin       = require('gulp-svgmin'),
	cheerio      = require('gulp-cheerio'),
	postcss      = require('gulp-postcss'),
	concat       = require('gulp-concat'),
	uglify       = require('gulp-uglify'),
	imagemin     = require('gulp-imagemin');

var BROWSER_SYNC_RELOAD_DELAY = 1000;


var input = 'scss/main.scss';
var output = '';



function swallowError (error) {
	util.log(error);
	this.emit('end');
}




/*
STYLES Task
 */
gulp.task('styles', function() {
  util.log('Building Styles');

  return gulp.src(input)
		//.pipe( sourcemaps.init() )
    .pipe( sass({outputStyle: 'compressed'}).on('error', swallowError) )
    .pipe(
    	postcss([ autoprefixer({ browsers: ['last 2 versions', 'iOS 7'] }),
    	require('postcss-flexibility') ])
    )
    .pipe( sourcemaps.write() )
    .pipe( rename("style.css") )
    .pipe( gulp.dest(output) )
    .pipe( browserSync.stream() );
});




/*
SCRIPTS Task
 */
gulp.task('plugins', function () {
	return gulp.src(['js/plugins/**/*.js'])
		.pipe(concat('plugins.min.js')) //the name of the resulting file
		.pipe(uglify().on('error', swallowError))
		.pipe(gulp.dest('js'))
		.pipe(browserSync.stream());

	util.log('Finished minifying Plugins');
});


gulp.task('js', function () {
	util.log('Begin minifying Scripts');
	return gulp.src('js/main.js')
		.pipe(concat('main.min.js')) //the name of the resulting file
		.pipe(uglify().on('error', swallowError))
		.pipe(gulp.dest('js'))
		.pipe(browserSync.stream());

	util.log('Finished minifying Scripts');
});

/*
SVG Task
 */
gulp.task('svg', function() {
	util.log('Begin SVG task');
	return gulp.src('svg/*.svg')
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
				//$('[stroke]').removeAttr('stroke');
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
		.pipe(gulp.dest('lib/'))
});


/*
IMAGES TASK
 */
gulp.task('images', function() {
	return gulp.src('images/*')
		.pipe(imagemin())
		.pipe(gulp.dest('images/'))
});




/*
WATCH Task
 */
gulp.task('watch', function() {

  util.log('watching sass')
  gulp.watch('scss/**/*.scss', ['styles'], browserSync.reload);

  util.log('watching svg')
  gulp.watch('svg/*.svg', ['svg'], browserSync.reload);

  util.log('watching js')
  gulp.watch('js/plugins/**/*.js', ['plugins'], browserSync.reload);
  gulp.watch('js/main.js', ['js'], browserSync.reload);

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
   proxy: "base.dev"
  });

  util.log('watching browser')

  gulp.watch("*.php").on('change', browserSync.reload);

});



/*
DEFAULT Task to kick things off
 */
gulp.task('default', function(done) {
  sequence('browser-sync', 'watch', done);
});