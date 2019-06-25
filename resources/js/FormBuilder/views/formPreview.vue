<template>
    <div id="preview">
        <el-container>

            <el-card id="preview-form" class="sm:tw-w-11/12 tw-w-5/6 xl:tw-w-5/12" shadow="always">
                <el-menu :default-active="$route.path" 
                    class="w-full" 
                    background-color="#fff" 
                    active-text-color="#409EFF" 
                    mode="horizontal" 
                    @select="handleSelect" router>
                        <el-menu-item default-active 
                            index="/forms/create" 
                            class="tw-font-bold focus:tw-font-extrabold">
                                Form Builder
                        </el-menu-item>
                        <el-menu-item index="/forms/create/preview" 
                            class="tw-font-bold focus:tw-font-extrabold">
                                Preview Form
                        </el-menu-item>
                        <el-menu-item index="/forms" 
                            class="tw-float-right tw-font-bold focus:font-extrabold" 
                            @click="buildForm">
                                Finish and Build!
                        </el-menu-item>
                </el-menu>

                <div v-for="data in formData" :key="data.title">
                    <el-header class="tw-text-center tw-mb-12">
                        <h1 class="tw-text-4xl">{{ data.title }}</h1>
                        <p>{{ data.description }}</p>
                        <el-divider></el-divider>
                    </el-header>
                    
                    <el-main>
                        <el-row :gutter="10" class="tw-mb-4">
                            <el-col :span="10">
                                <span class="input-label">{{ data.targetType }} Name</span>
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
                        
                        <div class="tw-mt-4" v-for="field in data.fields" :key="field.fieldType">

                            <div class="tw-my-8">
                                <component
                                    :field="field"
                                    :is="field.fieldType">
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
import NumericField from '@/FormBuilder/components/preview/numeric.vue'
import Dropdown from '@/FormBuilder/components/preview/dropdown.vue'
import Checkbox from '@/FormBuilder/components/preview/checkbox.vue'

export default {
    data: () => {
        return {
            formData: test,
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
        NumericField,
        Dropdown,
        Checkbox
    },
    created() {
        // this.getFormData();
    },
    methods: {
        handleSelect(key, keyPath) {
            console.log(key, keyPath);
        },
        buildForm() {
            alert('One day, this form will persist to the database. but alas, tis not this day.')
        }
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
