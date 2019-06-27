<template>
    <div id="datepicker">
        <label for="dateField" class="inputLabel">{{ field.label }}</label><br>
        <sup>{{ field.description }}</sup>
        <el-date-picker 
            id="dateField"
            v-model="dateSelection" 
            :type="dateType" 
            :picker-options="dateOptions" 
            :placeholder="datePlaceHolder"
            :range-separator="rangeSeparator"
            :start-placeholder="startDate"
            :end-placeholder="endDate"
            :format="dateFormat">
        </el-date-picker>
            
        <el-collapse>
            <el-collapse-item name="1">
                <template slot="title">
                    <el-button icon="el-icon-edit">Field Options</el-button>
                </template>
                    <div class="tw-flex tw-inline-block tw-w-full">
                        <div class="tw-float-left">
                             <span>Field Label</span>
                            <el-row>
                                <el-col :span="20">
                                    <el-input v-model="field.label"></el-input>
                                </el-col>
                            </el-row>
                            <el-row class="tw-my-6">
                                <el-col :span="20">
                                    <label for="description">Field Description</label>
                                    <el-input id="description" v-model="field.description"></el-input>
                                </el-col>
                            </el-row>
                            <el-row class="tw-my-6">
                                <span class="tw-mb-4">This field is</span><br>
                                <el-switch v-model="field.required" active-text="Required" inactive-text="Optional"></el-switch>
                            </el-row>
                        </div>

                        <div class="tw-float-right tw-mx-20">
                            <span>Calendar Preferences</span>
                            <el-row class="tw-m-4">
                                <el-switch @change="togglePastOnly" v-model="field.settings.past_only" active-text="Up to current day"></el-switch>
                            </el-row>
                            <el-row class="tw-m-4">
                                <el-switch @change="toggleFutureOnly" v-model="field.settings.future_only" active-text="Beyond current day"></el-switch>
                            </el-row>
                            <el-row class="tw-m-4">
                                <el-switch @change="toggleQuickMenu" v-model="field.settings.quick_menu" active-text="Include Quick menu"></el-switch>
                            </el-row>
                            <el-row class="tw-m-4">
                                <el-switch @change="toggleTime" v-model="field.settings.include_time" active-text="Include time"></el-switch>
                            </el-row>
                            <el-row class="tw-m-4">
                                <el-switch @change="toggleRangeMenu" v-model="field.settings.date_range" active-text="Date Range"></el-switch>
                            </el-row>
                        </div>
                    </div>
                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>

export default {
    data: () => {
        return {
            dateSelection: '',
            dateType: 'date',
            dateOptions: {},
            datePlaceHolder: 'Pick a day',
            dateFormat: 'yyyy/MM/dd',
            rangeSeparator: '',
            startDate: '',
            endDate: '',
            field: []
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    created() {
        this.field = _.clone(this.fieldData)
    },
    mounted() {
        this.togglePastOnly(),
        this.toggleFutureOnly(),
        this.toggleQuickMenu(),
        this.toggleTime(),
        this.toggleRangeMenu()
    },
    computed: {
        handlePastFutureToggle() {
            if(this.field.settings.past_only === true){
                this.field.settings.future_only === false
            }
            if(this.field.settings.future_only === true) {
                this.field.settings.past_only === false
            }
        }
    },
    methods: {
        togglePastOnly() {
            if(this.field.settings.past_only === true) {
                this.dateOptions = Object.assign({}, this.dateOptions, {
                    disabledDate(time) { 
                        return time.getTime() > Date.now() 
                    },
                });
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            } else {
                this.dateOptions = Object.assign({}, this.dateOptions, {
                    disabledDate: {}
                });
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            }
        },
        toggleFutureOnly() {
            if(this.field.settings.future_only === true) {
                this.dateOptions = Object.assign({}, this.dateOptions, {
                    disabledDate(time) { 
                        return time.getTime() < Date.now() 
                    },
                });
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            } else {
                this.dateOptions = Object.assign({}, this.dateOptions, {
                    disabledDate: {}
                });
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            }
        },
        toggleQuickMenu() {
            if(this.field.settings.quick_menu === true) {
                this.dateOptions = Object.assign({}, this.dateOptions, {
                    shortcuts: [
                        { text: 'Today', onClick(picker) 
                            { picker.$emit('pick', new Date()); }
                        }, 
                        { text: 'Yesterday', onClick(picker) 
                            { const date = new Date(); 
                            date.setTime(date.getTime() - 3600 * 1000 * 24); 
                            picker.$emit('pick', date);
                            }
                        },
                        { text: 'A week ago', onClick(picker) 
                            { const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', date);}
                        }
                    ],
                });
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            } else {
                this.datesettings.Object.assign({}, this.dateOptions, {
                    shortcuts: {}
                });
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            }
        },
        toggleTime() {
            if(this.field.settings.include_time === true) {
                this.dateType = "datetime",
                this.datePlaceHolder = "Pick a day and time"
                this.dateFormat = "yyyy/MM/dd hh:mm:ss a"
            } else {
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            }
            
        },
        toggleRangeMenu() {
            if(this.field.settings.date_range === true){
                this.dateType = 'daterange',
                this.rangeSeparator = 'to',
                this.dateFormat = "yyyy/MM/dd",
                this.startDate = 'Start date',
                this.endDate = 'End date'
            }
        }
    }
}
</script>

<style>

</style>
