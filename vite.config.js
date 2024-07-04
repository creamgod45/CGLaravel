import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import obfuscator from 'rollup-plugin-obfuscator';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // css
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/branding.css',
                'resources/css/members.css',
                'resources/css/profile.css',
                'resources/css/WelcomeEmail.css',
                // js
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/branding.js',
                'resources/js/branding_.js',
                'resources/js/members.js',
                'resources/js/profile.js',
                'resources/js/registerForm.js',
                'resources/js/WelcomeEmail.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            plugins: [
                obfuscator({
                    options:{
                        compact: true,
                        controlFlowFlattening: true,
                        controlFlowFlatteningThreshold: 1,
                        deadCodeInjection: true,
                        deadCodeInjectionThreshold: 1,
                        debugProtection: true,
                        debugProtectionInterval: 4000,
                        disableConsoleOutput: true,
                        domainLock: [
                            'http://127.0.0.1:8000/',
                            'https://blaetoan.cyou/',
                            'https://bltn.cc/',
                        ],
                        domainLockRedirectUrl: 'about:blank',
                        forceTransformStrings: [],
                        identifierNamesCache: null,
                        identifierNamesGenerator: 'hexadecimal',
                        identifiersDictionary: [],
                        identifiersPrefix: '',
                        ignoreImports: false,
                        inputFileName: '',
                        log: false,
                        numbersToExpressions: false,
                        optionsPreset: 'default',
                        renameGlobals: false,
                        renameProperties: false,
                        renamePropertiesMode: 'safe',
                        reservedNames: [],
                        reservedStrings: [],
                        seed: 0,
                        selfDefending: false,
                        simplify: true,
                        sourceMap: false,
                        sourceMapBaseUrl: '',
                        sourceMapFileName: '',
                        sourceMapMode: 'separate',
                        sourceMapSourcesMode: 'sources-content',
                        splitStrings: true,
                        splitStringsChunkLength: 10,
                        stringArray: true,
                        stringArrayCallsTransform: true,
                        stringArrayCallsTransformThreshold: 0.5,
                        stringArrayEncoding: [],
                        stringArrayIndexesType: [
                            'hexadecimal-number'
                        ],
                        stringArrayIndexShift: true,
                        stringArrayRotate: true,
                        stringArrayShuffle: true,
                        stringArrayWrappersCount: 1,
                        stringArrayWrappersChainedCalls: true,
                        stringArrayWrappersParametersMaxCount: 2,
                        stringArrayWrappersType: 'variable',
                        stringArrayThreshold: 0.75,
                        target: 'browser',
                        transformObjectKeys: false,
                        unicodeEscapeSequence: true
                    }
                })
            ],
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        // 保持第三方库不合并，按库拆分
                        return id.toString().split('node_modules/')[1].split('/')[0];
                    }
                }
            },
            external: [
                //'intl-tel-input/build/js/i18n/en/index.mjs',
                //'intl-tel-input/build/js/i18n/zh/index.mjs',
                //'intl-tel-input/build/js/i18n/zh_TW/index.mjs',
            ]
        }
    },
    //server: {
    //    hmr: {
    //        host: 'localhost',
    //    },
    //},
});
