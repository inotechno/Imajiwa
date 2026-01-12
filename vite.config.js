import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react';


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/tldraw-board.jsx'
            ],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        extensions: ['.js', '.jsx'],
        // Fix: Dedupe tldraw packages to prevent multiple instances
        dedupe: [
            'tldraw',
            '@tldraw/sync',
            '@tldraw/utils',
            '@tldraw/state',
            '@tldraw/store',
            '@tldraw/validate',
            '@tldraw/tlschema',
        ],
    },
})

