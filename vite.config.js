import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ command, mode }) => {
    return {
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/css/post.css',
                    'resources/js/app.js',
                    'resources/js/post.js',
                    'resources/js/tinymce.js',
                ],
                refresh: true,
            }),
        ],
        server: {
            // This is the development server setting
            host: '127.0.0.1', // Use localhost or 0.0.0.0 to make it accessible from your network
            port: 5174,        // Vite's default development server port
        },
        build: {
            // This section is only used in production builds
            rollupOptions: {
                // Configure the output to use proper paths
                output: {
                    assetFileNames: ({ name }) => {
                        if (/\.css$/i.test(name ?? '')) {
                            return 'assets/css/[name]-[hash][extname]';
                        }
                        return 'assets/[name]-[hash][extname]';
                    },
                    chunkFileNames: 'assets/js/[name]-[hash].js',
                    entryFileNames: 'assets/js/[name]-[hash].js',
                },
            },
        },
        base: command === 'build' ? '/' : '', // Ensures correct paths in production
    };
});
