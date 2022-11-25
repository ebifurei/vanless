<template>
  <LayoutAuthenticated>

    <Head title="Uplink" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiLinkVariant" title="Uplink" main>
        <!--  -->
      </SectionTitleLineWithButton>

      <TableUplinkList :uplinksData="uplinks" />

    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SectionMain from '@/Components/SectionMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import TableUplinkList from '@/Components/TableUplinkList.vue';
import { mdiLinkVariant } from '@mdi/js';
import { defineProps } from 'vue';

const props = defineProps({
  uplinks: {
    type: Object,
    required: true,
  },
});

</script>

<style lang="scss" scoped>

</style>
