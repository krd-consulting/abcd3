<template>
    <el-date-picker v-model="dateSelection" type="date" placeholder="Pick a day"></el-date-picker>
</template>

<script>
export default {
    data: () => {
        return {
            dateSelection: '',
        }
    },
    props: {

    }
}
</script>

<style>

</style>
