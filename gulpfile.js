var gulp = require('gulp'),
	connect = require('gulp-connect-php');

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

    }

    function taskSass() {

    }

    function taskReload() {

    }

    function taskDeploy() {

    }

    function taskWatch() {

    }

    function taskConnect() {
        connect.server({
            port: 8080,
            base: 'public'
        });
    }


})();
