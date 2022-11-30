<template>
  <LayoutAuthenticated>

    <Head title="Locations" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiMapCheckOutline" title="Locations" main>
        <!--  -->
      </SectionTitleLineWithButton>
      <GoogleMap :api-key="googleAPI" style="width: 100%; height: 500px" :center="getCenter" :zoom="16"
        :street-view-control="false" :disable-default-ui="true" :styles="theme">
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
import { mdiMapCheckOutline, mdiWeatherNight, mdiWeatherSunny } from '@mdi/js';
import { GoogleMap, Marker, InfoWindow } from 'vue3-google-map';
import { usePage } from '@inertiajs/inertia-vue3';
import { ref, computed, watch, onMounted } from 'vue';
import PillTagTrend from '@/Components/PillTagTrend.vue';
import BaseLevel from '@/Components/BaseLevel.vue';
import { useStyleStore } from '@/Stores/style';
import { storeToRefs } from 'pinia';

const googleAPI = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const devices = computed(() => usePage().props.value.devices);
const state = storeToRefs(useStyleStore());
const darkMode = state.darkMode;

// MAP THEME
const theme = ref();
const day = [
  {
    featureType: "poi.business",
    stylers: [{ visibility: "off" }],
  },
  {
    featureType: "transit",
    elementType: "labels.icon",
    stylers: [{ visibility: "off" }],
  },
];
const night = [
  { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
  { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
  { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
  {
    featureType: "administrative.locality",
    elementType: "labels.text.fill",
    stylers: [{ color: "#d59563" }],
  },
  {
    featureType: "poi",
    elementType: "labels.text.fill",
    stylers: [{ color: "#d59563" }],
  },
  {
    featureType: "poi.business",
    stylers: [{ visibility: "off" }],
  },
  {
    featureType: "poi.park",
    elementType: "geometry",
    stylers: [{ color: "#263c3f" }],
  },
  {
    featureType: "poi.park",
    elementType: "labels.text.fill",
    stylers: [{ color: "#6b9a76" }],
  },
  {
    featureType: "road",
    elementType: "geometry",
    stylers: [{ color: "#38414e" }],
  },
  {
    featureType: "road",
    elementType: "geometry.stroke",
    stylers: [{ color: "#212a37" }],
  },
  {
    featureType: "road",
    elementType: "labels.text.fill",
    stylers: [{ color: "#9ca5b3" }],
  },
  {
    featureType: "road.highway",
    elementType: "geometry",
    stylers: [{ color: "#746855" }],
  },
  {
    featureType: "road.highway",
    elementType: "geometry.stroke",
    stylers: [{ color: "#1f2835" }],
  },
  {
    featureType: "road.highway",
    elementType: "labels.text.fill",
    stylers: [{ color: "#f3d19c" }],
  },
  {
    featureType: "transit",
    elementType: "labels.icon",
    stylers: [{ visibility: "off" }],
  },
  {
    featureType: "transit.station",
    elementType: "labels.text.fill",
    stylers: [{ color: "#d59563" }],
  },
  {
    featureType: "water",
    elementType: "geometry",
    stylers: [{ color: "#17263c" }],
  },
  {
    featureType: "water",
    elementType: "labels.text.fill",
    stylers: [{ color: "#515c6d" }],
  },
  {
    featureType: "water",
    elementType: "labels.text.stroke",
    stylers: [{ color: "#17263c" }],
  },
];
onMounted(() => {
  if (darkMode.value) {
    theme.value = night;
  } else {
    theme.value = day;
  }
});
watch(darkMode, (val) => {
  if (val) {
    theme.value = night;
  } else {
    theme.value = day;
  }
});
// END MAP THEME

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
