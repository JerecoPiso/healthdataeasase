<template>
    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <!-- <Toast/> -->
        <Button label="Show" class="w-[4em]" @click="addModalVisible = true" ><v-icon name="bi-person-plus-fill" scale="1.2"></v-icon></Button>
        <DataTable :value="profiles" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
            <Column field="id" header="ID"></Column>
            <Column field="lastname" sortable header="Lastname"></Column>
            <Column field="firstname" sortable header="Firstname"></Column>
            <Column field="middlename" header="Middlename"></Column>
            <Column field="birthdate" header="Birthdate"></Column>
            <Column field="sex" sortable header="Sex"></Column>
            <Column field="civil_status" sortable header="Civil Status"></Column>

            <Column field="phone_number" header="Phone No."></Column>
            
            <Column field="educational_attainment" sortable header="Educational Attainment"></Column>
            <Column field="work" sortable header="Work"></Column>
        </DataTable>

        <Dialog v-model:visible="addModalVisible" maximizable modal header="Profile" position="top" class="md:w-4/6 w-full"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
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

        </Dialog>
    
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useToast } from "primevue/usetoast";
import { civil_status, educational_attainment, relationship_to_head, sex, work } from '@/service/SelectDatas.js'
import VueCookies from 'vue-cookies';

const family_head = ref([
    { id: 1, name: 'John Doe' },
    { id: 2, name: 'Juan Cruz' },
])
const isLoading = ref(true)
const profileInfo = ref({
    lastname: '',
    firstname: '',
    middlename: '',
    birthdate: '',
    sex: '',
    civil_status: '',
    educational_attainment: '',
    work: '',
    family_head_id: '',
    relation_ship_to_head: '',
    phone_number: ''
})
const profiles = ref([])
const toast = useToast();

const addModalVisible = ref(false)
onMounted(async () => {
    await getPersonalProfile()
    isLoading.value = false
})
async function insertPersonalProfile() {
    try {
        if (profileInfo.value.birthdate) {
            const date = new Date(profileInfo.value.birthdate);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            profileInfo.value.birthdate = `${year}-${month}-${day}`;
        }
        const response = await window.axios.post(`${window.baseurl}api/personalprofile/insertPersonalProfile`, profileInfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        addModalVisible.value = false
        toast.add({ severity: 'info', summary: 'Info', detail: 'Saved successfully', life: 3000 });
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
</script>