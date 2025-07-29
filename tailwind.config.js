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
                primary: '#FF6B6B',
                secondary: '#4ECDC4',
                accent: '#FFD166',
                dark: '#1A535C',
            },
            fontFamily: {
                sans: ['Figtree', 'sans-serif'],
            },
        },
    },
    
    plugins: [require('@tailwindcss/forms')],
};