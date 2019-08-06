<template>
    <div>
        <el-header class="tw-text-center tw-mb-12">
            <h1 class="tw-text-4xl">{{ title }}</h1>
            <p>{{ description }}</p>
            <el-divider></el-divider>
        </el-header>
        
        <el-main>
            <el-row class="tw-mb-4">
                <el-col :span="6">
                    <label for="name" class="tw-block tw-text-right tw-mr-1"> {{ target.name }} Name</label>
                </el-col>  
                <el-col :span="8">
                    <el-input id="name" class="inputField" v-model="inputName"></el-input>
                </el-col>
            </el-row>
                
            <el-row class="tw-my-4">
                <el-col :span="6">
                    <label for="teamSelect" class="tw-block tw-text-right tw-mr-1">Team</label>
                </el-col>
                <el-col :span="6">
                    <el-select value="" placeholder="Select">
                        <el-option v-for="team in teams" :key="team.value"
                        :label="team.label" :value="team.value">
                        </el-option>
                    </el-select>
                </el-col>
            </el-row>

            <el-row class="tw-my-4" v-if="type === 'pre-post'">
                <el-col :span="6">
                    <label for="pre-post" class="tw-block tw-text-right tw-mr-1">Completed for</label>
                </el-col>
                <el-col :span="6">
                    <el-select id="pre-post" v-model="value" placeholder="Select">
                        <el-option v-for="select in prePost" 
                            :key="select.value"
                            :label="select.value" 
                            :value="select.value">
                        </el-option>
                    </el-select>
                </el-col>
            </el-row>

            <el-row class="tw-my-4">
                <el-col :span="6">
                    <label for="formDate" class="tw-block tw-text-right tw-mr-1">Date Completed</label>
                </el-col>
                <el-col :span="8">
                    <el-date-picker 
                        id="formDate" 
                        v-model="dateCompleted" 
                        type="date" 
                        placeholder="Pick a day" 
                        :picker-options="pickerOptions">
                    </el-date-picker>
                </el-col>
                
            </el-row>
            
            <div class="tw-mt-4" v-for="field in fields" :key="field.type">

                <component
                    class="tw-my-8"
                    :field="field"
                    :is="field.type">
                </component>
                
            </div>

            <br>
            <br>

                <div class="tw-relative tw-text-center tw-mt-12">
                    <el-button type="primary" class="tw-w-48">Submit</el-button>
                </div>
        </el-main>
    </div>
</template>

<script>
import MatrixField from '@/components/formFields/matrix.vue'
import RadioField from '@/components/formFields/radio.vue'
import TextField from '@/components/formFields/textField.vue'
import TextBox from '@/components/formFields/textBox.vue'
import NumberField from '@/components/formFields/numeric.vue'
import DropdownField from '@/components/formFields/dropdown.vue'
import CheckBoxField from '@/components/formFields/checkbox.vue'
import DateField from '@/components/formFields/datePicker.vue'
import TimeField from '@/components/formFields/timePicker.vue'
import FileField from '@/components/formFields/upload.vue'
import SectionDivider from '@/components/formFields/sectionDivider.vue'

import { mapState } from 'vuex'

export default {
    data: () => {
        return {
            value: '',
            inputName: '',
            teams: [],
            dateCompleted: '',
            prePost: [
                {id: 0, value: 'Pre-test'},
                {id: 1, value: 'Intermittent'},
                {id: 2, value: 'Post-test'},
            ],
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                }
            }
        }
    },

    components: {
        MatrixField,
        RadioField,
        TextField,
        TextBox,
        NumberField,
        DropdownField,
        CheckBoxField,
        DateField,
        TimeField,
        FileField,
        SectionDivider,
    },

    computed: {
        ...mapState ([
            'title', 'description', 'target', 'type', 'fields'
        ])
    },
}
</script>

<style>

</style>
