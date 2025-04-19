import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { ZiggyVue } from 'ziggy-js';
import { Ziggy } from './ziggy'
import '../css/app.css'

// Optional: show progress bar during page loads
InertiaProgress.init()

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue')

    const page = pages[`./Pages/${name}.vue`]
    if (!page) {
      throw new Error(`Unknown page: ${name}. Check /resources/js/Pages/ for ${name}.vue`)
    }

    return page()
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy) // 👈 makes `route()` globally available
      .mount(el)
  },
})
