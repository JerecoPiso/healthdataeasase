// import { createRouter, createWebHistory  } from 'vue-router'
// import Login from '@/pages/Login.vue'
// const router = createRouter({
//     history: createWebHistory(),
//     routes: [
//         {
//             path: '/healthdataeasase/public/healthdataeasase/public/',
//             name: 'Login',
//             component: Login
//         },
//     ]
// })

// export default router;

import AppLayout from '@/layout/AppLayout.vue';
import { createRouter, createWebHistory } from 'vue-router';
import VueCookies from 'vue-cookies';
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '',
            component: AppLayout,
            children: [
                {
                    path: '/healthdataeasase/public/',
                    name: 'dashboard',
                    component: () => import('@/views/Dashboard.vue')
                },
                {
                    path: '/healthdataeasase/public/profile/personal',
                    name: 'personal',
                    component: () => import('@/views/pages/profile/Personal.vue')
                },
               
                {
                    path: '/healthdataeasase/public/profile/household',
                    name: 'household',
                    component: () => import('@/views/pages/profile/Household.vue')
                },
                {
                    path: '/healthdataeasase/public/profile/pregnancy',
                    name: 'pregnancy',
                    component: () => import('@/views/pages/profile/PregnancyForm.vue')
                },
                // admin
                {
                    path: '/healthdataeasase/public/administrator/users',
                    name: 'users',
                    component: () => import('@/views/pages/administrator/Users.vue')
                },
                {
                    path: '/healthdataeasase/public/administrator/reports',
                    name: 'reports',
                    component: () => import('@/views/pages/reports/index.vue')
                },

                // health
                {
                    path: '/healthdataeasase/public/health/vaccination',
                    name: 'health',
                    component: () => import('@/views/pages/health/Vaccination.vue')
                },
            ]
        },
        {
            path: '/healthdataeasase/public/auth/login',
            name: 'login',
            component: () => import('@/views/pages/auth/Login.vue')
        },

          //reports
        //   {
        //     path: '/healthdataeasase/public/report/household',
        //     name: 'householdreport',
        //     component: () => import('@/views/pages/reports/household.vue')
        // },
     
    ]
});
router.beforeEach(async (to, from, next) => {
    if (VueCookies.get('authenticated')) {
    
        VueCookies.set("authenticated", true)
        if (to.name === 'login') {
            next({ name: 'dashboard' })
        } else {
         
            next();
        }
    } else {
        if (to.name !== 'login') {
            next({ name: 'login' });
        } else {
            next()
        }
    }
})
export default router;
