import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
    build: {
        rollupOptions: {
          input: {
            main: './src/main.js',
          },
        },
      },
      server: {
        watch: {
          ignored: ['node_modules', 'dist', 'vendor'],
        },
      },
});
