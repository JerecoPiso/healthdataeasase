// import { createRouter, createWebHistory  } from 'vue-router'
// import Login from '@/pages/Login.vue'
// const router = createRouter({
//     history: createWebHistory(),
//     routes: [
//         {
//             path: '/healthdataease/public/healthdataease/public/',
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
                    path: '/healthdataease/public/',
                    name: 'dashboard',
                    component: () => import('@/views/Dashboard.vue')
                },
                {
                    path: '/healthdataease/public/profile/personal',
                    name: 'personal',
                    component: () => import('@/views/pages/profile/Personal.vue')
                },
               
                {
                    path: '/healthdataease/public/profile/household',
                    name: 'household',
                    component: () => import('@/views/pages/profile/Household.vue')
                },
                {
                    path: '/healthdataease/public/profile/pregnancy',
                    name: 'pregnancy',
                    component: () => import('@/views/pages/profile/PregnancyForm.vue')
                },
                {
                    path: '/healthdataease/public/profile/viewprofile/:id',
                    name: 'viewprofile',
                    component: () => import('@/views/pages/profile/ViewProfile.vue')
                },
                // admin
                {
                    path: '/healthdataease/public/administrator/users',
                    name: 'users',
                    component: () => import('@/views/pages/administrator/Users.vue')
                },
                {
                    path: '/healthdataease/public/administrator/reports',
                    name: 'reports',
                    component: () => import('@/views/pages/reports/index.vue')
                },
                {
                    path: '/healthdataease/public/administrator/logs',
                    name: 'logs',
                    component: () => import('@/views/pages/administrator/Logs.vue')
                },
                // health
                {
                    path: '/healthdataease/public/health/vaccination',
                    name: 'health',
                    component: () => import('@/views/pages/health/Vaccination.vue')
                },
            ]
        },
        {
            path: '/healthdataease/public/auth/login',
            name: 'login',
            component: () => import('@/views/pages/auth/Login.vue')
        },

          //reports
        //   {
        //     path: '/healthdataease/public/report/household',
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
