/** @type {import('tailwindcss').Config} */

const { colors: defaultColors } = require("tailwindcss/defaultTheme");

const colors = {
    ...defaultColors,
    ...{
        "custom-green": "#46D18F",
        "custom-blue": "#0084D1",
        "custom-slate": {
            100: "#F8F8F8",
            200: "#F5F5F5",
            300: "#E4E4E4",
            900: "#343434",
        },
    },
};

module.exports = {
    content: ["./resources/**/*.{html,js,jsx}"],
    theme: {
        extend: {
            colors: colors,
        },
    },
    plugins: [],
};

