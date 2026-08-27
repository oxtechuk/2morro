import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Cairo', ...defaultTheme.fontFamily.sans],
                cairo: ['Cairo', 'sans-serif'],
            },
            colors: {
                brand: {
                    navy: '#1360e2',
                    'navy-dark': '#0B1E48',
                    blue: '#2563EB',
                    'blue-light': '#3B82F6',
                    'blue-soft': '#EBF5FE',
                    coral: '#EF4444',
                    'coral-pink': '#F43F5E',
                    'coral-soft': '#FEF2F2',
                    turquoise: '#14B8A6',
                    'turquoise-soft': '#F0FDFA',
                    amber: '#F59E0B',
                    'amber-soft': '#FFFBEB',
                    purple: '#8B5CF6',
                    'purple-soft': '#F5F3FF',
                    green: '#F97316 ',
                    'green-soft': '#ECFDF5',
                }
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
                '4xl': '2rem',
                '5xl': '2.5rem',
            },
            boxShadow: {
                'soft': '0 4px 20px -2px rgba(16, 42, 99, 0.06)',
                'soft-lg': '0 10px 30px -4px rgba(16, 42, 99, 0.1)',
                'card': '0 2px 12px 0 rgba(0, 0, 0, 0.04)',
                'card-hover': '0 12px 28px -4px rgba(16, 42, 99, 0.12)',
            }
        },
    },

    plugins: [forms],
};

