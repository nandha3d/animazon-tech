const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'animazon-black':     '#0A0A0F',
                'animazon-navy':      '#0F1020',
                'animazon-blue':      '#2563EB',
                'animazon-purple':    '#7C3AED',
                'animazon-highlight': '#38BDF8',
                'animazon-white':     '#F8FAFC',
                'animazon-muted':     '#94A3B8',
                'animazon-border':    '#1E293B',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Montserrat', 'Poppins', 'sans-serif'],
                body: ['Inter', 'sans-serif'],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
