<script setup>
import { ref} from 'vue'
import AppConfigurator from '@/layout/AppConfigurator.vue';
import { useLayout } from '@/layout/composables/layout';

const { toggleDarkMode, isDarkTheme } = useLayout();
const color = ref(false)
</script>

<template>
    <div class="fixed flex gap-4 top-8 right-8">
        <Button type="button" @click="toggleDarkMode" rounded
            :icon="{ 'pi pi-moon': isDarkTheme, 'pi pi-sun': !isDarkTheme }" severity="secondary" />
        <div class="relative">
            <!-- v-styleclass="{ selector: '@next', enterFromClass: 'hidden', enterActiveClass: 'animate-scalein', leaveToClass: 'hidden', leaveActiveClass: 'animate-fadeout', hideOnOutsideClick: true }" -->
            <Button @click="color = color ? false : true"
                
                type="button" rounded>
                <v-icon name="co-color-palette"></v-icon>
            </Button>
            <AppConfigurator v-if="color" />
        </div>
    </div>
</template>
