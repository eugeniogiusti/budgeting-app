import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        // Raise the warning threshold — large chunks (ApexCharts, FullCalendar) are
        // lazy-loaded via dynamic import() and never block the initial page load.
        chunkSizeWarningLimit: 600,
    },
});
