import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import './components/header/Header.vue' // مسیر کامل بده
import { createPinia } from 'pinia'
import { createHead } from '@vueuse/head'; // پلاگین VueUse Head

const pinia = createPinia()



createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        const layouts = import.meta.glob('./Layouts/**/*.vue', { eager: true })

        const page = pages[`./Pages/${name}.vue`]
        page.default.layout = layouts['./Layouts/MainLayout.vue'].default
        return page
    },

    setup({ el, App, props, plugin }) {
        const head = createHead();
        const app = createApp({ render: () => h(App, props) })
        app.use(plugin)
        app.use(pinia)
        app.use(head)
        app.mount(el)
    },
})
