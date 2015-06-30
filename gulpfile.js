var gulp = require('gulp'),
	connect = require('gulp-connect-php');


(function() {

gulp.task('connect', connectTask);

gulp.task('default', ['connect']);


function connectTask() {
	connect.server({
		port: 8080,
		base: 'webroot'
	});
}


})();
