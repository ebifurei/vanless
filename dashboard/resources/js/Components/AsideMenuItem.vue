<script setup>
import { ref, computed, watch } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { useStyleStore } from "@/Stores/style.js";
import { mdiMinus, mdiPlus } from "@mdi/js";
import { getButtonColor } from "@/colors.js";
import BaseIcon from "@/Components/BaseIcon.vue";
import AsideMenuList from "@/Components/AsideMenuList.vue";

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  isDropdownList: Boolean,
});

// Add itemHref
const itemHref = computed(() => props.item.route ? route(props.item.route) : props.item.href)

// const secondCheck = computed(() => {
//   return route().current().startsWith('device.') &&
//     (props.item.route ? props.item.route.startsWith('device.') : false)
// })

const secondCheck = computed(() => {
  return ['device.', 'user.'].some(item => route().current().startsWith(item) &&
    (props.item.route ? props.item.route.startsWith(item) : false))
});
// Add activeInactiveStyle
const activeInactiveStyle = computed(
  () => props.item.route && route().current(props.item.route)
    ? styleStore.asideMenuItemActiveStyle
    : secondCheck.value ? styleStore.asideMenuItemActiveStyle : ''
)

const emit = defineEmits(["menu-click"]);

const styleStore = useStyleStore();

const hasColor = computed(() => props.item && props.item.color);

const asideMenuItemActiveStyle = computed(() =>
  hasColor.value ? "" : styleStore.asideMenuItemActiveStyle
);

const isDropdownActive = ref(false);

const componentClass = computed(() => [
  props.isDropdownList ? "py-3 px-6 text-sm" : "py-3",
  hasColor.value
    ? getButtonColor(props.item.color, false, true)
    : `${styleStore.asideMenuItemStyle} dark:text-slate-300 dark:hover:text-white`,
]);

const hasDropdown = computed(() => !!props.item.menu);

const menuClick = (event) => {
  emit("menu-click", event, props.item);

  if (hasDropdown.value) {
    isDropdownActive.value = !isDropdownActive.value;
  };
};

isDropdownActive.value = ['device.', 'location.index', 'uplink.index'].some(routeStart => route().current().startsWith(routeStart));


</script>

<template>
  <li>
    <component :is="item.route ? Link : 'a'" :href="itemHref" :target="item.target ?? null" class="flex cursor-pointer"
      :class="componentClass" @click="menuClick">
      <BaseIcon v-if="item.icon" :path="item.icon" class="flex-none" :class="activeInactiveStyle" w="w-16" :size="18" />
      <span class="grow text-ellipsis line-clamp-1" :class="activeInactiveStyle">{{ item.label }}</span>
      <BaseIcon v-if="hasDropdown" :path="isDropdownActive ? mdiMinus : mdiPlus" class="flex-none"
        :class="activeInactiveStyle" w="w-12" />
    </component>
    <AsideMenuList v-if="hasDropdown" :menu="item.menu" :class="[
      styleStore.asideMenuDropdownStyle,
      isDropdownActive ? 'block dark:bg-slate-800/50' : 'hidden',
    ]" is-dropdown-list />
  </li>
</template>
