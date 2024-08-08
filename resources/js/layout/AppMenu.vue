<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        label: 'Home',
        items: [{ label: 'Dashboard', icon: 'ri-dashboard-line', to: '/healthdataeasase/public/' }]
    },
    {
        label: 'Profile',
        items: [
            {
                label: 'Household',
                icon: 'bi-house-door-fill',
                to: '/healthdataeasase/public/profile/household'
            },
            {
                label: 'Personal',
                icon: 'bi-person-circle',
                to: '/healthdataeasase/public/profile/personal'
            },
            // {
            //     label: 'Health',
            //     icon: 'md-healthandsafety-sharp',
            //     to: '/healthdataeasase/public/profile/health'
            // },
          
            {
                label: 'Pregnancy Form',
                icon: 'md-pregnantwoman',
               to: '/healthdataeasase/public/profile/pregnancy'
            },
        ]
    },
    {
        label: 'Admin',
        items: [
            {
                label: 'Users',
                icon: 'fa-users-cog',
                to: '/healthdataeasase/public/administrator/users'
            }
        ]
    },

]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>