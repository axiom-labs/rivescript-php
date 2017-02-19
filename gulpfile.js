var gulp = require('gulp');
var run = require('gulp-run');
var phpunit = require('gulp-phpunit');
var notify = require('gulp-notify');

gulp.task('test', function() {
    gulp.src('')
        .pipe(run('clear'))
        .pipe(phpunit('', {notify: false}))
        .on('error', notify.onError({
            title: "RiveScript PHP",
            message: "Tests failed.",
            icon: __dirname + '/failed.png'
        }))
        .pipe(notify({
            title: "RiveScript PHP",
            message: "Tests passed!",
            icon: __dirname + '/success.png'
        }));
});

gulp.task('watch', function() {
    gulp.watch('**/*.php', ['test']);
    gulp.watch('**/*.rive', ['test']);
});

gulp.task('default', ['test', 'watch']);
