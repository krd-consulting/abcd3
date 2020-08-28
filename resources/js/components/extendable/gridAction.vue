<template>
  <base-button size="small" outline @click="$emit('click')">
    <i :class="icon" class="tw-mr-2"></i>
    <span class="tw-text-xs tw-align-middle">{{ label }}</span>
  </base-button>
</template>

<script>
export default {
  props: {
    icon: String,
    label: String
  }
};
</script>
