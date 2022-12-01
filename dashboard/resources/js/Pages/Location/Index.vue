<template>
  <LayoutAuthenticated>

    <Head title="Locations" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiMapCheckOutline" title="Locations" main>
        <!--  -->
      </SectionTitleLineWithButton>
      <GoogleMap :api-key="googleAPI" style="width: 100%; height: 500px" :center="getCenter" :zoom="16"
        :street-view-control="false" :disable-default-ui="true" :styles="mapStyle">
        <Marker v-for="l in devices" :key="l.id" :options="{ position: getPosition(l), icon: getIcon(l) }">
          <InfoWindow>
            <!-- name, address, description, status with pilltagtrend  -->
            <div class="flex flex-col dark:text-black">
              <div class="flex flex-row">
                <div class="flex flex-col">
                  <div class="font-bold text-lg ">
                    {{ l.name ?? l.device_id }}
                  </div>
                  <div class="text-sm">{{ l.address ?? 'No Address yet' }}</div>
                  <div class="text-sm">{{ l.description ?? 'No Description yet' }}</div>
                </div>
                <div class="flex flex-col ml-2">
                  <BaseLevel>
                    <PillTagTrend :trend="l.status" :trend-type="l.status" />
                  </BaseLevel>
                </div>
              </div>
              <div class="flex flex-row mt-2">
                <div class="flex flex-col ml-2">
                  <div class="font-bold">Last Seen</div>
                  <div class="text-sm">{{ l.last_payload_at }}</div>
                </div>
              </div>
            </div>
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
import PillTagTrend from '@/Components/PillTagTrend.vue';
import BaseLevel from '@/Components/BaseLevel.vue';
import { useStyleStore } from '@/Stores/style';
import { storeToRefs } from 'pinia';

const googleAPI = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const devices = computed(() => usePage().props.value.devices);
const state = storeToRefs(useStyleStore());
const mapStyle = state.mapStyle;

const getCenter = {
  // average of all latitudes and longitudes
  lat: devices.value.reduce((a, b) => a + parseFloat(b.latitude), 0) / devices.value.length,
  lng: devices.value.reduce((a, b) => a + parseFloat(b.longitude), 0) / devices.value.length
};

const getPosition = (l) => {
  return {
    lat: parseFloat(l.latitude),
    lng: parseFloat(l.longitude)
  }
};

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
