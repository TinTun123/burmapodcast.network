/** @type {import('tailwindcss').Config} */
// eslint-disable-next-line no-undef
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}"
  ],
  theme: {
    extend: {
      fontSize : {
        'xx-sm' : '0.597rem',
        'x-sm' : '0.694rem',
        'sm' : '0.833rem',
        'base' : '1rem',
        'lg' : '1.2rem',
        'x-lg' : '1.44rem',
        
      },
      screens : {
        'phone' : '270px',
        'tablet' : '600px',
        'lg-tablet' : '905px',
        'laptop' : '1000px',
        'desktop' : '1440'
      },
      boxShadow : {
        'card-shadow' : '2px 2px 20px 0px rgba(0, 0, 0, 0.40)',
        'icon-shadow' : '0px 4px 10px 0px rgba(0, 56, 255, 1)',
        'img-shadow' : '0px 6px 20px 0px rgba(0, 0, 0, 0.80)'
      }
    },
  },
  plugins: [],
}

