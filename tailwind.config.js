/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Livewire/**/*.php",
  ],
  safelist: [
    'bg-yellow-400',
    'bg-yellow-500',
    'bg-yellow-600',
    'from-yellow-500',
    'to-yellow-600',
    'to-orange-500',
    'bg-gray-300',
    'bg-orange-400',
    'from-gray-400',
    'to-gray-500',
    'from-orange-600',
    'to-red-600',
    'from-blue-600',
    'to-purple-600'
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        'gilroy': ['Gilroy', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        'sans': ['Gilroy', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      animation: {
        'marquee': 'marquee 30s linear infinite',
      },
      keyframes: {
        marquee: {
          '0%': { transform: 'translateX(100%)' },
          '100%': { transform: 'translateX(-100%)' },
        }
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/line-clamp')
  ],
}