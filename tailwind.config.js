import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode:"class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            colors: {
                primary: "#0672E8",
                primaryLight: "#D0E1FA",
                secondary: "#F7F7F7",
                neutralDark: "#1E1E1E",
                neutralGray: "#898989",
                neutralGray2: "#E6E6EB",
                neutralLight: "#0b0b0b",
                Dangerneutral: "#D20000",
            },
            fontFamily: {
                urbanist: ['Urbanist', 'sans-serif'],
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
