<template>
    <div id="datepicker">
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
            <slot></slot>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

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
        fieldLabel: {
            get() { return this.field.label; },
            set(label) { 
                console.log('field label edited');

                const fieldCopy = _.clone(this.field);

                fieldCopy.label = label;

                this.field = fieldCopy;
            }
        },

        field: {
            get() { return this.fieldData; },
            set(field) { 
                console.log('field edited');
                this.$emit('update', field); 
            }
        },
        // handlePastFutureToggle() {
        //     if(this.field.settings.past_only === true){
        //         this.field.settings.future_only === false
        //     }
        //     if(this.field.settings.future_only === true) {
        //         this.field.settings.past_only === false
        //     }
        // }
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
</style>
