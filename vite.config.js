import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import sass from 'sass'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 'resources/ts/app.ts'],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
          scss: {
            implementation: sass,
          },
        },
      },
});
