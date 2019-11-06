let mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js("resources/assets/js/app.js", "public/js")
  .sass("resources/assets/sass/app.scss", "public/css")
  ;

mix
  .js("resources/assets/js/new.js", "public/js")
  .sass("resources/assets/sass/new.scss", "public/css")
  ;

mix.styles(
  [
    "public/css/image-picker.css",
    "public/dist/css/skins/_all-skins.min.css",
    "public/style/morris.js/morris.css",
    "public/style/jvectormap/jquery-jvectormap.css",
    "public/plugins/timepicker/bootstrap-timepicker.min.css",
    "public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css",
    "public/style/select2/dist/css/select2.min.css",
    "public/plugins/file_upload/file_upload.css",
    "public/dist/css/AdminLTE.min.css",
    "public/plugins/iCheck/all.css",
    "public/css/bootstrap-tagsinput.css",
    "public/css/gallery.css",
    "public/css/bootstrap-datetimepicker.min.css",
    "public/css/jquery-ui.min.css",
    "public/css/jquery.comiseo.daterangepicker.css",
    "public/css/dropdowntree.css"
    // 'public/css/semantic.min.css'
  ],
  "public/css/header_all.css"
);

// mix.js('resources/assets/js/F.js', 'public/js');
