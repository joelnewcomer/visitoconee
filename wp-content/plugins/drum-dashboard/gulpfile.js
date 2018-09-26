var gulp = require('gulp'),
    $    = require('gulp-load-plugins')(),
	cleanCSS = require('gulp-clean-css'),
	concat = require('gulp-concat-css')
	rename = require("gulp-rename");



var sassPaths = [
  'assets/scss/*.scss'
];

// Browsers to target when prefixing CSS.
var COMPATIBILITY = [
  'last 2 versions',
  'ie >= 9',
  'Android >= 2.3',
  'ios >= 6'
];

gulp.task('sass', function() {
  return gulp.src(sassPaths)
    .pipe($.sass({
      includePaths: sassPaths,
      outputStyle: 'compressed' // if css compressed **file size**
    })
      .on('error', $.sass.logError))
    .pipe(gulp.dest('assets/stylesheets'))
    .pipe($.autoprefixer({
      browsers: COMPATIBILITY
    }))
    .pipe(concat('app.min.css'))
     .pipe(cleanCSS({compatibility: COMPATIBILITY}))
    .pipe(gulp.dest('assets/stylesheets'));
});

gulp.task('default', ['sass'], function() {
  gulp.watch(['assets/scss/**/*.scss'], ['sass']);
});
