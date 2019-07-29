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
                    <label for="name" class="input-label tw-mt-4"> {{ target.name }} Name</label>
                </el-col>  
                <el-col :span="8">
                    <el-input id="name" class="inputField" v-model="inputName"></el-input>
                </el-col>
            </el-row>
                
            <el-row class="tw-my-4">
                <el-col :span="6">
                    <label for="teamSelect" class="input-label">Team</label>
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
                    <label for="pre-post" class="input-label">Completed for</label>
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
                    <label for="formDate" class="input-label">Date Completed</label>
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
import MatrixField from '@/FormBuilder/components/preview/fields/matrix.vue'
import RadioField from '@/FormBuilder/components/preview/fields/radio.vue'
import TextField from '@/FormBuilder/components/preview/fields/textField.vue'
import TextBox from '@/FormBuilder/components/preview/fields/textBox.vue'
import NumberField from '@/FormBuilder/components/preview/fields/numeric.vue'
import DropdownField from '@/FormBuilder/components/preview/fields/dropdown.vue'
import CheckBoxField from '@/FormBuilder/components/preview/fields/checkbox.vue'
import DateField from '@/FormBuilder/components/preview/fields/datePicker.vue'
import TimeField from '@/FormBuilder/components/preview/fields/timePicker.vue'
import FileField from '@/FormBuilder/components/preview/fields/upload.vue'
import SectionDivider from '@/FormBuilder/components/preview/fields/sectionDivider.vue'

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
