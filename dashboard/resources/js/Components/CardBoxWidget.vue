<script setup>
import { computed, ref, watch } from "vue";
import { mdiCog } from "@mdi/js";
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
});
</script>

<template>
  <CardBox>
    <BaseLevel v-if="trend" class="mb-3" mobile>
      <PillTagTrend :trend="trend" :trend-type="trendType" small />
      <BaseButton :icon="mdiCog" icon-w="w-4" icon-h="h-4" color="lightDark" small @click="isModalActive = true" />
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
      <BaseIcon v-if="icon" :path="icon" size="75" w="" h="h-16" :class="color" />
    </BaseLevel>
  </CardBox>
<CardBoxModal v-model="isModalActive" title="Sample modal">
  <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
  <p>This is sample modal</p>
</CardBoxModal>
</template>