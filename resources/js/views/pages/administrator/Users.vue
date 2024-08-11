<template>
    <Spinner v-if="isLoading" />

    <div class="card flex flex-col gap-4" v-if="!isLoading">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <Dialog v-model:visible="addUpdateModalVisible" maximizable modal header="User Form" position="top"
            class="md:w-3/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="!updateUserOrNot ? register() : updateUser()">

                <div class="grid grid-cols-3 gap-2 mt-1">
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Username</label>
                        <InputText class="w-full" v-model="userinfo.username" required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Lastname</label>
                        <InputText class="w-full" v-model="userinfo.lastname" required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Firstname</label>
                        <InputText class="w-full" v-model="userinfo.firstname" required />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Middlename</label>
                        <InputText class="w-full" v-model="userinfo.middlename" />
                    </div>
                    <div class="md:col-span-1 col-span-3">
                        <label for="">Suffix</label>
                        <InputText class="w-full" v-model="userinfo.suffix" />
                    </div>
                    <div class="md:col-span-1 col-span-3" v-if="!updateUserOrNot">
                        <label for="">Password</label>
                        <Password v-model="userinfo.password" placeholder="Password" toggleMask required
                            :toggleMask="true" class="mb-4" fluid>
                        </Password>
                    </div>
                </div>
                <label for="">Admin</label> <br />
                <Checkbox v-model="isAdmin" binary />
                <Button :label="!updateUserOrNot ? 'SUBMIT' : 'UPDATE'" type="submit" class="w-full mt-2" />
            </form>

        </Dialog>
        <Dialog v-model:visible="changePasswordModal" maximizable modal header="Change Password" position="top"
            class="md:w-2/6 w-full" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            <form @submit.prevent="changePassword()">

                <label for="">Old Password</label>
                <Password v-model="userinfo.old_password" :feedback="false" placeholder="Password" required
                    class="mb-4 w-full" fluid>
                </Password>
                <label for="">New Password</label>
                <Password v-model="userinfo.password" placeholder="Password" toggleMask required :toggleMask="true"
                    class="mb-4" fluid>
                </Password>
                <label for="">Re-type Password</label>
                <Password v-model="userinfo.retype_password" placeholder="Password" V required :toggleMask="true"
                    class="mb-4" fluid>
                </Password>

                <Button label="Confirm" type="submit" class="w-full mt-2" />
            </form>
        </Dialog>
        <DataTable :value="users" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex justify-between">
                    <div class="flex items-center justify-center gap-x-2">
                        <Button label="Show" class="w-[4em]"
                            @click="updateUserOrNot = false, addUpdateModalVisible = true"><v-icon name="fa-user-plus"
                                scale="1.2"></v-icon></Button>
                    </div>
                    <div class="flex  ">
                        <IconField>
                            <InputIcon class="pi pi-search" />
                            <InputText placeholder="Search" v-model="search" @keyup="getUsers()" />
                        </IconField>
                    </div>
                </div>
            </template>
            <Column field="username" header="Username"></Column>
            <Column field="lastname" header="Lastname"></Column>
            <Column field="firstname" header="Firstname"></Column>
            <Column field="middlename" header="Middlename"></Column>
            <Column field="suffix" header="Suffix"></Column>
            <Column field="role" header="Role">
                <template #body="slotProps">
                    <p class="bg-sky-500 text-xs py-1 rounded-full text-white w-16 text-center"
                        v-if="slotProps.data.role == 0">ADMIN</p>
                    <p class="bg-green-500 text-xs py-1 rounded-full text-white w-16 text-center"
                        v-if="slotProps.data.role == 1">BHW</p>
                </template>
            </Column>
            <Column header="Action" class="min-w-48">
                <template #body="slotProps">
                    <button type="button"
                        @click="setForUpdateUser(slotProps.data), updateUserOrNot = true, addUpdateModalVisible = true"
                        class="bg-emerald-500 text-white py-1 px-2 rounded-sm ml-1" v-tooltip.top="'Update'"><v-icon
                            name="fa-edit"></v-icon></button>
                    <button type="button" @click="userinfo.id = slotProps.data.id, changePasswordModal = true"
                        class="bg-sky-500 text-white py-1 px-2 rounded-sm ml-1"
                        v-tooltip.top="'Update Password'"><v-icon name="bi-shield-lock"></v-icon></button>
                    <button type="button" @click="id = slotProps.data.id, confirmArchive()"
                        class="bg-red-500 text-white py-1 px-2 rounded-sm ml-1" v-tooltip.top="'Archive member'"><v-icon
                            name="bi-trash"></v-icon></button>
                </template>
            </Column>
            <template #footer>
                <Paginator v-on:page="getUsers()" ref="paginator" :rows="10" :totalRecords="totalRecords"
                    :rowsPerPageOptions="[10, 25, 50, 100]"></Paginator>
            </template>
        </DataTable>
    </div>
</template>
<script setup>
import { ref, onMounted, watch } from 'vue'
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import VueCookies from 'vue-cookies';
const addUpdateModalVisible = ref(false)
const changePasswordModal = ref(false)
const confirm = useConfirm();
const isLoading = ref(true)
const id = ref(0)
const paginator = ref(null)
const users = ref([])

const userinfo = ref({
    id: '',
    username: '',
    lastname: '',
    firstname: '',
    middlename: '',
    suffix: '',
    role: 1,
    old_password: '',
    password: '',
    retype_password: ''
})
const isAdmin = ref(false)
const search = ref('')
const toast = useToast();
const totalRecords = ref('')
const updateUserOrNot = ref(false)

watch(
    () => addUpdateModalVisible.value,
    () => {
        if (!addUpdateModalVisible.value) {
            clearVariables()
            updateUserOrNot.value = false
        }
    }
)
onMounted(async () => {
    await getUsers()
    isLoading.value = false
})
async function getUsers() {
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
    await window.axios.post(`${window.baseurl}api/auth/getUsers`, data, {
        headers: {
            'Authorization': `Bearer ${VueCookies.get('token')}`
        }
    }).then(response => {
        users.value = response.data.users
        totalRecords.value = response.data.count
        console.log(response.data)
    }).catch(err => {
        console.error(err)
    })
}
async function register() {
    try {
        if (isAdmin.value) {
            userinfo.value.role = 0
        }
        const response = await window.axios.post(`${window.baseurl}api/auth/register`, userinfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        await getUsers()
        toast.add({ severity: response.data.status, summary: 'Success', detail: response.data.message, life: 3000 });
        addUpdateModalVisible.value = false
    } catch (err) {
        console.log(err)
    }
}
async function changePassword() {
    try {
        const response = await window.axios.post(`${window.baseurl}api/auth/changePassword`, userinfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        toast.add({ severity: response.data.status, summary: 'Success', detail: response.data.message, life: 3000 });
        changePasswordModal.value = false
    } catch (err) {
        console.log(err)
    }
}
async function updateUser() {
    try {
        if (isAdmin.value) {
            userinfo.value.role = 0
        }
        const response = await window.axios.post(`${window.baseurl}api/auth/updateUser`, userinfo.value, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        await getUsers()
        toast.add({ severity: response.data.status, summary: 'Success', detail: response.data.message, life: 3000 });
        addUpdateModalVisible.value = false
    } catch (err) {
        console.log(err)
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
            await window.axios.delete(`${window.baseurl}api/auth/archiveUser/${id.value}`, {
                headers: {
                    'Authorization': `Bearer ${VueCookies.get('token')}`
                }
            })
            await getUsers()
            toast.add({ severity: 'success', summary: 'Success', detail: 'Archive successfully', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });

}
function clearVariables() {
    for (const key in userinfo.value) {
        if (typeof userinfo.value[key] === 'string') {
            userinfo.value[key] = ''
        } else {
            userinfo.value[key] = 1
        }
    }
    isAdmin.value = false
}
function setForUpdateUser(user) {
    for (const key in userinfo.value) {
        if (key == 'role') {
            isAdmin.value = user[key] == 0 ? true : false
        } else {
            if (key !== 'password' && key !== 'old_password' && key !== 'retype_password') {
                userinfo.value[key] = user[key]
            }
        }
    }
}
</script>