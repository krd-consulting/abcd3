<template>
    <div id="datepciker">
        <el-collapse>
            <span class="inputLabel">{{ myOptions.title }}</span><br>
            <el-collapse-item name="1">
                <template slot="title">
                    <div>
                        <el-date-picker 
                            v-model="dateSelection" 
                            :type="dateType" 
                            :picker-options="dateOptions" 
                            :placeholder="datePlaceHolder"
                            :range-separator="rangeSeparator"
                            :start-placeholder="startDate"
                            :end-placeholder="endDate"
                            :format="dateFormat">
                        </el-date-picker>
                    </div>

                </template>
                <div>
                    <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                        <el-form-item label="Field Label">
                            <el-col :span="6">
                                <el-input v-model="options.title"></el-input>
                            </el-col>
                        </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-form-item>
                        <el-form-item label="Calendar Preferences">
                                <el-row>
                                    <el-switch @change="togglePastOnly" v-model="myOptions.dateSelect1" active-text="Only allow up to current day"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch @change="toggleQuickMenu" v-model="myOptions.dateSelect2" active-text="Include Quick menu"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch @change="toggleTime" v-model="myOptions.dateSelect3" active-text="Include time"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch @change="toggleRangeMenu" v-model="myOptions.dateSelect4" active-text="Date Range"></el-switch>
                                </el-row>
                        </el-form-item>
                    </el-form>
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
            myOptions: []
        }
    },
    props: {
        options: {
            type: Array | Object,
            default: {}
        }
    },
    mounted() {
        this.togglePastOnly(),
        this.toggleQuickMenu(),
        this.toggleTime(),
        this.toggleRangeMenu()
    },
    created() {
        this.myOptions = _.clone(this.options)
    },
    methods: {
        togglePastOnly() {
            if(this.myOptions.dateSelect1 === true) {
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
            if(this.myOptions.dateSelect2 === true) {
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
            if(this.myOptions.dateSelect3 === true) {
                this.dateType = "datetime",
                this.datePlaceHolder = "Pick a day and time"
                this.dateFormat = "yyyy/MM/dd hh:mm:ss a"
            } else {
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            }
            
        },
        toggleRangeMenu() {
            if(this.myOptions.dateSelect4 === true){
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
