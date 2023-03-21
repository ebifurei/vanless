<template>
  <LayoutAuthenticated>

    <Head title="Users" />

    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiAccountMultiple" title="User Lists" main>
        <Link :href="route('user.create')">
        <BaseButton class="border-slate-400 dark:border-slate-600" :icon="mdiPlus" label="Create User" color="light"
          rounded-full small />
        </Link>
      </SectionTitleLineWithButton>

      <TableUserList :users="users" :links="links" />
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import SectionMain from '@/Components/SectionMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import TableUserList from '@/Components/TableUserList.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { mdiAccountMultiple, mdiPlus } from '@mdi/js';
import { computed } from 'vue';
import BaseButton from '@/Components/BaseButton.vue';

const users = computed(() => usePage().props.value.users.data);
const links = computed(() => usePage().props.value.users.links);

</script>

<style lang="scss" scoped></style>
