// load everything
var gulp = require('gulp');

var browserSync = require('browser-sync').create();
var del = require('del');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var csso = require('gulp-csso');
var surge = require('gulp-surge');

// a task to delete all css files in dist folder
gulp.task('css:clean', function(){
    return del([
        'dist/*.css',
        'dist/*.map'
    ], { force: true });
});

// CSS compilation (also deletes css files first using previously defined task)
gulp.task('css:compile', ['css:clean'], function(){
    return gulp
        .src('./src/scss/index.scss') // this is the source of for compilation from scss to css
        .pipe(sass().on('error', sass.logError)) // compile sass to css and also tell us about a problem if happens
        .pipe(sourcemaps.init()) // initalizes a sourcemap
        .pipe(postcss([autoprefixer( // adds vendor prefixes…
            // … for these browsers
            'Chrome >= 45',
            'Firefox ESR',
            'Edge >= 12',
            'Explorer >= 10',
            'iOS >= 9',
            'Safari >= 9',
            'Android >= 4.4',
            'Opera >= 30'
        ),
            require('postcss-flexbugs-fixes') // Runs CSS through PostCSS plugin that tries to fix these bugs https://github.com/philipwalton/flexbugs
        ]))
        .pipe(csso()) // compresses CSS
        .pipe(sourcemaps.write('.')) // writes the sourcemap
        .pipe(gulp.dest('./dist')) // destination of the resulting css
        .pipe(browserSync.stream()); // tell browsersync to reload CSS (injects compiled CSS)
});

// Static files cleanup
gulp.task('static:clean', function(){
    return del([
        'dist/**/*', // delete all files from src
        '!dist/**/*.css', // except css and
        '!dist/**/*.map' // and sourcemaps
    ], { force: true });
});

// copy everything to static folder
gulp.task('static:copy', ['static:clean'], function(){
    return gulp.src('src/static/**/*')
        .pipe(gulp.dest('dist'))
        .on('end', function(){ // after copying finishes…
            browserSync.reload() // … tell Browsersync to reload
        });
});

gulp.task('build', ['css:compile', 'static:copy']);

gulp.task('develop', ['build'], function(){
    browserSync.init({ // initalize Browsersync
        // set what files be served
        server: {
            baseDir: './dist', // serve from folder that this file is located
            serveStaticOptions: {
                // trying a extension when one isn't specified:
                // effectively means that http://localhost:3050/another-page shows another-page.html
                extensions: ['html']
            }
        },
        port: 3050
    });
    gulp.watch('src/scss/**/*', ['css:compile']); // watch for changes in scss files
    gulp.watch('src/static/**/*', ['static:copy']); // watch for changes in static files
});

// deployment to surge.sh
gulp.task('deploy', ['build'], function(){
    return surge({
        project: 'dist',
        domain: 'https://domainofyourchoice.surge.sh'
    })
});

gulp.task('default', ['develop']); // set develop as a default task (gulp runs this when you don't specify a task)
