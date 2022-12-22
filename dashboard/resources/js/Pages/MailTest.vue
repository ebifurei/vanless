<template>
  <LayoutAuthenticated>
    <SectionMain>
      <CardBox :class="cardClass" is-form @submit.prevent="submit">
        <FormValidationErrors />

        <NotificationBarInCard v-if="status" color="info">
          {{ status }}
        </NotificationBarInCard>

        <FormField label="Subject" label-for="subject">
          <FormControl v-model="form.subject" :icon="mdiAccount" id="subject" autocomplete="subject" type="text"
            required />
        </FormField>

        <FormField label="Message" label-for="message">
          <FormControl v-model="form.message" :icon="mdiAsterisk" type="text" id="message"
            autocomplete="current-message" required />
        </FormField>

        <FormField label="Device Name" label-for="device_name">
          <FormControl v-model="form.device_name" :icon="mdiAsterisk" type="text" id="device_name"
            autocomplete="current-device_name" required />
        </FormField>

        <FormField label="Link" label-for="link">
          <FormControl v-model="form.link" :icon="mdiAsterisk" type="text" id="link" autocomplete="current-link"
            required />
        </FormField>


        <BaseDivider />

        <BaseLevel>
          <BaseButtons>
            <BaseButton type="submit" color="info" label="Send" :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing" />
          </BaseButtons>
        </BaseLevel>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseDivider from '@/Components/BaseDivider.vue';
import BaseLevel from '@/Components/BaseLevel.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import FormValidationErrors from '@/Components/FormValidationErrors.vue';
import NotificationBarInCard from '@/Components/NotificationBarInCard.vue';
import SectionMain from '@/Components/SectionMain.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
  subject: '',
  message: '',
  device_name: '',
  link: '',
});

const submit = () => {
  form.post(route('mail.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('subject', 'message', 'device_name', 'link');
    },
  });
};
</script>

<style lang="scss" scoped>

</style>
