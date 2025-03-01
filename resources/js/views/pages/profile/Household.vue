<template>
    <Spinner v-if="isLoading" />
    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <Dialog v-model:visible="updateHouseholdModalVisible" maximizable modal header="Update Household Information"
            class="md:w-2/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="updateHousehold()">
                <!-- <label for="">Household Number</label>
                <InputText class="w-full" v-model="householdInfo.household_number" :disabled="true" /> -->
                <label for="">NHTS (National Household Targeting System)
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.nhts" optionValue="name" :options="nhts"
                    :invalid="householdInfo.nhts == null" optionLabel="name" class="w-full " />
                <label for="">Electricity
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.electricity" optionValue="name" :options="electricity" editable
                    optionLabel="name" class="w-full " />
                <label for="">Water Supply
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.water_supply" optionValue="name" :options="water_supply" editable
                    optionLabel="name" class="w-full " />
                <label for="">Toilet
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.toilet" optionValue="name" :options="toilet" editable optionLabel="name"
                    class="w-full " />
                <label for="">BHW
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.bhw_user_id" :options="bhws" optionValue="id" filter
                    optionLabel="lastname" placeholder="Select" class="w-full">
                    <template #option="slotProps">
                        <div class="flex items-center">
                            <div>{{ `${slotProps.option.lastname} ${slotProps.option.firstname}
                                ${slotProps.option.lastname ? slotProps.option.middlename : ''}` }}</div>
                        </div>
                    </template>
                </Select>
                <label for="">Purok
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.purok_id" :options="puroks" optionValue="id" filter optionLabel="name"
                    placeholder="Select" class="w-full">
                </Select>
                <Button label="Submit" type="submit" class="w-full mt-2" />
            </form>
        </Dialog>
        <Dialog v-model:visible="separateHouseholdModalVisible" maximizable modal
            header="Separate Household Information" class="md:w-2/6 w-full"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="separateHousehold()">
                <label for="">Household Number
                    <Asterisk />
                </label>
                <InputText class="w-full" v-model="householdInfo.household_number" />
                <label for="">NHTS (National Household Targeting System)
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.nhts" optionValue="name" :options="nhts"
                    :invalid="householdInfo.nhts == null" optionLabel="name" class="w-full " />
                <label for="">Electricity</label>
                <Select v-model="householdInfo.electricity" optionValue="name" :options="electricity" editable
                    optionLabel="name" class="w-full " />
                <label for="">Water Supply
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.water_supply" optionValue="name" :options="water_supply" editable
                    optionLabel="name" class="w-full " />
                <label for="">Toilet
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.toilet" optionValue="name" :options="toilet" editable optionLabel="name"
                    class="w-full " />


                <label for="">BHW
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.bhw_user_id" :options="bhws" optionValue="id" filter
                    optionLabel="lastname" placeholder="Select" class="w-full">
                    <template #option="slotProps">
                        <div class="flex items-center">
                            <div>{{ `${slotProps.option.lastname} ${slotProps.option.firstname}
                                ${slotProps.option.lastname ? slotProps.option.middlename : ''}` }}</div>
                        </div>
                    </template>
                </Select>

                <label for="">Purok
                    <Asterisk />
                </label>
                <Select v-model="householdInfo.purok_id" :options="puroks" optionValue="id" filter optionLabel="name"
                    placeholder="Select" class="w-full">

                </Select>

                <Button label="Submit" type="submit" class="w-full mt-2" />
            </form>
        </Dialog>
        <Dialog v-model:visible="addModalVisible" maximizable modal
            :header="`${!personalInfoOnly ? 'HOUSEHOLD INFORMATION' : 'PERSONAL INFORMATION'}`" position="top"
            class="md:w-4/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="!personalInfoOnly ? insertHouseholdProfile() : insertPersonalProfile()">
                <p class="text-base uppercase font-bold " v-if="!personalInfoOnly">Household Information</p>
                <div class="grid grid-cols-3 gap-2" v-if="!personalInfoOnly">
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Household Number</label>
                        <InputText class="w-full" v-model="householdInfo.household_number" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">NHTS (National Household Targeting System)
                            <Asterisk />
                        </label>
                        <Select v-model="householdInfo.nhts" optionValue="name" :options="nhts" optionLabel="name"
                            class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Electricity
                            <Asterisk />
                        </label>
                        <Select v-model="householdInfo.electricity" optionValue="name" :options="electricity" editable
                            optionLabel="name" class="w-full " required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Water Supply
                            <Asterisk />
                        </label>
                        <Select v-model="householdInfo.water_supply" optionValue="name" :options="water_supply" editable
                            optionLabel="name" class="w-full " required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Toilet
                            <Asterisk />
                        </label>
                        <Select v-model="householdInfo.toilet" optionValue="name" :options="toilet" editable
                            optionLabel="name" class="w-full " />
                    </div>


                    <div class="md:col-span-1 col-span-3">
                        <label for="">BHW
                            <Asterisk />
                        </label>
                        <Select v-model="householdInfo.bhw_user_id" :options="bhws" optionValue="id" filter
                            optionLabel="lastname" placeholder="Select" class="w-full">
                            <template #option="slotProps">
                                <div class="flex items-center">
                                    <div>{{ `${slotProps.option.lastname} ${slotProps.option.firstname}
                                        ${slotProps.option.lastname ? slotProps.option.middlename : ''}` }}</div>
                                </div>
                            </template>
                        </Select>
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Purok
                            <Asterisk />
                        </label>
                        <Select v-model="householdInfo.purok_id" :options="puroks" optionValue="id" filter
                            optionLabel="name" placeholder="Select" class="w-full">

                        </Select>
                    </div>
                </div>
                <p class="text-base uppercase font-bold mt-3" v-if="!personalInfoOnly">Household Head Information</p>
                <div class="grid grid-cols-3 gap-2">
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Lastname
                            <Asterisk />
                        </label>
                        <InputText class="w-full" required v-model="profileInfo.lastname" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Firstname
                            <Asterisk />
                        </label>
                        <InputText class="w-full" v-model="profileInfo.firstname" required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Middlename

                        </label>
                        <InputText class="w-full" v-model="profileInfo.middlename" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Suffix</label>
                        <InputText class="w-full" v-model="profileInfo.suffix" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Birthdate
                            <Asterisk />
                        </label>
                        <DatePicker class="w-full" v-model="profileInfo.birthdate" required dateFormat="yy-mm-dd" />
                    </div>

                    <div class="md:col-span-1 col-span-3">
                        <label for="">Age</label>
                        <InputText class="w-full" v-model="profileInfo.age" disabled />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Sex
                            <Asterisk />
                        </label>
                        <Select v-model="profileInfo.sex" optionValue="name" :options="sex" optionLabel="name"
                            class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Civil Status
                            <Asterisk />
                        </label>
                        <Select v-model="profileInfo.civil_status" optionValue="name" :options="civil_status"
                            optionLabel="name" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Phone Number</label>
                        <InputMask v-model="profileInfo.phone_number" mask="99999999999" placeholder="99999999999"
                            class="w-full" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Educational Attainment
                            <Asterisk />
                        </label>
                        <Select v-model="profileInfo.educational_attainment" optionValue="name"
                            :options="educational_attainment" editable optionLabel="name" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Work
                            <Asterisk />
                        </label>
                        <Select v-model="profileInfo.work" optionValue="name" :options="work" editable
                            optionLabel="name" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Relationship to Family Head
                            <Asterisk />
                        </label>
                        <Select v-model="profileInfo.relation_ship_to_head" optionValue="name"
                            :options="relationship_to_head" editable optionLabel="name" class="w-full " />
                    </div>
                </div>
                <p class="text-base uppercase font-bold mt-3">Health Status</p>
                <div class="grid grid-cols-3 gap-2">
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Philhealth Number</label>
                        <InputText class="w-full" v-model="healthInfo.philhealth_number" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Blood Type</label>
                        <Select v-model="healthInfo.blood_type" editable optionValue="name" :options="blood_type"
                            optionLabel="name" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Maintenance</label>
                        <MultiSelect v-model="_maintenance" :options="maintenance" filter optionLabel="name"
                            class="w-full " />
                        <!-- <Select v-model="healthInfo.maintenance" editable optionValue="name" :options="maintenance"
                            optionLabel="name" class="w-full " /> -->
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Height(cm)</label>
                        <InputNumber class="w-full" v-model="healthInfo.height" required :useGrouping="false"
                            inputId="integeronly" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Weight(kl)</label>
                        <InputNumber class="w-full" v-model="healthInfo.weight" inputId="integeronly"
                            :useGrouping="false" required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">BMI(Body Mass Index)</label>
                        <InputNumber class="w-full" v-model="healthInfo.bmi" inputId="withoutgrouping" required
                            :useGrouping="false" disabled />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Health Status</label>
                        <MultiSelect v-model="_health_status" :options="health_status" filter optionLabel="name"
                            class="w-full " />
                        <!-- <Select v-model="healthInfo.health_status" editable optionValue="name" :options="health_status"
                            optionLabel="name" class="w-full " /> -->
                    </div>

                </div>
                <Button label="Submit" type="submit" class="w-full mt-2" />
            </form>

        </Dialog>
        <DataTable v-model:expandedRows="expandedRows" :value="households" dataKey="id" :rows="5"
            :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex md:flex-row flex-col justify-between">
                    <div class="flex gap-x-2">
                        <Button label="Show" class="w-[4em]"
                            @click="getHouseHoldNumber(), addModalVisible = true, personalInfoOnly = false"><v-icon
                                name="bi-house-door-fill" scale="1.2"></v-icon></Button>
                        <Select @change="getHousehold()" v-model="_status" optionValue="value" :options="status"
                            optionLabel="name" class="w-32 " />
                    </div>
                    <div class="flex flex-wrap justify-end gap-2">
                        <Button text icon="pi pi-plus" label="Expand All Household Members" @click="expandAll" />
                        <Button text icon="pi pi-minus" label="Collapse All" @click="collapseAll" />
                        <div class="flex  ">
                            <IconField>
                                <InputIcon class="pi pi-search" />
                                <InputText placeholder="Search" v-model="search" @keyup="getHousehold()" class="md:w-80 w-60" />
                            </IconField>
                        </div>
                    </div>
                </div>
            </template>
            <Column expander style="width: 5rem" />
            <Column field="household_number" header="Household No."></Column>
            <Column field="purok_name" header="Purok"></Column>
            <Column header="BHW">
                <template #body="slotProps">
                    {{ `${slotProps.data.bhw_lname}, ${slotProps.data.bhw_fname}` }}

                </template>
            </Column>
            <!-- <Column field="household_head" header="Household Head"></Column> -->
            <Column field="nhts" header="NHTS"></Column>
            <Column field="electricity" header="Electricity"></Column>
            <Column field="water_supply" header="Water Supply"></Column>
            <Column field="toilet" header="Toilet"></Column>
            <Column header="Action" class="w-40">

                <template #body="slotProps">
                    <div v-if="slotProps.data.archive == 0">
                        <button type="button" class="bg-emerald-500 text-white py-1 px-2 rounded-sm"
                            v-tooltip.top="'Add household member'"
                            @click="profileInfo.household_profile_id = slotProps.data.id, addModalVisible = true, personalInfoOnly = true"><v-icon
                                name="bi-person-circle"></v-icon></button>
                        <button type="button"
                            @click="setForUpdateHousehold(slotProps.data), updateHouseholdModalVisible = true"
                            class="bg-sky-500 text-white py-1 px-2 rounded-sm ml-1"
                            v-tooltip.top="'Update household information'"><v-icon name="fa-edit"></v-icon></button>
                        <button type="button" @click="id = slotProps.data.id, confirmArchive()"
                            class="bg-red-500 text-white py-1 px-2 rounded-sm ml-1"
                            v-tooltip.top="'Archive household'"><v-icon name="bi-trash"></v-icon></button>
                    </div>
                    <div v-else>
                        <button type="button" @click="confirmUnarchive(slotProps.data.id)"
                             class="bg-sky-500 text-white py-1 px-2 rounded-sm ml-1"
                            v-tooltip.top="'Unarchive household'"><v-icon name="fa-archive"></v-icon></button>
                    </div>
                    <!-- <Button v-tooltip.left="'Add house member'" @click="profileInfo.household_profile_id = slotProps.data.id, addModalVisible = true, personalInfoOnly = true" severity="info" ><v-icon name="bi-person-circle"></v-icon></Button> -->
                </template>
            </Column>
            <template #expansion="slotProps">
                <div class="p-4">
                    <p class="uppercase font-bold">Household Members</p>
                    <DataTable :value="slotProps.data.personal_profiles">
                        <Column field="lastname" header="Lastname">
                            <template #body="slotProp">
                                <span v-if="slotProp.data.id === slotProps.data.personal_profile_id"
                                    class="bg-sky-500 px-3 py-1 rounded-full text-white">Head</span>
                                {{ slotProp.data.lastname }}
                            </template>
                        </Column>
                        <Column field="firstname" header="Firstname"></Column>
                        <Column field="middlename" header="Middlename"></Column>
                        <Column field="sex" header="Sex"></Column>
                        <Column field="civil_status" header="Civil Status"></Column>
                        <Column field="relation_ship_to_head" header="Relationship to Head"></Column>
                        <Column field="status" header="Status"></Column>
                        <Column header="Action">
                            <template #body="slotProp">


                                <router-link v-tooltip.top="'View Information'"
                                    :to="{ name: 'viewprofile', params: { id: slotProp.data.id } }"
                                    class=" bg-sky-500 text-white py-[6px] px-2 rounded-sm">
                                    <v-icon name="bi-eye-fill"></v-icon>
                                </router-link>
                                <button type="button"
                                    @click="confirmChangeHouseholdHead(slotProp.data.id, slotProps.data.personal_profile_id, slotProps.data.id)"
                                    class="bg-sky-500 text-white py-1 px-2 rounded-sm ml-1"
                                    v-tooltip.top="'Set as household head'"><v-icon
                                        name="fa-user-shield"></v-icon></button>
                                <button type="button"
                                    @click="setAsSeparateHousehold(slotProp.data.id, slotProps.data.personal_profile_id)"
                                    class="ml-1 bg-green-500 text-white py-1 px-2 rounded-sm"
                                    v-tooltip.top="'Separate household'"><v-icon
                                        name="md-supervisedusercircle-round"></v-icon></button>


                            </template>
                        </Column>
                    </DataTable>
                </div>
            </template>
            <template #footer>
                <Paginator v-on:page="getHousehold()" ref="paginator" :rows="10" :totalRecords="totalRecords"
                    :rowsPerPageOptions="[10, 25, 50, 100]"></Paginator>
            </template>
        </DataTable>
    </div>
</template>
<script setup>
import { ref, onMounted, watch } from 'vue'
import { useConfirm } from "primevue/useconfirm";
import { useRouter } from 'vue-router'
import { useToast } from "primevue/usetoast";
import { calculateBMI, calculateAge } from '@/service/Calculations.js'

import { blood_type, civil_status, educational_attainment, status, electricity, health_status, maintenance, nhts, relationship_to_head, sex, toilet, water_supply, work } from '@/service/SelectDatas.js'
import VueCookies from 'vue-cookies';
const addModalVisible = ref(false)
const confirm = useConfirm()
const expandedRows = ref({});
const isLoading = ref(true)
const id = ref(0)
const _health_status = ref([])
const _maintenance = ref([])
const healthInfo = ref({
    philhealth_number: '',
    blood_type: '',
    maintenance: '',
    height: 0,
    weight: 0,
    bmi: 0,
    health_status: []
})
const puroks = ref([])
const households = ref([])
const householdInfo = ref({
    id: '',
    personal_profile_id: '',
    household_number: '',
    nhts: '',
    electricity: '',
    water_supply: '',
    toilet: '',
    bhw_user_id: '',
    purok_id: ''
})
const paginator = ref(null)
// const profileInfo = ref({
//     household_profile_id: '',
//     lastname: '',
//     firstname: '',
//     middlename: '',
//     suffix: '',
//     birthdate: '',
//     age: '',
//     sex: '',
//     civil_status: '',
//     educational_attainment: '',
//     work: '',
//     relation_ship_to_head: '',
//     phone_number: '',
// })
const bhws = ref([])
const profileInfo = ref({
    household_profile_id: '',
    lastname: '345345',
    firstname: '345',
    middlename: '3454',
    suffix: '',
    birthdate: '',
    age: '',
    sex: 'Male',
    civil_status: 'Single',
    educational_attainment: 'Elementary Level',
    work: 'Farmer',
    relation_ship_to_head: 'Son',
    phone_number: '09656585982',
})
const personalInfoOnly = ref(true)
const _status = ref(0)
const router = useRouter()
const search = ref('')

const separateHouseholdModalVisible = ref(false)
const totalRecords = ref(0)
const toast = useToast();
const updateHouseholdModalVisible = ref(false)
watch(
    () => healthInfo.value.weight,
    () => {
        if (healthInfo.value.height) {
            healthInfo.value.bmi = parseFloat(calculateBMI(healthInfo.value.weight, healthInfo.value.height))
        }
        // healthInfo.value.bmi = calculateBMI(healthInfo.value.weight, healthInfo.value.height)
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
watch(
    () => addModalVisible.value,
    () => {
        if (!addModalVisible.value) {
            clearVariables()
        }
    }
)
watch(
    () => updateHouseholdModalVisible.value,
    () => {
        if (!updateHouseholdModalVisible.value) {
            clearVariables()
        }
    }
)
watch(
    () => separateHouseholdModalVisible.value,
    () => {
        if (!separateHouseholdModalVisible.value) {
            clearVariables()
        }
    }
)
onMounted(async () => {
    await getPuroks()
    await getUsersByRole()
    await getHousehold()
    isLoading.value = false
})
const expandAll = () => {
    expandedRows.value = households.value.reduce((acc, p) => (acc[p.id] = true) && acc, {});
};
const collapseAll = () => {
    expandedRows.value = null;
};
async function insertHouseholdProfile() {
    try {
        if (profileInfo.value.birthdate) {
            const date = new Date(profileInfo.value.birthdate);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            profileInfo.value.birthdate = `${year}-${month}-${day}`;
        }
        healthInfo.value.health_status = JSON.stringify(_health_status.value)
        healthInfo.value.maintenance = JSON.stringify(_maintenance.value)

        const response = await window.axios.post(`${window.baseurl}api/household/insertHousehold`, { ...profileInfo.value, ...householdInfo.value, ...healthInfo.value }, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        _health_status.value = []
        _maintenance.value = []
        addModalVisible.value = false
        clearVariables()
        await getHousehold()
        toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
    } catch (err) {
        console.log(err.response.data)
        toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });

    }
}
async function insertPersonalProfile() {
    try {
        if (profileInfo.value.birthdate) {
            const date = new Date(profileInfo.value.birthdate);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            profileInfo.value.birthdate = `${year}-${month}-${day}`;
        }
        healthInfo.value.health_status = JSON.stringify(_health_status.value)
        healthInfo.value.maintenance = JSON.stringify(_maintenance.value)
        const response = await window.axios.post(`${window.baseurl}api/personalprofile/insertPersonalProfile`, { ...profileInfo.value, ...healthInfo.value }, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        _health_status.value = []
        _maintenance.value = []

        addModalVisible.value = false
        clearVariables()
        await getHousehold()
        toast.add({ severity: 'success', summary: 'Success', detail: 'Saved successfully', life: 3000 });
        // router.push({ name: 'personal' })
    } catch (err) {

        toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });
    }
}
async function getPuroks() {
    await window.axios.get(`${window.baseurl}api/household/getPuroks`, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        puroks.value = response.data.puroks
        // console.log(response.data)
    }).catch(err => {
        console.error(err)
    })
}
async function getUsersByRole() {
    await window.axios.get(`${window.baseurl}api/auth/getUsersByRole/${1}`, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        bhws.value = response.data.users
        // console.log(response.data)
    }).catch(err => {
        console.error(err)
    })
}
async function getHousehold() {
    let data = null;
    if (paginator.value === null) {
        data = {
            page: 1,
            recordPerPage: 10,
            search: search.value,
            status: _status.value
        }
    } else {
        data = {
            page: paginator.value.page + 1,
            recordPerPage: paginator.value.d_rows,
            search: search.value,
            status: _status.value

        }
    }
    await window.axios.post(`${window.baseurl}api/household/getHousehold`, data, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        households.value = response.data.data
        totalRecords.value = response.data.count
        console.log(response.data.data)
    }).catch(err => {
        console.error(err)
    })
}
// household number generator
async function getHouseHoldNumber() {
    await window.axios.post(`${window.baseurl}api/household/getHouseHoldNumber`, {}, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        if (response.statusText === "OK") {
            householdInfo.value.household_number = response.data.householdNumber;
        }
    }).catch(err => {
        console.error(err)
    })
}
async function separateHousehold() {
    try {

        const response = await window.axios.post(`${window.baseurl}api/household/separateHousehold`, householdInfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        separateHouseholdModalVisible.value = false
        clearVariables()
        await getHousehold()
        toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
        console.log(response.data)
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });
    }
}
async function updateHousehold() {
    try {

        const response = await window.axios.post(`${window.baseurl}api/household/updateHousehold`, householdInfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        updateHouseholdModalVisible.value = false
        clearVariables()
        await getHousehold()
        toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
        console.log(response.data)
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });
    }
}
async function setAsSeparateHousehold(personal_profile_id, household_personal_profile_id) {
    if (personal_profile_id != household_personal_profile_id) {
        await getHouseHoldNumber(),
            householdInfo.value.personal_profile_id = personal_profile_id
        separateHouseholdModalVisible.value = true
    } else {
        toast.add({ severity: 'error', summary: 'Error', detail: 'The profile is the head of the household. Please changed the household head first.', life: 3000 });
    }
}
function confirmChangeHouseholdHead(personal_profile_id, household_personal_profile_id, household_id) {
    if (personal_profile_id != household_personal_profile_id) {
        confirm.require({
            message: 'Are you sure you want to change the household head?',
            header: 'Confirmation',
            icon: 'pi pi-exclamation-triangle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Save'
            },
            accept: async () => {
                try {
                    const data = {
                        id: household_id,
                        personal_profile_id: personal_profile_id,
                        household_personal_profile_id: household_personal_profile_id
                    }
                    const response = await window.axios.post(`${window.baseurl}api/household/changeHouseholdHead`, data, {
                        headers: {
                            'Authorization': `Bearer ${VueCookies.get('token')}`
                        }
                    })
                    await getHousehold()
                    toast.add({ severity: response.data.status, summary: response.data.status == 'success' ? 'Success' : 'Error', detail: response.data.message, life: 3000 });
                } catch (err) {
                    toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });
                }
            },
            reject: () => {
                toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
            }
        });
    } else {
        toast.add({ severity: 'error', summary: 'Error', detail: 'The profile is already the household head.', life: 3000 });
    }
}
function confirmArchive() {
    confirm.require({
        message: 'Are you sure you want to archive?',
        header: 'Confirmation',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Save'
        },
        accept: async () => {
            const response = await window.axios.delete(`${window.baseurl}api/household/archiveHouseholdProfile/${id.value}`, {
                headers: {
                    'Authorization': `Bearer ${VueCookies.get('token')}`
                }
            })
            await getHousehold()
            toast.add({ severity: response.data.status, summary: response.data.status == 'success' ? 'Success' : 'Error', detail: response.data.message, life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
}
function confirmUnarchive(id) {
    confirm.require({
        message: 'Are you sure you want to  unarchive?',
        header: 'Confirmation',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Save'
        },
        accept: async () => {
            const response = await window.axios.delete(`${window.baseurl}api/household/unarchiveHouseholdProfile/${id}`, {
                headers: {
                    'Authorization': `Bearer ${VueCookies.get('token')}`
                }
            })
            await getHousehold()
            toast.add({ severity: response.data.status, summary: response.data.status == 'success' ? 'Success' : 'Error', detail: response.data.message, life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
}
function clearVariables() {
    for (const key in profileInfo.value) {
        profileInfo.value[key] = ''
    }
    for (const key in householdInfo.value) {
        householdInfo.value[key] = ''
    }
    for (const key in healthInfo.value) {

        if (typeof healthInfo.value[key] === 'string') {
            if (key != 'health_status') {
                healthInfo.value[key] = 0
            } else {
                healthInfo.value[key] = ''
            }

        } else {
            healthInfo.value[key] = 0
        }
    }
}
function setForUpdateHousehold(_householdInfo) {
    for (const key in householdInfo.value) {
        householdInfo.value[key] = _householdInfo[key]
    }
}
</script>