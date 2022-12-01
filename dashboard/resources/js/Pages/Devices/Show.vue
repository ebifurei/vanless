<template>
  <LayoutAuthenticated>

    <Head title="Device" />
    <SectionMain>
      <CardBox>
        {{ $page.props.device.uplinks }}
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SectionMain from '@/Components/SectionMain.vue';
import CardBox from '@/Components/CardBox.vue';

</script>

<style lang="scss" scoped>

</style>
