<script setup>
import { mdiMarker, mdiGoogleMaps, mdiTrashCan, mdiMapMarker } from '@mdi/js';
import BaseButton from '@/Components/BaseButton.vue';
import PillTagTrend from '@/Components/PillTagTrend.vue';
import UserAvatar from '@/Components/UserAvatar.vue';
import CardBoxModal from '@/Components/CardBoxModal.vue';
import { ref, watch } from 'vue';
import { GoogleMap, InfoWindow, Marker } from 'vue3-google-map';
import { useStyleStore } from '@/Stores/style';
import { storeToRefs } from 'pinia';
import { Link } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseDivider from '@/Components/BaseDivider.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardBox from '@/Components/CardBox.vue';
import { format } from 'date-fns';

const googleAPI = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const selectedDevice = ref(null);
const isMapModalActive = ref(false);
const isDeleteModalActive = ref(false);
const state = storeToRefs(useStyleStore());
const mapStyle = state.mapStyle;
const form = useForm()

const handleMapClick = (device) => {
  selectedDevice.value = device;
  isMapModalActive.value = true;
};

const handleDeleteClick = (device) => {
  selectedDevice.value = device;
  isDeleteModalActive.value = true;
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

const handleDeleteConfirm = () => {
  form.delete(route('device.destroy', selectedDevice.value.id), {
    preserveState: true,
    onSuccess: () => {
      // close modal
      isDeleteModalActive.value = false;
      // reset selected device
      selectedDevice.value = null;
    }
  });
};

</script>

<template>
  <div>
    <div v-if="$page.props.deviceList" class="overflow-auto rounded-lg shadow dark:shadow-gray-500">
      <table class="w-full'">
        <thead>
          <tr>
            <th class="lg:hidden" />
            <th>Status</th>
            <th>Name</th>
            <th>Device_id</th>
            <th>Device EUI</th>
            <th>Device Class</th>
            <th>Uplink Interval</th>
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
              <!-- Clickable name that route to device.show -->
              <Link :href="route('device.show', device.id)" class="text-blue-500 hover:text-blue-600">
              {{ device.name ?? device.device_id }}
              </Link>
            </td>
            <td data-label="Device ID">
              {{ device.device_id }}
            </td>
            <td data-label="Device EUI">
              {{ device.device_eui }}
            </td>
            <td data-label="Device Class">
              {{ device.device_class ?? "A" }}
            </td>
            <td data-label="Uplink Interval">
              {{ device.device_normal_interval ?? "5" }}
            </td>
            <td data-label="Address" class="overflow-auto">
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
              {{ format(new Date(device.latest_payload_at), 'dd-LL-yy HH:mm:ss') }}
            </td>
            <td data-label="Actions">
              <div class="space-x-1">
                <Link :href="route('device.edit', device.id)">
                <BaseButton :icon="mdiMarker" title="Edit devices" />
                </Link>
                <BaseButton :icon="mdiTrashCan" title="Delete devices" @click="handleDeleteClick(device)" />
                <BaseButton :icon="mdiGoogleMaps" @click="handleMapClick(device)" title="Show Location" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <CardBox>
        <CardBoxComponentEmpty />
      </CardBox>
    </div>
    <!-- DELETE MODAL -->
    <CardBoxModal v-if="selectedDevice" :title="`Delete ${selectedDevice.name ?? selectedDevice.device_id}`"
      v-model="isDeleteModalActive" noFooter>

      <p>Are you sure you want to delete this device?</p>

      <BaseDivider />
      <BaseButtons class="justify-end">
        <BaseButton label="Delete" color="danger" @click="handleDeleteConfirm" :disabled="form.processing" />
        <BaseButton label="Cancel" color="danger" outline @click="isDeleteModalActive = false" />
      </BaseButtons>
    </CardBoxModal>
    <!-- END DELETE MODAL -->
    <!-- MAP MODAL -->
    <CardBoxModal v-if="selectedDevice" v-model="isMapModalActive" title="Location" noFooter>
      <GoogleMap v-if="selectedDevice.latitude" :api-key="googleAPI" style="width: 100%; height: 250px"
        :center="getLocation" :zoom="18" :street-view-control="false" :disable-default-ui="true" :styles="mapStyle">
        <Marker :options="{ position: getLocation, icon: getIcon }">
          <InfoWindow v-if="selectedDevice">
            {{ selectedDevice.device_id }}
          </InfoWindow>
        </Marker>
      </GoogleMap>
      <!-- there no map selected  -->
      <div v-else class="flex flex-col items-center justify-center h-64">
        <div class="flex items-center justify-center mb-3">
          <BaseButton class="border-slate-600 dark:border-slate-400" :icon="mdiMapMarker" :icon-size="60" color="light"
            rounded-full />
        </div>
        <p class="text-sm font-medium" color="contrast">Theres no Map</p>
      </div>
      <div class="flex flex-col items-center justify-center">
        <div class="text-xl">
          {{ selectedDevice.name ?? selectedDevice.device_id }}
        </div>
        <div class="text-sm">
          {{ selectedDevice.address ?? "No address" }}
        </div>
        <div class="text-sm text-blue-800">
          <a :href="`https://www.google.com/maps/search/?api=1&query=${selectedDevice.latitude},${selectedDevice.longitude}`"
            target="_blank">Open with Google Map</a>
        </div>
      </div>
    </CardBoxModal>
    <!-- END MAP MODAL -->
  </div>
</template>

<style lang="scss" scoped></style>
