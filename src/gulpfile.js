'use strict';

// fckyah studio gulp file
var errors          = require('./gulperrors.js');

var env             = require('minimist')(process.argv.slice(2));
var gulp            = require('gulp');
var autoprefix      = require('gulp-autoprefixer');
var changed         = require('gulp-changed');
var gulpif          = require('gulp-if');
var imagemin        = require('gulp-imagemin');
var livereload      = require('gulp-livereload');
var sass            = require('gulp-sass');
var sourcemaps      = require('gulp-sourcemaps');
var svg2png         = require('gulp-svg2png');
var runSequence     = require('run-sequence');
var browserify      = require('gulp-browserify');
var uglify          = require('gulp-uglify');
var concat          = require('gulp-concat');
var plumber         = require('gulp-plumber');
var minifyHTML      = require('gulp-minify-html');
var jade            = require('gulp-jade');
var del             = require('del');


gulp.task('default', [ 'development']); 

gulp.task('development', function(cb) {
  global.isProd = false;
  runSequence('browserify', 'jade', 'sass', 'images', 'watch', cb);
});

gulp.task('watch', function() {
  livereload.listen();
  gulp.watch('sass/**/*', ['sass']);
  gulp.watch('img/**/*.{jpg,png,gif}', ['images']);
  gulp.watch('*.html', ['reload']);
  gulp.watch('templates/**/*.jade', ['jade']);
  gulp.watch('js/**/*.js', ['js', 'browserify']);
});


// Call Watch for Browserify
gulp.task('watchfy', function(){
  gulp.watch('templates/**/*.jade', ['jade']);
  gulp.watch('js/**/*.js', ['browserify']);
});

gulp.task('reload', function() { 
  return gulp.src('/**/*.html')
    .pipe(livereload())
});

gulp.task('sass', function() { 
  return gulp.src('sass/**/*')
    .pipe(sass({
      outputStyle:'compressed'
    }))
    .on('error', errors)
    .pipe(autoprefix("last 4 versions", "> 1%", "ie 6"))
    .pipe(gulp.dest('../css'))
    .pipe(gulpif(!global.isProd, livereload()))
});

gulp.task('images', function() {
  return gulp.src('img/**/*.{jpg,png,gif}')
    .pipe(changed('img/**/*.{jpg,png,gif}'))
    .pipe(gulpif(global.isProd,
      imagemin({
        progressive: true,
        svgoPlugins: [{removeViewBox: false}]
      })))  
    .pipe(gulp.dest('../img'))
    .pipe(gulpif(!global.isProd, livereload()));
});

gulp.task('jade', function(){
  var minOpts = {
    conditionals : true
  }
  return gulp.src('templates/*.jade')
    .pipe(plumber())
    .pipe(jade({pretty: !global.isProd }))
    .pipe(minifyHTML(minOpts))
    .pipe(gulp.dest('../'))
});

// Call Uglify and Concat JS
gulp.task('js', function(){
  return gulp.src('js/**/*.js')
    .pipe(plumber())
    .pipe(concat('main.js'))
    .pipe(uglify())
    .pipe(gulp.dest('../js'))
});

 gulp.task('browserify', function(){
  return gulp.src('js/main.js')
    .pipe(plumber())
    .pipe(browserify())
    .pipe(uglify())
    .pipe(gulp.dest('../js'))
});

// gulp.task('clean', function(cb) {
//   del(['beta'], cb);
// });

