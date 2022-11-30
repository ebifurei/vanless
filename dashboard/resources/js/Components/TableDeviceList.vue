<script setup>
import { mdiMarker, mdiGoogleMaps, mdiTrashCan } from '@mdi/js';
import BaseButton from '@/Components/BaseButton.vue';
import PillTagTrend from '@/Components/PillTagTrend.vue';
import UserAvatar from '@/Components/UserAvatar.vue';
import CardBoxModal from './CardBoxModal.vue';
import { ref, watch, onMounted } from 'vue';
import { GoogleMap, InfoWindow, Marker } from 'vue3-google-map';
import { useStyleStore } from '@/Stores/style';
import { storeToRefs } from 'pinia';

const googleAPI = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const selectedDevice = ref(null);
const isMapModalActive = ref(false);

const handleMapClick = (device) => {
  selectedDevice.value = device;
  isMapModalActive.value = true;
};

const getIcon = ref(null);
const getLocation = ref({
  lat: 0,
  lng: 0
});

watch(selectedDevice, (device) => {
  if (device) {
    getLocation.value = {
      lat: parseFloat(device.latitude),
      lng: parseFloat(device.longitude)
    };
    switch (device.status) {
      case 'active':
        getIcon.value = 'https://maps.google.com/mapfiles/ms/icons/green-dot.png';
        break;
      case 'danger':
        getIcon.value = 'https://maps.google.com/mapfiles/ms/icons/red-dot.png';
        break;
      case 'onrepair':
        getIcon.value = 'https://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
        break;
      case 'inactive':
        getIcon.value = 'https://maps.google.com/mapfiles/ms/icons/ltblue-dot.png';
        break;
    }
  }
});

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
</script>

<template>
  <div class="overflow-auto rounded-lg shadow dark:shadow-gray-500">
    <table class="w-full'">
      <thead>
        <tr>
          <th class="lg:hidden" />
          <th>Status</th>
          <th>Name</th>
          <th>Device_id</th>
          <th>Device EUI</th>
          <th>Address</th>
          <th>Progress Daily</th>
          <th>Last Payload</th>
          <th>Last Seen</th>
          <th />
        </tr>
      </thead>
      <tbody>
        <tr v-for="device in $page.props.deviceList" :key="device.id">
          <td class="lg:hidden">
            <UserAvatar :username="device.device_id" :api="'initials'" :status="device.status" :font-size="40"
              class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
          </td>
          <td data-label="Status">
            <PillTagTrend :trend="device.status" :trend-type="device.status" />
          </td>
          <td data-label="Name">
            {{ device.device_name ?? device.device_id }}
          </td>
          <td data-label="Device ID">
            {{ device.device_id }}
          </td>
          <td data-label="Device EUI">
            {{ device.device_eui }}
          </td>
          <td data-label="Address">
            {{ device.address ?? "No address" }}
          </td>
          <td data-label="Progress Daily">
            <div>
              <progress class="progress progress-success" :value="device.progress_daily ?? 20" max="144">
                {{ device.progress_daily ?? 20 }}/144
              </progress> {{ device.progress_daily ?? 20 }}/144
            </div>
          </td>
          <td data-label="Last Payload">
            <div class="lg:w-44 overflow-auto">
              {{ device.latest_payload }}
            </div>
          </td>
          <td data-label="Last seen">
            {{ device.latest_payload_at }}
          </td>
          <td data-label="Actions">
            <div class="space-x-1">
              <BaseButton :icon="mdiMarker" />
              <BaseButton :icon="mdiTrashCan" />
              <BaseButton :icon="mdiGoogleMaps" @click="handleMapClick(device)" />
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- MAP MODAL -->
    <CardBoxModal v-if="selectedDevice" v-model="isMapModalActive" title="Location" noFooter>
      <GoogleMap :api-key="googleAPI" style="width: 100%; height: 250px" :center="getLocation" :zoom="18"
        :street-view-control="false" :disable-default-ui="true" :styles="theme">
        <Marker :options="{ position: getLocation, icon: getIcon }">
          <InfoWindow v-if="selectedDevice">
            {{ selectedDevice.device_id }}
          </InfoWindow>
        </Marker>
      </GoogleMap>
      <!-- device name and address and open with google map -->
      <div class="flex flex-col items-center justify-center">
        <div class="text-xl">
          {{ selectedDevice.name ?? selectedDevice.device_id }}
        </div>
        <div class="text-sm">
          {{ selectedDevice.address ?? "No address" }}
        </div>
        <div class="text-sm">
          <a :href="`https://www.google.com/maps/search/?api=1&query=${selectedDevice.latitude},${selectedDevice.longitude}`"
            target="_blank">Open with Google Map</a>
        </div>
      </div>
    </CardBoxModal>
    <!-- END MAP MODAL -->

  </div>
</template>

<style lang="scss" scoped>

</style>
