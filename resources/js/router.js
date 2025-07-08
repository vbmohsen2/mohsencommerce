
import { createRouter, createWebHistory } from 'vue-router'

// importهای فعلی شما باقی می‌ماند
// حالا مسیرهای مربوط به کاربر رو هم اضافه می‌کنیم:
const UserPanel = () => import('./components/user/UserPanel.vue')
const Dashboard = () => import('./components/user/Dashboard.vue')
const Addresses = () => import('./components/user/Addresses.vue')
const Orders = () => import('./components/user/Orders.vue')

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
    },

    // ✅ مسیرهای پنل کاربر
    {
        path: '/user',
        component: UserPanel,
        children: [
            { path: '', redirect: '/user/dashboard' },
            { path: 'dashboard', component: Dashboard },
            { path: 'addresses', component: Addresses },
            { path: 'orders', component: Orders }
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
