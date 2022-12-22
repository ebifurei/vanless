<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { useStyleStore } from "@/Stores/style.js";
import { gradientBgPurplePink } from "@/colors.js";
import SectionMain from "@/Components/SectionMain.vue";
import CardBox from "@/Components/CardBox.vue";
import LayoutGuest from "@/Layouts/LayoutGuest.vue";

const styles = ["white", "basic"];

const styleStore = useStyleStore();

styleStore.setDarkMode(false);

// click change style and redirect to home
const click = (style) => {
  styleStore.setStyle(style);
};

</script>

<template>
  <LayoutGuest>
    <div :class="gradientBgPurplePink" class="flex min-h-screen items-center justify-center">
      <SectionMain>
        <h1 class="text-4xl md:text-5xl text-center text-white font-bold mt-12 mb-3 lg:mt-0">
          Pick a style&hellip;
        </h1>
        <h2 class="text-xl md:text-xl text-center text-white mb-12">
          Style switching with a single
          <code class="px-1.5 py-0.5 rounded bg-white bg-opacity-20">action()</code>
        </h2>
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-2 px-6 max-w-6xl mx-auto">
          <CardBox v-for="style in styles" :key="style" class="cursor-pointer bg-gray-50" is-hoverable
            @click="click(style)">
            <Link href="/login">
            <div class="mb-3 md:mb-6">
              <img :src="`https://static.justboil.me/templates/one/small/${style}-v3.png`" width="1280" height="720" />
            </div>

            <h1 class="text-xl md:text-2xl font-black capitalize">
              {{ style }}
            </h1>
            <h2 class="text-lg md:text-xl">& Dark mode</h2>
            </Link>
          </CardBox>
        </div>
      </SectionMain>
    </div>
  </LayoutGuest>
</template>
