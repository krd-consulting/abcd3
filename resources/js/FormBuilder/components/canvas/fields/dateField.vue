<template>
    <div id="datepicker">
        <label for="dateField" class="inputLabel">{{ inputFieldData.label }}</label><br>
        <sup>{{ inputFieldData.description }}</sup>
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
                                    <el-input v-model="inputFieldData.label"></el-input>
                                </el-col>
                            </el-row>
                            <el-row class="tw-my-6">
                                <el-col :span="20">
                                    <label for="description">Field Description</label>
                                    <el-input id="description" v-model="inputFieldData.description"></el-input>
                                </el-col>
                            </el-row>
                            <el-row class="tw-my-6">
                                <span class="tw-mb-4">This field is</span><br>
                                <el-switch v-model="inputFieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
                            </el-row>
                        </div>

                        <div class="tw-float-right tw-mx-20">
                            <span>Calendar Preferences</span>
                            <el-row class="tw-m-4">
                                <el-switch @change="togglePastOnly" v-model="inputFieldData.options.dateSelect1" active-text="Only allow up to current day"></el-switch>
                            </el-row>
                            <el-row class="tw-m-4">
                                <el-switch @change="toggleQuickMenu" v-model="inputFieldData.options.dateSelect2" active-text="Include Quick menu"></el-switch>
                            </el-row>
                            <el-row class="tw-m-4">
                                <el-switch @change="toggleTime" v-model="inputFieldData.options.dateSelect3" active-text="Include time"></el-switch>
                            </el-row>
                            <el-row class="tw-m-4">
                                <el-switch @change="toggleRangeMenu" v-model="inputFieldData.options.dateSelect4" active-text="Date Range"></el-switch>
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
            inputFieldData: []
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    created() {
        this.inputFieldData = _.clone(this.fieldData)
    },
    mounted() {
        this.togglePastOnly(),
        this.toggleQuickMenu(),
        this.toggleTime(),
        this.toggleRangeMenu()
    },
    methods: {
        togglePastOnly() {
            if(this.inputFieldData.options.dateSelect1 === true) {
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
        toggleQuickMenu() {
            if(this.inputFieldData.options.dateSelect2 === true) {
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
                this.dateOptions.Object.assign({}, this.dateOptions, {
                    shortcuts: {}
                });
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            }
        },
        toggleTime() {
            if(this.inputFieldData.options.dateSelect3 === true) {
                this.dateType = "datetime",
                this.datePlaceHolder = "Pick a day and time"
                this.dateFormat = "yyyy/MM/dd hh:mm:ss a"
            } else {
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            }
            
        },
        toggleRangeMenu() {
            if(this.inputFieldData.options.dateSelect4 === true){
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
