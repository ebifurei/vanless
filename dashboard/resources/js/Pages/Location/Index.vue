<template>
  <LayoutAuthenticated>

    <Head title="Locations" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Locations List" main>
        <!--  -->
      </SectionTitleLineWithButton>

    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import SectionMain from '@/Components/SectionMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
</script>

<style lang="scss" scoped>

</style>
