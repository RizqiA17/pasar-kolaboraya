import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import legacy from '@vitejs/plugin-legacy';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        legacy({
            targets: ['defaults', 'not IE 11', 'iOS >= 10'],
            modernPolyfills: true,
            renderLegacyChunks: true,
            additionalLegacyPolyfills: ['regenerator-runtime/runtime'],
            // paksa SystemJS loader disertakan
            polyfills: true,
        }),
    ],
    server: {
        cors: true,
    },
});