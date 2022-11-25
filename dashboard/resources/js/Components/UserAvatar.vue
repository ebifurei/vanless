<script setup>
import { computed } from "vue";

const props = defineProps({
  username: {
    type: String,
    required: true,
  },
  avatar: {
    type: String,
    default: null,
  },
  api: {
    type: String,
    default: "avataaars",
  },
  status: {
    type: String,
    default: null,
  },
  fontSize: {
    type: Number,
    default: null,
  },
});

// status background color if status is danger equals red, inactive equals gray, maintenance equals yellow, active equals green
// color in rgb hex format
const statusColor = computed(() => {
  if (props.status === "danger") {
    return "%23ef4444";
  }

  if (props.status === "inactive") {
    return "%23475569"
  }

  if (props.status === "onrepair") {
    return "%23eab308";
  }

  if (props.status === "active") {
    return "%2310b981";
  }
  return "%2300b0f0";
});

const avatar = computed(
  () =>
    props.avatar ??
    `https://avatars.dicebear.com/api/${props.api}/${props.username.replace(
      /[^a-z0-9]+/i,
      "-"
    )}.svg?b=${statusColor.value}&fontSize=${props.fontSize}`
);

const username = computed(() => props.username);
</script>

<template>
  <div>
    <img :src="avatar" :alt="username"
      class="rounded-full block h-auto w-full max-w-full bg-gray-100 dark:bg-slate-800" />
    <slot />
  </div>
</template>
