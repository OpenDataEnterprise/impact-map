var gulp = require('gulp'),
    config = require('./gulp-config.js'),
    stylus = require('gulp-stylus'),
    watch = require('gulp-watch'),
    jade = require('gulp-jade'),
    react = require('gulp-react'),
    jsdoc = require("gulp-jsdoc"),
    del = require('del'),
    uglify = require('gulp-uglify')


// Stylus Watch Functions ------------------------------------
gulp.task('stylus-watch', function () {
    gulp.watch(config.stylus.watch, ['stylus-dev']);

});
gulp.task('stylus-dev', function () {
  return gulp.src(config.stylus.src)
    .pipe(stylus({compress: true, linenos: true }))
    .pipe(gulp.dest(config.stylus.devOut));
});

// Jade Watch Function ---------------------------------------
gulp.task('jade-watch', function () {
    gulp.watch(config.jade.watch, ['jade-dev']);
});
gulp.task('jade-dev', function () {
    return gulp.src(config.jade.src)
        .pipe(jade())
        .pipe(gulp.dest(config.jade.devOut));
});

//JSX Configs  ------------------------------------------------
gulp.task('jsx-watch', function () {
    gulp.watch(config.jsx.watch, ['jsx-dev']);
});
gulp.task('jsx-dev', function () {
    return gulp.src(config.jsx.src)
        .pipe(react())
        .pipe(gulp.dest(config.jsx.devOut));
});

//jsDocs

/*gulp.task('jsdocs',function()){
    return gulp.src(["./src/*.js", "README.md"])
      .pipe(jsdoc.parser(infos, name))
      .pipe(gulp.dest('./somewhere'));
}*/

gulp.task('dist-clear', ['jsx-dev', 'jade-dev', 'stylus-dev'], function (callback) {
    del(config.del, callback);
})

gulp.task('dist-copy', ['dist-clear'], function(){

    //copies full src folder, and add excludes
    var src = [
       'src/**',
        '!**/*.jade',
        '!**/*.styl',
        '!**/*.jsx'
    ]
    return gulp.src(src)
        .pipe(gulp.dest(config.dist));
})

gulp.task('dist-minify', ['dist-copy'], function(){

    var src = [
        'dist/**/*.js',
        '!**/leaflet.markercluster-src.js'
    ]

    return gulp.src(src)
        .pipe(uglify())
        .pipe(gulp.dest(config.dist));
});

//Starting Tasks

gulp.task('watch', ['stylus-watch', 'jade-watch','jsx-watch']);
//gulp.task('build-task', ['copy', 'minify', 'stylus-build', 'jade-build', 'optimize']);
gulp.task('dist', ['dist-minify'])

/*gulp.task('build', function () {
  del(config.del, function () {
    gulp.start('build-task');
  });
});
*/


