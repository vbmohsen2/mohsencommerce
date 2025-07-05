import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
        path: '/admin/blog/posts',
        name: 'posts.list',
        component: () => import('./components/admin/blog/blogPosts.vue')
    },
    {
        path: '/admin/blog/posts/edit/:slug',
        name: 'posts.edit',
        component: () => import('./components/admin/blog/editPost.vue')
    },
    {
        path: '/admin/blog/posts/edit/newpost',
        name: 'posts.new',
        component: () => import('./components/admin/blog/newPost.vue')
    },
    {
        path: '/admin/orders',
        name: 'orders',
        component: () => import('./components/admin/orders/orders.vue')
    },
    {
        path: '/admin/orders/:id',
        name: 'orderDetails',
        component: () => import('./components/admin/orders/OrderDetails.vue')
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
