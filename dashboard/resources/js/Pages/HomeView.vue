<script setup>
import {
  mdiChartTimelineVariant,
  mdiGithub,
  mdiWifiCheck,
  mdiAlert,
  mdiWrenchClock,
  mdiUpload,
  mdiPowerOff,
  mdiPowerOn,
  mdiCloseCircle,
  mdiCheckUnderline,
  mdiCheckCircleOutline,
  mdiCloseCircleOutline,
  mdiAlertCircleCheckOutline,
  mdiAlertCircleOutline,
  mdiClockAlertOutline,
} from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import CardBoxWidget from "@/Components/CardBoxWidget.vue";
import CardBox from "@/Components/CardBox.vue";
import TableSampleClients from "@/Components/TableSampleClients.vue";
import BaseButton from "@/Components/BaseButton.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { Head } from '@inertiajs/inertia-vue3';
import TableDeviceList from '@/Components/TableDeviceList.vue';

const deviceStatusColor = (status) => {
  if (status === "danger") {
    return "text-red-500";
  }
  if (status === "inactive") {
    return "text-gray-600 dark:text-slate-500";
  }
  if (status === "maintenance") {
    return "text-yellow-500";
  }
  if (status === "active") {
    return "text-emerald-500";
  }
};

const deviceStatusIcon = (status) => {
  if (status === "danger") {
    return mdiAlertCircleOutline;
  }
  if (status === "inactive") {
    return mdiCloseCircleOutline
  }
  if (status === "maintenance") {
    return mdiClockAlertOutline;
  }
  if (status === "active") {
    return mdiCheckCircleOutline
  }
};

</script>

<template>
  <LayoutAuthenticated>
    <Head title="Dashboard" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Overview" main>
        <BaseButton href="#" target="_blank" :icon="mdiGithub" label="GitHub" color="contrast" rounded-full small />
      </SectionTitleLineWithButton>
      <!-- foreach device on devices key index -->
      <div class="grid grid-cols-2 gap-6 lg:grid-cols-3 mb-6">
        <CardBoxWidget v-for="(device, index) in $page.props.devices" :key="index" :number="100" :trend="device.status"
          :trend-type="device.status" :label="device.name ?? device.device_id" :color="deviceStatusColor(device.status)"
          :icon="deviceStatusIcon(device.status)" />
      </div>

      <SectionTitleLineWithButton :icon="mdiUpload" title="Latest Uplinks" />
      <CardBox has-table>
        <!-- <TableSampleClients /> -->
        <TableDeviceList />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
