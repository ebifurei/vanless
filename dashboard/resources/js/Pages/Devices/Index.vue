<template>
  <LayoutAuthenticated>

  </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';

// props devices
const props = defineProps({
  devices: {
    type: Array,
    default: () => [],
  },
});


</script>

<style lang="scss" scoped>

</style>
