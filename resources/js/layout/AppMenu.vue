<template>
    <ul class="layout-menu" v-if="!isLoading">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator && ((_role === '0') || (_role == '1' && item.label != 'Admin'))"
                :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import VueCookies  from 'vue-cookies'
import AppMenuItem from './AppMenuItem.vue';
const _role = ref('0')
const isLoading = ref(true)
onMounted(() => {
    if (VueCookies.get('_role')) {
        _role.value = VueCookies.get('_role')
    }
    // alert(typeof VueCookies.get('_role'))
    isLoading.value = false
})
const model = ref([
    {
        label: 'Home',
        items: [{ label: 'Dashboard', icon: 'ri-dashboard-line', to: '/healthdataease/public/' }]
    },
    {
        label: 'Profile',
        items: [
            {
                label: 'Household',
                icon: 'bi-house-door-fill',
                to: '/healthdataease/public/profile/household'
            },
            {
                label: 'Personal & Health',
                icon: 'bi-person-circle',
                to: '/healthdataease/public/profile/personal'
            },


            {
                label: 'Pregnancy',
                icon: 'md-pregnantwoman',
                to: '/healthdataease/public/profile/pregnancy'
            },

        ]
    },
    {
        label: 'Others',
        items: [
            {
                label: 'Vaccination',
                icon: 'md-vaccines',
                to: '/healthdataease/public/health/vaccination'
            },
        ]
    },
    {
        label: 'Admin',
        items: [
            {
                label: 'Users',
                icon: 'fa-users-cog',
                to: '/healthdataease/public/administrator/users'
            },
            {
                label: 'Reports',
                icon: 'hi-document-report',
                to: '/healthdataease/public/administrator/reports'
            },
            {
                label: 'Logs',
                icon: 'co-logstash',
                to: '/healthdataease/public/administrator/logs'
            },
        ]
    },

]);
</script>
<style lang="scss" scoped></style>