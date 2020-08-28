<template>
  <div class="tw-flex tw-items-center tw-mt-1">
    <el-switch v-bind="$attrs" v-on="$listeners" :value="value" />
    <div
      class="tw-text-indigo-base tw-text-sm tw-ml-3"
    >{{value === activeValue ? activeText : inactiveText}}</div>
  </div>
</template>
<script>
export default {
  inheritAttrs: false,
  props: {
    value: [Number, String, Boolean],
    activeValue: {
      type: [Boolean, String],
      default: true
    },
    activeText: String,
    inactiveText: String
  }
};
</script>
