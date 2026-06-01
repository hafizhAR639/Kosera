import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                kosera: {
                    50:  '#e8f4fb',
                    100: '#c5e3f5',
                    200: '#8fc8ed',
                    400: '#3a96cc',
                    600: '#1a6fa0',
                    700: '#155c87',
                    800: '#0f4366',
                    900: '#092c45',
                },
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            fontWeight: {
                '600': '600',
                '700': '700',
                '800': '800',
            },
        },
    },
    plugins: [],
};
