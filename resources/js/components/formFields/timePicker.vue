<template>
    <div class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="time-picker" class="tw-block tw-text-right tw-mr-1">{{ field.title }}</label>
            </el-col>

            <el-col :span="10">
                <el-time-select v-if="field.settings.exact_time === false"
                    arrow-control
                    :value="value"
                    @input="$emit('input', $event)"
                    :picker-options="{  
                        start: '01:00',
                        step: '00:15',
                        end: '24:45'
                    }"
                    placeholder=" ">
                </el-time-select>
                
                <el-time-picker v-else
                    arrow-control
                    :value="value"
                    @input="$emit('input', $event)"
                    placeholder=" ">
                </el-time-picker>
            </el-col>
        </el-row>
    </div>
</template>

<script>
export default {
    data: () => {
        return {}
    },
    props: { 
        field: Object,
        value: ''
    },
}
</script>

<style>

</style>
