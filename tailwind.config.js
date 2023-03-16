/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
          sans: ["Inter", "sans-serif"],
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
