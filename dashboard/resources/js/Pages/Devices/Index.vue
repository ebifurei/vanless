<template>
  <LayoutAuthenticated>
  <Head title="Devices" />
  <SectionMain>
    <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Devices List" main>
      <!--  -->
    </SectionTitleLineWithButton>

      <TableDeviceList :device-list="deviceList" />
      </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import { mdiChartTimelineVariant } from "@mdi/js";
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SectionMain from '@/Components/SectionMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import CardBox from '@/Components/CardBox.vue';
import TableDeviceList from '@/Components/TableDeviceList.vue';

const props = defineProps({
  deviceList: {
    type: Array,
    required: true,
  },
});
</script>

<style lang="scss" scoped>

</style>
