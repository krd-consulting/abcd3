<template>
    <div id="preview">
        <el-container>

            <el-card id="preview-form" class="sm:tw-w-11/12 tw-w-5/6 xl:tw-w-5/12" shadow="always">
                <el-menu :default-active="$route.path" 
                    class="w-full" 
                    background-color="#fff" 
                    active-text-color="#409EFF" 
                    mode="horizontal" 
                    router>
                        <el-menu-item default-active 
                            index="/forms/create" 
                            class="tw-font-bold focus:tw-font-extrabold">
                                Form Builder
                        </el-menu-item>
                        <el-menu-item index="/forms/create/preview" 
                            class="tw-font-bold focus:tw-font-extrabold">
                                Preview Form
                        </el-menu-item>
                        <el-menu-item
                            class="float-right tw-font-bold focus:font-extrabold" 
                            @click="buildForm">
                                Finish and Build!
                        </el-menu-item>
                </el-menu>

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

                        <el-row class="tw-my-4" >
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

            </el-card>

        </el-container>
    </div>
</template>

<script>
import test from '@/FormBuilder/store/test.json'

import MatrixField from '@/FormBuilder/components/preview/matrix.vue'
import RadioField from '@/FormBuilder/components/preview/radio.vue'
import TextField from '@/FormBuilder/components/preview/textField.vue'
import TextBox from '@/FormBuilder/components/preview/textBox.vue'
import NumberField from '@/FormBuilder/components/preview/numeric.vue'
import DropdownField from '@/FormBuilder/components/preview/dropdown.vue'
import CheckBoxField from '@/FormBuilder/components/preview/checkbox.vue'
import DateField from '@/FormBuilder/components/preview/datePicker.vue'
import TimeField from '@/FormBuilder/components/preview/timePicker.vue'
import FileField from '@/FormBuilder/components/preview/upload.vue'
import SectionDivider from '@/FormBuilder/components/preview/sectionDivider.vue'

import { mapState } from 'vuex'
// import { store } from '@/FormBuilder/store/state.js';


export default {
    data: () => {
        return {
            // formData: store.state,
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
        SectionDivider
    },
    computed: {
        ...mapState ([
            'title', 'description', 'target', 'fields'
        ])
    },
    methods: {
        buildForm() {
            this.$confirm('Are you sure you are ready to build this form?', 'Confirm', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'info'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: 'Build Successful'
                });
                alert('One day, this form will persist to the database. but alas, tis not this day.')
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: "Keep doing what you're are doing"
                });          
            });
        },
        // getFormData() {
        //     return this.$store.state
        // }
    }
}
</script>

<style scoped>
#preview {
        display: flex;
        position: absolute;
        top: 50;
        left: 0;
        min-height: 85%;
        width: 100%;
}
#preview-form {
    margin: 0 auto;
    width: 1000px;
}
.float-right {
        float: right !important;
    }

@media (min-width: 768px){
    
}
 
@media (min-width: 1024px){

    
}
 
@media (min-width: 1200px){

 
}
</style>
