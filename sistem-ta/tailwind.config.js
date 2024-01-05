/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: { 
        "inter": ['Inter', 'sans-serif'] 
    } ,
    },
  },
  plugins: [require('flowbite/plugin')],
}