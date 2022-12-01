<script setup>
import { mdiAccount, mdiAsterisk } from "@mdi/js";
import SectionFullScreen from "@/Components/SectionFullScreen.vue";
import CardBox from "@/Components/CardBox.vue";
import FormCheckRadio from "@/Components/FormCheckRadio.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButton from "@/Components/BaseButton.vue";
import LayoutGuest from "@/Layouts/LayoutGuest.vue";
import { Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onSuccess: () => {
      form.reset("password");
    },
  });
};
</script>

<template>
  <LayoutGuest>
    <SectionFullScreen v-slot="{ cardClass }" bg="purplePink">
      <CardBox :class="cardClass" is-form @submit.prevent="submit">
        <FormField label="Email" help="Please enter your email">
          <FormControl v-model="form.email" :icon="mdiAccount" name="email" autocomplete="email" />
        </FormField>

        <FormField label="Password" help="Please enter your password">
          <FormControl v-model="form.password" :icon="mdiAsterisk" type="password" name="password"
            autocomplete="current-password" />
        </FormField>

        <FormCheckRadio v-model="form.remember" name="remember" label="Remember" :input-value="true" />

        <template #footer>
          <BaseButton type="submit" color="info" label="Login" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing" />
          <Link v-if="canResetPassword" :href="route('password.request')"
            class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-200 ml-3">
          Forgot your password?
          </Link>
        </template>
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>
