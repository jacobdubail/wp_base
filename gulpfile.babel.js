import gulp from 'gulp';
import sass from 'gulp-sass';
import babel from 'gulp-babel';
import webpack from 'webpack-stream';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify';
import cleanCSS from 'gulp-clean-css';
import del from 'del';
import svgstore from 'gulp-svgstore';
import rename from 'gulp-rename';
import svgmin from 'gulp-svgmin';
import cheerio from 'gulp-cheerio';
import postcss from 'gulp-postcss';
import browserSync from 'browser-sync';
import autoprefixer from 'autoprefixer';

const paths = {
  styles: {
    src: 'scss/**/*.scss',
    dest: './'
  },
  scripts: {
    src: 'js/**/*.js',
    dest: 'build/'
  }
};


// export const clean = () => del([ 'assets' ]);

export function styles() {
  return gulp.src(paths.styles.src)
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(cleanCSS())
    .pipe(
      postcss([ autoprefixer({ browsers: ['last 2 versions', 'iOS 7', 'IE 11'] }),
      require('postcss-flexibility') ])
    )
    // pass in options to the stream
    .pipe(rename({
      basename: 'style'
    }))
    .pipe(gulp.dest(paths.styles.dest))
    .pipe( browserSync.stream() )
}

export function scripts() {
  return gulp.src(paths.scripts.src, { sourcemaps: true })
    .pipe(babel())
    .pipe(webpack())
    // .pipe(uglify())
    .pipe(concat('main.min.js'))
    .pipe(gulp.dest(paths.scripts.dest));
}


export function svg() {
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
        //$('[fill]').removeAttr('fill');
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
}



function watchFiles() {
  gulp.watch('js/**/*.js', scripts, function(e) {
    browserSync.reload
    console.log(event)
  });
  gulp.watch('scss/**/*.scss', styles, function(e) {
    browserSync.reload
    console.log(event)
  });
  gulp.watch('svg/*.svg', svg, function(e) {
    browserSync.reload
    console.log(event)
  })
}
export { watchFiles as watch };


// const clean = gulp.series(clean, gulp.parallel(styles, scripts));


function bsync() {

  browserSync.init({
    proxy: "http://familyhouse.dev",
    ui: {
      port: 8080
    }
  });

  gulp.watch("**/*.php").on('change', function(e) {
    browserSync.reload
    console.log(e)
  });
  gulp.watch('js/**/*.js', scripts, function(e) {
    browserSync.reload
    console.log(e)
  });
  gulp.watch('scss/**/*.scss', styles, function(e) {
    browserSync.reload
    console.log(e)
  });
  gulp.watch('svg/*.svg', svg, function(e) {
    browserSync.reload
    console.log(e)
  })

}

/*
 * Export a default task
 */
export function build() {
  gulp.series(bsync, watchFiles)();
}
