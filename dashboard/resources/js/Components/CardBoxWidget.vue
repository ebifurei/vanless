<script setup>
import { ref } from "vue";
import { mdiAlertCircleOutline, mdiCheckCircleOutline, mdiClockAlertOutline, mdiCloseCircleOutline, mdiCog } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import NumberDynamic from "@/Components/NumberDynamic.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import BaseLevel from "@/Components/BaseLevel.vue";
import PillTagTrend from "@/Components/PillTagTrend.vue";
import BaseButton from "@/Components/BaseButton.vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";

const isModalActive = ref(false);

defineProps({
  number: {
    type: Number,
    default: 0,
  },
  icon: {
    type: String,
    default: null,
  },
  prefix: {
    type: String,
    default: null,
  },
  suffix: {
    type: String,
    default: null,
  },
  label: {
    type: String,
    default: null,
  },
  color: {
    type: String,
    default: null,
  },
  trend: {
    type: String,
    default: null,
  },
  trendType: {
    type: String,
    default: null,
  },
  lastSeen: {
    type: String,
    default: 'now',
  },
  config: {
    type: Boolean,
    default: false,
  },
});

const deviceStatusColor = (status) => {
  if (status === "danger") {
    return "text-red-500";
  }
  if (status === "inactive") {
    return "text-gray-600 dark:text-slate-500";
  }
  if (status === "maintenance") {
    return "text-yellow-500";
  }
  if (status === "active") {
    return "text-emerald-500";
  }
};

const deviceStatusIcon = (status) => {
  if (status === "danger") {
    return mdiAlertCircleOutline;
  }
  if (status === "inactive") {
    return mdiCloseCircleOutline;
  }
  if (status === "maintenance") {
    return mdiClockAlertOutline;
  }
  if (status === "active") {
    return mdiCheckCircleOutline;
  }
};
</script>

<template>
  <CardBox>
    <BaseLevel v-if="trend" class="mb-3" mobile>
      <PillTagTrend :trend="trend" :trend-type="trendType" small />
      <BaseButton v-if="config" :icon="mdiCog" icon-w="w-4" icon-h="h-4" color="lightDark" small
        @click="isModalActive = true" />
    </BaseLevel>
    <BaseLevel mobile>
      <div>
        <h3 class="text-lg leading-tight text-gray-500 dark:text-slate-400">
          {{ label }}
        </h3>
        <h3 class="text-sm mt-2 leading-tight text-gray-500 dark:text-slate-400">
          Uplink count
        </h3>
        <h1 class="text-3xl leading-tight font-semibold">
          <NumberDynamic :value="number" :prefix="prefix" :suffix="suffix" />
        </h1>
        <h3 class="text-sm mt-2 leading-tight text-gray-500 dark:text-slate-400">
          Last seen : {{ lastSeen }}
        </h3>
      </div>
      <BaseIcon v-if="icon" :path="deviceStatusIcon(icon)" size="75" w="" h="h-16" :class="deviceStatusColor(color)" />
    </BaseLevel>
  </CardBox>
  <CardBoxModal v-model="isModalActive" title="Sample modal">
    <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
    <p>This is sample modal</p>
  </CardBoxModal>
</template>
