import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import { defineConfig, lazyPlugins } from 'vite-plus';
import omniaIcons from './vite-icons.js';

export default defineConfig({
    plugins: lazyPlugins(() => [
        omniaIcons(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                /* @chisel-passkeys */
                'resources/js/passkeys.js',
                /* @end-chisel-passkeys */
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
    ]),
    server: {
        cors: true,
        watch: {
            ignored: [
                '**/.agents/**',
                '**/.claude/**',
                '**/.cursor/**',
                '**/.junie/**',
                '**/storage/framework/views/**',
                '**/vendor/**',
            ],
        },
    },
});
