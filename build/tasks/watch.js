var gulp = require('gulp');

gulp.task('watch', function() {
    gulp.watch(['src/scripts/**/*.js', 'src/vendor/**/*.js'], ['scripts']);
    gulp.watch('src/styles/**/*.{sass,scss}', ['styles']);
    gulp.watch('src/media/**/*', ['media']);
    gulp.watch('src/vendor/**/*', ['vendor']);
});