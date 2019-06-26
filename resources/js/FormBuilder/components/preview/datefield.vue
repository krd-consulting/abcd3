<template>
    <div id="datepicker">
        <el-col :span="12">
            <label for="dateField" class="inputLabel">{{ field.label }}</label><br>
            <sup>{{ field.fieldDescription }}</sup><br>
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
