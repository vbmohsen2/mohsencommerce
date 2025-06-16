import { createRouter, createWebHistory } from 'vue-router'

import blogPosts from './components/admin/blog/blogPosts.vue'
import EditPost from './components/admin/blog/editPost.vue'
import NewPost from  './components/admin/blog/newPost.vue'
import orders from './components/admin/orders/orders.vue'
import orderDetails from './components/admin/orders/OrderDetails.vue'

const routes = [
    {
        path: '/admin/blog/posts',
        name: 'posts.list',
        component: blogPosts
    },
    {
        path: '/admin/blog/posts/edit/:slug',
        name: 'posts.edit',
        component: EditPost
    },
    {
        path: '/admin/blog/posts/edit/newpost',
        name: 'posts.new',
        component: NewPost
    },
    {
        path: '/admin/orders',
        name: 'orders',
        component: orders

    },
    {
        path: '/admin/orders/:id',
        name: 'orderDetails',
        component: orderDetails

    }



]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
