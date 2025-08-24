import { createSSRApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { createHead } from '@vueuse/head'; // ✅ Add this import
import { createPinia } from 'pinia'; // ✅ Add this import

createServer(page =>
    createInertiaApp({
        page,
        render: renderToString,
        resolve: name => {
            const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
            const layouts = import.meta.glob('./Layouts/**/*.vue', { eager: true });

            const page = pages[`./Pages/${name}.vue`];
            page.default.layout = layouts['./Layouts/MainLayout.vue'].default;
            return page;
        },
        setup({ App, props, plugin }) {
            // ✅ CRITICAL FIX: Create new instances for each request
            const head = createHead();
            const pinia = createPinia();

            return createSSRApp({
                render: () => h(App, props),
            })
                .use(plugin)
                .use(head) // ✅ Use the new head instance
                .use(pinia); // ✅ Use the new pinia instance
        },
    }),
);
