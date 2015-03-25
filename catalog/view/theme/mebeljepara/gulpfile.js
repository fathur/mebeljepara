var gulp          = require('gulp'),
    autoPrefixer  = require('gulp-autoprefixer'),
    concat        = require('gulp-concat'),
    jade          = require('gulp-jade'),
    less          = require('gulp-less'),
    minifyCSS     = require('gulp-minify-css'),
    print         = require('gulp-print'),
    rename        = require('gulp-rename'),
    uglify        = require('gulp-uglify'),  
    /*browserSync   = require('browser-sync'),
    reload        = browserSync.reload,*/
    //livereload    = require('gulp-livereload'),

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
        watch: 'jade/**/*.jade',
        source: [
          'jade/*.jade',
          '!jade/_include/**/*.jade'
        ],
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
    .pipe(print(function (file) { return file + ' has successfully created.' }))
    //.pipe(browserSync.reload({stream: true}))
    //.pipe(livereload())
    ;
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
    .pipe(print(function (file) { return file + ' has successfully created.' }))
    //.pipe(browserSync.reload())
    //.pipe(livereload())
    ;
});

gulp.task('build:js', function() {
  gulp.src(files.js.source)
    .pipe(concat('core.js'))
    .pipe(gulp.dest(files.js.dest))
    .pipe(print(function (file) { return file + ' has successfully created.' }))
    .pipe(uglify())
    .pipe(rename('core.min.js'))
    .pipe(gulp.dest(files.js.dest))
    .pipe(print(function (file) { return file + ' has successfully created.' }))
    //.pipe(reload({stream: true}))
    //.pipe(livereload())
    ;
});

// Watch files
gulp.task('watch', function() {
  
  gulp.watch(files.template.watch, ['build:template'], function (file) {
    gulp.src(file.path).pipe(print(function (file) { return file + ' has modified.' }));
  });

  gulp.watch(files.less.watch, ['build:less'], function (file) {
    gulp.src(file.path).pipe(print(function (file) { return file + ' has modified.' }));
  });

  gulp.watch(files.js.watch, ['build:js'], function (file) {
    gulp.src(file.path).pipe(print(function (file) { return file + ' has modified.' }));
  });
});

// Default
gulp.task('default', ['build:template','build:less','build:js','watch']);