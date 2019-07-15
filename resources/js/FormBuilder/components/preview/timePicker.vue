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
                    :picker-options="{  
                        start: '01:00',
                        step: '00:15',
                        end: '24:45'
                    }"
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
