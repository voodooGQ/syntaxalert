var gulp = require('gulp');

var requireDir = require('require-dir');
requireDir('./tasks');

gulp.task('default', ['scripts', 'styles', 'media', 'vendor'], function () {
    gulp.watch(['src/scripts/**/*.js', 'src/vendor/**/*.js'], ['scripts']);
    gulp.watch('src/styles/**/*.{sass,scss}', ['styles']);
    gulp.watch('src/media/**/*', ['media']);
    gulp.watch('src/vendor/**/*', ['vendor']);
});