<script setup>
import { computed, ref } from "vue";
import { useMainStore } from "@/Stores/main.js";
import { mdiCheckDecagram } from "@mdi/js";
import BaseLevel from "@/Components/BaseLevel.vue";
import UserAvatarCurrentUser from "@/Components/UserAvatarCurrentUser.vue";
import CardBox from "@/Components/CardBox.vue";
import FormCheckRadio from "@/Components/FormCheckRadio.vue";
import PillTag from "@/Components/PillTag.vue";

const mainStore = useMainStore();

const userName = computed(() => mainStore.userName);

const userSwitchVal = computed({
  get: () => mainStore.userNotification,
  set: (val) => mainStore.setUserSwitchVal(val),
});
</script>

<template>
  <CardBox>
    <BaseLevel type="justify-around lg:justify-center">
      <UserAvatarCurrentUser class="lg:mx-12" />
      <div class="space-y-3 text-center md:text-left lg:mx-12">
        <div class="flex justify-center md:block">
          <FormCheckRadio v-model="userSwitchVal" name="notifications-switch" type="switch" label="Notifications"
            :input-value="true" />
        </div>
        <h1 class="text-2xl">
          Howdy, <b>{{ userName }}</b>!
        </h1>
        <div class="flex justify-center md:block">
          <PillTag label="Verified" color="info" :icon="mdiCheckDecagram" />
        </div>
      </div>
    </BaseLevel>
  </CardBox>
</template>
