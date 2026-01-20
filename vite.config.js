import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/toast.js',
                'resources/js/session-toast.js',
                'resources/js/shop-autocomplete.js',
            ],
            refresh: true,
        }),
    ],
});
