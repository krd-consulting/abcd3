<template>
  <div class="notification tw-rounded-lg tw-border-gray-lighter tw-border tw-pr-3 tw-flex tw-items-center">
    <div class="tw-rounded-l-lg tw-h-12" :class="[`tw-bg-${varientColor}`]" style="width: 5px"></div>
    <i class="tw-ml-4 tw-mr-6 tw-text-lg" :class="[icon, `tw-text-${varientColor}`]"></i>
    <div>
      <div class="tw-font-semibold">{{ title }}</div>
      <div class="tw-text-sm tw-text-gray-dark">{{ description }}</div>
    </div>
    <base-link class="tw-ml-auto tw-text-sm tw-text-indigo-darker">Open</base-link>
  </div>
</template>

<script>
export default {
  name: "Notification",
  props: {
    varientColor: String,
    icon: String,
    title: String,
    description: String
  }
};
</script>

<style>
.notification .el-link--inner {
  @apply tw-no-underline !important;
}
</style>
