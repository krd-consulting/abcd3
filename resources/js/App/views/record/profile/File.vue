<template>
  <div class="tw-rounded-lg tw-border tw-border-gray-lighter tw-pl-2 tw-pr-5 tw-py-3 tw-inline-flex">
    <div class="tw-w-6 tw-h-6 tw-rounded-full tw-bg-indigo-darker tw-text-white tw-flex tw-justify-center tw-items-center tw-text-xs">
      <i class="fas fa-file"></i>
    </div>
    <div class="tw-ml-2 tw-text-indigo-base tw-underline tw-font-semibold">
      {{ name }}
    </div>
  </div>
</template>

<script>
export default {
  name: "File",
  props: {
    name: String
  }
};
</script>
