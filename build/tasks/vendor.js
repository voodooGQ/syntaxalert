'use strict';

var gulp = require('gulp');
var env = require('../env');

gulp.task('vendor', function () {
        return gulp.src('./' + env.DIR_SRC + 'vendor/**/*')
            .pipe(gulp.dest(env.DIR_WEB + 'assets/vendor'))
    }
);
