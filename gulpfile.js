/**
* Update file for Agda.
* New fixed IP
*/
var gulp       = require('gulp'),
    concat     = require('gulp-concat'),
    connect    = require('gulp-connect-php'),
    csso       = require('gulp-csso'),
    filter     = require('gulp-filter'),
    livereload = require('gulp-livereload'),
    plumber    = require('gulp-plumber'),
    rename     = require('gulp-rename'),
    sass       = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify     = require('gulp-uglify'),
    gutil      = require('gulp-util'),
    watch      = require('gulp-watch'),
    wrap       = require('gulp-wrap'),
    _          = require('lodash'),
    fs         = require('fs'),
    ftp        = require('vinyl-ftp');

/**
 * app         Concat and generate angular applicaiton
 * sass        Generate css files from sass source
 * connect     Starts a simple php testserver
 * reload      Start a development server that watches for and reloads
 *             resources on changes
 * deploy      Deploy project to server using ftp
 * watch       Watch for and update .scss and .js changes
 */
(function() {

    gulp.task('app', taskApp);
    gulp.task('sass', taskSass);
    gulp.task('connect', taskConnect);
    gulp.task('reload', ['connect', 'watch'], taskReload);
    gulp.task('deploy', ['default'], taskDeploy);
    gulp.task('watch', ['default'], taskWatch);

    gulp.task('default', ['app', 'sass']);


    function taskApp() {
        var wrapper = [
            '(function(window, angular) {',
                '"use strict";',
                '<%= contents %>',
            '})(window, window.angular);'
        ].join('\n');

        return gulp.src([
                'web/app/*/**/*.js',
                'web/app/platoon.js'
            ])
            .pipe(plumber())
            .pipe(concat('platoon.js'))
            .pipe(wrap(wrapper))
            .pipe(sourcemaps.init())
            .pipe(gulp.dest('public/js'))
            .pipe(uglify())
            .pipe(sourcemaps.write('.', {
                includeContent: false,
                sourceRoot: '/js'
            }))
            .pipe(rename(function(path) {
                if (path.extname === '.js') {
                    path.basename += '.min';
                }
            }))
            .pipe(gulp.dest('public/js'))
            .pipe(filter('*.js'))
            .pipe(livereload());
    }

    function taskSass() {
        return gulp.src('web/sass/*.scss')
            .pipe(plumber())
            .pipe(sass())
            .pipe(sourcemaps.init())
            .pipe(gulp.dest('public/css'))
            .pipe(csso())
            .pipe(sourcemaps.write('.', {
                includeContent: false,
                sourceRoot: '/css'
            }))
            .pipe(rename(function(path) {
                if (path.extname === '.css') {
                    path.basename += '.min';
                }
            }))
            .pipe(gulp.dest('public/css'))
            .pipe(filter('*.css'))
            .pipe(livereload());
    }

    function taskReload() {
        watch('app/views/**', function() {
            livereload.reload();
        });
        return livereload.listen();
    }

    function taskDeploy() {
        var ftpSettings = JSON.parse(fs.readFileSync('.deploy', 'utf-8'));

        var conn = ftp.create({
            host:     ftpSettings.host,
            user:     ftpSettings.user,
            password: ftpSettings.password,
            log: gutil.log
        });

        // To get better uplaod performarce are composer and bower packages
        // synced manually using a ftp client or whatnot
        return gulp.src([
                'app/**',
                '!public/bower/**',
                'public/**',
                'public/.htaccess'
            ], { base: '.', buffer: false })
            .pipe(conn.newerOrDifferentSize(ftpSettings.dest))
            .pipe(conn.dest(ftpSettings.dest))
    }

    function taskWatch() {
        watch('web/app/**', function() {
            gulp.start('app');
        });

        watch('web/sass/**', function() {
            gulp.start('sass');
        });
    }

    function taskConnect() {
        return connect.server({
		hostname: '192.168.1.5',
		port: 8001,
            	base: 'public'
        });
    }


})();
