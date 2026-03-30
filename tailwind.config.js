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
              "surface-dim": "#dcd9d9",
              "error": "#ba1a1a",
              "on-tertiary-fixed-variant": "#434750",
              "background": "#fbf9f8",
              "primary": "#3e0007",
              "on-tertiary": "#ffffff",
              "on-secondary": "#ffffff",
              "surface-container-highest": "#e4e2e1",
              "primary-container": "#620814",
              "surface-variant": "#e4e2e1",
              "surface-container-high": "#eae8e7",
              "surface-container": "#f0eded",
              "on-surface": "#1b1c1c",
              "surface-container-lowest": "#ffffff",
              "on-secondary-container": "#004270",
              "on-background": "#1b1c1c",
              "secondary-container": "#63b0fd",
              "on-tertiary-fixed": "#181c23",
              "surface-tint": "#a33b3f",
              "surface-bright": "#fbf9f8",
              "on-primary-container": "#eb7172",
              "primary-fixed": "#ffdad8",
              "outline": "#8a7170",
              "on-tertiary-container": "#9396a1",
              "inverse-primary": "#ffb3b1",
              "secondary-fixed-dim": "#9dcaff",
              "tertiary": "#161a22",
              "outline-variant": "#ddc0bf",
              "inverse-on-surface": "#f3f0f0",
              "on-secondary-fixed-variant": "#00497c",
              "on-primary": "#ffffff",
              "surface": "#fbf9f8",
              "inverse-surface": "#303030",
              "on-primary-fixed": "#410008",
              "error-container": "#ffdad6",
              "tertiary-fixed-dim": "#c3c6d1",
              "secondary-fixed": "#d1e4ff",
              "primary-fixed-dim": "#ffb3b1",
              "tertiary-container": "#2b2f37",
              "on-primary-fixed-variant": "#832329",
              "on-error-container": "#93000a",
              "on-surface-variant": "#564241",
              "on-secondary-fixed": "#001d35",
              "on-error": "#ffffff",
              "surface-container-low": "#f6f3f2",
              "secondary": "#0061a2",
              "tertiary-fixed": "#dfe2ed"
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
