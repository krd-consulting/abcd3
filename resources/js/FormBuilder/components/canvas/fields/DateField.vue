<template>
    <div id="datepciker">
        <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
            <el-collapse-item name="1">
                <template slot="title">
                    <el-date-picker v-if="value === 0" 
                        v-model="dateSelection" 
                        type="date" 
                        placeholder="Pick a day">
                    </el-date-picker>
                    <el-date-picker v-if="value === 1" 
                        v-model="dateSelection" 
                        type="date" 
                        placeholder="Pick a day" 
                        :picker-options="pastOptions">
                    </el-date-picker>
                    <el-date-picker v-if="value === 2" 
                        v-model="dateSelection" type="daterange"
                        range-separator="To"
                        start-placeholder="Start date"
                        end-placeholder="End date">
                    </el-date-picker>
                </template>
                <div>
                    <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                        <el-form-item label="Field Label">
                            <el-input v-model="options.title"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-form-item>
                        <el-form-item label="Type of Date Picker">
                            <el-select v-model="value" placeholder="Select">
                                <el-option v-for="item in dateType" :key="item.value" :label="item.label" :value="item.value"></el-option>
                            </el-select>
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
            // options: {
            //     title: 'Date Function',
            //     required: false,
            //     reference: '',
            //     setLength: 50,
            //     dropdownItems: {
            //     domains: [{
            //             key:1,
            //             value:''
            //         }]
            //     }
            // },
            dateType: [
                {value: 0, label: 'No Restrictions', rules: 'none'},
                {value: 1, label: 'Select Past only', rules: 'pastOptions'},
                {value: 2, label: 'Select Rate Range', rules: 'rangeOptions'},
            ],
            value: 0,
            pastOptions: {
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
