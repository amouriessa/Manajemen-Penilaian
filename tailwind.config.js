import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                // UI default (body, form, tabel)
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],

                // UI modern / panel / secondary text
                ui: ["Manrope", ...defaultTheme.fontFamily.sans],

                // Branding / headline kuat (uppercase cocok)
                display: ["Koulen", ...defaultTheme.fontFamily.sans],

                // Judul elegan / institusional
                serif: ["Cormorant", ...defaultTheme.fontFamily.serif],
            },
            colors: {
                indigo: {
                    100: "#D6E3F5",
                    300: "#8FA8CC",
                    600: "#2D3F63",
                    700: "#1E2A40",
                },
                white: "#FDFAF5",
                red: {
                    100: "#F5E8E6",
                    600: "#B5655A",
                    700: "#8B4040",
                },
                yellow: {
                    100: "#F7EDDA",
                    300: "#E8C990",
                    500: "#D4A355",
                    600: "#B07833",
                    700: "#7A4F1A",
                },
                green: {
                    100: "#EAF2EE",
                    600: "#7A9E8A",
                }
            }
        },
    },

    plugins: [forms],
};
