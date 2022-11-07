<script setup>
import { computed, ref, onMounted } from "vue";
import { useMainStore } from "@/Stores/main";
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
  mdiMonitorCellphone,
  mdiReload,
  mdiGithub,
  mdiChartPie,
} from "@mdi/js";
import * as chartConfig from "@/Components/Charts/chart.config.js";
import LineChart from "@/Components/Charts/LineChart.vue";
import SectionMain from "@/Components/SectionMain.vue";
import CardBoxWidget from "@/Components/CardBoxWidget.vue";
import CardBox from "@/Components/CardBox.vue";
import TableSampleClients from "@/Components/TableSampleClients.vue";
import BaseButton from "@/Components/BaseButton.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
  user: Object,
});

const chartData = ref(null);

const fillChartData = () => {
  chartData.value = chartConfig.sampleChartData();
};

onMounted(() => {
  fillChartData();
});

</script>

<template>
  <LayoutAuthenticated :user='props.user'>
    <Head title="Dashboard" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Overview" main>
        <BaseButton href="https://github.com/justboil/admin-one-vue-tailwind" target="_blank" :icon="mdiGithub"
          label="Star on GitHub" color="contrast" rounded-full small />
      </SectionTitleLineWithButton>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <CardBoxWidget trend="12%" trend-type="up" color="text-emerald-500" :icon="mdiAccountMultiple" :number="512"
          label="Clients" />
        <CardBoxWidget trend="12%" trend-type="down" color="text-blue-500" :icon="mdiCartOutline" :number="7770"
          prefix="$" label="Sales" />
        <CardBoxWidget trend="Overflow" trend-type="alert" color="text-red-500" :icon="mdiChartTimelineVariant"
          :number="256" suffix="%" label="Performance" />
      </div>
      <SectionTitleLineWithButton :icon="mdiChartPie" title="Trends overview">
        <BaseButton :icon="mdiReload" color="whiteDark" @click="fillChartData" />
      </SectionTitleLineWithButton>

      <CardBox class="mb-6">
        <div v-if="chartData">
          <line-chart :data="chartData" class="h-96" />
        </div>
      </CardBox>

      <SectionTitleLineWithButton :icon="mdiAccountMultiple" title="Clients" />
      <CardBox has-tablen>
        <!-- pass users as data to tablesampleclients -->
        <TableSampleClients :data="props.user" />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
