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
                            class="tw-float-right tw-font-bold focus:font-extrabold" 
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
                        <el-row :gutter="20" class="tw-mb-4">
                            <el-col :span="2">
                                <span class="input-label">  Name</span>
                                {{ target.type }}
                            </el-col>  
                            <el-col :span="10">
                                <el-input class="inputField" v-model="clientName"></el-input>
                            </el-col>
                            
                            <el-col :span="6">
                                <span class="input-label">Team</span><br>
                                <el-select value="" placeholder="Select">
                                    <el-option v-for="team in teams" :key="team.value"
                                    :label="team.label" :value="team.value">
                                    </el-option>
                                </el-select>
                            </el-col>
                        </el-row>

                        <el-row :guttter="10">
                            <el-col :span="6">
                                <span class="input-label">Date Completed</span><br>
                                <el-date-picker v-model="dateCompleted" type="date" placeholder="Pick a day" :picker-options="pickerOptions">
                                </el-date-picker>
                            </el-col>
                        </el-row>
                        
                        <div class="tw-mt-4" v-for="field in fields" :key="field.type">

                            <div class="tw-my-8">
                                <component
                                    :field="field"
                                    :is="field.type">
                                </component>
                            </div>
                        </div>
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

import Matrix from '@/FormBuilder/components/preview/matrix.vue'
import Radio from '@/FormBuilder/components/preview/radio.vue'
import TextField from '@/FormBuilder/components/preview/textField.vue'
import TextBox from '@/FormBuilder/components/preview/textBox.vue'
import Numeric from '@/FormBuilder/components/preview/numeric.vue'
import Dropdown from '@/FormBuilder/components/preview/dropdown.vue'
import CheckBox from '@/FormBuilder/components/preview/checkbox.vue'
import DatePicker from '@/FormBuilder/components/preview/datePicker.vue'
import TimePicker from '@/FormBuilder/components/preview/timePicker.vue'
import Upload from '@/FormBuilder/components/preview/upload.vue'
import SectionDivider from '@/FormBuilder/components/preview/sectionDivider.vue'

import { mapGetters } from 'vuex'
// import { store } from '@/FormBuilder/store/state.js';


export default {
    data: () => {
        return {
            // formData: store.state,
            clientName: '',
            teams: [],
            dateCompleted: '',
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                }
            }
        }
    },
    components: {
        Matrix,
        Radio,
        TextField,
        TextBox,
        Numeric,
        Dropdown,
        CheckBox,
        DatePicker,
        TimePicker,
        Upload,
        SectionDivider
    },
    computed: {
        title: {
            get() { return this.$store.state.title },
            set(title) { this.$store.commit('SET_TITLE', title) }, 
        },
        target: {
            get() { return this.$store.state.target },
            set(target) { this.$store.commit('SET_TARGET', target) }, 
        },
        description: {
            get() { return this.$store.state.description },
            set(description) { this.$store.commit('SET_DESCRIPTION', description) }
        },
        fields: { 
            get() { return this.$store.state.fields },
            set(fields) { this.$store.commit('SET_FIELDS', fields); }
        },
    },
    watch: {
        // formData: {
        //     handler() {
        //         this.state_fields = this.formData
        //     },
        //     deep: true
        // }
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
</style>
