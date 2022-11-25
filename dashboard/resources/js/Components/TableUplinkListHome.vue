<script setup>
import UserAvatar from '@/Components/UserAvatar.vue';

</script>

<template>
  <div>
    <div class="rounded-lg shadow dark:shadow-gray-500">
      <table class="w-full'">
        <thead>
          <tr>
            <th class="lg:hidden" />
            <th>Port</th>
            <th>Device name</th>
            <th>Date</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="uplink in $page.props.uplinksData" :key="uplink.id">
            <td class="lg:hidden">
              <UserAvatar :username="uplink.device_id" :api="'initials'" :font-size="40"
                class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
            </td>
            <td data-label="Port">
              {{ uplink.port }}
            </td>
            <td data-label="Device Name">
              {{ uplink.device_id }}
            </td>
            <td data-label="Date">
              {{ uplink.date }}
            </td>
            <td data-label="Time">
              {{ uplink.time }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>
