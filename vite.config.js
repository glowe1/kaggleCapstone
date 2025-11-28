import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    optimizeDeps: {
        include: ['animejs'],
    },
    build: {
        commonjsOptions: {
            include: [/node_modules/],
            transformMixedEsModules: true,
        },
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    // Split vendor chunks for better caching
                    if (id.includes('node_modules')) {
                        // Large libraries get their own chunk
                        if (id.includes('react') || id.includes('react-dom')) {
                            return 'vendor-react';
                        }
                        if (id.includes('@radix-ui')) {
                            return 'vendor-radix';
                        }
                        if (id.includes('chart.js') || id.includes('react-chartjs-2')) {
                            return 'vendor-charts';
                        }
                        if (id.includes('react-router')) {
                            return 'vendor-router';
                        }
                        if (id.includes('@tanstack/react-query')) {
                            return 'vendor-query';
                        }
                        // Other node_modules go into vendor chunk
                        return 'vendor';
                    }
                    // Pages are already code-split by Vite's dynamic imports
                },
            },
        },
        // Warn if chunk exceeds 500KB
        chunkSizeWarningLimit: 500,
        // Disable sourcemaps for smaller builds
        sourcemap: false,
        // Use esbuild minifier (default, faster than terser)
        minify: 'esbuild',
    },
});
