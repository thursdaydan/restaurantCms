const mix = require('laravel-mix');
const domain = 'restaurantcms.localhost';
const homedir = require('os').homedir();

mix.browserSync({
    proxy: 'https://' + domain,
    browser: 'google chrome',
    host: domain,
    open: 'external',
    https: {
        key: homedir + '/.config/valet/Certificates/' + domain + '.key',
        cert: homedir + '/.config/valet/Certificates/' + domain + '.crt'
    },
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

if (mix.inProduction()) {
    mix.version()
        .disableNotifications();
}
