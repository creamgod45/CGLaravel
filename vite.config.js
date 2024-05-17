import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/branding.css',
                'resources/css/members.css',
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/branding.js',
                'resources/js/members.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        // 保持第三方库不合并，按库拆分
                        return id.toString().split('node_modules/')[1].split('/')[0];
                    }
                }
            },
            external: [
                'intl-tel-input/build/js/i18n/en/index.mjs',
                'intl-tel-input/build/js/i18n/zh/index.mjs',
                'intl-tel-input/build/js/i18n/zh_TW/index.mjs',
            ]
        }
    },
    //server: {
    //    hmr: {
    //        host: 'localhost',
    //    },
    //},
});
