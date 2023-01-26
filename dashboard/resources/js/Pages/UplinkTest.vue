<template>
  <LayoutAuthenticated>
    <SectionMain>
      <CardBox is-form @submit.prevent="submit">
        <FormValidationErrors />

        <FormField label="deviceName" label-for="deviceName">
          <FormControl v-model="form.deviceName" :icon="mdiAccount" id="deviceName" autocomplete="deviceName"
            type="text" required />
        </FormField>

        <FormField label="devEUI" label-for="devEUI">
          <FormControl v-model="form.devEUI" :icon="mdiAsterisk" type="text" id="devEUI" autocomplete="current-devEUI"
            required />
        </FormField>

        <FormField label="objectJSON" label-for="objectJSON">
          <FormControl type="textarea" v-model="form.objectJSON" id="objectJSON" autocomplete="current-objectJSON"
            required />
        </FormField>

        <FormField label="fPort" label-for="fPort">
          <FormControl type="textarea" v-model="form.fPort" id="Port" autocomplete="current-fPort" required />
        </FormField>

        <FormField label="time" label-for="time">
          <FormControl type="datetime-local" id="time" name="time" v-model="form.rxInfo[0].time" required />
        </FormField>

        <!-- button -->
        <BaseDivider />

        <BaseButtons>
          <BaseButton type="submit" color="info" label="Send" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing" />
        </BaseButtons>


      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import FormValidationErrors from '@/Components/FormValidationErrors.vue';
import SectionMain from '@/Components/SectionMain.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { mdiAccount, mdiAsterisk } from '@mdi/js';
import { useForm } from '@inertiajs/inertia-vue3';
import BaseDivider from '@/Components/BaseDivider.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseButton from '@/Components/BaseButton.vue';

const form = useForm({
  applicationID: '1',
  applicationName: 'LoraAntiVandalisme',
  deviceName: '',
  devEUI: 'vVnh4aKO7Ho=',
  rxInfo: [
    {
      gatewayID: 'b827ebfffee12e02',
      name: 'vanless-loraserver',
      time: '2019-07-21T11:45:01.389569Z',
      rssi: -41,
      loRaSNR: 5,
      location: {
        latitude: 0,
        longitude: 0,
        altitude: 0,
      },
    },
  ],
  txInfo: {
    frequency: 923200000,
    dr: 5,
  },
  adr: true,
  fCnt: 1,
  fPort: 1,
  data: 'CK4=',
  objectJSON: '{ "Peter": 50, "Ben": 37, "Joe": 43 }',
});

const submit = () => {
  // post with params event = up
  form.post('/api/uplink/chirpstack?event=up', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('deviceName', 'devEUI', 'objectJSON', 'time');
    },
  });
};

</script>

<style lang="scss" scoped>

</style>
