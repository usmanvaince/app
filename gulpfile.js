/*var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync');

gulp.task('sass', function () {
    gulp.src('scss/main.scss')
        .pipe(sass({includePaths: ['scss']}))
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest('dist'));
});

gulp.task('browser-sync', function() {
    browserSync.init(["*.html","**!/!*", "css/!*.css", "js/!*.js"], {
        proxy: "localhost/admin-dashboard",
        port: 8000
    });
});
gulp.task('default', ['sass', 'browser-sync'], function () {
    gulp.watch("scss/!**!/!*", ['sass']);
});*/


var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

gulp.task('sass', function () {
    gulp.src('./templates/assets/sass/main.scss')
        .pipe(sass({includePaths: ['scss']}))
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest('./templates/assets/css'));
});
/*
gulp.task('pack-js', function () {
    return gulp.src(['js/vendor/*.js', 'js/alert.js', 'js/main.js', 'js/plugins.js'])
        .pipe(concat('bundle.js'))
        .pipe(gulp.dest('dist/js'));
});

gulp.task('pack-css', function () {
    return gulp.src(['css/normalize.css'])
        .pipe(concat('stylesheet.css'))
        .pipe(gulp.dest('dist/css'));
});
*/
//gulp.task('default', [/*'pack-js',*/ 'pack-css']);

gulp.task('watch', function(){
    gulp.watch('./templates/assets/sass/**/*.scss', ['sass']);
    // Other watchers
});