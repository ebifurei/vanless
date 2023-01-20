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
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';



</script>

<template>
  <LayoutAuthenticated>

    <Head title="Dashboard" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Overview" main>
        <!-- -->
      </SectionTitleLineWithButton>
      <div v-if="$page.props.devices" class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <CardBoxWidget v-for="device in $page.props.devices" :key="device.id" :number="(device.uplink_counter ?? 0)"
          :trend="device.status" :trend-type="device.status" :label="device.name ?? device.device_id"
          :color="device.status" :icon="device.status" :last-seen="device.last_payload_at" :config="true"
          :device-id="device.id" />
      </div>
      <div v-else>
        <CardBox>
          <CardBoxComponentEmpty />
        </CardBox>
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
