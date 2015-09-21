var gulp       = require('gulp'),
    concat     = require('gulp-concat'),
    sass       = require('gulp-sass'),
    minifyCSS  = require('gulp-minify-css'),
    uglify     = require('gulp-uglify'),
    rename     = require("gulp-rename"),
    remoteSrc  = require('gulp-remote-src');

var scriptsPrefix = './resources/views/js/';

// compile scss and minify it
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

// merge js and minify it
gulp.task('js', function () {
    gulp.src([
        scriptsPrefix + 'angular.js.php',
        scriptsPrefix + 'routes.js.php',
        scriptsPrefix + 'controllers/*.js.php',
        scriptsPrefix + 'directives/*.js.php',
        scriptsPrefix + 'factories/*.js.php',
        scriptsPrefix + 'filters/*.js.php',
        scriptsPrefix + 'ccu.js.php'
    ])
        .pipe(concat('all.js.php'))
        .pipe(uglify())
        .pipe(gulp.dest('./resources/views/js/'));
});

// merge vendors
gulp.task('vendorjs', function() {
    remoteSrc([
        'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-animate.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/angularjs-toaster/0.4.15/toaster.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/angulartics/0.19.2/angulartics.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.8.0/loading-bar.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/7.2.2/ng-file-upload.min.js',
        'https://cdn.bepsvpt.net/js/arrive.min.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/material.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/ripples.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.9.0/validator.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.12/autosize.min.js',
        'https://cdn.bepsvpt.net/js/ga.min.js',
        'https://cdn.bepsvpt.net/vendor/textboxio/angular/tbio.js',
        'https://cdn.bepsvpt.net/vendor/textboxio/angular/tbioValidationsFactory.js',
        'https://cdn.bepsvpt.net/vendor/textboxio/angular/tbioConfigFactory.js'
    ], {base: ''})
        .pipe(concat('vendors.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./storage/temp/'));
});

gulp.task('default', ['sass']);