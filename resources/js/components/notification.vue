<template>
  <div
    class="tw-w-10 tw-h-10 tw-cursor-pointer tw-relative tw-rounded-full tw-border tw-border-gray-lighter tw-bg-gray-lightest tw-flex tw-justify-center tw-items-center tw-text-indigo-base"
  >
    <base-icon class="tw-text-xl">chat</base-icon>
    <div v-if="hasNew" class="tw-w-3 tw-h-3 tw-rounded-full tw-bg-orange-base tw-absolute tw-top-0 tw-right-0"></div>
  </div>
</template>

<script>
export default {
  name: "notification",
  props: {
    hasNew: {
      type: Boolean,
      default: true
    }
  }
};
</script>
