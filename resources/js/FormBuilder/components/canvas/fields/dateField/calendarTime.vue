<template>
    <el-date-picker
      v-model="dateSelection"
      type="datetime"
      placeholder="Select date and time"
      format="yyyy/MM/dd h:mm:ss a">
    </el-date-picker>
</template>

<script>
export default {
    data: () => {
        return {
            dateSelection: ''
        }
    }
}
</script>

<style>

</style>
