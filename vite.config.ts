import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    // server: {
    //     host: '0.0.0.0',
    //     hmr: {
    //         host: 'https://lurline-unkilled-edgar.ngrok-free.dev', // Replace with your actual ngrok URL domain
    //         protocol: 'wss',
    //         clientPort: 443,
    //         // Tells the HMR client to connect using port 443 (default HTTPS port)
    //         // This allows the connection to route back through ngrok's HTTPS tunnel.
    //         //clientPort: 443,

    //         // OPTIONAL: You might also need to set the host to `true` or '0.0.0.0'
    //         // to listen on all network interfaces if the default doesn't work.
    //         // host: true,
    //     },
    // },
});
