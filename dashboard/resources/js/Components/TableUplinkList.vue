<script setup>
import UserAvatar from '@/Components/UserAvatar.vue';
import Pagination from '@/Components/Pagination.vue';


</script>

<template>
  <div>
    <div class="rounded-lg shadow dark:shadow-gray-500">
      <table class="w-full'">
        <thead>
          <tr>
            <th class="lg:hidden" />
            <th>Port</th>
            <th>Device-id</th>
            <th>Date</th>
            <th>Payloads</th>
            <th>Time</th>
            <th />
          </tr>
        </thead>
        <tbody>
          <tr v-for="uplink in $page.props.uplinks.data" :key="uplink.id">
            <td class="lg:hidden">
              <UserAvatar :username="uplink.device_id" :api="'initials'" :font-size="40"
                class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
            </td>
            <td data-label="Port">
              {{ uplink.port }}
            </td>
            <td data-label="Device ID">
              {{ uplink.device_id }}
            </td>
            <td data-label="Date">
              {{ uplink.date }}
            </td>
            <td data-label="Payloads">
              <div class="overflow-auto">
                {{ uplink.payloads }}
              </div>
            </td>
            <td data-label="Payloads at">
              {{ uplink.created_at }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <Pagination class="mt-6" :links="$page.props.uplinks.links" />
  </div>
</template>

<style lang="scss" scoped>

</style>
