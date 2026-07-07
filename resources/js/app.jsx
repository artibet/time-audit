import '@fontsource/roboto/300.css'
import '@fontsource/roboto/400.css'
import '@fontsource/roboto/500.css'
import '@fontsource/roboto/700.css'

import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client';
import { router } from '@inertiajs/react';
import NProgress from 'nprogress';

const appName = import.meta.env.VITE_APP_NAME || 'Aneser';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true })
    return pages[`./Pages/${name}.jsx`].default
  },
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />)
  },
  progress: false
});

// Custom progress indicator
// InertiaProgress.init({ color: '#4B5563' });
router.on('start', () => {
  NProgress.start()
})
router.on('finish', () => {
  NProgress.done()
})