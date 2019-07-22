<template>
    <div id="datepicker">
        
            <el-col :span="10">
                <label class="inputLabel">
                    <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                        {{ fieldLabel }}
                    </editable-text>
                </label>
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
            </el-col>
            
        
            <el-switch 
                v-model="field.settings.required" 
                active-text="Required" 
                inactive-text="Optional"
                class="tw-float-right tw-mr-48 button-top">
            </el-switch>
            
            <el-col>
                <slot></slot>
            </el-col>
        
        
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data: () => {
        return {
            dateSelection: '',
            // dateType: 'date',
            // dateOptions: {},
            // datePlaceHolder: 'Pick a day',
            // dateFormat: 'yyyy/MM/dd',
            // rangeSeparator: '',
            startDate: '',
            endDate: '',
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    components: {
        EditableText
    },
    // created() {
    //     this.field = _.clone(this.fieldData)
    // },
    mounted() {
        this.togglePastOnly(),
        this.toggleFutureOnly(),
        this.toggleQuickMenu(),
        this.toggleTime(),
        this.toggleRangeMenu()
    },
    computed: {
        field: {
            get() { return this.fieldData; },
            set(field) { this.$emit('update', field); }
        },

        fieldLabel: {
            get() { return this.field.title; },
            set(title) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.title = title;
                this.field = fieldCopy;
            }
        },

        // dateSelection: {
        //     get() { return this.field.format.dateSelection; },
        //     set(dateSelection) { 
        //         const fieldCopy = _.clone(this.field);
        //         fieldCopy.format.dateSelection = dateSelection;
        //         this.field = fieldCopy;
        //     }
        // },
        dateType: {
            get() { return this.field.format.dateType; },
            set(dateType) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.format.dateType = dateType;
                this.field = fieldCopy;
            }
        },
        dateOptions: {
            get() { return this.field.format.dateOptions; },
            set(dateOptions) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.format.dateOptions = dateOptions;
                this.field = fieldCopy;
            }
        },
        datePlaceHolder: {
            get() { return this.field.format.datePlaceHolder; },
            set(datePlaceHolder) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.format.datePlaceHolder = datePlaceHolder;
                this.field = fieldCopy;
            }
        },
        dateFormat: {
            get() { return this.field.format.dateFormat; },
            set(dateFormat) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.format.dateFormat = dateFormat;
                this.field = fieldCopy;
            }
        },
        rangeSeparator: {
            get() { return this.field.format.rangeSeparator; },
            set(rangeSeparator) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.format.rangeSeparator = rangeSeparator;
                this.field = fieldCopy;
            }
        },
        // startDate: {
        //     get() { return this.field.format.startDate; },
        //     set(startDate) { 
        //         const fieldCopy = _.clone(this.field);
        //         fieldCopy.format.startDate = startDate;
        //         this.field = fieldCopy;
        //     }
        // },
        // endDate: {
        //     get() { return this.field.format.endDate; },
        //     set(endDate) { 
        //         const fieldCopy = _.clone(this.field);
        //         fieldCopy.format.endDate = endDate;
        //         this.field = fieldCopy;
        //     }
        // },

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

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
.button-top {
    position: absolute;
    top: 30px;;
    right: 10px;
}
</style>
