<template>
  <el-tabs @tab-click="handleClick" :value="$route.name">
    <slot></slot>
  </el-tabs>
</template>
<script>
  export default {
    methods: {
      handleClick(tab, event) {
        if(this.$route.name === tab.name)
          return;

        this.$router.push({ name: tab.name });
      },
    },
  }
</script>
