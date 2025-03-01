<template>
    <Spinner v-if="isLoading" />

    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <Dialog v-model:visible="addUpdatePurokModalVisible" modal header="Purok" position="top" class="md:w-2/6 w-full"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="!updatePurokOrNot ? addPurok() : updatePurok()">
                <label for="">Name
                    <Asterisk />
                </label>
                <InputText class="w-full" v-model="purokinfo.name" required />
                <Button :label="!updatePurokOrNot ? 'SUBMIT' : 'UPDATE'" type="submit" class="w-full mt-2" />
            </form>
        </Dialog>
        <Dialog v-model:visible="addUpdateVaccineModalVisible" modal header="Vaccine" position="top"
            class="md:w-2/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="!updateVaccineOrNot ? addVaccine() : updateVaccine()">
                <label for="">Name
                    <Asterisk />
                </label>
                <InputText class="w-full" v-model="vaccineinfo.name" required />
                <Button :label="!updateVaccineOrNot ? 'SUBMIT' : 'UPDATE'" type="submit" class="w-full mt-2" />
            </form>
        </Dialog>
        <p class="text-xl uppercase">Purok List</p>
        <DataTable :value="filteredPuroks" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
            tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex md:justify-between flex-wrap gap-2">
                    <div class="flex items-center justify-center gap-x-2">
                        <Button label="Show" class="w-[4em]"
                            @click="updatePurokOrNot = false, addUpdatePurokModalVisible = true"><v-icon
                                name="co-location-pin" scale="1.2"></v-icon></Button>
                    </div>
                    <div class="flex  ">
                        <IconField>
                            <InputIcon class="pi pi-search" />
                            <InputText placeholder="Search" v-model="searchPurok" />
                        </IconField>
                    </div>
                </div>
            </template>
            <Column field="name" header="Purok Name"></Column>
            <Column header="Action" class="w-40">
                <template #body="slotProps">
                    <button type="button"
                        @click="setForUpdatePurok(slotProps.data), updatePurokOrNot = true, addUpdatePurokModalVisible = true"
                        class="bg-emerald-500 text-white py-1 px-2 rounded-sm ml-1" v-tooltip.top="'Update'"><v-icon
                            name="fa-edit"></v-icon></button>

                    <button type="button" @click="purokinfo.id = slotProps.data.id, confirmPurokArchive()"
                        class="bg-red-500 text-white py-1 px-2 rounded-sm ml-1" v-tooltip.top="'Archive member'"><v-icon
                            name="bi-trash"></v-icon></button>
                </template>
            </Column>

        </DataTable>
        <p class="text-xl uppercase mt-4">Vaccine List</p>
        <DataTable :value="filteredVaccines" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
            tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex md:justify-between flex-wrap gap-2">
                    <div class="flex items-center justify-center gap-x-2">
                        <Button label="Show" class="w-[4em]"
                            @click="updateVaccineOrNot = false, addUpdateVaccineModalVisible = true"><v-icon
                                name="md-vaccines-round" scale="1.2"></v-icon></Button>
                    </div>
                    <div class="flex  ">
                        <IconField>
                            <InputIcon class="pi pi-search" />
                            <InputText placeholder="Search" v-model="searchVaccine" />
                        </IconField>
                    </div>
                </div>
            </template>
            <Column field="name" header="Vaccine Name"></Column>

            <Column header="Action" class="w-40">
                <template #body="slotProps">
                    <button type="button"
                        @click="setForUpdateVaccine(slotProps.data), updateVaccineOrNot = true, addUpdateVaccineModalVisible = true"
                        class="bg-emerald-500 text-white py-1 px-2 rounded-sm ml-1" v-tooltip.top="'Update'"><v-icon
                            name="fa-edit"></v-icon></button>

                    <button type="button" @click="vaccineinfo.id = slotProps.data.id, confirmVaccineArchive()"
                        class="bg-red-500 text-white py-1 px-2 rounded-sm ml-1" v-tooltip.top="'Archive member'"><v-icon
                            name="bi-trash"></v-icon></button>
                </template>
            </Column>

        </DataTable>
    </div>
</template>
<script setup>
import { computed, ref, onMounted, watch } from 'vue'
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import VueCookies from 'vue-cookies';
const addUpdatePurokModalVisible = ref(false)

const addUpdateVaccineModalVisible = ref(false)
const confirm = useConfirm();
const isLoading = ref(true)
// const id = ref(0)
const puroks = ref([])
const vaccines = ref([])
const purokinfo = ref({
    id: '',
    name: '',
})
const vaccineinfo = ref({
    id: '',
    name: '',
})
const searchPurok = ref('')
const searchVaccine = ref('')
const toast = useToast();
const updatePurokOrNot = ref(false)
const updateVaccineOrNot = ref(false)

watch(
    () => addUpdatePurokModalVisible.value,
    () => {
        if (!addUpdatePurokModalVisible.value) {
            clearVariables()
            updatePurokOrNot.value = false
        }
    }
)
const filteredPuroks = computed(() => {
    return puroks.value.filter((el) => el.name.toLowerCase().includes(searchPurok.value.toLowerCase()))
})
const filteredVaccines = computed(() => {
    return vaccines.value.filter((el) => el.name.toLowerCase().includes(searchVaccine.value.toLowerCase()))
})
onMounted(async () => {
    await getPuroks()
    await getVaccines()
    isLoading.value = false
})
async function getPuroks() {

    await window.axios.get(`${window.baseurl}api/household/getPuroks`, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        puroks.value = response.data.puroks
        console.log(response.data)
    }).catch(err => {
        console.error(err)
    })
}
async function getVaccines() {
    await window.axios.get(`${window.baseurl}api/healthprofile/getVaccines`, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        vaccines.value = response.data.vaccines
        // console.log(response.data)
    }).catch(err => {
        console.error(err)
    })
}
async function addPurok() {
    try {
        const response = await window.axios.post(`${window.baseurl}api/household/addPurok`, purokinfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        await getPuroks()
        toast.add({ severity: response.data.status, summary: 'Success', detail: response.data.message, life: 3000 });
        addUpdatePurokModalVisible.value = false
    } catch (err) {
        console.log(err)
    }
}
async function addVaccine() {
    try {
        const response = await window.axios.post(`${window.baseurl}api/healthprofile/addVaccine`, vaccineinfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        await getVaccines()
        toast.add({ severity: response.data.status, summary: 'Success', detail: response.data.message, life: 3000 });
        addUpdateVaccineModalVisible.value = false
    } catch (err) {
        console.log(err)
    }
}
async function updatePurok() {
    try {
        const response = await window.axios.post(`${window.baseurl}api/household/updatePurok`, purokinfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        await getPuroks()
        toast.add({ severity: response.data.status, summary: 'Success', detail: response.data.message, life: 3000 });
        addUpdatePurokModalVisible.value = false
    } catch (err) {
        console.log(err)
    }
}
async function updateVaccine() {
    try {
        const response = await window.axios.post(`${window.baseurl}api/healthprofile/updateVaccine`, vaccineinfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        await getVaccines()
        toast.add({ severity: response.data.status, summary: 'Success', detail: response.data.message, life: 3000 });
        addUpdateVaccineModalVisible.value = false
    } catch (err) {
        console.log(err)
    }
}
function confirmPurokArchive() {
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
            await window.axios.delete(`${window.baseurl}api/household/archivePurok/${purokinfo.value.id}`, {
                headers: {
                    'Authorization': `Bearer ${VueCookies.get('token')}`
                }
            })
            await getVaccines()
            toast.add({ severity: 'success', summary: 'Success', detail: 'Archive successfully', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });

}
function confirmVaccineArchive() {
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
            await window.axios.delete(`${window.baseurl}api/healthprofile/archiveVaccine/${vaccineinfo.value.id}`, {
                headers: {
                    'Authorization': `Bearer ${VueCookies.get('token')}`
                }
            })
            await getVaccines()
            toast.add({ severity: 'success', summary: 'Success', detail: 'Archive successfully', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });

}
function clearVariables() {
    for (const key in purokinfo.value) {
        purokinfo.value[key] = ''
    }
    // isAdmin.value = false
}
function setForUpdatePurok(purok) {
    for (const key in purokinfo.value) {
        purokinfo.value[key] = purok[key]
    }
}
function setForUpdateVaccine(vaccine) {
    for (const key in vaccineinfo.value) {
        vaccineinfo.value[key] = vaccine[key]
    }
}
</script>