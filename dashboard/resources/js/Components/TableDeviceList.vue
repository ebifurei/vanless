<script setup>
import { mdiEye, mdiGoogleMaps, mdiMarker, mdiTrashCan } from '@mdi/js';
import BaseButton from '@/Components/BaseButton.vue';
import PillTagTrend from '@/Components/PillTagTrend.vue';
import UserAvatar from '@/Components/UserAvatar.vue';

const props = defineProps({
  deviceList: {
    type: Array,
    required: true,
  },
});
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
        <tr v-for="device in deviceList" :key="device.id">
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
              <BaseButton :icon="mdiEye" />
              <BaseButton :icon="mdiTrashCan" />
              <BaseButton :icon="mdiGoogleMaps" />
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style lang="scss" scoped>

</style>
