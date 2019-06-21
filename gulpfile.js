'use strict';

var gulp = require('gulp');
var browserify = require('browserify');
var source = require('vinyl-source-stream');

gulp.task('track', function () {
  var b =browserify({
      entries: './bundle.js',
      debug: true,
      // defining transforms here will avoid crashing your stream
      transform: ['babelify']
  });
});
gulp.task('browserify', function() {
    return browserify('bundle.js')
        .bundle()
        //Pass desired output filename to vinyl-source-stream
        .pipe(source('main.js'))
        // Start piping stream to tasks!
        .pipe(gulp.dest('./'));
});
