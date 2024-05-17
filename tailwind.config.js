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
                'ball_court': "url('/resources/images/background_images/bg_court2.jpg')",
                'login_court': "url('/resources/images/background_images/login_court.jpg')",
                'curves' : "url('/resources/images/image.svg')",
                'danger_stripes': "url('/resources/images/background_images/danger_stripe.svg')"
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors:{
                'rich_black' : "#111827",
                'pacific_cyan':"#0EB1D2",
                'flax' : "#E9D985",
                'orange_fruit' : "#E57A44",
                'rose_quartz' : "#A39BA8"
            }
        },
    },
    plugins: [
        forms
    ],
};
