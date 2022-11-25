<template>
  <LayoutAuthenticated>

    <Head title="Uplink" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiLinkVariant" title="Uplink" main>
        <!--  -->
      </SectionTitleLineWithButton>

      <TableUplinkList />

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

</script>

<style lang="scss" scoped>

</style>
