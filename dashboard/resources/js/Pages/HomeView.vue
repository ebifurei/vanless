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



</script>

<template>
  <LayoutAuthenticated>

    <Head title="Dashboard" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Overview" main>
        <!-- -->
      </SectionTitleLineWithButton>
      <div class="grid grid-cols-2 gap-6 lg:grid-cols-3 mb-6">
        <CardBoxWidget v-for="device in $page.props.devices" :key="device.id" :number="100" :trend="device.status"
          :trend-type="device.status" :label="device.name ?? device.device_id" :color="device.status"
          :icon="device.status" :last-seen="device.last_payload_at" :config="true" />
      </div>
      <SectionTitleLineWithButton :icon="mdiUpload" title="4 Latest Uplinks">
        <!--  -->
      </SectionTitleLineWithButton>
      <CardBox has-table>
        <TableUplinkListHome />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
