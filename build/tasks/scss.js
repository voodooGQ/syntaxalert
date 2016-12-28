'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var minify = require('gulp-clean-css');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var argv = require('yargs').argv;
var env = require('../env');
var sourcemaps = require('gulp-sourcemaps');

// SCSS Compiation
gulp.task('styles', function() {
    var compiled = gulp.src('./' + env.DIR_SRC + 'styles/screen.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.init())
        .pipe(concat('screen.css'))
        .pipe(minify())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(env.DIR_WEB + 'assets/styles'));
});
