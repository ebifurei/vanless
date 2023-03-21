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
                  <td class="font-semibold pr-3 text-left">Device Class</td>
                  <td class="px-4 py-2 text-right">{{ device.device_Class ?? "C" }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Uplink Interval</td>
                  <td class="px-4 py-2 text-right">{{ device.device_normal_internal ?? "5" }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Description</td>
                  <td class="px-4 py-2 text-right overflow-auto">{{ device.description ?? 'No Description' }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Address</td>
                  <td class="px-4 py-2 text-right overflow-auto">{{ device.address ?? 'No Address' }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Progress Daily</td>
                  <td class="text-right">
                    <progress class="progress progress-success" :value="device.progress_daily ?? 0" max="144">
                      {{ device.progress_daily ?? 0 }}/144
                    </progress> {{ device.progress_daily ?? 0 }}/144
                  </td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Last Payload</td>
                  <td class="px-4 py-2 overflow-auto text-right">{{ device.latest_payload }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Last Payload at</td>
                  <td class="px-4 py-2 text-right">{{ device.latest_payload_at }}</td>
                </tr>
                <tr>
                  <td class="font-semibold pr-3 text-left">Created At</td>
                  <td class="px-4 py-2 text-right">{{ device.created_at }}</td>
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
                  <td data-label="Last Payload at">
                    {{ device.latest_payload_at }}
                  </td>
                  <td data-label="Created At">
                    {{ device.created_at }}
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
                style="width: 100%; height: 580px" :street-view-control="false" :styles="mapStyle">
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

      <SectionTitleLineWithButton :icon="mdiUpload" label="Uplinks Data" title="Uplink Data" class="mt-10">
        <!--  -->
      </SectionTitleLineWithButton>
      <CardBox hasTable>
        <TableUplinkList :uplinks="uplinks" :links="uplink_links" noIcon />
      </CardBox>

      <SectionTitleLineWithButton :icon="mdiDownload" label="Downlink History" title="Downlink History" class="mt-10">
        <BaseButton class="border-slate-400 dark:border-slate-600" :icon="mdiDownload" label="Send Command" color="light"
          rounded-full small @click="isModalActive = true" />
      </SectionTitleLineWithButton>

      <CardBox hasTable v-if="downlinks">
        <TableDownlinkList :downlinks="downlinks" :links="downlink_links" noIcon />
      </CardBox>
      <CardBox v-else>
        <CardBoxComponentEmpty class="mt-4" />
      </CardBox>

      <CardBoxModal v-model="isModalActive" :title="'Send Command to ' + device.device_id" noFooter>
        <form @submit.prevent="formCommandSubmit">
          <FormField label="Select Command">
            <FormControl v-model="form.port" :options="commandOptions" required />
          </FormField>

          <FormField label="Payload" :help="payloadHelper" :error="form.errors.payload">
            <FormControl v-model="form.payload" type="number" required />
          </FormField>

          <BaseButton type="submit" color="info" label="Send" class="w-full" />
        </form>
      </CardBoxModal>

    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { computed, ref, watch } from 'vue';
import SectionMain from '@/Components/SectionMain.vue';
import CardBox from '@/Components/CardBox.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiArrowLeft, mdiDevices, mdiDownload, mdiUpload } from '@mdi/js';
import BaseButton from '@/Components/BaseButton.vue';
import { GoogleMap, Marker } from 'vue3-google-map';
import { useStyleStore } from '@/Stores/style';
import { storeToRefs } from 'pinia';
import PillTagTrend from '@/Components/PillTagTrend.vue';
import TableUplinkList from '@/Components/TableUplinkList.vue';
import TableDownlinkList from '@/Components/TableDownlinkList.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardBoxModal from '@/Components/CardBoxModal.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';

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

const uplinks = computed(() => usePage().props.value.uplinks.data);
const uplink_links = computed(() => usePage().props.value.uplinks.links);
const downlinks = computed(() => usePage().props.value.downlinks.data);
const downlink_links = computed(() => usePage().props.value.downlinks.links);

const isModalActive = ref(false);

const commandOptions = [
  { value: 3, label: 'Change Device Maintenance/Onrepair Status' },
  { value: 100, label: 'Change Device Class' },
  { value: 101, label: 'Change Device Normal Interval Uplink' },
  { value: 102, label: 'Change Device Alert Interval Uplink' },
  { value: 103, label: 'Request Latest Device Data for Debugging' },
  { value: 104, label: 'Check Port Downlink' },
]

const form = useForm({
  device_id: device.value.device_id,
  command: '',
  payload: null,
  port: null,
});

const payloadHelper = ref("");

watch(() => form.port, (val) => {
  if (val == 3) {
    form.command = 'Change Device Maintenance/Onrepair Status';
    payloadHelper.value = 'Note: 0 = Deactivated Onrepair, 1 = Activated Onrepair';
  } else if (val == 100) {
    form.command = 'Change Device Class';
    payloadHelper.value = 'Note: 0 = Class A, 1 = Class B, 2 = Class C';
  } else if (val == 101) {
    form.command = 'Change Device Normal Interval Uplink';
    payloadHelper.value = 'Note: Must be Number in minute e.g. 5'
  } else if (val == 102) {
    form.command = 'Change Device Alert Interval Uplink';
    payloadHelper.value = 'Note: Must be Number in minute e.g. 5';
  } else if (val == 103) {
    form.command = 'Request Latest Device Data for Debugging';
    payloadHelper.value = 'This command will send a request to device to send latest data for debugging';
  } else if (val == 104) {
    form.command = 'Check Port Downlink';
    payloadHelper.value = 'This command will send a request to device to check port downlink';
  }
});

const formCommandSubmit = () => {
  form.post(route('downlink.send'), {
    preserveScroll: true,
    onSuccess: () => {
      isModalActive.value = false;
    },
  });
};

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
