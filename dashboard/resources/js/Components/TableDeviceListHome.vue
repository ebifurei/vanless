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
        <th class="w-10">
          Status
        </th>
        <th>Name</th>
        <th>Device id</th>
        <th>Description</th>
        <th>Last Seen</th>
        <th>Daily Progress</th>
        <th>Created Time</th>
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
          {{ device.description ?? "No description" }}
        </td>
        <td data-label="Last seen">
          {{ device.last_payload_at }}
        </td>
        <td data-label="Daily Progress">
          <progress class="progress is-small is-primary" value="15" max="100">15%</progress>
        </td>
        <td data-label="Device Created">
          {{ device.created_at }}
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
