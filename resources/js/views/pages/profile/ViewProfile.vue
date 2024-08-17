<template>
    <Spinner v-if="isLoading" />

    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <div class="grid grid-cols-2 gap-2">
            <div class="md:col-span-1 col-span-2">
                <Fieldset legend="Personal Profile">
                    <form @submit.prevent="updatePersonalProfile()">
                        <div class="grid grid-cols-3 gap-2">
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Lastname</label>
                                <InputText class="w-full" v-model="profileInfo.lastname" />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Firstname</label>
                                <InputText class="w-full" v-model="profileInfo.firstname" />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Middlename</label>
                                <InputText class="w-full" v-model="profileInfo.middlename" />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Suffix</label>
                                <InputText class="w-full" v-model="profileInfo.suffix" />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Birthdate</label>
                                <DatePicker class="w-full" v-model="profileInfo.birthdate" dateFormat="yy-mm-dd" />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Age</label>
                                <InputText class="w-full" v-model="profileInfo.age" disabled />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Sex</label>
                                <Select v-model="profileInfo.sex" optionValue="name" :options="sex" optionLabel="name"
                                    class="w-full " />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Civil Status</label>
                                <Select v-model="profileInfo.civil_status" optionValue="name" :options="civil_status"
                                    optionLabel="name" class="w-full " />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Phone Number</label>
                                <InputMask v-model="profileInfo.phone_number" mask="99999999999"
                                    placeholder="99999999999" class="w-full" />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Educational Attainment</label>
                                <Select v-model="profileInfo.educational_attainment" optionValue="name"
                                    :options="educational_attainment" editable optionLabel="name" class="w-full " />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Work</label>
                                <Select v-model="profileInfo.work" optionValue="name" :options="work" editable
                                    optionLabel="name" class="w-full " />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Rel. to Family Head</label>
                                <Select v-model="profileInfo.relation_ship_to_head" optionValue="name"
                                    :options="relationship_to_head" editable optionLabel="name" class="w-full " />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Status</label>
                                <Select v-model="profileInfo.status" optionValue="name" :options="profile_status"
                                    optionLabel="name" class="w-full " />
                            </div>
                        </div>
                        <Button label="Update" type="submit" class="w-full mt-2" />
                    </form>
                </Fieldset>

            </div>
            <div class="md:col-span-1 col-span-2">
                <Fieldset legend="Health Profile">
                    <form @submit.prevent="updateHealthProfile()">
                        <div class="grid grid-cols-3 gap-2">
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Philhealth Number</label>
                                <InputText class="w-full" v-model="healthInfo.philhealth_number"
                                     />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Blood Type</label>
                                <Select v-model="healthInfo.blood_type" editable optionValue="name"
                                    :options="blood_type" optionLabel="name" placeholder="Select blood type"
                                    class="w-full "  />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Maintenance</label>
                                <Select v-model="healthInfo.maintenance" editable optionValue="name"
                                    :options="maintenance" optionLabel="name" class="w-full "
                                    />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Height(cm)</label>
                                <InputNumber class="w-fit" v-model="healthInfo.height"
                                    inputId="integeronly" fluid />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Weight(kl)</label>
                                <InputNumber class="w-full" v-model="healthInfo.weight"
                                    inputId="integeronly" fluid />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">BMI(Body Mass Index)</label>
                                <InputNumber class="w-full" v-model="healthInfo.bmi" inputId="withoutgrouping" fluid
                                    :useGrouping="false" disabled />
                            </div>
                            <div class="md:col-span-1 col-span-3">
                                <label for="">Health Status</label>
                                <Select v-model="healthInfo.health_status" editable optionValue="name"
                                    :options="health_status" optionLabel="name" class="w-full "
                                   />
                            </div>

                        </div>
                        <Button label="Update" type="submit" class="w-full mt-2"/>
                    </form>
                </Fieldset>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { civil_status, blood_type, educational_attainment, health_status, maintenance, relationship_to_head, sex, work, profile_status } from '@/service/SelectDatas.js'
import { calculateBMI, calculateAge } from '@/service/Calculations.js'
import { useToast } from "primevue/usetoast";

import VueCookies from 'vue-cookies';

const route = useRoute()
const isLoading = ref(true)
const healthInfo = ref({
    health_id: '',
    philhealth_number: '',
    blood_type: '',
    maintenance: '',
    height: 0,
    weight: 0,
    bmi: 0,
    health_status: ''
})
const profileInfo = ref({
    id: '',
    lastname: '',
    firstname: '',
    middlename: '',
    suffix: '',
    birthdate: '',
    age: '',
    sex: '',
    civil_status: '',
    educational_attainment: '',
    work: '',
    relation_ship_to_head: '',
    phone_number: '',
    status: ''
})
const toast = useToast();

watch(
    () => healthInfo.value.weight,
    () => {
        if (healthInfo.value.height) {
            healthInfo.value.bmi = parseFloat(calculateBMI(healthInfo.value.weight, healthInfo.value.height))
        }
    }
)
watch(
    () => healthInfo.value.height,
    () => {
        if (healthInfo.value.weight) {
            healthInfo.value.bmi = parseFloat(calculateBMI(healthInfo.value.weight, healthInfo.value.height))
        }
    }
)
watch(
    () => profileInfo.value.birthdate,
    () => {
        profileInfo.value.age = calculateAge(profileInfo.value.birthdate)
    }
)
onMounted(async () => {
    await viewProfile()
    isLoading.value = false
})
async function updatePersonalProfile() {
    try {
        if (profileInfo.value.birthdate) {
            const date = new Date(profileInfo.value.birthdate);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            profileInfo.value.birthdate = `${year}-${month}-${day}`;
        }
        const response = await window.axios.post(`${window.baseurl}api/personalprofile/updatePersonalProfile`, profileInfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });
    }
}
async function updateHealthProfile() {
    try {
        const response = await window.axios.post(`${window.baseurl}api/healthprofile/updateHealthProfile`, healthInfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
    
        toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });
    }
}
async function viewProfile(){
    try{
        const response = await window.axios.post(`${window.baseurl}api/personalprofile/viewProfile`, {id: route.params.id }, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        if(response.data){
            for (const key in profileInfo.value) {
                profileInfo.value[key] = response.data['profile'][key]
            }
            for (const key in healthInfo.value) {
                healthInfo.value[key] = response.data['health'][key]
            }
        }
       
    }catch(err){
        console.log(err)
    }
}
</script>