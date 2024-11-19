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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'santa-maroon': '#A60328',
                'santa-green': '#087460',
                'santa-white': '#FFFFFF',
                'santa-gold': '#F4A41D',
                'teal': '#087460',
                'blue': '##2b6cb0',
            },
        },
    },
    plugins: [],
};
