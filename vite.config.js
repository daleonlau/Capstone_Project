import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: '0.0.0.0', // allow access from local network (e.g., 192.168.x.x)
        port: 5173,
        strictPort: true,
        cors: true, // enable CORS globally for dev server
        hmr: {
            host: '192.168.1.72', // <-- replace this with your actual local IP
        },
    },

    plugins: [
        tailwindcss(),
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
