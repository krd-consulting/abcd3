<template>
    <div id="datepciker">
        <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
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

                    <!-- <div v-if="myOptions.dateSelect === 'Extended Time'">
                        <el-date-picker 
                            v-model="dateSelection" 
                            :type="dateType" 
                            :picker-options="dateOptions" 
                            :placeholder="datePlaceHolder"
                            :format="dateFormat">
                        </el-date-picker>
                    </div>
                    <div v-if="myOptions.dateSelect === 'Range'">
                        <span>DERP</span>
                    </div> -->

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
                        <el-form-item label="Select By">
                            <el-radio-group v-model="myOptions.dateSelect" size="medium">
                                <el-radio-button label="Day" ></el-radio-button>
                                <el-radio-button label="Extended Time"></el-radio-button>
                                <el-radio-button label="Range"></el-radio-button>
                            </el-radio-group>
                            <div v-if="myOptions.dateSelect === 'Day'">
                                <span>Calendar Preferences</span><br>
                                <el-row>
                                    <el-switch @change="togglePastOnly" v-model="myOptions.dateSelect1" active-text="Only allow up to current day"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch @change="toggleQuickMenu" v-model="myOptions.dateSelect2" active-text="Quick menu"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch @change="toggleTime" v-model="myOptions.dateSelect3" active-text="Include time"></el-switch>
                                </el-row>
                            </div>
                            <div v-if="myOptions.dateSelect === 'Extended Time'">
                                <el-row>
                                    <el-switch 
                                        @change="toggleMonthYear"
                                        v-model="myOptions.dateSelect4" 
                                        active-text="Year" 
                                        inactive-text="Month" 
                                        active-color="#409EFF"
                                        inactive-color="#409EFF">
                                    </el-switch>
                                </el-row>
                            </div>
                            <div v-if="myOptions.dateSelect === 'Range'">
                                <el-row>
                                    <el-switch @change="toggleRangeMenu" v-model="myOptions.dateSelect5" active-text="Quick Menu"></el-switch>
                                </el-row>
                            </div>
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
        this.toggleMonthYear(),
        this.togglePastOnly(),
        this.toggleQuickMenu(),
        this.toggleTime()
    },
    created() {
        this.myOptions = _.clone(this.options)
    },
    methods: {
        togglePastOnly() {
            if(this.myOptions.dateSelect === 'Day' && this.myOptions.dateSelect1 === true) {
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
                this.dateOptions = Object.assign({}, this.dateOptions, {
                    quickMenu: {}
                });
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            }
        },
        toggleTime() {
            if(this.myOptions.dateSelect === 'Day' && this.myOptions.dateSelect3 === true) {
                this.dateType = "datetime",
                this.datePlaceHolder = "Pick a day and time"
                this.dateFormat = "yyyy/MM/dd hh:mm:ss a"
            } else {
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
            }
            
        },
        toggleMonthYear() {
            if(this.myOptions.dateSelect === 'Extended Time' && this.myOptions.dateSelect4 === true) {
                this.dateType = "year",
                this.datePlaceHolder = "Pick a year"
            } else if(this.myOptions.dateSelect4 === false) {
                this.dateType = "month",
                this.datePlaceHolder = "Pick a month"
            }
        },
        toggleRangeMenu() {
            if(this.myOptions.dateSelect === 'Range' && this.myOptions.dateSelect5 === true){
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
                this.dateType = 'daterange',
                this.rangeSeparator = 'to',
                this.startDate = 'Start date',
                this.endDate = 'End date'
            } else if(this.myOptions.dateSelect === 'Range' && this.myOptions.dateSelect5 === false) {
                this.dateType = 'daterange',
                this.rangeSeparator = 'to',
                this.startDate = 'Start date',
                this.endDate = 'End date'
            }
        }
    }
}
</script>

<style>

</style>
