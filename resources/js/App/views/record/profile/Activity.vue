<template>
  <div
    class="tw-flex tw-items-center"
    :class="{'tw-border-t tw-border-gray-lighter tw-pt-5 tw-mt-5': separation}"
  >
    <div class="tw-text-xs tw-text-indigo-darker">
      <div>{{ date | moment('hh:mm A') }}</div>
      <div class="tw-mt-1">{{ date | moment('MMM DD') }}</div>
    </div>
    <div class="tw-border-r tw-border-gray-lighter tw-h-8 tw-mx-4"></div>
    <div>
      <div class="tw-font-semibold tw-text-indigo-base">{{ title }}</div>
      <div class="tw-mt-1 tw-text-sm">{{ description }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Activity",
  props: {
    date: String,
    title: String,
    description: String,
    separation: Boolean
  }
};
</script>
