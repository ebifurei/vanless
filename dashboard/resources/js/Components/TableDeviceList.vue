<script setup>
import { computed, ref } from "vue";
import { mdiEye, mdiTrashCan } from "@mdi/js";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import BaseLevel from "@/Components/BaseLevel.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseButton from "@/Components/BaseButton.vue";
import UserAvatar from "@/Components/UserAvatar.vue";
import PillTagTrend from './PillTagTrend.vue';

</script>


<template>
  <!-- <CardBoxModal v-model="isModalActive" title="Sample modal">
    <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
    <p>This is sample modal</p>
  </CardBoxModal>

  <CardBoxModal v-model="isModalDangerActive" title="Please confirm" button="danger" has-cancel>
    <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
    <p>This is sample modal</p>
  </CardBoxModal> -->

  <table class="table-auto table-responsive">
    <thead>
      <tr>
        <th />
        <!-- status with width of 15% -->
        <th class="w-10">
          Status
        </th>
        <th>Name</th>
        <th>Device id</th>
        <th>Description</th>
        <th v-if="route.name === 'devices.index'">devEUI</th>
        <th v-if="route.name === 'devices.index'">Address</th>
        <th v-if="route.name === 'devices.index'">Location</th>
        <th v-if="route.name === 'devices.index'">Last Payload</th>
        <th>Last Uplink At</th>
        <th>Daily Progress</th>
        <th v-if="route.name === 'devices.index'">Created</th>
        <th v-if="route.name === 'devices.index'">Actions</th>
      </tr>
    </thead>

    <tbody>
      <tr v-for="(device, index) in $page.props.devices" :key="index">
        <td class="border-b-0 lg:w-6 before:hidden">
          <UserAvatar :username="device.device_id" :api="'initials'" :status="device.status" :font-size="40"
            class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
        </td>
        <td data-label="Status">
          <PillTagTrend :trend="device.status" :trend-type="device.status" />
        </td>
        <td data-label="Name">
          {{ device.name ?? device.device_id }}
        </td>
        <td data-label="Device id">
          {{ device.device_id }}
        </td>
        <td data-label="Description">
          {{ device.description }}
        </td>
        <td v-if="route.name === 'devices.index'" data-label="Device EUI">
          {{ device.device_eui }}
        </td>
        <td v-if="route.name === 'devices.index'" data-label="Address">
          {{ $device.address }}
        </td>
        <td v-if="route.name === 'devices.index'" data-label="Location">
          longitude: {{ device.longitude }} <br>
          latitude: {{ device.latitude }}
        </td>
        <td v-if="route.name === 'devices.index'" data-label="Last payload">
          {{ device.last_payload }}
        </td>
        <td data-label="Last seen">
          {{ device.last_payload_at }}
        </td>
        <td data-label="Daily Progress">
          <progress class="progress is-small is-primary" value="15" max="100">15%</progress>
        </td>
        <td v-if="route.name === 'devices.index'" data-label="Device Created">
          {{ device.created_at }}
        </td>
        <td v-if="route.name === 'devices.index'">
          <BaseButton icon="mdi-eye" type="primary" />
          <BaseButtons icon="mdi-location" type="primary" />
          <BaseButton icon="mdi-trash-can" type="danger" />
        </td>
      </tr>
    </tbody>
  </table>
  <!-- <div class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800">
    <BaseLevel>
      <BaseButtons>
        <BaseButton v-for="page in pagesList" :key="page" :active="page === currentPage" :label="page + 1"
          :color="page === currentPage ? 'lightDark' : 'whiteDark'" small @click="currentPage = page" />
      </BaseButtons>
      <small>Page {{ currentPageHuman }} of {{ numPages }}</small>
    </BaseLevel>
  </div> -->
</template>
