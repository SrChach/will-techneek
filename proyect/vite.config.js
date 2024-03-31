import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
    plugins: [
        viteStaticCopy({
            targets: [
                {
                    src: path.join(__dirname, '/resources/images'),
                    dest: path.join(__dirname, '/public/assets'),
                }
            ],
        }),
        laravel({
            input: [
                // CSS
                'resources/css/app.css',
                'resources/css/main.css',
                
                // JS
                'resources/js/app.js',
                'resources/js/main.js',
            ],
            refresh: true,
        }),
    ],
});
