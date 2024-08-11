import { defineConfig } from 'vite';
import { fileURLToPath, URL } from 'node:url'
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
// import { PrimeVueResolver } from '@primevue/auto-import-resolver';
// import Components from 'unplugin-vue-components/vite';
export default defineConfig({
    // optimizeDeps: {
    //     noDiscovery: true
    // },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        // Components({
        //     resolvers: [PrimeVueResolver()]
        // })
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
            '@images': fileURLToPath(new URL('./public/images', import.meta.url)),
        }
    }
});
