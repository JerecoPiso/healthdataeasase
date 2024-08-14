<template>
     <main class=" dark:bg-gray-900 h-screen">
        <RouterView />
    </main>
</template>
<script setup>
import { onMounted } from 'vue';
import {  useLayout } from '@/layout/composables/layout';
const { toggleDarkMode } = useLayout();

onMounted(() => {
    if(localStorage.getItem('color-theme') == 'dark'){
        // document.documentElement.classList.add('app-dark');
        // layoutConfig.darkTheme = true
        toggleDarkMode()
    }
})
import { RouterView } from 'vue-router';
</script>