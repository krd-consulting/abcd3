<template>
    <el-date-picker
      v-model="dateSelection"
      type="datetime"
      placeholder="Select date and time"
      format="yyyy/MM/dd h:mm:ss a"
      :picker-options="pastOnly">
    </el-date-picker>
</template>

<script>
export default {
    data: () => {
        return {
            dateSelection: '',
            pastOnly: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                }
            },
        }
    }
}
</script>

<style>

</style>
