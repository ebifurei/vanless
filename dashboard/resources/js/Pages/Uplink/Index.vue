<template>
  <LayoutAuthenticated>

    <Head title="Uplink" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiLinkVariant" title="Uplink" main>
        <!--  -->
      </SectionTitleLineWithButton>

      <TableUplinkList :uplinks="uplinks" :links="links" />

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
import { usePage } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

const uplinks = computed(() => usePage().props.value.uplinks.data);
const links = computed(() => usePage().props.value.uplinks.links);

</script>

<style>
::-webkit-scrollbar {
  width: 6px;
  height: 6px
}

::-webkit-scrollbar-thumb {
  -webkit-border-radius: 6px;
  border-radius: 6px;
  background: #6B7280;
}
</style>
