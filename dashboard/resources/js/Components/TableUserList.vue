<script setup>
import UserAvatar from '@/Components/UserAvatar.vue';
import Pagination from '@/Components/Pagination.vue';
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import CardBox from '@/Components/CardBox.vue';
import BaseButton from '@/Components/BaseButton.vue';
import { mdiMarker } from '@mdi/js';
import { Link } from '@inertiajs/inertia-vue3';
import FormCheckRadio from './FormCheckRadio.vue';
import { ref } from 'vue';

const props = defineProps({
  users: {
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

const subscribeEmail = (value) => {
  if (value == 1) {
    return "Yes";
  }
  return "No";
}

const userSwitchVal = ref(false);

</script>

<template>
  <div>
    <div v-if="props.users" class="rounded-lg shadow dark:shadow-gray-500">
      <table class="w-full'">
        <thead>
          <tr>
            <th />
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created Time</th>
            <th>Notifications</th>
            <th />
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in props.users" :key="user.id">
            <td v-if="!noIcon">
              <UserAvatar :username="user.name" :font-size="40" class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
            </td>
            <td data-label="Name">
              {{ user.name }}
            </td>
            <td data-label="Email">
              {{ user.email }}
            </td>
            <td data-label="Role">
              {{ user.role }}
            </td>
            <td data-label="Created at">
              {{ user.created_at }}
            </td>
            <td data-label="email subscription">
              {{ subscribeEmail(user.email_subscribe) }}
            </td>
            <td>
              <div class="space-x-1">
                <BaseButton :icon="mdiMarker" title="Edit user" />
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

    <Pagination class="mt-6" :links="props.links" />
  </div>
</template>

<style lang="scss" scoped>

</style>
