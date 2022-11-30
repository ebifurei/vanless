<template>
  <LayoutAuthenticated>

    <Head title="Devices" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Devices List" main>
        <!--  -->
      </SectionTitleLineWithButton>
      <TableDeviceList />
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import { mdiChartTimelineVariant } from "@mdi/js";
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SectionMain from '@/Components/SectionMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import TableDeviceList from '@/Components/TableDeviceList.vue';

</script>

<style lang="scss" scoped>

</style>
