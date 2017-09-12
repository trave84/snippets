// load everything
var gulp = require('gulp');

var browserSync = require('browser-sync').create();
var del = require('del');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');

// a task to delete all css files in main folder
gulp.task('css:clean', function(){
    return del(['*.css'], { force: true });
});

// CSS compilation (also deletes css files first using previously defined task)
gulp.task('css:compile', ['css:clean'], function(){
    return gulp
        .src('index.scss') // this is the source of for compilation from scss to css
        .pipe(sass().on('error', sass.logError)) // compile sass to css and also tell us about a problem if happens
        .pipe(sourcemaps.init()) // initalizes a sourcemap
        .pipe(sourcemaps.write('.')) // writes the sourcemap
        .pipe(gulp.dest('./')) // destination of the resulting css
        .pipe(browserSync.stream()); // tell browsersync to reload CSS (injects compiled CSS)
});

gulp.task('develop', ['css:compile'], function(){
    browserSync.init({ // initalize Browsersync
        // set what files be served
        server: {
            baseDir: './' // serve from folder that this file is located
        },
        port: 3020,
        files: ['*.html'] // watch for changes all files named anything.html in the same folder gulpfile.js is located
    });
    gulp.watch('*.scss', ['css:compile']); // watch for changes in scss files
});

gulp.task('default', ['develop']); // set develop as a default task (gulp runs this when you don't specify a task)
