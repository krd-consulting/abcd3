<template>
  <el-input v-bind="$attrs" v-on="$listeners" :class="{'el-input--background': background}">
    <slot slot="prefix" name="prefix"></slot>
  </el-input>
</template>
<script>
export default {
  inheritAttrs: false,
  props: {
    background: Boolean
  }
};
</script>
