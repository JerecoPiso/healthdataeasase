<template>
  <div class="card flex flex-col gap-4">
    <div class="flex flex-wrap gap-4">
      <a href="/healthdataeasase/public/reports/household" v-tooltip.top="'Download household report'"
        class="flex flex-col items-center gap-2 bg-emerald-400 w-44 text-center py-4 rounded-md tracking-wider text-white ">
        <v-icon name="bi-house-door-fill" scale="3"></v-icon>
        HOUSEHOLDS
      </a>
      <a href="/healthdataeasase/public/reports/seniorcitizen" v-tooltip.top="'Download senior citizen report'"
        class="flex flex-col items-center gap-2 bg-emerald-400 w-44 text-center py-4 rounded-md tracking-wider text-white ">
        <v-icon name="oi-person-fill" scale="3"></v-icon>
        SENIOR CITIZENS
      </a>
      <a href="/healthdataeasase/public/reports/pregnants" v-tooltip.top="'Download senior citizen report'"
        class="flex flex-col items-center gap-2 bg-emerald-400 w-44 text-center py-4 rounded-md tracking-wider text-white ">
        <v-icon name="md-pregnantwoman" scale="3"></v-icon>
        PREGNANTS
      </a>
    </div>
  </div>
</template>