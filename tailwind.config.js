import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gu: {
                    navy:   '#002d62',
                    gold:   '#e8a23e',
                    orange: '#e85426',
                    light:  '#f5f6f7',
                    dark:   '#1a1a2e',
                },
            },
        },
    },

    plugins: [forms],
};
