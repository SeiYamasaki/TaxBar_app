import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/*.blade.php',
        './resources/views/themes/**/*.blade.php',
        './resources/views/taxbarviews/**/*.blade.php',
        './resources/views/taxminivideos/**/*.blade.php',
        './resources/views/layouts/**/*.blade.php',
        './resources/views/components/**/*.blade.php',
        './resources/views/auth/**/*.blade.php',
        './resources/views/profile/**/*.blade.php',
        './resources/views/inquiry/**/*.blade.php',
        './resources/views/faqs/**/*.blade.php',
        './resources/views/pricing/**/*.blade.php',
        './resources/views/livewire/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
