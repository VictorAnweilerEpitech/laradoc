let mix = require('laravel-mix');

mix.js('resources/assets/js/admin/appadmin.js', 'public/js/admin').vue()
    .js('resources/assets/js/client/template.js', 'public/js/client')
    .sass('resources/assets/scss/admin.scss', 'public/css/admin')
    .sass('resources/assets/scss/Components/Tree.scss', 'public/css/components');
