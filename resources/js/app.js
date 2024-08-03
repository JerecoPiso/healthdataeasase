// import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'
import router from './router';
import theme from './components/theme.vue';
import PrimeVue from 'primevue/config';
import { OhVueIcon, addIcons } from "oh-vue-icons";
import { LaSpinnerSolid , MdDarkmode, MdLightmode } from "oh-vue-icons/icons";

addIcons(LaSpinnerSolid , MdDarkmode, MdLightmode );
const app = createApp(App)


app.use(PrimeVue, {
   
});
app.use(router)
app.component("v-icon", OhVueIcon)
app.component("Theme", theme)
app.mount("#app")