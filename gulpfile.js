var gulp       = require('gulp'),
    concat     = require('gulp-concat'),
    sass       = require('gulp-sass'),
    minifyCSS  = require('gulp-minify-css'),
    uglify     = require('gulp-uglify'),
    rename     = require("gulp-rename");

gulp.task('sass', function () {
    gulp.src('./resources/assets/sass/*.scss')
        .pipe(sass())
        .pipe(minifyCSS())
        .pipe(rename(function(path) {
            path.basename = "ccu.css";
            path.extname = ".php";
        }))
        .pipe(gulp.dest('./resources/views/css/'));
});

var scriptsPrefix = './resources/views/js/';

gulp.task('js', function () {
    gulp.src([
        scriptsPrefix + 'angular.js.php',
        scriptsPrefix + 'routes.js.php',
        scriptsPrefix + 'controllers/*.js.php',
        scriptsPrefix + 'directives/*.js.php',
        scriptsPrefix + 'factories/*.js.php'
    ])
        .pipe(concat('temp.js'))
        .pipe(uglify())
        .pipe(rename(function(path) {
            path.basename = "all.js";
            path.extname = ".php";
        }))
        .pipe(gulp.dest('./resources/views/js/'));
});

gulp.task('default',['sass','js']);