import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
	    preload: false,
        }),
        tailwindcss(),
        legacy({
            targets: ['defaults', 'not IE 11', 'iOS >= 10'],
        }),
    ],
    server: {
        cors: true,
    },
});
