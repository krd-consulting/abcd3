<template>
    <div class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="time-picker" class="inputLabel">{{ field.title }}</label>
            </el-col>

            <el-col :span="10">
                <el-time-select v-if="field.settings.exact_time === false"
                    arrow-control
                    v-model="timeSelection"
                    :picker-options="{  
                        start: '01:00',
                        step: '00:15',
                        end: '24:45'
                    }"
                    placeholder="Pick a time">
                </el-time-select>
                
                <el-time-picker v-else
                    arrow-control
                    v-model="timeSelection"
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
