<template>
  <LayoutAuthenticated>

    <Head title="User Create" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiAccount" title="User Create" main>
        <Link :href="route('user.index')">
        <BaseButton class="border-slate-400 dark:border-slate-600" :icon="mdiArrowLeft" label="Back" color="light"
          rounded-full small />
        </Link>
      </SectionTitleLineWithButton>

      <CardBox is-form @submit.prevent="submit">
        <FormValidationErrors />

        <FormField label="Name" label-for="name" help="Please enter name">
          <FormControl v-model="form.name" id="name" :icon="mdiAccount" autocomplete="name" type="text" required />
        </FormField>

        <FormField label="Email" label-for="email" help="Please enter email">
          <FormControl v-model="form.email" id="email" :icon="mdiEmail" autocomplete="email" type="email" required />
        </FormField>

        <FormField label="Password" label-for="password" help="Please enter new password">
          <FormControl v-model="form.password" id="password" :icon="mdiFormTextboxPassword" type="password"
            autocomplete="new-password" required />
        </FormField>

        <FormField label="Confirm Password" label-for="password_confirmation" help="Please confirm password">
          <FormControl v-model="form.password_confirmation" id="password_confirmation" :icon="mdiFormTextboxPassword"
            type="password" autocomplete="new-password" required />
        </FormField>

        <FormCheckRadioGroup v-model="form.email_subscribe" name="email subscription"
          :options="{ true: 'I agree to receive email notifications (can be changed later)' }" />

        <BaseDivider />

        <BaseButtons>
          <BaseButton type="submit" color="info" label="Create" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing" />
        </BaseButtons>
      </CardBox>

    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import SectionMain from '@/Components/SectionMain.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';
import { mdiAccount, mdiArrowLeft, mdiEmail, mdiFormTextboxPassword } from '@mdi/js';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseButton from '@/Components/BaseButton.vue';
import FormField from '@/Components/FormField.vue';
import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue';
import FormValidationErrors from '@/Components/FormValidationErrors.vue';
import BaseDivider from '@/Components/BaseDivider.vue';


const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  email_subscribe: false,
});


const submit = () => {
  form.post(route('user.store'), form);
};

</script>

<style lang="scss" scoped>

</style>
