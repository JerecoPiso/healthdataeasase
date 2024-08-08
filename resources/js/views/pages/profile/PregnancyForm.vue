<template>
    <div class="card flex flex-col gap-4" v-if="!isLoading">

        <Button label="Show" class="w-[4em]" @click="addModalVisible = true" ><v-icon name="bi-person-plus-fill" scale="1.2"></v-icon></Button>
        <DataTable :value="pregnancies" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
           
        </DataTable>

        <Dialog v-model:visible="addModalVisible" maximizable modal header="Pregnancy Form" position="top" class="md:w-3/6 w-full"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="insertPersonalProfile()">
                <div class="grid grid-cols-3 gap-2">
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Post-Partum</label>
                        <InputText class="w-full" v-model="pregnancyInfo.post_partum" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Family Planning</label>
                        <Select v-model="pregnancyInfo.family_planning" editable  optionValue="name" :options="family_planning"
                        optionLabel="name" placeholder="Select family planning" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Type of Delivery</label>
                        <Select v-model="pregnancyInfo.type_of_delivery" editable  optionValue="name" :options="type_of_delivery"
                        optionLabel="name" placeholder="Select type of delivery" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">LMP</label>
                        <InputText class="w-full" v-model="pregnancyInfo.lmp" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">EDC</label>
                        <InputText class="w-full" v-model="pregnancyInfo.edc" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Pregnant GP</label>
                        <InputText class="w-full" v-model="pregnancyInfo.gp" />
                    </div>
                </div>
                <Button label="Submit" type="submit" class="w-full mt-2" />
            </form>

        </Dialog>
    
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useToast } from "primevue/usetoast";
import { family_planning, type_of_delivery } from '@/service/SelectDatas.js'
import VueCookies from 'vue-cookies';

const pregnancyInfo = ref({
    id: '',
    personal_profile_id: '',
    post_partum: '',
    family_planning: '',
    type_of_delivery: '',
    lmp: '',
    edc: '',
    gp: ''
})
const isLoading = ref(true)

const pregnancies = ref([])
// const toast = useToast();

const addModalVisible = ref(false)
onMounted(async () => {
    await getFemales()
    isLoading.value = false
})
async function getFemales() {
    await window.axios.post(`${window.baseurl}api/personalprofile/getFemales`, {}, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
       
        console.log(response.data)
    }).catch(err => {
        console.error(err)
    })
}
</script>