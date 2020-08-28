<template>
  <div>
    <div
      class="tw-rounded-t-lg tw-bg-indigo-darker tw-h-12 tw-px-5 tw-flex tw-items-center tw-justify-between"
      v-if="title"
    >
      <div class="tw-text-sm tw-text-white">{{ title }}</div>
      <base-button
        v-for="action in actions"
        :key="action.text"
        size="small"
        gray
        class="tw-text-xs tw-rounded-full"
      >
        <i :class="[action.icon]" class="tw-mr-1"></i>
        {{ action.text }}
      </base-button>
    </div>
    <div
      class="tw-rounded-b-lg tw-border-gray-lighter tw-border-b tw-border-r tw-border-l tw-p-5"
      :class="{'tw-border-t tw-rounded-t-lg': !title}"
    >
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    actions: Array
  }
};
</script>
