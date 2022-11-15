<script setup>
import { computed } from "vue";
import { mdiAlertCircleOutline, mdiTools, mdiCheckCircleOutline, mdiCloseCircleOutline } from "@mdi/js";
import PillTag from "@/Components/PillTag.vue";

const props = defineProps({
  trend: {
    type: String,
    required: true,
  },
  trendType: {
    type: String,
    default: null,
  },
  small: Boolean,
});

const trendStyle = computed(() => {
  if (props.trendType === "active") {
    return {
      icon: mdiCheckCircleOutline,
      style: "success",
    };
  }

  if (props.trendType === "maintenance") {
    return {
      icon: mdiTools,
      style: "warning",
    };
  }

  if (props.trendType === "danger") {
    return {
      icon: mdiAlertCircleOutline,
      style: "danger",
    };
  }

  if (props.trendType === "inactive") {
    return {
      icon: mdiCloseCircleOutline,
      style: "secondary",
    };
  }
});
</script>

<template>
  <PillTag :label="trend" :color="trendStyle.style" :icon="trendStyle.icon" :small="small" />
</template>
