import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.jsx'], // Only app.jsx belongs here!
      refresh: true,
    }),
    react()
  ],
  server: {
    watch: {
      ignored: ['**/storage/**'],
    },
  },
})