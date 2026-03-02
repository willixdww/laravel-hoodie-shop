import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dark: {
                    900: '#0F0F0F',
                    800: '#1A1A1A',
                    700: '#262626',
                    600: '#404040',
                },
                brand: {
                    DEFAULT: '#6366F1',
                    light: '#818CF8',
                }
            }
        },
    },

    plugins: [forms],
};
