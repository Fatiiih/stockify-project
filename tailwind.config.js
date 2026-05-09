import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50:  '#fff7ed',
                    100: '#ffedd5',
                    200: '#fed7aa',
                    400: '#fb923c',
                    500: '#f97316',
                    600: '#ea6c0d',
                    700: '#c2570a',
                    800: '#9a3f07',
                    900: '#7c3205',
                },
                navy: {
                    50:  '#f0f4f8',
                    100: '#d9e2ec',
                    400: '#627d98',
                    600: '#334155',
                    700: '#253347',
                    800: '#1e293b',
                    900: '#0f172a',
                },
            },
        },
    },

    plugins: [forms, require('flowbite/plugin')],
};