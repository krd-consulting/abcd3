<template>
  <div
    class="tw-rounded-lg tw-p-5 tw-flex tw-items-center tw-bg-white tw-border-indigo-lightest tw-border"
  >
    <div
      class="tw-w-16 tw-h-16 tw-rounded-lg tw-flex tw-items-center tw-justify-center"
      :class="[textClass, bgClass]"
    >
      <i class="tw-text-3xl" :class="[icon]"></i>
    </div>
    <div class="tw-ml-5">
      <div class="tw-text-2xl tw-font-bold" :class="[textClass]">{{ title }}</div>
      <div class="tw-text-sm tw-text-gray-dark">{{description}}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "InfoCard",
  props: {
    icon: String,
    textClass: String,
    bgClass: String,
    title: String,
    description: String,
  }
};
</script>
