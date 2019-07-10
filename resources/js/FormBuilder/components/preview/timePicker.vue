<template>
    <div class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="time-picker" class="inputLabel">{{ field.label }}</label>
            </el-col>

            <el-col :span="10">
                <el-time-picker
                    id="time-picker"
                    arrow-control
                    v-model="value"
                    :picker-options="{selectableRange: '18:30:00 - 20:30:00'}"
                    placeholder="Pick a time">
                </el-time-picker>
            </el-col>
        </el-row>
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
