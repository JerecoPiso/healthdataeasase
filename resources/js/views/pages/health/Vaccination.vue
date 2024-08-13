<template>
    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <Toast />
        <ConfirmDialog></ConfirmDialog>

        <Dialog v-model:visible="addUpdateModalVisible" maximizable modal header="Vaccination" position="top"
            class="md:w-2/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="saveVaccination()">
                <label for="" v-if="!updateVaccinationOrNot">Select baby</label>
                <Select v-if="!updateVaccinationOrNot" v-model="babyInfo.personal_profile_id" :options="babies"
                    optionValue="id" filter optionLabel="lastname" placeholder="Select" class="w-full">
                    <template #option="slotProps">
                        <div class="flex items-center">
                            <div>{{ `${slotProps.option.lastname} ${slotProps.option.firstname}
                                ${slotProps.option.lastname ? slotProps.option.middlename : ''}` }}</div>
                        </div>
                    </template>
                </Select>
                <div class="grid grid-cols-2 gap-2 my-2">
                    <div class="md:col-span-1">
                        <label for="">Vaccine</label>
                        <InputText v-model="babyInfo.vaccine" class="w-full" required />
                    </div>
                    <div class="md:col-span-1">
                        <label for="">Vaccinator</label>
                        <InputText v-model="babyInfo.vaccinator" class="w-full" required />
                    </div>
                    <div class="md:col-span-1">
                        <label for="">Dose</label>
                        <InputNumber v-model="babyInfo.dose" :useGrouping="false" class="w-full" required />
                    </div>
                    <div class="md:col-span-1">
                        <label for="">Vaccination date</label>
                        <DatePicker v-model="vaccination_datetime" class="w-full" required showTime hourFormat="24"
                            fluid />
                    </div>
                </div>
                <label for="">Remarks</label>
                <Textarea rows="2" class="w-full" />

                <Button :label="!updateVaccinationOrNot ? 'SUBMIT' : 'UPDATE'" type="submit" class="w-full mt-2" />
            </form>
        </Dialog>
        <DataTable v-model:expandedRows="expandedRows" :value="vaccinations" dataKey="id" :rows="5"
            :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex justify-between">
                    <div>
                        <Button label="Show" class="w-[4em]"
                            @click="addUpdateModalVisible = true"><v-icon
                                name="co-baby" scale="1.2"></v-icon></Button>
                    </div>
                    <div class="flex flex-wrap justify-end gap-2">
                        <Button text icon="pi pi-plus" label="Expand All" @click="expandAll" />
                        <Button text icon="pi pi-minus" label="Collapse All" @click="collapseAll" />
                        <div class="flex  ">
                            <IconField>
                                <InputIcon class="pi pi-search" />
                                <InputText placeholder="Search" v-model="search" @keyup="getVaccinations()" />
                            </IconField>
                        </div>
                    </div>
                </div>
            </template>
            <Column expander style="width: 5rem" />
            <Column field="lastname" header="Lastname" />
            <Column field="firstname" header="Firstname" />
            <Column field="middlename" header="Middlename" />
            <Column field="sex" header="Sex" />
            <Column field="birthdate" header="Birthdate" />
            <template #expansion="slotProps">
                <div class="p-4">
                    <p class="uppercase font-bold">Vaccinations</p>
                    <DataTable :value="slotProps.data.vaccinations">
                        <Column field="vaccine" header="Vaccine" />
                        <Column field="vaccinator" header="Vaccinator" />
                        <Column field="dose" header="Dose" />
                        <Column field="vaccination_datetime" header="Date & Time" />
                        <Column field="remarks" header="Remarks" />
                        <Column header="Action">
                            <template #body="slotProp">
                                <button type="button"
                                    @click="updateVaccinationOrNot = true, setForUpdateVaccination(slotProp.data), addUpdateModalVisible = true"
                                    class="bg-sky-500 text-white py-1 px-2 rounded-sm"
                                    v-tooltip.top="'Update vaccination'"><v-icon
                                        name="co-baby"></v-icon></button>
                                <button type="button"
                                    @click="confirmArchive(slotProp.data.id)"
                                    class="ml-1 bg-red-500 text-white py-1 px-2 rounded-sm"
                                    v-tooltip.top="'Archive'"><v-icon
                                        name="bi-trash"></v-icon></button>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </template>
            <template #footer>
                <Paginator v-on:page="getBabies()" ref="paginator" :rows="10" :totalRecords="totalRecords"
                    :rowsPerPageOptions="[10, 25, 50, 100]"></Paginator>
            </template>
        </DataTable>
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue'
import { convertDateTimeString } from '@/service/Calculations.js'
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";

import VueCookies from 'vue-cookies'
const addUpdateModalVisible = ref(false)
const babies = ref([])
const babyInfo = ref({
    id: 0,
    personal_profile_id: 0,
    vaccine: '',
    vaccinator: '',
    dose: 0,
    vaccination_datetime: '',
    remarks: ''
})
const confirm = useConfirm()

const expandedRows = ref({});

const isLoading = ref(true)
const paginator = ref(null)
const search = ref('')
const totalRecords = ref(0)
const toast = useToast();
const updateVaccinationOrNot = ref(false)
const vaccination_datetime = ref('')
const vaccinations = ref([])
const expandAll = () => {
    expandedRows.value = vaccinations.value.reduce((acc, p) => (acc[p.id] = true) && acc, {});
};
const collapseAll = () => {
    expandedRows.value = null;
};
onMounted(async () => {
    await getVaccinations()
    await getBabies()
    isLoading.value = false
})
function confirmArchive(id) {
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
            alert(id)
            // const response = await window.axios.delete(`${window.baseurl}api/household/archiveHouseholdProfile/${id}`, {
            //     headers: {
            //         'Authorization': `Bearer ${VueCookies.get('token')}`
            //     }
            // })
            // await getHousehold()
            // toast.add({ severity: response.data.status, summary: response.data.status == 'success' ? 'Success' : 'Error', detail: response.data.message, life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
}
async function getBabies() {
    try {
        const response = await window.axios.get(`${window.baseurl}api/personalprofile/getBabies`, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        });
        babies.value = response.data.babies
        // console.log(response.data)
    } catch (err) {
        console.log(err.response.data)
    }
}
async function getVaccinations() {
    try {
        let data = null;
        if (paginator.value === null) {
            data = {
                page: 1,
                recordPerPage: 10,
                search: search.value
            }
        } else {
            console.log(paginator.value)
            data = {
                page: paginator.value.page + 1,
                recordPerPage: paginator.value.d_rows,
                search: search.value
            }
        }
        const response = await window.axios.post(`${window.baseurl}api/healthprofile/getVaccinations`, data, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        });
        vaccinations.value = response.data.vaccinations
        console.log(response.data)
    } catch (err) {
        console.log(err)
    }
}
async function saveVaccination() {
    try {
        // console.log(babyInfo.value.vaccination_datetime)
        if (babyInfo.value.personal_profile_id > 0) {
            if (vaccination_datetime.value) {
                babyInfo.value.vaccination_datetime = convertDateTimeString(vaccination_datetime.value)
                // console.log(convertDateTimeString(babyInfo.value.vaccination_datetime)); // Outputs: "2024-08-11 17:30:26"
                const response = await window.axios.post(`${window.baseurl}api/healthprofile/saveVaccination`, babyInfo.value, {
                    headers: {
                        'Authorization': `Bearer ${VueCookies.get('token')}`
                    }
                })
                addUpdateModalVisible.value = false
                clearVariables()
                toast.add({ severity: response.data.status, summary: response.data.status == 'success' ? 'Success' : 'Error', detail: response.data.message, life: 3000 });

            } else {
                toast.add({ severity: 'error', summary: 'Error', detail: 'Vaccination date is required!', life: 3000 });
            }
        } else {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Please select a baby!', life: 3000 });
        }
    } catch (err) {
        console.log(err)
    }
}
function clearVariables() {
    for (const key in babyInfo.value) {
        if (typeof babyInfo.value[key] === 'string') {
            babyInfo.value[key] = ''
        } else {
            babyInfo.value[key] = 0
        }
    }
}
function setForUpdateVaccination(_vaccination) {
    for (const key in babyInfo.value) {
        babyInfo.value[key] = _vaccination[key]
    }
}
</script>