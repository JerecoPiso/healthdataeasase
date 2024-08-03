<template>
  <button type="button" @click="toggleDarkMode()" class="text-slate-800 dark:text-slate-300 fixed right-3 bottom-5">
    <v-icon name="md-darkmode" v-if="darkMode" scale="1.2"></v-icon>
    <v-icon name="md-lightmode" v-if="!darkMode" scale="1.2"></v-icon>
  </button>
</template>
<script setup>
import { ref, onMounted } from 'vue';
const darkMode = ref(false);
onMounted(() => {
  if (
    localStorage.getItem('color-theme') === 'dark' ||
    (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
  ) {
    darkMode.value = true
    document.documentElement.classList.add('dark')
  } else {
    darkMode.value = false
    document.documentElement.classList.remove('dark')
  }
})
function toggleDarkMode() {
  if (localStorage.getItem('color-theme')) {
    if (localStorage.getItem('color-theme') === 'light') {
      darkMode.value = true
      document.documentElement.classList.add('dark')
      localStorage.setItem('color-theme', 'dark')
    } else {
      darkMode.value = false
      document.documentElement.classList.remove('dark')
      localStorage.setItem('color-theme', 'light')
    }
  } else {
    if (document.documentElement.classList.contains('dark')) {
      darkMode.value = true
      document.documentElement.classList.remove('dark')
      localStorage.setItem('color-theme', 'light')
    } else {
      darkMode.value = false
      document.documentElement.classList.add('dark')
      localStorage.setItem('color-theme', 'dark')
    }
  }
}
</script>