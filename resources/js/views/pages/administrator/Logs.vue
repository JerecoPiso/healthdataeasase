<template>
    <Spinner v-if="isLoading" />

    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <DataTable :value="logs" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex justify-between">
                    <div class="flex items-center justify-center gap-x-2">

                    </div>
                    <div class="flex  ">
                        <IconField>
                            <InputIcon class="pi pi-search" />
                            <InputText placeholder="Search" v-model="search" @keyup="getLogs()" />
                        </IconField>
                    </div>
                </div>
            </template>
            <Column field="action" header="Action"></Column>
            <Column field="status" header="Status"></Column>
            <Column field="message" header="Message"></Column>
            <Column field="username" header="Username"></Column>
            <Column  header="Date & Time">
                <template #body="slotProps">

                        {{ convertDateTime(slotProps.data.created_at) }}
                </template>
            </Column>
            <Column field="role" header="Role">
                <template #body="slotProps">
                    <p class="bg-sky-500 text-xs py-1 rounded-full text-white w-16 text-center"
                        v-if="slotProps.data.role == 0">ADMIN</p>
                    <p class="bg-green-500 text-xs py-1 rounded-full text-white w-16 text-center"
                        v-if="slotProps.data.role == 1">BHW</p>
                </template>
            </Column>

            <template #footer>
                <Paginator v-on:page="getLogs()" ref="paginator" :rows="10" :totalRecords="totalRecords"
                    :rowsPerPageOptions="[10, 25, 50, 100]"></Paginator>
            </template>
        </DataTable>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import VueCookies from 'vue-cookies';
const isLoading = ref(true)
const paginator = ref(null)
const logs = ref([])
const search = ref('')
const totalRecords = ref('')
const updateUserOrNot = ref(false)
onMounted(async () => {
    await getLogs()
    isLoading.value = false
})
async function getLogs() {
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
    await window.axios.post(`${window.baseurl}api/auth/getLogs`, data, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        logs.value = response.data.logs
        totalRecords.value = response.data.count
        console.log(response.data)
    }).catch(err => {
        console.error(err)
    })
}
function convertDateTime(datetime) {
    let date = new Date(datetime);
    let formattedDate = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2)

    let hours = date.getHours()
    let minues = ('0' + date.getMinutes()).slice(-2)
    let seconds = ('0' + date.getSeconds()).slice(-2)

    let ampm = hours >= 12 ? 'pm' : 'am'
    hours = hours % 12 || 12

    let formattedTime = ('0' + hours).slice(-2) + ':'+minues+':'+seconds + ' ' + ampm

    return `${formattedDate} ${formattedTime}`
}
</script>