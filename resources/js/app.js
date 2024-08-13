import './bootstrap';
// import { createApp } from 'vue';
// import App from './App.vue'
// import router from './router';
// import theme from './components/theme.vue';
// import PrimeVue from 'primevue/config';
// import { OhVueIcon, addIcons } from "oh-vue-icons";
// import { LaSpinnerSolid , MdDarkmode, MdLightmode } from "oh-vue-icons/icons";

// addIcons(LaSpinnerSolid , MdDarkmode, MdLightmode );
// const app = createApp(App)


// app.use(PrimeVue, {

// });
// app.use(router)
// app.component("v-icon", OhVueIcon)
// app.component("Theme", theme)
// app.mount("#app")
import '@/assets/styles.scss';
import '@/assets/tailwind.css';
import { createApp } from 'vue';

import App from './App.vue';
import router from './router';
import { OhVueIcon, addIcons } from "oh-vue-icons";
import Aura from '@primevue/themes/aura';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import VueCookies from 'vue-cookies';
import InputText from 'primevue/inputtext';
import Spinner from './components/Spinner.vue';
import ConfirmDialog from 'primevue/confirmdialog';

import Button from 'primevue/button';
import Password from 'primevue/password';
import Dialog from 'primevue/dialog';
import DatePicker from 'primevue/datepicker';
import Select from 'primevue/select';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputMask from 'primevue/inputmask';
import Paginator from 'primevue/paginator';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import SelectButton from 'primevue/selectbutton';
import Toast from 'primevue/toast';
import StyleClass from 'primevue/styleclass';
import Tooltip from 'primevue/tooltip';
import InputNumber from 'primevue/inputnumber';
import Chart from 'primevue/chart';
import Card from 'primevue/card';
import Checkbox from 'primevue/checkbox';
import Textarea from 'primevue/textarea';

import {
    BiTrash, BiPersonPlusFill, BiHouseDoorFill, BiShieldLock, BiPersonCircle, CoBaby , CoUserFemale, CoColorPalette,
    FaSearch, FaSpinner, FaUserPlus, FaUsersCog, FaEdit,FaUserShield , FaHouseUser, LaSpinnerSolid,MdSupervisedusercircleRound , MdPregnantwoman, MdDarkmode,
    MdLightmode, MdVaccines, MdHealthandsafetySharp, RiDashboardLine, RiHealthBookLine
} from "oh-vue-icons/icons";
addIcons(BiTrash, BiPersonPlusFill, BiHouseDoorFill, BiShieldLock, BiPersonCircle, CoUserFemale, CoBaby , CoColorPalette,
    FaSearch, FaSpinner, FaUserPlus, FaUsersCog, FaEdit,FaUserShield , FaHouseUser, LaSpinnerSolid,MdSupervisedusercircleRound , MdPregnantwoman, MdDarkmode,
    MdLightmode, MdVaccines, MdHealthandsafetySharp, RiDashboardLine, RiHealthBookLine);
const app = createApp(App);
app.component('Chart', Chart);
app.component('Card', Card);

app.component('DataTable', DataTable);
app.component('ConfirmDialog', ConfirmDialog)
app.component('Checkbox', Checkbox)
app.component('IconField', IconField)
app.component('InputIcon', InputIcon)
app.component('Column', Column);
app.component('InputText', InputText);
app.component('Button', Button);
app.component('Password', Password);
app.component('Dialog', Dialog);
app.component('InputNumber', InputNumber);
app.component('DatePicker', DatePicker)
app.component("Select", Select)
app.component("InputMask", InputMask)
app.component("Paginator", Paginator)
app.component("SelectButton", SelectButton)
app.component("Toast", Toast)
app.component('Spinner', Spinner)

app.component('Textarea', Textarea)

app.directive('tooltip', Tooltip);

app.directive('styleclass', StyleClass);
app.use(router);
app.use(VueCookies, {
    expires: '4h',
    path: '/',
    domain: '',
    secure: false,
    sameSite: 'Lax'
})
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            darkModeSelector: '.app-dark'
        }
    }
});

app.component("v-icon", OhVueIcon)
app.use(ToastService);
app.use(ConfirmationService);

app.mount('#app');
