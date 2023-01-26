<script setup>
import UserAvatar from '@/Components/UserAvatar.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
  downlinks: {
    type: Array,
    required: true,
  },
  links: {
    type: Array,
    required: true,
  },
  noIcon: {
    type: Boolean,
    default: false
  },
});

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
            <th>Created_at</th>
            <th>Command</th>
            <th>Payload</th>
            <th>Status</th>
            <th>Updated_at</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="downlink in props.downlinks" :key="downlink.id">
            <td class="lg:hidden" v-if="!noIcon">
              <UserAvatar :username="downlink.device_id" :api="'initials'" :font-size="40"
                class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
            </td>
            <td data-label="Port">
              {{ downlink.port }}
            </td>
            <td data-label="Device ID">
              {{ downlink.device_id }}
            </td>
            <td data-label="Created_at">
              {{ downlink.created_at }}
            </td>
            <td data-label="Command">
              {{ downlink.command }}
            </td>
            <td data-label="Payload">
              <div class="overflow-auto">
                {{ downlink.payload }}
              </div>
            </td>
            <td data-label="status">
              {{ downlink.status }}
            </td>
            <td data-label="Updated_at">
              {{ downlink.updated_at }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pagination class="mt-6" :links="props.links" />
  </div>
</template>

<style lang="scss" scoped>

</style>
