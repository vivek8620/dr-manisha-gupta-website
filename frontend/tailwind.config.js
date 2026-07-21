module.exports = {
  content: [
    './*.php',
    './components/**/*.php',
    './data/**/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
        display: ['Fraunces', 'serif'],
        fraunces: ['Fraunces', 'serif'],
      },
      colors: {
        brand: {
          teal: '#0eadae',
          tealDk: '#0a9596',
          navy: '#042A3F',
          navyMd: '#062D42',
          sky: '#58A9E2',
          skyLt: '#74C2F9',
          blue: '#1D6E9B',
          dark: '#062D42',
          gold: '#FBBF24',
        },
      },
      keyframes: {
        riseIn: {
          from: { opacity: '0', transform: 'translateY(24px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
        slideDown: {
          from: { opacity: '0', transform: 'translateY(-12px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
      },
      animation: {
        rise: 'riseIn 0.55s cubic-bezier(.22,1,.36,1) both',
        'rise-1': 'riseIn 0.55s cubic-bezier(.22,1,.36,1) 0.05s both',
        'rise-2': 'riseIn 0.55s cubic-bezier(.22,1,.36,1) 0.15s both',
        'rise-3': 'riseIn 0.55s cubic-bezier(.22,1,.36,1) 0.25s both',
        slideDown: 'slideDown 0.35s cubic-bezier(.22,1,.36,1) both',
      },
    },
  },
  plugins: [],
};
