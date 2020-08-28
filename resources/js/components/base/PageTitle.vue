<template>
  <div class="tw-flex tw-items-center">
    <div
      v-if="hasBookmark"
      class="tw-w-6 tw-h-6 tw-bg-orange-base tw-rounded-full tw-flex tw-justify-center tw-items-center tw-mr-3"
    >
      <base-icon class="tw-text-white tw-text-sm">bookmark</base-icon>
    </div>
    <h1 class="tw-text-3xl tw-text-black tw-font-light">{{ title }}</h1>
  </div>
</template>

<script>
export default {
  name: "PageTitle",
  props: {
    title: String,
    hasBookmark: Boolean
  }
};
</script>
