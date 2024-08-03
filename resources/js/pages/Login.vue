<template>
  <Theme />
  <div class="flex justify-center items-center h-screen">
    <form @submit.prevent="login()" class="w-[25em] border rounded-lg dark:border-gray-700 p-6">
      <label class="label">Username</label>
      <input type="text" class="input mb-3">
      <label class="label">Password</label>
      <input type="password" class="input">
      <button type="submit"
        class="mt-5 w-full bg-slate-800  font-medium text-white dark:bg-slate-200  dark:text-slate-800 text-sm py-[11px] rounded-lg disabled:opacity-80" :disabled="loggingIn">
        <span v-if="!loggingIn">Login</span>
        <v-icon name="la-spinner-solid" class="animate-spin" v-if="loggingIn"></v-icon>
      </button>
    </form>
  </div>
</template>
<script setup>
import { ref } from 'vue'
const loggingIn = ref(false)
const user = ref({
  name: '',
  password: ''
})

async function login() {  
  loggingIn.value = true
}
</script>