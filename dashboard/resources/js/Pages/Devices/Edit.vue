<template>
  <LayoutAuthenticated>

    <Head title="Device Edit" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiDevices" title="Edit Device" main>
        <Link :href="route('device.index')">
        <BaseButton class="border-slate-400 dark:border-slate-600" :icon="mdiArrowLeft" label="Back" color="light"
          roundedFull small />
        </Link>
      </SectionTitleLineWithButton>
      <form @submit.prevent="submit">
        <CardBox form @submit.prevent="submit">
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
          <div class="flex justify-end">
            <BaseButton type="button" color="light" label="Reset location" @click="resetLocation"
              class="p-0 dark:border-slate-600" />
          </div>
          <GoogleMap :apiKey="googleAPI" :center="{ lat: form.latitude, lng: form.longitude }" :zoom="17"
            style="width: 100%; height: 400px" :streetViewControl="false" @click="mapClick" :styles="mapStyle">
            <Marker v-if="form.latitude" :options="{
              position: { lat: form.latitude, lng: form.longitude },
              icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
            }" />
          </GoogleMap>
          <template #footer>
            <BaseButtons>
              <BaseButton type="submit" color="info" label="Submit" :disabled="form.processing" />
              <BaseButton color="info" outline label="Reset" @click="reset" />
              <BaseButton color="danger" outline label="Delete" @click="(isDeleteModalActive = true)" />
            </BaseButtons>
          </template>
        </CardBox>
      </form>
      <CardBoxModal :title="`Delete ${form.name ?? form.device_id}`" v-model="isDeleteModalActive" noFooter>

        <p>Are you sure you want to delete this device?</p>

        <BaseDivider />
        <BaseButtons>
          <BaseButton label="Delete" color="danger" @click="deleteDevice" :disabled="form.processing" />
          <BaseButton label="Cancel" color="danger" outline @click="isDeleteModalActive = false" />
        </BaseButtons>
      </CardBoxModal>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import SectionMain from '@/Components/SectionMain.vue';
import { mdiDevices, mdiAccount, mdiArrowLeft } from '@mdi/js';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseButton from '@/Components/BaseButton.vue';
import FormField from '@/Components/FormField.vue';
import { GoogleMap, Marker } from 'vue3-google-map';
import { useStyleStore } from '@/Stores/style';
import { storeToRefs } from 'pinia';
import { computed, ref } from 'vue';
import CardBoxModal from '@/Components/CardBoxModal.vue';
import BaseDivider from '@/Components/BaseDivider.vue';

const googleAPI = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const state = storeToRefs(useStyleStore());
const mapStyle = state.mapStyle;
const isDeleteModalActive = ref(false);

const device = computed(() => usePage().props.value.device);

const form = useForm({
  name: device.value.name,
  device_id: device.value.device_id,
  device_eui: device.value.device_eui,
  address: device.value.address,
  latitude: parseFloat(device.value.latitude),
  longitude: parseFloat(device.value.longitude),
});

const mapClick = (e) => {
  form.latitude = e.latLng.lat();
  form.longitude = e.latLng.lng();
};

const submit = () => {
  form.put(route('device.update', device.value.id), {
    preserveScroll: true,
  });
};

const reset = () => {
  form.name = device.value.name;
  form.device_id = device.value.device_id;
  form.device_eui = device.value.device_eui;
  form.address = device.value.address;
  form.latitude = parseFloat(device.value.latitude);
  form.longitude = parseFloat(device.value.longitude);
};

const resetLocation = () => {
  form.latitude = parseFloat(device.value.latitude);
  form.longitude = parseFloat(device.value.longitude);
};

const deleteDevice = () => {
  form.delete(route('device.destroy', device.value.id), {
    preserveScroll: true,
  });
};


</script>

<style lang="scss" scoped>

</style>
