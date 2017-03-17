var gulp = require('gulp');
var browserSync = require('browser-sync');

gulp.task('browser-sync', function() {
    browserSync.init({
        //files: "**",
        server: {
            baseDir: "./"
        }
    });
});

// gulp.task('default', ["browser-sync"]);

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "localhost"
    });
});