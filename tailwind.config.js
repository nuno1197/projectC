import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            backgroundImage:{
                'ball_court': "url('/resources/images/bg_court2.jpg')",
                'login_court': "url('/resources/images/login_court.jpg')",
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            }
        },
    },

    plugins: [forms],
};
