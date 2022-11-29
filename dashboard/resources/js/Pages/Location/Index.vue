<template>
  <LayoutAuthenticated>

    <Head title="Locations" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiMapCheckOutline" title="Locations" main>
        <!--  -->
      </SectionTitleLineWithButton>
      <GoogleMap :api-key="googleAPI" style="width: 100%; height: 500px" :center="getCenter" :zoom="16"
        mapTypeId="terrain">
        <Marker v-for="l in devices" :key="l.id" :options="{ position: getPosition(l), icon: getIcon(l) }">
          <InfoWindow>
            <CardBoxWidget :number="100" :trend="l.status" :trend-type="l.status" :label="l.name ?? l.device_id"
              :color="l.status" :icon="l.status" :last-seen="l.last_payload_at" />
          </InfoWindow>
        </Marker>
      </GoogleMap>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import SectionMain from '@/Components/SectionMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { mdiMapCheckOutline } from '@mdi/js';
import { GoogleMap, Marker, InfoWindow } from 'vue3-google-map';
import { usePage } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';
import CardBox from '@/Components/CardBox.vue';
import CardBoxWidget from '@/Components/CardBoxWidget.vue';

const googleAPI = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

const devices = computed(() => usePage().props.value.devices);

const getCenter = {
  // average of all latitudes and longitudes
  lat: devices.value.reduce((a, b) => a + parseFloat(b.latitude), 0) / devices.value.length,
  lng: devices.value.reduce((a, b) => a + parseFloat(b.longitude), 0) / devices.value.length
}

const getPosition = (l) => {
  return {
    lat: parseFloat(l.latitude),
    lng: parseFloat(l.longitude)
  }
}

const getIcon = (l) => {
  switch (l.status) {
    case 'active':
      return 'https://maps.google.com/mapfiles/ms/icons/green-dot.png';
    case 'danger':
      return 'https://maps.google.com/mapfiles/ms/icons/red-dot.png';
    case 'onrepair':
      return 'https://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
    case 'inactive':
      return 'https://maps.google.com/mapfiles/ms/icons/ltblue-dot.png';
    default:
      return 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png';
  }
}
</script>

<style>

</style>
