<template>
    <div>
        <el-col :span="12" class="tw-mt-6">
            <label for="time-picker" class="inputLabel">{{ field.label }}</label><br>
            <sup>{{ field.fieldDescription }}</sup>
            <el-time-picker
                id="time-picker"
                arrow-control
                v-model="value"
                :picker-options="{selectableRange: '18:30:00 - 20:30:00'}"
                placeholder="Pick a time">
            </el-time-picker>
        </el-col>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            value: ''
        }
    },
    props: { 
        field: Object
    },
}
</script>

<style>

</style>
