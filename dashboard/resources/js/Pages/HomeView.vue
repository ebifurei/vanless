<script setup>
import {
  mdiChartTimelineVariant,
  mdiUpload,
  mdiCheckCircleOutline,
  mdiCloseCircleOutline,
  mdiAlertCircleOutline,
  mdiClockAlertOutline,
} from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import CardBoxWidget from "@/Components/CardBoxWidget.vue";
import CardBox from "@/Components/CardBox.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { Head } from '@inertiajs/inertia-vue3';
import TableUplinkListHome from '@/Components/TableUplinkListHome.vue';

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
        <!-- <BaseButton href="#" target="_blank" :icon="mdiGithub" label="GitHub" color="contrast" rounded-full small /> -->
      </SectionTitleLineWithButton>
      <div class="grid grid-cols-2 gap-6 lg:grid-cols-3 mb-6">
        <CardBoxWidget v-for="device in $page.props.devices" :key="device.id" :number="100" :trend="device.status"
          :trend-type="device.status" :label="device.name ?? device.device_id" :color="deviceStatusColor(device.status)"
          :icon="deviceStatusIcon(device.status)" :last-seen="device.last_payload_at" />
      </div>
      <SectionTitleLineWithButton :icon="mdiUpload" title="6 Latest Uplinks" />
      <CardBox has-table>
        <TableUplinkListHome :uplinks-data="$page.props.uplinks" />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
