<template>
    <div id="datepicker" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="dateField" class="inputLabel">{{ field.title }}</label>
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
                    :format="dateFormat"
                    :required="isRequired">
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
        }
    },
    props: { 
        field: Object
    },
    computed: {
        isRequired: {
            get() { return this.field.settings.required }
        },
        dateType: {
            get() { return this.field.settings.dateType} 
        },
        dateOptions: {
            get() { return this.field.settings.dateOptions } 
        },
        datePlaceHolder: {
            get() { return this.field.settings.datePlaceHolder } 
        },
        rangeSeparator: {
            get() { return this.field.settings.rangeSeparator } 
        },
        startDate: {
            get() { return this.field.settings.startDate } 
        },
        endDate: {
            get() { return this.field.settings.endDate } 
        },
        dateFormat: {
            get() { return this.field.settings.dateFormat } 
        },
    }
}
</script>

<style>

</style>
