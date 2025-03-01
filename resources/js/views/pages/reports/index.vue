<template>
  <Dialog v-model:visible="ageModal" modal header="Enter age" position="top" class="md:w-1/6 w-full"
    :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
    <form @submit.prevent="downloadUnderweight()">
      <label for="">Age</label>
      <InputNumber class="w-full" v-model="age" required :useGrouping="false" inputId="integeronly" />
      <label for="">Purok
        <Asterisk />
      </label>
      <Select v-model="purok_id" :options="puroks" optionValue="id" filter optionLabel="name" placeholder="Select"
        class="w-full">   
      </Select>
      <Button label="Generate" type="submit" class="w-full mt-2" />
    </form>
  </Dialog>
  <Dialog v-model:visible="purokModal" modal header="Select purok" position="top" class="md:w-1/6 w-full"
    :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
    <form @submit.prevent="download()">
      <label for="">Purok
        <Asterisk />
      </label>
      <Select v-model="purok_id" :options="puroks" optionValue="id" filter optionLabel="name" placeholder="Select"
        class="w-full">
      </Select>
      <Button label="Generate" type="submit" class="w-full mt-2" />
    </form>
  </Dialog>
  <Dialog v-model:visible="pregnantModal" modal header="Enter age" position="top" class="md:w-1/6 w-full"
    :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
    <form @submit.prevent="downloadPregnants()">
      <label for="">Age</label>
      <InputNumber class="w-full" v-model="age" required :useGrouping="false" inputId="integeronly" />
      <label for="">Purok
        <Asterisk />
      </label>
      <Select v-model="purok_id" :options="puroks" optionValue="id" filter optionLabel="name" placeholder="Select"
        class="w-full">   
      </Select>
      <Button label="Generate" type="submit" class="w-full mt-2" />
    </form>
  </Dialog>
  <div class="card flex flex-col gap-4">
    <div class="flex flex-wrap gap-4">
      <a href="javascript:void(0)" @click="purokModal = true, reportToGenerate = 'household'"
        v-tooltip.top="'Download household report'"
        class="flex flex-col items-center gap-2 bg-emerald-400 w-44 text-center py-4 rounded-md tracking-wider text-white ">
        <v-icon name="bi-house-door-fill" scale="3"></v-icon>
        HOUSEHOLDS
      </a>
      <a href="javascript:void(0)" @click="purokModal = true, reportToGenerate = 'seniorcitizen'"
        v-tooltip.top="'Download senior citizen report'"
        class="flex flex-col items-center gap-2 bg-emerald-400 w-44 text-center py-4 rounded-md tracking-wider text-white ">
        <v-icon name="oi-person-fill" scale="3"></v-icon>
        SENIOR CITIZENS
      </a>
      <a href="javascript:void(0)" @click="pregnantModal = true" v-tooltip.top="'Download pregnant report'"
        class="flex flex-col items-center gap-2 bg-emerald-400 w-44 text-center py-4 rounded-md tracking-wider text-white ">
        <v-icon name="md-pregnantwoman" scale="3"></v-icon>
        PREGNANTS
      </a>
      <a href="javascript:void(0)" @click="ageModal = true" v-tooltip.top="'Download underweight report'"
        class="flex flex-col items-center gap-2 bg-emerald-400 w-44 text-center py-4 rounded-md tracking-wider text-white ">
        <v-icon name="fa-child" scale="3"></v-icon>
        UNDERWEIGHT
      </a>
    </div>
    <form @submit.prevent="createReportByCategory()">
      <div class="flex md:justify-between flex-wrap gap-4">
        <div class="flex-1">
          <label>Category</label>
          <Select v-model="category" optionValue="name" :options="categories" optionLabel="name" class="w-full "
            required />
        </div>
        <div class="flex-1">
          <div v-if="category == 'Civil Status'">
            <label>Civil Status</label>
            <Select v-model="categoryValue" optionValue="name" :options="civil_status" optionLabel="name"
              class="w-full " required />
          </div>
          <div v-if="category == 'Educational Attainment'">
            <label>Educational Attainment</label>
            <Select v-model="categoryValue" optionValue="name" :options="educational_attainment" optionLabel="name"
              class="w-full " required />
          </div>
          <div v-if="category == 'Electricity'">
            <label>Electricity</label>
            <Select v-model="categoryValue" optionValue="name" :options="electricity" optionLabel="name" class="w-full "
              required />
          </div>
          <div v-if="category == 'Health Status'">
            <label>Health Status</label>
            <Select v-model="categoryValue" optionValue="name" :options="health_status" optionLabel="name"
              class="w-full " required />
          </div>
          <div v-if="category == 'Maintenance'">
            <label>Maintenance</label>
            <Select v-model="categoryValue" optionValue="name" :options="maintenance" optionLabel="name" class="w-full "
              required />
          </div>
          <div v-if="category == 'Sex'">
            <label>Sex</label>
            <Select v-model="categoryValue" optionValue="name" :options="sex" optionLabel="name" class="w-full "
              required />
          </div>
          <div v-if="category == 'Work'">
            <label>Work</label>
            <Select v-model="categoryValue" optionValue="name" :options="work" optionLabel="name" class="w-full "
              required />
          </div>
          <div v-if="category == 'Age'">
            <div class="flex md:justify-between flex-wrap  gap-4">
              <div class="flex-1">
                <label for="">Minimum Age</label>
                <InputNumber class="w-full" v-model="minAge" inputId="withoutgrouping" required :useGrouping="false" />
              </div>
              <div class="flex-1">
                <label for="">Maximum Age</label>
                <InputNumber class="w-full" v-model="maxAge" inputId="withoutgrouping" required :useGrouping="false" />
              </div>

            </div>
          </div>
        </div>
        <div class="flex-1">
          <label class="text-transparent">.</label>
          <Button label="Generate Report" type="submit" class="w-full" />
        </div>
      </div>
    </form>
    <!-- <p class="text-xl font-bold">Filter By Age (Range):</p>
    <form @submit.prevent="generateReportAgeRange()">
      <div class="flex md:justify-between flex-wrap  gap-4">
        <div class="flex-1">
          <label for="">Minimum Age</label>
          <InputNumber class="w-full" v-model="minAge" inputId="withoutgrouping" required :useGrouping="false" />
        </div>
        <div class="flex-1">
          <label for="">Maximum Age</label>
          <InputNumber class="w-full" v-model="maxAge" inputId="withoutgrouping" required :useGrouping="false" />
        </div>
        <div class="flex-1">
          <label class="text-transparent">.</label>
          <Button label="Generate Report" type="submit" class="w-full" />
        </div>
      </div>
    </form> -->
  </div>
</template>
<script setup>
import { onMounted, watch, ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import VueCookies from 'vue-cookies';

const toast = useToast()
import { civil_status, educational_attainment, electricity, health_status, maintenance, sex, work } from '@/service/SelectDatas.js'
const categories = ref([
  { name: 'Civil Status' },
  { name: 'Educational Attainment' },
  { name: 'Electricity' },
  { name: 'Health Status' },
  { name: 'Maintenance' },
  { name: 'Sex' },
  { name: 'Work' },
  { name: 'Age' }
])
const ageModal = ref(false)
const pregnantModal = ref(false)
const age = ref(18)
const category = ref('Civil Status')
const categoryValue = ref('')
const minAge = ref(0)
const maxAge = ref(0)
const puroks = ref([])
const purok_id = ref(0)
const purokModal = ref(false)
const reportToGenerate = ref('')
watch(
  () => category.value,
  () => {
    categoryValue.value = ''
  }
)
onMounted(async () => {
  await getPuroks()
})
async function getPuroks() {
  await window.axios.get(`${window.baseurl}api/household/getPuroks`, {
    headers: {
      'Authorization': `Bearer ${VueCookies.get('token')}`
    }
  }).then(response => {
    puroks.value = response.data.puroks
    puroks.value.push({ id: 0, name: 'All' })
    // console.log(response.data)
  }).catch(err => {
    console.error(err)
  })
}
function generateReportAgeRange() {
  window.location.href = `/healthdataease/public/reports/generateReportAgeRange/${minAge.value}/${maxAge.value}`
}
function createReportByCategory() {
  if (category.value == 'Age') {
    generateReportAgeRange();
    return;
  }
  if (category.value == '') {
    toast.add({ severity: 'error', summary: 'Error', detail: 'Please select category', life: 3000 });
  } else if (categoryValue.value == '') {
    toast.add({ severity: 'error', summary: 'Error', detail: 'Please select category value', life: 3000 });
  } else {
    window.location.href = `/healthdataease/public/reports/bycategory/${category.value}/${categoryValue.value}`;
  }
}
function downloadUnderweight() {
  ageModal.value = false
  window.location.href = `/healthdataease/public/reports/underweight/${age.value}/${purok_id.value}`;
}
function downloadPregnants() {
  pregnantModal.value = false
  window.location.href = `/healthdataease/public/reports/pregnants/${age.value}/${purok_id.value}`;
}
function download() {
  window.location.href = `/healthdataease/public/reports/${reportToGenerate.value}/${purok_id.value}`;
}
</script>