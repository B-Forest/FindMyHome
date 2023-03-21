/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        'main': '#2F52E0',
        'myblack' : '#1D1E18',
        'secondary': '#DBE9EE',
      },
      fontFamily: {
          'lato': ['Lato', 'sans-serif'],
          'fasthand': ['Fasthand', 'serif'],
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
