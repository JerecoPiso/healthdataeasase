<template>
    <Spinner v-if="isLoading" />
    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <Dialog v-model:visible="editPersonalProfileModal" maximizable modal header="Edit Personal Profile"
            position="top" class="md:w-3/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
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
                        <InputMask v-model="profileInfo.phone_number" mask="99999999999" placeholder="99999999999"
                            class="w-full" />
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
                        <label for="">Relationship to Family Head</label>
                        <Select v-model="profileInfo.relation_ship_to_head" optionValue="name"
                            :options="relationship_to_head" editable optionLabel="name" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Status</label>
                        <Select v-model="profileInfo.status" optionValue="name" :options="profile_status"
                            optionLabel="name" class="w-full " />
                    </div>
                </div>
                <Button label="Submit" type="submit" class="w-full mt-2" />
            </form>

        </Dialog>
        <Dialog v-model:visible="editHealthModal" maximizable modal
            :header="`${!viewHealthInfoOnly ? 'Edit Health Status' : 'View Health Status'}`" position="top"
            class="md:w-3/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="updateHealthProfile()">
                <div class="grid grid-cols-3 gap-2">
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Philhealth Number</label>
                        <InputText class="w-full" v-model="healthInfo.philhealth_number"
                            :disabled="viewHealthInfoOnly" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Blood Type</label>
                        <Select v-model="healthInfo.blood_type" editable optionValue="name" :options="blood_type"
                            optionLabel="name" placeholder="Select blood type" class="w-full "
                            :disabled="viewHealthInfoOnly" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Maintenance</label>
                        <Select v-model="healthInfo.maintenance" editable optionValue="name" :options="maintenance"
                            optionLabel="name" class="w-full " :disabled="viewHealthInfoOnly" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Height(cm)</label>
                        <InputNumber class="w-full" v-model="healthInfo.height" :disabled="viewHealthInfoOnly"
                            inputId="integeronly" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Weight(kl)</label>
                        <InputNumber class="w-full" v-model="healthInfo.weight" :disabled="viewHealthInfoOnly"
                            inputId="integeronly" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">BMI(Body Mass Index)</label>
                        <InputNumber class="w-full" v-model="healthInfo.bmi" inputId="withoutgrouping"
                            :useGrouping="false" disabled />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Health Status</label>
                        <Select v-model="healthInfo.health_status" editable optionValue="name" :options="health_status"
                            optionLabel="name" class="w-full " :disabled="viewHealthInfoOnly" />
                    </div>

                </div>
                <Button label="Submit" type="submit" class="w-full mt-2" v-if="!viewHealthInfoOnly" />
            </form>

        </Dialog>
        <!-- <Button label="Show" class="w-[4em]" @click="editHealthModal = true" ><v-icon name="bi-person-plus-fill" scale="1.2"></v-icon></Button> -->
        <DataTable :value="profiles" scrollable tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex md:justify-between flex-wrap   gap-2">
                    <div class="flex md:justify-between flex-wrap  gap-2">
                        <Select v-model="residentStatus" @change="getPersonalProfile()" optionValue="name"
                            :options="profile_status" optionLabel="name" class="w-56 " />
                        <Select @change="getPersonalProfile()" v-model="_status" optionValue="value" :options="status"
                            optionLabel="name" class="w-32 " />
                    </div>
                    <div class="flex  ">
                        <IconField>
                            <InputIcon class="pi pi-search" />
                            <InputText placeholder="Search" v-model="search" @keyup="getPersonalProfile()" />
                        </IconField>
                    </div>
                </div>
            </template>
            <Column field="philhealth_number" header="Philhealth"></Column>
            <Column field="lastname" sortable header="Lastname"></Column>
            <Column field="firstname" sortable header="Firstname"></Column>
            <Column field="middlename" header="Middlename"></Column>
            <Column field="birthdate" header="Birthdate"></Column>
            <Column field="sex" sortable header="Sex"></Column>
            <Column field="civil_status" sortable header="Civil Status"></Column>

            <!-- <Column field="phone_number" header="Phone No."></Column> -->
            <Column field="educational_attainment" sortable header="Educational Attainment"></Column>
            <Column field="work" sortable header="Work"></Column>
            <Column header="Health Status">
                <template #body="slotProps">
                    {{ viewArrayAsString(slotProps.data.health_status) }}
                </template>
            </Column>
            <Column sortable header="Maintenance">
                <template #body="slotProps">
                    {{ viewArrayAsString(slotProps.data.maintenance) }}
                </template>
            </Column>
            <Column field="status" sortable header="Status"></Column>
            <Column header="Action" class="min-w-40" alignFrozen="right" :frozen="true">
                <template #body="slotProps">


                    <div v-if="slotProps.data.archive == 0">
                        <router-link v-tooltip.top="'View Information'"
                            :to="{ name: 'viewprofile', params: { id: slotProps.data.id } }"
                            class=" bg-sky-500 text-white p-2 rounded-sm">
                            <v-icon name="bi-eye-fill"></v-icon>
                        </router-link>
                        <!-- <button type="button"
                        @click="setForUpdatePersonalProfile(slotProps.data), editPersonalProfileModal = true"
                        class="bg-emerald-500 text-white py-1 px-2 rounded-sm ml-1"
                        v-tooltip.top="'Update personal profile'"><v-icon name="fa-edit"></v-icon></button>
                    <button type="button" @click="setForUpdateHealthProfile(slotProps.data), viewHealthInfoOnly = false, editHealthModal = true"
                        class="bg-sky-500 text-white py-1 px-2 rounded-sm ml-1"
                        v-tooltip.top="'Update health information'"><v-icon
                            name="md-healthandsafety-sharp"></v-icon></button> -->
                        <button type="button"
                            @click="setForUpdateHealthProfile(slotProps.data), viewHealthInfoOnly = true, editHealthModal = true"
                            class="bg-emerald-500 text-white py-1 px-2 rounded-sm ml-1"
                            v-tooltip.top="'View health information'"><v-icon
                                name="ri-health-book-line"></v-icon></button>
                        <button type="button" @click="id = slotProps.data.id, confirmArchive()"
                            class="bg-red-500 text-white py-1 px-2 rounded-sm ml-1"
                            v-tooltip.top="'Archive member'"><v-icon name="bi-trash"></v-icon></button>
                    </div>
                    <div v-else>
                        <button type="button" @click="confirmUnarchive(slotProps.data.id)"
                            class="bg-sky-500 text-white py-1 px-2 rounded-sm ml-1"
                            v-tooltip.top="'Unarchive personal profile'"><v-icon name="fa-archive"></v-icon></button>
                    </div>
                </template>
            </Column>
            <template #footer>
                <Paginator v-on:page="getPersonalProfile()" ref="paginator" :rows="10" :totalRecords="totalRecords"
                    :rowsPerPageOptions="[10, 25, 50, 100]"></Paginator>
            </template>
        </DataTable>
    </div>
</template>
<script setup>
import { ref, onMounted, watch } from 'vue'
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import { calculateBMI, calculateAge } from '@/service/Calculations.js'
import { civil_status, blood_type, educational_attainment, health_status, status, maintenance, relationship_to_head, sex, work, profile_status } from '@/service/SelectDatas.js'
import VueCookies from 'vue-cookies';
const confirm = useConfirm();
const editPersonalProfileModal = ref(false)
const editHealthModal = ref(false)
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
const _status = ref(0)
const residentStatus = ref('Active')
const id = ref(0)
const isLoading = ref(true)
const paginator = ref(null)
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
const profiles = ref([])
const search = ref('')
const toast = useToast();
const totalRecords = ref(1)
const viewHealthInfoOnly = ref(false)
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
onMounted(async () => {
    await getPersonalProfile()
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
        editPersonalProfileModal.value = false
        await getPersonalProfile()
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
        editHealthModal.value = false
        await getPersonalProfile()
        toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });
    }
}
async function getPersonalProfile() {
    let data = null;
    if (paginator.value === null) {
        data = {
            page: 1,
            recordPerPage: 10,
            search: search.value,
            residentStatus: residentStatus.value,
            status: _status.value
        }
    } else {
        data = {
            page: paginator.value.page + 1,
            recordPerPage: paginator.value.d_rows,
            search: search.value,
            residentStatus: residentStatus.value,
            status: _status.value
        }
    }
    await window.axios.post(`${window.baseurl}api/personalprofile/getPersonalProfile`, data, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        profiles.value = response.data.data
        totalRecords.value = response.data.count
        console.log(response.data)
    }).catch(err => {
        console.error(err)
    })
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
            label: 'Save',
        },
        accept: async () => {
            await window.axios.delete(`${window.baseurl}api/personalprofile/archivePersonalProfile/${id.value}`, {
                headers: {
                    'Authorization': `Bearer ${VueCookies.get('token')}`
                }
            })
            await getPersonalProfile()
            toast.add({ severity: 'success', summary: 'Success', detail: 'Archived successfully', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });

}
function confirmUnarchive(id) {
    confirm.require({
        message: 'Are you sure you want to unarchive?',
        header: 'Confirmation',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Save',
        },
        accept: async () => {
            await window.axios.delete(`${window.baseurl}api/personalprofile/unarchivePersonalProfile/${id}`, {
                headers: {
                    'Authorization': `Bearer ${VueCookies.get('token')}`
                }
            })
            await getPersonalProfile()
            toast.add({ severity: 'success', summary: 'Success', detail: 'Unarchived successfully', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });

}
function setForUpdatePersonalProfile(profile) {
    for (const key in profileInfo.value) {
        profileInfo.value[key] = profile[key]
    }
}
function setForUpdateHealthProfile(profile) {
    for (const key in healthInfo.value) {
        healthInfo.value[key] = profile[key]
    }
}
function viewArrayAsString(data) {
    if (data) {
        let health_status = '';
        JSON.parse(data).forEach(el => {
            health_status += el.name + ', '
        })
        return health_status.substring(0, health_status.length - 2)
    } else {
        return ''
    }
}
</script>