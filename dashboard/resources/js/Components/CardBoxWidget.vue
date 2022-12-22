<script setup>
import { ref } from "vue";
import { mdiAccount, mdiAlertCircleOutline, mdiCheckCircleOutline, mdiClockAlertOutline, mdiCloseCircleOutline, mdiCog } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import NumberDynamic from "@/Components/NumberDynamic.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import BaseLevel from "@/Components/BaseLevel.vue";
import PillTagTrend from "@/Components/PillTagTrend.vue";
import BaseButton from "@/Components/BaseButton.vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import { useForm } from '@inertiajs/inertia-vue3';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";

const isModalActive = ref(false);

const props = defineProps({
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
  deviceId: {
    type: Number,
    default: null,
  },
});

const deviceStatusColor = (status) => {
  if (status === "danger") {
    return "text-red-500";
  }
  if (status === "inactive") {
    return "text-gray-600 dark:text-slate-500";
  }
  if (status === "onrepair") {
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
  if (status === "onrepair") {
    return mdiClockAlertOutline;
  }
  if (status === "active") {
    return mdiCheckCircleOutline;
  }
};

const form = useForm({
  status: props.trend,
});

const formStatusSubmit = () => {
  form.put(route('device.update', props.deviceId), {
    preserveScroll: true,
  });
};

const optionsSelect = ['active', 'inactive', 'onrepair', 'danger'];

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

  <CardBoxModal v-model="isModalActive" title="Change Status" noFooter>
    <form @submit.prevent="formStatusSubmit">
      <FormField label="">
        <FormCheckRadioGroup v-model="form.status" name="sample-radio" type="radio"
          :options="{ danger: 'Danger', active: 'Active', inactive: 'Inactive', onrepair: 'On Repair' }" />
      </FormField>

      <BaseButton type="submit" color="info" label="Update" class="w-full" />
    </form>
  </CardBoxModal>
</template>
