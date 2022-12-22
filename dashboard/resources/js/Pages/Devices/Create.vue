<template>
  <LayoutAuthenticated>

    <Head title="Device Create" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiDevices" title="Device Create" main>
        <Link :href="route('device.index')">
        <BaseButton class="border-slate-400 dark:border-slate-600" :icon="mdiArrowLeft" label="Back" color="light"
          rounded-full small />
        </Link>
      </SectionTitleLineWithButton>

      <CardBox is-form @submit.prevent="submit">
        <FormField label="Device Name">
          <FormControl v-model="form.name" :icon="mdiAccount" required />
        </FormField>

        <FormField label="Device ID" help="make sure device_id same as deviceName on chirpstack">
          <FormControl v-model="form.device_id" required />
        </FormField>

        <FormField label="Device Eui">
          <FormControl v-model="form.device_eui" required />
        </FormField>

        <FormField label="Address">
          <FormControl v-model="form.address" type="tel" placeholder="Address" />
        </FormField>

        <FormField label="Description">
          <FormControl type="textarea" placeholder="Description" />
        </FormField>

        <FormField label="Location" help="pleace select from map below">
          <FormControl v-model="form.latitude" placeholder="latitude" disabled />
          <FormControl v-model="form.longitude" placeholder="longitude" disabled />
        </FormField>
        <BaseDivider />
        <GoogleMap :api-key="googleAPI" :center="{ lat: -7.765804, lng: 110.370529 }" :zoom="13"
          style="width: 100%; height: 400px" :street-view-control="false" @click="mapClick" :styles="mapStyle">
          <Marker v-if="form.latitude" :options="{
            position: { lat: form.latitude, lng: form.longitude },
            icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
          }" />
        </GoogleMap>

        <template #footer>
          <BaseButtons>
            <BaseButton type="submit" color="info" label="Submit" :disabled="form.processing" />
            <BaseButton type="reset" color="info" outline label="Reset" />
          </BaseButtons>
        </template>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import SectionMain from '@/Components/SectionMain.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { mdiDevices, mdiAccount, mdiArrowLeft } from '@mdi/js';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import BaseDivider from '@/Components/BaseDivider.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseButton from '@/Components/BaseButton.vue';
import FormField from '@/Components/FormField.vue';
import { GoogleMap, Marker } from 'vue3-google-map';
import { useStyleStore } from '@/Stores/style';
import { storeToRefs } from 'pinia';

const googleAPI = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const state = storeToRefs(useStyleStore());
const mapStyle = state.mapStyle;

const form = useForm({
  name: '',
  device_id: '',
  device_eui: '',
  description: '',
  address: '',
  latitude: '',
  longitude: '',
});

const mapClick = (e) => {
  form.latitude = e.latLng.lat();
  form.longitude = e.latLng.lng();
};

const submit = () => {
  form.post(route('device.store'), form);
};

</script>

<style lang="scss" scoped>

</style>
