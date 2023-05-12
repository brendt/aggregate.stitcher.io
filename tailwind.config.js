const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },


    safelist: [
        'bg-red-100',
        'hover:bg-red-200',
        'border-red-400',
        'hover:border-red-300',
        'bg-green-100',
        'hover:bg-green-200',
        'border-green-400',
        'hover:border-green-300',
        'bg-blue-100',
        'hover:bg-blue-200',
        'border-blue-400',
        'hover:border-blue-300',
        'bg-yellow-100',
        'hover:bg-yellow-200',
        'border-yellow-400',
        'hover:border-yellow-300',
        'bg-purple-100',
        'hover:bg-purple-200',
        'border-purple-400',
        'hover:border-purple-300',
    ],

    plugins: [require('@tailwindcss/forms')],
};
