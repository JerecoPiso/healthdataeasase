<template>
    <Spinner v-if="isLoading" />
    <div class="grid grid-cols-12 gap-8" v-if="!isLoading">
        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="card mb-0">
                <div class="flex justify-between mb-4">
                    <div>
                        <span class="block text-muted-color font-medium mb-4">Registered</span>
                        <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">{{ counts.personal }}
                        </div>
                    </div>
                    <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-full"
                        style="width: 2.5rem; height: 2.5rem">
                        <!-- <i class="pi pi-shopping-cart text-blue-500 !text-xl"></i> -->
                        <v-icon name="bi-person-circle" class="text-blue-500 !text-xl"></v-icon>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="card mb-0">
                <div class="flex justify-between mb-4">
                    <div>
                        <span class="block text-muted-color font-medium mb-4">Users</span>
                        <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">{{ counts.users }}</div>
                    </div>
                    <div class="flex items-center justify-center bg-orange-100 dark:bg-orange-400/10 rounded-full"
                        style="width: 2.5rem; height: 2.5rem">
                        <v-icon name="fa-users-cog" class="text-orange-500 !text-xl"></v-icon>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="card mb-0">
                <div class="flex justify-between mb-4">
                    <div>
                        <span class="block text-muted-color font-medium mb-4">Households</span>
                        <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">{{ counts.household }}
                        </div>
                    </div>
                    <div class="flex items-center justify-center bg-cyan-100 dark:bg-cyan-400/10 rounded-full"
                        style="width: 2.5rem; height: 2.5rem">
                        <v-icon name="fa-house-user" class="text-cyan-500 !text-xl"></v-icon>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="card mb-0">
                <div class="flex justify-between mb-4">
                    <div>
                        <span class="block text-muted-color font-medium mb-4">Pregnancy Record</span>
                        <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">{{ counts.pregnancy }}
                        </div>
                    </div>
                    <div class="flex items-center justify-center bg-purple-100 dark:bg-purple-400/10 rounded-full"
                        style="width: 2.5rem; height: 2.5rem">
                        <!-- <i class="pi pi-comment text-purple-500 !text-xl"></i> -->
                        <v-icon name="md-pregnantwoman" class="text-purple-500 !text-xl rounded-border"></v-icon>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-span-12 xl:col-span-6" v-if="!isLoading">
        <div class="grid grid-cols-12 gap-4 mt-4">
            <div class="md:col-span-8">
                <div class="card mb-0">
                    <Chart type="bar" :data="ageChart" :options="ageOptions" :plugins="plugins" />
                </div>
            </div>
            <div class="md:col-span-4">
                <div class="card mb-0">
                    <label class="block text-muted-color font-medium mb-4">Gender</label>
                    <Chart type="doughnut" :data="genderChart" :options="genderOptions" :plugins="plugins" />
                </div>
                <div class="card mb-0 mt-4">
                    <label class="block text-muted-color font-medium mb-4">BMI Categories <span class="text-slate-500 text-sm">(18 yrs. old below)</span></label>
                    <Chart type="doughnut" :data="bmiTeenChart" :options="bmiTeenChartOptions" :plugins="plugins" />
                </div>
                <div class="card mb-0 mt-4">
                    <label class="block text-muted-color font-medium mb-4">BMI Categories <span class="text-slate-500 text-sm">(18 yrs. old above)</span></label>
                    <Chart type="doughnut" :data="bmiAdultChart" :options="bmiAdultChartOptions" :plugins="plugins" />
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import VueCookies from 'vue-cookies';

import ChartDataLabels from 'chartjs-plugin-datalabels'
import { setBarChartData, setBarChartOptions, setDoughnutData, setDoughnutOptions } from '@/service/Charts.js'
import { onMounted, ref, watch } from 'vue';
const ageChart = ref()
const ageOptions = ref()
const ageCounts = ref()
const bmiTeenChart = ref()
const bmiTeenChartOptions = ref()
const bmiTeenCounts = ref()
const bmiAdultChart = ref()
const bmiAdultChartOptions = ref()
const bmiAdultCounts = ref()
const genderChart = ref()
const genderOptions = ref()
const genderCounts = ref()

const counts = ref({
    users: 0,
    household: 0,
    personal: 0,
    health: 0,
    pregnancy: 0
})
const isLoading = ref(true)
const plugins = [ChartDataLabels]
onMounted(async () => {
    await getCounts()
    await getCountsByAgeGroup()
    const bgColors = ['#00A9FF', '#68D2E8', '#FDDE55', '#FEEFAD']
    ageChart.value = setBarChartData(['0-2 yrs. old', '3-18 yrs. old', '19-59 yrs. old', '60 yrs. old Above'], Object.entries(ageCounts.value).map(([key, value]) => value), bgColors)
    ageOptions.value = setBarChartOptions()

    genderChart.value = setDoughnutData(Object.entries(genderCounts.value).map((key, value) => key[0]), Object.entries(genderCounts.value).map((key, value) => key[1]), ['#00FFAB', '#92B4EC'])
    genderOptions.value = setDoughnutOptions()

    bmiTeenChart.value = setDoughnutData(Object.entries(bmiTeenCounts.value).map((key, value) => key[0]), Object.entries(bmiTeenCounts.value).map((key, value) => key[1]), ['#7286D3', '#8EA7E9', '#E5E0FF', '#FFF2F2'])
    bmiTeenChartOptions.value = setDoughnutOptions()

    bmiAdultChart.value = setDoughnutData(Object.entries(bmiAdultCounts.value).map((key, value) => key[0]), Object.entries(bmiAdultCounts.value).map((key, value) => key[1]), ['#7286D3', '#8EA7E9', '#E5E0FF', '#FFF2F2'])
    bmiAdultChartOptions.value = setDoughnutOptions()
    isLoading.value = false
});
async function getCountsByAgeGroup() {
    try {
        const response = await window.axios.get(`${window.baseurl}api/dashboard/getCountsByAgeGroup`, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        });
        ageCounts.value = response.data.ages
        genderCounts.value = response.data.genders
        bmiTeenCounts.value = response.data.bmiTeenagers
        bmiAdultCounts.value = response.data.bmiAdults
        
        console.log(response.data)
    } catch (err) {
        console.log(err.response)
    }
}
async function getCounts() {
    try {
        const response = await window.axios.get(`${window.baseurl}api/dashboard/getCounts`, {
            headers: {
                'Authorization': `Bearer ${VueCookies.get('token')}`
            }
        })
        if (response.statusText === "OK") {
            console.log(response.data)
            for (const key in counts.value) {
                counts.value[key] = response.data.counts[key]
            }
        }
    } catch (err) {
        console.log(err)
    }
}
</script>
