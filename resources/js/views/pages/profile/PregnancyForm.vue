<template>
    <Spinner v-if="isLoading" />
    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <Dialog v-model:visible="addUpdateModalVisible" maximizable modal header="Pregnancy Form" position="top"
            class="md:w-3/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="!updatePregnancyOrNot ? insertPregnancy() : updatePregnancy()">
                <label for="" v-if="!updatePregnancyOrNot">Select Pregnant <Asterisk /></label>
                <Select v-if="!updatePregnancyOrNot" v-model="pregnancyInfo.personal_profile_id" :options="females"
                    optionValue="id" filter optionLabel="lastname" placeholder="Select" class="w-full">
                    <template #option="slotProps">
                        <div class="flex items-center">

                            <div>{{ `${slotProps.option.lastname} ${slotProps.option.firstname}
                                ${slotProps.option.lastname ? slotProps.option.middlename : ''}` }}</div>
                        </div>
                    </template>
                </Select>
                <div class="grid grid-cols-3 gap-2 mt-1 mb-2">
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Post-Partum <Asterisk /></label>
                        <InputNumber class="w-full" v-model="pregnancyInfo.post_partum" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Family Planning <Asterisk /></label>
                        <Select v-model="pregnancyInfo.family_planning" editable optionValue="name"
                            :options="family_planning" optionLabel="name" placeholder="Select family planning"
                            class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Type of Delivery <Asterisk /></label>
                        <Select v-model="pregnancyInfo.type_of_delivery" editable optionValue="name"
                            :options="type_of_delivery" optionLabel="name" placeholder="Select type of delivery"
                            class="w-full " />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">LMP <Asterisk /></label>
                        <DatePicker class="w-full" v-model="pregnancyInfo.lmp" dateFormat="yy-mm-dd" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">EDC <Asterisk /></label>
                        <InputText class="w-full" v-model="pregnancyInfo.edc" disabled />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Pregnant GP <Asterisk /></label>
                        <InputNumber class="w-full" v-model="pregnancyInfo.gp" />
                    </div>

                </div>
                <label for="">Status <Asterisk /></label>
                <Select v-model="pregnancyInfo.status" optionValue="name" :options="pregnancy_status" optionLabel="name"
                    placeholder="Select status" class="w-full " />
                <Button :label="!updatePregnancyOrNot ? 'SUBMIT' : 'UPDATE'" type="submit" class="w-full mt-2" />
            </form>

        </Dialog>

        <DataTable :value="pregnancies" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex md:justify-between flex-wrap gap-2">
                    <div class="flex items-center justify-center gap-x-2">
                        <Button label="Show" class="w-[4em]"
                            @click="updatePregnancyOrNot = false, addUpdateModalVisible = true"><v-icon
                                name="co-user-female" scale="1.2"></v-icon></Button>
                    </div>
                    <div class="flex  ">
                        <IconField>
                            <InputIcon class="pi pi-search" />
                            <InputText placeholder="Search" v-model="search" @keyup="getPregnancies()" />
                        </IconField>
                    </div>
                </div>
            </template>
            <Column field="lastname" header="Lastname"></Column>
            <Column field="firstname" header="Firstname"></Column>
            <Column field="middlename" header="Middlename"></Column>
            <Column field="post_partum" header="Post-Partum"></Column>
            <Column field="family_planning" header="Family Planning"></Column>
            <Column field="type_of_delivery" header="Type of Delivery"></Column>
            <Column field="lmp" header="LMP (Last Menstrual Period)"></Column>
            <Column field="edc" header="EDC (Estimated Date of Confinement)"></Column>
            <Column field="gp" header="GP (Gravida/Para)"></Column>
            <Column field="pregnancy_status" header="Status"></Column>
            <Column header="Action" class="min-w-48">
                <template #body="slotProps">
                    <button type="button"
                        @click="setForUpdatePregnancy(slotProps.data), updatePregnancyOrNot = true, addUpdateModalVisible = true"
                        class="bg-emerald-500 text-white py-1 px-2 rounded-sm ml-1" v-tooltip.top="'Update'"><v-icon
                            name="fa-edit"></v-icon></button>

                    <button type="button" @click="id = slotProps.data.pregnancy_id, confirmArchive()"
                        class="bg-red-500 text-white py-1 px-2 rounded-sm ml-1" v-tooltip.top="'Archive member'"><v-icon
                            name="bi-trash"></v-icon></button>
                </template>
            </Column>
            <template #footer>
                <Paginator v-on:page="getPregnancies()" ref="paginator" :rows="10" :totalRecords="totalRecords"
                    :rowsPerPageOptions="[10, 25, 50, 100]"></Paginator>
            </template>
        </DataTable>
    </div>
</template>
<script setup>
import { ref, onMounted, watch } from 'vue'
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { calculateEDC } from '@/service/Calculations.js'
import { family_planning, type_of_delivery, pregnancy_status } from '@/service/SelectDatas.js'
import VueCookies from 'vue-cookies';
const addUpdateModalVisible = ref(false)
const confirm = useConfirm();
const females = ref([])
const isLoading = ref(true)
const id = ref(0)
const paginator = ref(null)
const pregnancies = ref([])
const pregnancyInfo = ref({
    pregnancy_id: '',
    personal_profile_id: '',
    post_partum: 0,
    family_planning: '',
    type_of_delivery: '',
    lmp: '',
    edc: '',
    gp: 0,
    status: ''
})
const search = ref('')
const toast = useToast();
const totalRecords = ref('')
const updatePregnancyOrNot = ref(false)
watch(
    () => pregnancyInfo.value.lmp,
    () => {
        if (pregnancyInfo.value.lmp) {
            pregnancyInfo.value.edc = calculateEDC(pregnancyInfo.value.lmp)
        }
    }
)
watch(
    () => addUpdateModalVisible.value,
    () => {
        if (!addUpdateModalVisible.value) {
            clearVariables()
            updatePregnancyOrNot.value = false
        }
    }
)
onMounted(async () => {
    await getFemales()
    await getPregnancies()
    isLoading.value = false
})
async function getFemales() {
    await window.axios.post(`${window.baseurl}api/personalprofile/getFemales`, {}, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        females.value = response.data.females
    }).catch(err => {
        console.error(err)
    })
}
async function getPregnancies() {
    let data = null;
    if (paginator.value === null) {
        data = {
            page: 1,
            recordPerPage: 10,
            search: search.value
        }
    } else {
        data = {
            page: paginator.value.page + 1,
            recordPerPage: paginator.value.d_rows,
            search: search.value
        }
    }
    await window.axios.post(`${window.baseurl}api/pregnancy/getPregnancies`, data, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        pregnancies.value = response.data.pregnancies
        totalRecords.value = response.data.count
        // console.log(response.data.pregnancies)
    }).catch(err => {
        console.error(err)
    })
}
async function insertPregnancy() {
    try {
        if (pregnancyInfo.value.lmp) {
            const date = new Date(pregnancyInfo.value.lmp);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            pregnancyInfo.value.lmp = `${year}-${month}-${day}`;
        }
        const response = await window.axios.post(`${window.baseurl}api/pregnancy/insertPregnancy`, pregnancyInfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        await getFemales()
        await getPregnancies()
        toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
        addUpdateModalVisible.value = false
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });
    }
}
async function updatePregnancy() {
    try {
        if (pregnancyInfo.value.lmp) {
            const date = new Date(pregnancyInfo.value.lmp);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            pregnancyInfo.value.lmp = `${year}-${month}-${day}`;
        }
        const response = await window.axios.post(`${window.baseurl}api/pregnancy/updatePregnancy`, pregnancyInfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        await getFemales()
        await getPregnancies()
        toast.add({ severity: 'success', summary: 'Success', detail: response.data.message, life: 3000 });
        addUpdateModalVisible.value = false
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: err.response.data.message, life: 3000 });
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
            await window.axios.delete(`${window.baseurl}api/pregnancy/archivePregnancy/${id.value}`, {
                headers: {
                    'Authorization': `Bearer ${VueCookies.get('token')}`
                }
            })
            await getPregnancies()
            toast.add({ severity: 'success', summary: 'Success', detail: 'Archive successfully', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });

}
function clearVariables() {
    for (const key in pregnancyInfo.value) {
        if (typeof pregnancyInfo.value[key] === 'string') {
            pregnancyInfo.value[key] = ''
        } else {
            pregnancyInfo.value[key] = 0
        }
    }
}
function setForUpdatePregnancy(pregnancy) {
    for (const key in pregnancyInfo.value) {
        pregnancyInfo.value[key] = pregnancy[key]
    }
}
</script>