<template>
  <el-button
    :class="{'el-button--outline': outline, 'el-button--gray': gray}"
    v-bind="$attrs"
    :native-type="type"
    @click="click"
  >
    <slot></slot>
  </el-button>
</template>
<script>
export default {
  props: {
    type: String,
    outline: Boolean,
    gray: Boolean
  },
  inheritAttrs: false,
  methods: {
    click(payload) {
      this.$emit("click", payload);
    }
  }
};
</script>
