var args = process.argv.slice(2);
var fs = require('fs');
var path = require('path');
var gulp = require('gulp');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var jscs = require('gulp-jscs');
var jshint = require('gulp-jshint');
var imageMin = require('gulp-imagemin');
var pngCrush = require('imagemin-pngcrush');
var sass = require('gulp-sass');
var prefix = require('gulp-autoprefixer');
var cmq = require('gulp-combine-mq');
var cssMin = require('gulp-cssmin');
var csscomb = require('gulp-csscomb');
var rigger = require('gulp-rigger');

var browserSync = require('browser-sync').create();
var changed = require('gulp-changed');
var gulpIgnore = require('gulp-ignore');

var pages = '_*.html';
var syncPages = '*.html';
var minFilesCondition = '*.min.*';
var startPage = 'octoKIT.lo/menu.html';

//gulp -p _home.html
var _p = args.indexOf('-p');
if (_p !== -1) {
  var pageName = args[_p + 1];
  if (pageName) {
    pages = pageName;
  }
}
var pagesWatch = [pages, 'templates/*.html'];

//HTML include

gulp.task('html', function () {
  gulp.src(pages)
    .pipe(changed(syncPages))
    .pipe(rigger())
    .pipe(rename(function (path) {
      var newName = path.basename;
      if (newName.charAt(0) === '_')
        newName = newName.slice(1);
      path.basename = newName;
    }))
    .pipe(gulp.dest(''));
});

// Images, Fonts

gulp.task('images', function () {
  return gulp.src('assets/images/**')
    .pipe(changed('dist/images'))
    .pipe(gulp.dest('dist/images'));
});

gulp.task('images-prod', function () {
  return gulp.src('assets/images/**')
    .pipe(imageMin({
      progressive: true,
      svgoPlugins: [
        {removeViewBox: false}
      ],
      use: [pngCrush()]
    }))
    .pipe(gulp.dest('dist/images'));
});

gulp.task('fonts', function () {
  gulp.src('assets/fonts/**')
    .pipe(gulp.dest('dist/fonts'));
});

// CSS

gulp.task('scss', function () {
  gulp.src(['assets/css/global.scss', 'assets/css/pages/*.scss'])
    .pipe(changed('dist/css'))
    .pipe(sass())
    .pipe(prefix('last 2 versions', '> 1%', 'ie 10'))
    .pipe(cmq({
      beautify: true
    }))
    .pipe(gulp.dest('dist/css'))
    .pipe(csscomb())
    .pipe(gulp.dest('dist/css'));
});

gulp.task('scss-prod', function () {
  gulp.src(['dist/css/*.css'])
    .pipe(gulpIgnore.exclude(minFilesCondition))
    .pipe(cssMin())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('dist/css'));
});

// JS

gulp.task('jscs', function () {
  gulp.src(['assets/js/*.js'])
    .pipe(jscs());
});

gulp.task('lint', function () {
  gulp.src(['assets/js/*.js'])
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'));
});

gulp.task('js', ['jscs', 'lint'], function () {
  gulp.src(['assets/js/*.js'])
    .pipe(rigger())
    .pipe(gulp.dest('dist/js'));
});

gulp.task('js-prod', ['jscs', 'lint'], function () {
  gulp.src(['dist/js/*.js'])
    .pipe(gulpIgnore.exclude(minFilesCondition))
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('dist/js'));
});

// BROWSERSYNC
gulp.task('serve', function () {
  browserSync.init({
    proxy: startPage
  });

  browserSync.watch(['dist/**/*.*', syncPages]).on('change', browserSync.reload)

});

// WATCH

gulp.task('watch', function () {
  gulp.watch('assets/js/**/*.js', ['js']);
  gulp.watch(pagesWatch, ['html']);
  gulp.watch('assets/css/**/*.scss', ['scss']);
});

// DEFAULT

gulp.task('default', ['html', 'images', 'fonts', 'scss', 'js', /*'serve',*/ 'watch']);
gulp.task('prod', ['images-prod', 'scss-prod', 'js-prod']);
