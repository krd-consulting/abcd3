<template>
    <div id="canvas">
        <el-container>
            <el-main>
                <el-card body-style="padding: 10px;" shadow="hover" >
                    <el-header class="tw-text-center tw-mb-12">
                        <h1 class="tw-text-4xl">
                            <editable-text class="tw-cursor-pointer" 
                                @input="showField" 
                                v-model="title">
                                    {{ title }}
                            </editable-text>
                        </h1>

                        <editable-text v-if="description" class="tw-cursor-pointer" 
                            @input="showField" 
                            v-model="description">
                                {{ description }}
                        </editable-text>

                        <div v-if="!description">
                            <el-input v-model="description" placeholder="This field is for subtext"></el-input>
                        </div>
                    </el-header>

                <el-divider></el-divider>
                        
                    <el-row :gutter="10">
                        <el-col :span="10">
                            <span class="input-label">Client Name</span>
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
                <el-divider></el-divider>

                <el-divider content-position="left"><span>Your Content</span></el-divider>

                    <draggable class="dropArea" v-model="form">
                        <div v-for="(inputType, index) in formList" :key="index">
                            <el-row type="flex" :gutter="2">
                            <el-col class="float-left" :span="24">
                                <el-card class="cursor-move" body-style="padding: 10px;" shadow="hover">

                                    <component :is="inputType.input.component" 
                                        :fieldData="inputType.fieldData">
                                    </component>
                                    
                                </el-card>
                            </el-col>
                        </el-row>
                    </div>
                </draggable>
                <el-divider></el-divider>
            </el-card>
            </el-main>
        </el-container>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import SidePanel from '@/components/sidePanel.vue'
import ClickOutside from 'vue-click-outside'
import EditableText from '@/components/editableText.vue'

import TextField from '@/FormBuilder/components/canvas/fields/textField.vue'
import TextBox from '@/FormBuilder/components/canvas/fields/textArea.vue'
import CheckboxField from '@/FormBuilder/components/canvas/fields/checkboxField.vue'
import DropdownField from '@/FormBuilder/components/canvas/fields/dropdownField.vue'
import NumericField from '@/FormBuilder/components/canvas/fields/numericField.vue'
import RadioField from '@/FormBuilder/components/canvas/fields/radioField.vue'
import DateField from '@/FormBuilder/components/canvas/fields/dateField.vue'
import MatrixField from '@/FormBuilder/components/canvas/fields/matrixField.vue'
import TimePicker from '@/FormBuilder/components/canvas/fields/timePicker.vue'
import FileUpload from '@/FormBuilder/components/canvas/fields/fileUpload.vue'
import SectionDivider from '@/FormBuilder/components/canvas/fields/SectionDivider.vue'

import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'

export default {
    data: () => {
        return {
            // title: 'Your Form Title',
            // description: 'Subtext',
            visible: false,
            clientName: '',
            dateCompleted: '',
            formList: [],
            // form: [],
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                },
                shortcuts: [{
                    text: 'Today',
                    onClick(picker) {
                    picker.$emit('pick', new Date());
                    }
                }, {
                    text: 'Yesterday',
                    onClick(picker) {
                    const date = new Date();
                    date.setTime(date.getTime() - 3600 * 1000 * 24);
                    picker.$emit('pick', date);
                    }
                }, {
                    text: 'A week ago',
                    onClick(picker) {
                    const date = new Date();
                    date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                    picker.$emit('pick', date);
                    }
                }],
            },
            teams: [ // TODO: replace with data pulled from backend
                { value: 'Counselling', label: 'Counselling'},
                { value: 'Community Programs', label: 'Community Programs'}
            ],
            inputType: {},
            inputFieldData: {},
        }
    },
    props: {
        newInput: Function,
        fields: {
            type: Array,
            default: []
        },
        fieldData: Function
    },
    components: {
        draggable,
        SidePanel,
        EditableText,
        TextField,
        TextBox,
        SectionDivider,
        NumericField,
        CheckboxField,
        DropdownField,
        RadioField,
        DateField,
        MatrixField,
        TimePicker,
        FileUpload,
    },
    computed: {
        ...mapState ([
            'title',
            'description',
            'form'
        ]),
        ...mapMutations ([
            'SET_TITLE',
            'SET_DESCRIPTION',
            'ADD_FIELD'
        ]),
        title: {
            get() { return this.$store.state.title },
            set(title) { this.$store.commit('SET_TITLE', title) }, 
        },
        description: {
            get() { return this.$store.state.description },
            set(description) { this.$store.commit('SET_DESCRIPTION', description) }
        },
        form: {
            get() { return this.$store.state.form },
            set(input) { this.$store.commit('ADD_FIELD', input) }
        }
    },
    methods: {
        removeItem(index) {
            this.$confirm('are you sure you want to remove this field from your form?', 'Warning', {
                confirmButtonText: 'Remove',
                cancelButtonText: 'Nevermind',
                type: 'warning'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: 'Field Successfully Removed'
                })
                this.fields.splice(index, 1);
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: "Alright, we'll keep it"
                })
            })
        },
        showField(value){
            return (this.value == '' || this.editField == value)
        }
    },
    watch: {
        newInput() {
            this.form.push(this.input.id)
        },
        fields() {
            this.formList = _.clone(this.fields);
            // this.inputFieldData = _.clone(this.fieldData)
        }
    }
}
</script>

<style scoped>
#canvas {
    font-family: 'Inter UI', Arial, sans-serif;
    /* font-weight: bold; */
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
}
.el-row {
    margin: 5px;
  }
  .el-col {
    border-radius: 4px;
    min-width: 300px;
    margin-top: 15px;
  }
  .el-input {
      font-size: 18px;
  }
  .el-divider span {
      font-size: 18px;
  }
  .canvas-card {
      font-size: 110%;
  }
</style>
