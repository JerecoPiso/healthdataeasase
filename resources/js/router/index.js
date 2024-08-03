import { createRouter, createWebHistory  } from 'vue-router'
import Login from '@/pages/Login.vue'
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/healthdataeasase/public/',
            name: 'Login',
            component: Login
        },
    ]
})

export default router;