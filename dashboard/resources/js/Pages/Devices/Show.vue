<template>
  <LayoutAuthenticated>

    <Head title="Device" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiDevices" :title="`${device.name ?? device.device_id}`" main>
        <Link :href="route('device.index')">
        <BaseButton class="border-slate-400 dark:border-slate-600" :icon="mdiArrowLeft" label="Back" color="light"
          rounded-full small />
        </Link>
      </SectionTitleLineWithButton>

      <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 lg:grid-rows-1">
        <div class="lg:col-span-3">
          <CardBox class="h-ful rounded-lg shadow dark:shadow-gray-500" hasTable>
            <table class="hidden lg:table w-full">
              <tbody>
                <tr>
                  <td class="font-semibold pr-3 text-left">Status</td>
                  <td class="text-right">
                    <PillTagTrend :trend="device.status" :trend-type="device.status" />
                  </td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Name</td>
                  <td class="px-4 py-2 text-right">{{ device.name ?? device.device_id }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Device ID</td>
                  <td class="px-4 py-2 text-right">{{ device.device_id }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Device EUI</td>
                  <td class="px-4 py-2 text-right">{{ device.device_eui }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Description</td>
                  <td class="px-4 py-2 text-right">{{ device.description ?? 'No Description' }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Address</td>
                  <td class="px-4 py-2 text-right">{{ device.address ?? 'No Address' }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Progress Daily</td>
                  <td class="text-right">
                    <progress class="progress progress-success" :value="device.progress_daily ?? 20" max="144">
                      {{ device.progress_daily ?? 20 }}/144
                    </progress> {{ device.progress_daily ?? 20 }}/144
                  </td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Last Payload</td>
                  <td class="px-4 py-2 overflow-auto text-right">{{ device.latest_payload }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Last Seen</td>
                  <td class="px-4 py-2 text-right">{{ device.latest_payload_at }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Created At</td>
                  <td class="px-4 py-2 text-right">{{ dateTime(device.created_at) }}</td>
                </tr>
              </tbody>
            </table>
            <table class="w-full lg:hidden">
              <tbody>
                <tr>
                  <td data-label="Status">
                    <PillTagTrend :trend="device.status" :trend-type="device.status" />
                  </td>
                  <td data-label="Name">
                    {{ device.name ?? device.device_id }}
                  </td>
                  <td data-label="Device ID">
                    {{ device.device_id }}
                  </td>
                  <td data-label="Device EUI">
                    {{ device.device_eui }}
                  </td>
                  <td data-label="Description">
                    {{ device.description ?? 'No Description' }}
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
                    <div class="overflow-auto">
                      {{ device.latest_payload }}
                    </div>
                  </td>
                  <td data-label="Last seen">
                    {{ device.latest_payload_at }}
                  </td>
                  <td data-label="Created At">
                    {{ dateTime(device.created_at) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </CardBox>
        </div>

        <!-- MAP -->
        <div class="lg:col-span-2 rounded-lg shadow dark:shadow-gray-500">
          <CardBox class="h-full" hasTable>
            <div v-if="device.latitude">
              <GoogleMap v-if="device.latitude" :api-key="googleAPI" :center="deviceLocation" :zoom="17"
                style="width: 100%; height: 492px" :street-view-control="false" :styles="mapStyle">
                <Marker v-if="device.latitude" :options="{
                  position: deviceLocation,
                  icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                }" />
              </GoogleMap>
            </div>
            <div v-else class="flex h-full">
              <p class="text-gray-500 dark:text-gray-400 m-auto">No location data</p>
            </div>
          </CardBox>
        </div>
        <!-- END MAP -->
      </div>

      <SectionTitleLineWithButton :icon="mdiUpload" label="Uplinks" title="Uplinks" class="mt-10" main>
        <!--  -->
      </SectionTitleLineWithButton>
      <CardBox hasTable>
        <TableUplinkList :uplinks="uplinks" :links="links" />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';
import SectionMain from '@/Components/SectionMain.vue';
import CardBox from '@/Components/CardBox.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiArrowLeft, mdiDevices, mdiUpload } from '@mdi/js';
import BaseButton from '@/Components/BaseButton.vue';
import { GoogleMap, Marker } from 'vue3-google-map';
import { useStyleStore } from '@/Stores/style';
import { storeToRefs } from 'pinia';
import PillTagTrend from '@/Components/PillTagTrend.vue';
import TableUplinkList from '@/Components/TableUplinkList.vue';

const device = computed(() => usePage().props.value.device);
const googleAPI = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const state = storeToRefs(useStyleStore());
const mapStyle = state.mapStyle;

const deviceLocation = computed(() => {
  return {
    lat: parseFloat(device.value.latitude),
    lng: parseFloat(device.value.longitude),
  };
});

const dateTime = (date) => {
  const d = new Date(date);
  const year = d.getFullYear();
  const month = String(d.getMonth() + 1).padStart(2, '0');
  const day = String(d.getDate()).padStart(2, '0');
  const hour = String(d.getHours()).padStart(2, '0');
  const minute = String(d.getMinutes()).padStart(2, '0');
  const second = String(d.getSeconds()).padStart(2, '0');

  return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
};

const uplinks = computed(() => usePage().props.value.uplinks.data);
const links = computed(() => usePage().props.value.uplinks.links);


</script>

<style>
::-webkit-scrollbar {
  width: 6px;
  height: 6px
}

::-webkit-scrollbar-thumb {
  -webkit-border-radius: 6px;
  border-radius: 6px;
  background: #6B7280;
}
</style>
