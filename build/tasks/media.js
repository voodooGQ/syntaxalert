'use strict';

var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var env = require('../env');

gulp.task('media', function () {
    return gulp.src('./' + env.DIR_SRC + 'media/**/*')
            .pipe(imagemin())
            .pipe(gulp.dest(env.DIR_WEB + 'assets/media/'))
    }
);
