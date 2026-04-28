/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./arsip.html",
    "./belajar.html",
    "./belajar2.html",
    "./Tugas1.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        'plus-jakarta': ['Plus Jakarta Sans', 'sans-serif'],
      },
      colors: {
        primary: {
          50: '#f0f9ff',
          500: '#0ea5e9',
          600: '#0284c7',
          900: '#0c4a6e',
        },
        secondary: {
          50: '#f8fafc',
          500: '#64748b',
          600: '#475569',
          900: '#1e293b',
        }
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
      },
    },
  },
  plugins: [],
}