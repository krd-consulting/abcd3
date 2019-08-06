<template>
    <div id="datepicker">

        <slot></slot>
        
            <el-col :span="10" class="tw-mb-2">
                <label class="inputLabel">
                    <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                        {{ fieldLabel }}
                    </editable-text>
                </label>
                <el-date-picker 
                    id="dateField" 
                    :type="dateType" 
                    :picker-options="dateOptions" 
                    :placeholder="datePlaceHolder"
                    :range-separator="rangeSeparator"
                    :start-placeholder="startDate"
                    :end-placeholder="endDate"
                    :settings="dateFormat">
                </el-date-picker>
            </el-col>
            
        
            <el-switch 
                v-model="field.settings.required" 
                active-text="Required" 
                inactive-text="Optional"
                class="tw-float-right switch-position">
            </el-switch>     
        
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data: () => {
        return {
            dateSelection: '',
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
    mounted() {
        this.togglePastOnly(),
        this.toggleFutureOnly(),
        this.toggleQuickMenu(),
        this.toggleTime(),
        this.toggleRange()
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
        dateType: {
            get() { return this.field.settings.dateType; },
            set(dateType) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.settings.dateType = dateType;
                this.field = fieldCopy;
            }
        },
        dateOptions: {
            get() { return this.field.settings.dateOptions; },
            set(dateOptions) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.settings.dateOptions = dateOptions;
                this.field = fieldCopy;
            }
        },
        datePlaceHolder: {
            get() { return this.field.settings.datePlaceHolder; },
            set(datePlaceHolder) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.settings.datePlaceHolder = datePlaceHolder;
                this.field = fieldCopy;
            }
        },
        dateFormat: {
            get() { return this.field.settings.dateFormat; },
            set(dateFormat) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.settings.dateFormat = dateFormat;
                this.field = fieldCopy;
            }
        },
        rangeSeparator: {
            get() { return this.field.settings.rangeSeparator; },
            set(rangeSeparator) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.settings.rangeSeparator = rangeSeparator;
                this.field = fieldCopy;
            }
        },

    },
    
    methods: {
        togglePastOnly() {
            if(this.field.settings.pastOnly === true) {
                this.dateOptions = Object.assign({}, this.dateOptions, {
                    disabledDate(time) { 
                        return time.getTime() > Date.now() 
                    },
                });
                this.dateType = "date"
                this.datePlaceHolder = "Pick a day"
                this.$store.commit('UPDATE_FIELD', this.field)
            }
        },
        toggleFutureOnly() {
            if(this.field.settings.futureOnly === true) {
                this.dateOptions = Object.assign({}, this.dateOptions, {
                    disabledDate(time) { 
                        return time.getTime() < Date.now() 
                    },
                });
                this.dateType = "date",
                this.datePlaceHolder = "Pick a day"
                this.$store.commit('UPDATE_FIELD', this.field)
            }
        },
        toggleQuickMenu() {
            if(this.field.settings.quickMenu === true) {
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
                this.$store.commit('UPDATE_FIELD', this.field)
            }
        },
        toggleTime() {
            if(this.field.settings.includeTime === true) {
                this.dateType = "datetime",
                this.datePlaceHolder = "Pick a day and time"
                this.dateFormat = "yyyy/MM/dd hh:mm:ss a"
                this.$store.commit('UPDATE_FIELD', this.field)
            } 
            
        },
        toggleRange() {
            if(this.field.settings.dateRange === true){
                this.dateType = 'daterange',
                this.rangeSeparator = 'to',
                this.dateFormat = "yyyy/MM/dd",
                this.startDate = 'Start date',
                this.endDate = 'End date'
                this.$store.commit('UPDATE_FIELD', this.field)
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
.switch-position {
    position: absolute;
    bottom: 20px;;
    right: 10px;
}
</style>
