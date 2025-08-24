import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({

    // server: {
    //     host: '0.0.0.0',
    //     port: 5173,
    //     strictPort: true,
    //     origin: 'http://192.168.1.68:5173'
    // },

    plugins: [

        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js','resources/js/admin.js'],
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue()
        // vue({
        //     template: {
        //         transformAssetUrls: {
        //             base: null,
        //             includeAbsolute: false,
        //         },
        //     },
        // })


    ],

});
