/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    
    darkMode: 'class', // Asegúrate de que esto esté configurado como 'class'
    
    theme: {
        extend: {
            colors: {
                primary: '#7C444F',
                secondary: '#9F5255',
                accent: '#FF6F61',
                dark: '#F39E60',
            },
            fontFamily: {
                sans: ['Figtree', 'sans-serif'],
            },
        },
    },
    
    plugins: [require('@tailwindcss/forms')],
};