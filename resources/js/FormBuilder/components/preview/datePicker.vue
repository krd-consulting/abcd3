<template>
    <div id="datepicker" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="dateField" class="inputLabel">{{ field.label }}</label>
            </el-col>

            <el-col :span="10">
                <el-date-picker 
                    id="dateField"
                    v-model="value" 
                    :type="dateType" 
                    :picker-options="dateOptions" 
                    :placeholder="datePlaceHolder"
                    :range-separator="rangeSeparator"
                    :start-placeholder="startDate"
                    :end-placeholder="endDate"
                    :format="dateFormat">
                </el-date-picker>
            </el-col>
        </el-row>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            value: '',
            dateType: 'date',
            dateOptions: '',
            datePlaceHolder: 'Select a date',
            rangeSeparator: '',
            startDate: '',
            endDate: '',
            dateFormat: ''
        }
    },
    props: { 
        field: Object
    },

}
</script>

<style>

</style>
