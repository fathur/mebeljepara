var gulp          = require('gulp'),
    autoPrefixer  = require('gulp-autoprefixer'),
    concat        = require('gulp-concat'),
    jade          = require('gulp-jade'),
    less          = require('gulp-less'),
    minifyCSS     = require('gulp-minify-css'),
    print         = require('gulp-print'),
    rename        = require('gulp-rename'),
    uglify        = require('gulp-uglify'),  

    setPrefix = [
      'last 2 version',
      '> 1%',
      'opera 12.1',
      'safari 6',
      'ie 9',
      'bb 10',
      'android 4'
    ],

    files = {
      template: {
        source: 'jade/*.jade',
        dest: '_public/'
      },
      less: {
        watch: 'less/**/*.less',
        source: 'less/style.less',
        dest: '_public/css/'
      },
      js: {
        watch: 'javascript/**/*.js',
        source: [
          'bower_components/jquery/dist/jquery.js',
          'bower_components/bootstrap/dist/js/bootstrap.js',
          'javascript/**/*.js'
        ],
        dest: '_public/js/'
      },
    }
;

// Build
gulp.task('build:template', function() {
  gulp.src(files.template.source)
    .pipe(jade({ pretty: true }))
    .pipe(gulp.dest(files.template.dest))
    .pipe(print(function (file) { return file + ' has successfully created.' }));

});

gulp.task('build:less', function() {
  gulp.src(files.less.source)
    .pipe(less())
    .pipe(autoPrefixer(setPrefix))
    .pipe(gulp.dest(files.less.dest))
    .pipe(print(function (file) { return file + ' has successfully created.' }))
    .pipe(rename('style.min.css'))
    .pipe(minifyCSS())
    .pipe(gulp.dest(files.less.dest))
    .pipe(print(function (file) { return file + ' has successfully created.' }));
});

gulp.task('build:js', function() {
  gulp.src(files.js.source)
    .pipe(concat('core.js'))
    .pipe(gulp.dest(files.js.dest))
    .pipe(print(function (file) { return file + ' has successfully created.' }))
    .pipe(uglify())
    .pipe(rename('core.min.js'))
    .pipe(gulp.dest(files.js.dest))
    .pipe(print(function (file) { return file + ' has successfully created.' }));

});

// Watch files
gulp.task('watch', function() {
  gulp.watch(files.template.source, function (file) {
    gulp.src(file.path).pipe(print(function (file) { return file + ' has modified.' }));
    gulp.start('build:template');
  });

  gulp.watch(files.less.watch, function (file) {
    gulp.src(file.path).pipe(print(function (file) { return file + ' has modified.' }));
    gulp.start('build:less');
  });

  gulp.watch(files.js.watch, function (file) {
    gulp.src(file.path).pipe(print(function (file) { return file + ' has modified.' }));
    gulp.start('build:js');
  });
});

// Default
gulp.task('default', ['build:template','build:less','build:js','watch']);