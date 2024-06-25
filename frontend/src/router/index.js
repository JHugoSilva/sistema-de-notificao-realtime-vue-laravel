import { useAuthStore } from "@/stores/authStore"
import { createRouter, createWebHistory } from "vue-router"


const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../views/HomeView.vue')
    },
    {
        path: '',
        name: 'timeline',
        component: () => import('../views/dashboard/HomeView.vue'),
        children: [
            {
                path: '/timeline',
                name: 'dashboard.timeline',
                component: () => import('../views/dashboard/TimeLine.vue')
            },
            {
                path: '/settings',
                name: 'dashboard.settings',
                component: () => import('../views/dashboard/Settings.vue')
            },
            {
                path: '/notifications',
                name: 'dashboard.notifications',
                component: () => import('../views/dashboard/Notifications.vue')
            }
        ],
        beforeEnter(to, from , next){
            const store = useAuthStore()
            if (store.isLoggedIn) {
                next()
            } else {
                next('/login')
            }
        }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../views/auth/LoginView.vue'),
        beforeEnter(to, from , next){
            const store = useAuthStore()
            if (store.isLoggedIn) {
                next('/timeline')
            } else {
                next()
            }
        }
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../views/auth/RegisterView.vue')
    }
]

const router =  createRouter({
    history: createWebHistory(),
    routes
})

export default router