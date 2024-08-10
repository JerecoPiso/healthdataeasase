<template>

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
    <div class="col-span-12 xl:col-span-6">
        <Spinner v-if="isLoading" />
    </div>
</template>
<script setup>
import { useLayout } from '@/layout/composables/layout';
import VueCookies from 'vue-cookies';

import { onMounted, ref, watch } from 'vue';
const { getPrimary, getSurface, isDarkTheme } = useLayout();
const counts = ref({
    users: 0,
    household: 0,
    personal: 0,
    health: 0,
    pregnancy: 0
})
const isLoading = ref(true)
onMounted(async () => {
    await getCounts()
    isLoading.value = false
});
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
function setChartData() {
    const documentStyle = getComputedStyle(document.documentElement);

    return {
        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        datasets: [
            {
                type: 'bar',
                label: 'Subscriptions',
                backgroundColor: documentStyle.getPropertyValue('--p-primary-400'),
                data: [4000, 10000, 15000, 4000],
                barThickness: 32
            },
            {
                type: 'bar',
                label: 'Advertising',
                backgroundColor: documentStyle.getPropertyValue('--p-primary-300'),
                data: [2100, 8400, 2400, 7500],
                barThickness: 32
            },
            {
                type: 'bar',
                label: 'Affiliate',
                backgroundColor: documentStyle.getPropertyValue('--p-primary-200'),
                data: [4100, 5200, 3400, 7400],
                borderRadius: {
                    topLeft: 8,
                    topRight: 8
                },
                borderSkipped: true,
                barThickness: 32
            }
        ]
    };
}

function setChartOptions() {
    const documentStyle = getComputedStyle(document.documentElement);
    const borderColor = documentStyle.getPropertyValue('--surface-border');
    const textMutedColor = documentStyle.getPropertyValue('--text-color-secondary');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        scales: {
            x: {
                stacked: true,
                ticks: {
                    color: textMutedColor
                },
                grid: {
                    color: 'transparent',
                    borderColor: 'transparent'
                }
            },
            y: {
                stacked: true,
                ticks: {
                    color: textMutedColor
                },
                grid: {
                    color: borderColor,
                    borderColor: 'transparent',
                    drawTicks: false
                }
            }
        }
    };
}

// const formatCurrency = (value) => {
//     return value.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
// };

// watch([getPrimary, getSurface, isDarkTheme], () => {
//     chartData.value = setChartData();
//     chartOptions.value = setChartOptions();
// });
</script>
