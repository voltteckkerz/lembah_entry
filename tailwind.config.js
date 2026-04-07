import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
              "surface-container-highest": "#e4e2e1",
              "background": "#fbf9f8",
              "surface-variant": "#e4e2e1",
              "on-secondary-fixed": "#001d35",
              "on-primary-container": "#eb7172",
              "surface-dim": "#dcd9d9",
              "on-tertiary-fixed-variant": "#434750",
              "on-surface-variant": "#564241",
              "surface-container-lowest": "#ffffff",
              "primary-container": "#620814",
              "surface-tint": "#a33b3f",
              "secondary-fixed-dim": "#9dcaff",
              "primary": "#3e0007",
              "on-primary-fixed-variant": "#832329",
              "surface-container-low": "#f6f3f2",
              "tertiary-container": "#2b2f37",
              "secondary-container": "#63b0fd",
              "primary-fixed-dim": "#ffb3b1",
              "outline-variant": "#ddc0bf",
              "surface-bright": "#fbf9f8",
              "outline": "#8a7170",
              "primary-fixed": "#ffdad8",
              "on-secondary": "#ffffff",
              "secondary": "#0061a2",
              "on-primary": "#ffffff",
              "tertiary": "#161a22",
              "on-primary-fixed": "#410008",
              "on-tertiary-container": "#9396a1",
              "on-secondary-container": "#004270",
              "tertiary-fixed": "#dfe2ed",
              "surface-container-high": "#eae8e7",
              "surface-container": "#f0eded",
              "on-error": "#ffffff",
              "error": "#ba1a1a",
              "inverse-primary": "#ffb3b1",
              "on-secondary-fixed-variant": "#00497c",
              "inverse-surface": "#303030",
              "surface": "#fbf9f8",
              "on-surface": "#1b1c1c",
              "error-container": "#ffdad6",
              "on-tertiary": "#ffffff",
              "on-error-container": "#93000a",
              "tertiary-fixed-dim": "#c3c6d1",
              "on-background": "#1b1c1c",
              "inverse-on-surface": "#f3f0f0"
            },
            fontFamily: {
              "headline": ["Plus Jakarta Sans", "sans-serif"],
              "body": ["Manrope", "sans-serif"],
              "label": ["Manrope", "sans-serif"],
              sans: ['Manrope', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
