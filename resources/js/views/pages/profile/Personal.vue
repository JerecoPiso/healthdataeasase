<template>
    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
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
                        <label for="">Birthdate</label>
                        <DatePicker class="w-full" v-model="profileInfo.birthdate" dateFormat="yy-mm-dd" />
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
                            :options="educational_attainment" editable optionLabel="name" 
                            class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Work</label>
                        <Select v-model="profileInfo.work" optionValue="name" :options="work" editable
                            optionLabel="name"  class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Relationship to Family Head</label>
                        <Select v-model="profileInfo.relation_ship_to_head" optionValue="name"
                            :options="relationship_to_head" editable optionLabel="name" 
                            class="w-full " />
                    </div>
                </div>
                <Button label="Submit" type="submit" class="w-full mt-2" />
            </form>

        </Dialog>
        <Dialog v-model:visible="editHealthModal" maximizable modal header="Edit Health Status" position="top"
            class="md:w-3/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="updateHealthProfile()">
                <div class="grid grid-cols-3 gap-2">
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Philhealth Number</label>
                        <InputText class="w-full" v-model="healthInfo.philhealth_number" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Blood Type</label>
                        <Select v-model="healthInfo.blood_type" optionValue="name" :options="blood_type"
                            optionLabel="name" placeholder="Select blood type" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Maintenance</label>
                        <Select v-model="healthInfo.maintenance" optionValue="name" :options="maintenance"
                            optionLabel="name"  class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Height(cm)</label>
                        <InputNumber class="w-full" v-model="healthInfo.height" inputId="integeronly" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Weight(kl)</label>
                        <InputNumber class="w-full" v-model="healthInfo.weight" inputId="integeronly" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Health Status</label>
                        <Select v-model="healthInfo.health_status" optionValue="name" :options="health_status"
                            optionLabel="name"  class="w-full " />
                    </div>
                </div>
                <Button label="Submit" type="submit" class="w-full mt-2" />
            </form>

        </Dialog>
        <!-- <Button label="Show" class="w-[4em]" @click="editHealthModal = true" ><v-icon name="bi-person-plus-fill" scale="1.2"></v-icon></Button> -->
        <DataTable :value="profiles" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
            tableStyle="min-width: 50rem">
            <!-- <Column field="id" header="ID"></Column> -->
            <Column field="lastname" sortable header="Lastname"></Column>
            <Column field="firstname" sortable header="Firstname"></Column>
            <Column field="middlename" header="Middlename"></Column>
            <Column field="birthdate" header="Birthdate"></Column>
            <Column field="sex" sortable header="Sex"></Column>
            <Column field="civil_status" sortable header="Civil Status"></Column>
            <Column field="phone_number" header="Phone No."></Column>
            <Column field="educational_attainment" sortable header="Educational Attainment"></Column>
            <Column field="work" sortable header="Work"></Column>
            <Column header="Action" class="min-w-48">
                <template #body="slotProps">
                    <button type="button" @click="setForUpdatePersonalProfile(slotProps.data), editPersonalProfileModal = true"
                        class="bg-emerald-500 text-white py-1 px-2 rounded-sm ml-1"
                        v-tooltip.top="'Set as household head'"><v-icon name="fa-house-user"></v-icon></button>
                    <button type="button" @click="setForUpdateHealthProfile(slotProps.data), editHealthModal = true"
                        class="bg-sky-500 text-white py-1 px-2 rounded-sm ml-1"
                        v-tooltip.top="'View health information'"><v-icon
                            name="md-healthandsafety-sharp"></v-icon></button>
                    <button type="button" @click="confirmArchive()"
                        class="bg-red-500 text-white py-1 px-2 rounded-sm ml-1" v-tooltip.top="'Archive member'"><v-icon
                            name="bi-trash"></v-icon></button>
                </template>
            </Column>
        </DataTable>
        <!-- 
        <Dialog v-model:visible="editHealthModal" maximizable modal header="Profile" position="top"
            class="md:w-4/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="insertPersonalProfile()">
                <div class="grid grid-cols-3 gap-2">
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Lastname</label>
                        <InputText class="w-full" v-model="profileInfo.lastname" required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Firstname</label>
                        <InputText class="w-full" v-model="profileInfo.firstname" required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Middlename</label>
                        <InputText class="w-full" v-model="profileInfo.middlename" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Birthdate</label>
                        <DatePicker class="w-full" v-model="profileInfo.birthdate" dateFormat="yy-mm-dd" required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Sex</label>
                        <Select v-model="profileInfo.sex" optionValue="name" :options="sex" optionLabel="name"
                            placeholder="Select a City" class="w-full " required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Civil Status</label>
                        <Select v-model="profileInfo.civil_status" optionValue="name" :options="civil_status"
                            optionLabel="name" placeholder="Select a City" class="w-full " required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Phone Number</label>
                        <InputMask v-model="profileInfo.phone_number" mask="99999999999" placeholder="99999999999"
                            class="w-full" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Educational Attainment</label>
                        <Select v-model="profileInfo.educational_attainment" optionValue="name"
                            :options="educational_attainment" editable optionLabel="name" placeholder="Select a City"
                            class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Work</label>
                        <Select v-model="profileInfo.work" optionValue="name" :options="work" editable
                            optionLabel="name" placeholder="Select a City" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Family Head</label>
                        <Select v-model="profileInfo.family_head_id" :options="family_head" optionValue="id" editable
                            optionLabel="name" placeholder="Select a City" class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Relationship to Family Head</label>
                        <Select v-model="profileInfo.relation_ship_to_head" optionValue="name"
                            :options="relationship_to_head" editable optionLabel="name" placeholder="Select a City"
                            class="w-full " />
                    </div>
                </div>
                <Button label="Submit" type="submit" class="w-full mt-2" />
            </form>
        </Dialog> -->
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import { civil_status, blood_type, educational_attainment, health_status, maintenance, relationship_to_head, sex, work } from '@/service/SelectDatas.js'
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
    bmi: '',
    health_status: ''
})
const isLoading = ref(true)
const profileInfo = ref({
    id: '',
    lastname: '',
    firstname: '',
    middlename: '',
    birthdate: '',
    sex: '',
    civil_status: '',
    educational_attainment: '',
    work: '',
    relation_ship_to_head: '',
    phone_number: ''
})

const profiles = ref([])
const toast = useToast();
onMounted(async () => {
    await getPersonalProfile()
    isLoading.value = false
})
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
        accept: () => {
            toast.add({ severity: 'info', summary: 'Confirmed', detail: 'You have accepted', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });

}
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
        toast.add({ severity: 'info', summary: 'Info', detail: 'Updated successfully', life: 3000 });
    } catch (err) {
        console.log(err)
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
        toast.add({ severity: 'info', summary: 'Info', detail: 'Updated successfully', life: 3000 });
    } catch (err) {
        console.log(err)
    }
}
async function getPersonalProfile() {
    await window.axios.post(`${window.baseurl}api/personalprofile/getPersonalProfile`, {}, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        profiles.value = response.data.data
        console.log(response.data)
    }).catch(err => {
        console.error(err)
    })
}
function setForUpdatePersonalProfile(profile){
    for (const key in profileInfo.value) {
        profileInfo.value[key] = profile[key]
    }
}
function setForUpdateHealthProfile(profile){
    for (const key in healthInfo.value) {
        healthInfo.value[key] = profile[key]
    }
}
</script>