import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/app.scss', 'resources/css/header.scss', 'resources/css/footer.scss', 'resources/css/contact.scss', 'resources/css/anuncie.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
