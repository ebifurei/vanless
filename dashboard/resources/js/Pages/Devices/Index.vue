<template>
  <LayoutAuthenticated>

    <Head title="Devices" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Devices List" main>
        <Link :href="route('device.create')">
        <BaseButton class="border-slate-400 dark:border-slate-600" :icon="mdiPlus" label="Create Device" color="light"
          rounded-full small />
        </Link>
      </SectionTitleLineWithButton>
      <TableDeviceList />
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import { mdiChartTimelineVariant, mdiPlus } from "@mdi/js";
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import SectionMain from '@/Components/SectionMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import TableDeviceList from '@/Components/TableDeviceList.vue';
import BaseButton from '@/Components/BaseButton.vue';

</script>

<style lang="scss" scoped>

</style>
