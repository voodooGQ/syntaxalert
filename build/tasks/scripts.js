'use strict';

var gulp = require('gulp');
var browserify = require('browserify');
var uglify = require('gulp-uglify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var tap = require('gulp-tap');
var sourcemaps = require('gulp-sourcemaps');
var gutil = require('gulp-util');
var env = require('../env');

// Browserify
gulp.task('scripts', function () {
    return gulp.src(
        ['./' + env.DIR_SRC + 'scripts/**/*.js'],
        {read: false}
    ) // no need of reading file because browserify does.
    // transform file objects using gulp-tap plugin
        .pipe(tap(function (file) {
            gutil.log('bundling ' + file.path);
            // replace file contents with browserify's bundle stream
            file.contents = browserify(file.path, {debug: true}).bundle();
        }))
        // transform streaming contents into buffer contents (because gulp-sourcemaps does not support streaming contents)
        .pipe(buffer())
        // load and init sourcemaps
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(uglify())
        // write sourcemaps
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(env.DIR_WEB + '/assets/scripts'));
});