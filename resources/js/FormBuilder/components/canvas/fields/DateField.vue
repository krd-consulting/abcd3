<template>
    <div id="datepciker">
        <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
            <el-collapse-item name="1">
                <template slot="title">
                    <el-date-picker v-if="!options.daySelect1 && !options.daySelect2 && !options.daySelect3" 
                        v-model="dateSelection" 
                        type="date" 
                        placeholder="Pick a day">
                    </el-date-picker>
                    <el-date-picker v-if="options.daySelect1 && !options.daySelect2 && !options.daySelect3" 
                        v-model="dateSelection" 
                        type="date" 
                        placeholder="Pick a day" 
                        :picker-options="pastOnly">
                    </el-date-picker>
                    <el-date-picker v-if="options.daySelect2 && !options.daySelect1 && !options.daySelect3" 
                        v-model="dateSelection" 
                        type="date" 
                        placeholder="Pick a day" 
                        :picker-options="shortcutOnly">
                    </el-date-picker>
                    <el-date-picker v-if="options.daySelect2 && options.daySelect1 && !options.daySelect3" 
                        v-model="dateSelection" 
                        type="date" 
                        placeholder="Pick a day" 
                        :picker-options="shortcutOnly">
                    </el-date-picker>
                    <!-- <el-date-picker v-if="value === 2" 
                        v-model="dateSelection" type="daterange"
                        range-separator="To"
                        start-placeholder="Start date"
                        end-placeholder="End date">
                    </el-date-picker> -->
                </template>
                <div>
                    <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                        <el-form-item label="Field Label">
                            <el-input v-model="options.title"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-form-item>
                        <el-form-item label="Select By">
                            <el-radio-group v-model="options.dateType" size="medium">
                                <el-radio-button label="day" ></el-radio-button>
                                <el-radio-button label="week"></el-radio-button>
                                <el-radio-button label="month"></el-radio-button>
                            </el-radio-group>
                            <div v-if="options.dateType === 'day'">
                                <span>Calendar Preferences</span><br>
                                <el-row>
                                    <el-switch v-model="options.daySelect1" inactive-text="No restriction" active-text="Only past dates"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch v-model="options.daySelect2" inactive-text="No Quick menu" active-text="Quick menu"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch v-model="options.daySelect3" inactive-text="No time" active-text="Include time"></el-switch>
                                </el-row>
                            </div>
                            <div v-if="options.dateType === 'week'">
                                <p>heeeyy</p>
                            </div>
                            <div v-if="options.dateType === 'month'">
                                <p>eeyyoooo</p>
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
            dateLabel: '',
            dateSelection: '',
            value: 0,
            pastOnly: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                }
            },
            shortcutOnly: {
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
            },
            pastWithShortcut: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                },
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
            }
        }
    },
    props: {
        options: {
            type: Array | Object,
            default: {
                title: 'Text Area',
                required: false,
                reference: '',
                dropdownNum: 2,
                radioNum: 2,
                checkboxNum: 2,
                matrixQuestions: 2,
                matrixChoices: 5,
                setLength: 50,
                dropdownItems: {
                    domains: [{
                        key:1,
                        value:''
                    }]
                }
                // title: 'Text Field',
                // isRequired: false,
                // reference: '',
                // charCount: 50,
                // dropdownItems: {
                //         domains: [{
                //         key:1,
                //         value:''
                //     }]
                // }
            }
        }
    },
}
</script>

<style>

</style>
