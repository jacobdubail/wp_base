var
	gulp         = require('gulp'),
	sass         = require('gulp-sass'),
	sourcemaps   = require('gulp-sourcemaps'),
	autoprefixer = require('gulp-autoprefixer'),
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


	source     = require( 'vinyl-source-stream' ),
	buffer     = require( 'vinyl-buffer' ),
	browserify = require('browserify'),
	babelify   = require('babelify'),
	watchify   = require('watchify'),
	notify     = require('gulp-notify');

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

function handleErrors() {
  var args = Array.prototype.slice.call(arguments);
  notify.onError({
    title: 'Compile Error',
    message: '<%= error.message %>'
  }).apply(this, args);
  this.emit('end'); // Keep gulp from hanging on this task
}


function swallowError (error) {
	util.log(error);
	this.emit('end');
}


/*
Bundle React Task
 */
function buildScript(file, watch) {

  var props = {
    entries: ['./js/components/' + file],
    debug : true,
    transform:  [babelify]
  };

  // watchify() if watch requested, otherwise run browserify() once
  var bundler = watch ? watchify(browserify(props)).transform('babelify', {presets: ['react','es2015']}) : browserify(props).transform('babelify', {presets: ['react','es2015']});

  function rebundle() {
    var stream = bundler.bundle();
    return stream
      .on('error', handleErrors)
      .pipe(source(file))
      .pipe(gulp.dest('./js/'))
      // If you also want to uglify it
      // .pipe(buffer())
      // .pipe(uglify())
      // .pipe(rename('app.min.js'))
      // .pipe(gulp.dest('./build'))
      .pipe(browserSync.reload({stream:true}))
  }

  // listen for an update and run rebundle
  bundler.on('update', function() {
    rebundle();
    gutil.log('Rebundle...');
  });

  // run it once the first time buildScript is called
  return rebundle();
}

gulp.task('build-react', function() {
  return buildScript('Kada.js', false); // this will only run once because we set watch to false
});

/*
STYLES Task
 */
gulp.task('styles', function() {
  util.log('Building Styles');

  return gulp.src(input)
		//.pipe( sourcemaps.init() )
    .pipe( sass({outputStyle: 'compressed'}).on('error', swallowError) )
    .pipe( postcss([ require('autoprefixer'), require('postcss-flexibility') ]) )
    //.pipe( autoprefixer(autoprefixerOptions) )
    .pipe( sourcemaps.write() )
    .pipe( rename("./style.css") )
    .pipe( gulp.dest(output) )
    .pipe( browserSync.stream() );
});




/*
SCRIPTS Task
 */
gulp.task('plugins', function () {
	return gulp.src(['./js/plugins/**/*.js'])
		.pipe(concat('plugins.min.js')) //the name of the resulting file
		.pipe(uglify().on('error', swallowError))
		.pipe(gulp.dest('./js'))
		.pipe(browserSync.stream());

	util.log('Finished minifying Plugins');
});


gulp.task('js', function () {
	util.log('Begin minifying Scripts');
	return gulp.src('./js/main.js')
		.pipe(concat('main.min.js')) //the name of the resulting file
		.pipe(uglify().on('error', swallowError))
		.pipe(gulp.dest('./js'))
		.pipe(browserSync.stream());

	util.log('Finished minifying Scripts');
});

/*
SVG Task
 */
gulp.task('svg', function() {
	util.log('Begin SVG task');
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
  gulp.watch('./js/plugins/**/*.js', ['plugins'], browserSync.reload);
  gulp.watch('./js/main.js', ['js'], browserSync.reload);

  util.log('watching pests')
  //return buildScript('js/components/*.js', false)
  gulp.watch('./js/components/*.js', ['build-react'], browserSync.reload);

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
   proxy: "kada.dev"
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