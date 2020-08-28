<template>
  <div class="tw-flex">
    <div
      v-for="(item, index) in items"
      :key="item"
      class="tw-flex tw-items-center"
      :style="{marginLeft: index > 0 ? '5px' : 0}"
    >
      <div
        v-if="index > 0"
        class="tw-w-1 tw-h-1 tw-rounded-full"
        :class="{'tw-bg-indigo-base': index === items.length - 1, 'tw-bg-gray-darker': index < items.length - 1}"
      ></div>
      <div
        class="tw-text-xs"
        :style="{marginLeft: '5px'}"
        :class="{'tw-text-indigo-base tw-font-semibold': index === items.length - 1, 'tw-text-gray-darker': index < items.length - 1}"
      >{{ item }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "breadcrumb",
  props: {
    items: {
      type: Array,
      default: () => []
    }
  }
};
</script>
