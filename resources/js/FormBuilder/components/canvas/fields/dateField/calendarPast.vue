<template>
    <el-date-picker 
        v-model="dateSelection" 
        type="date" 
        placeholder="Pick a day" 
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
    },
    props: {

    }
}
</script>

<style>

</style>
