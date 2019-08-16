<template>
    <div id="canvas">
        <el-container>
            <el-main>
                <el-card body-style="padding: 10px;" shadow="hover" >

                    <el-header class="tw-text-center">
                        <h1 class="tw-text-4xl">
                            <editable-text class="tw-cursor-pointer mouseOver tw-text-4xl" 
                                v-model="title">
                                    {{ title }}
                            </editable-text>
                        </h1>

                        <!-- <editable-text v-if="description" 
                            class="tw-cursor-pointer mouseOver tw-text-xs"  
                            v-model="description">
                                {{ description }}
                        </editable-text> -->

                        <!-- div v-if="!description">
                            <el-input v-model="description" placeholder="Please enter an optional description for this form"></el-input>
                        </div -->
                    </el-header>

                <!-- <el-divider></el-divider> -->
                    
                    <el-row class="tw-mb-4">
                        <el-col :span="8">
                            <label for="name" class="input-label tw-mt-4"> {{ targetName }} Name</label>
                        </el-col>  
                        <el-col :span="6">
                            <el-input id="name" class="inputField"></el-input>
                        </el-col>
                    </el-row>

                    <el-row class="tw-mb-4">    
                            <el-col :span="8">
                                <label class="input-label">Team</label>
                            </el-col>
                            <el-col :span="6">
                            <el-select value="" placeholder="Select">
                                <el-option v-for="team in teams" :key="team.value"
                                    :label="team.label" :value="team.value">
                                </el-option>
                            </el-select>
                        </el-col>
                    </el-row>

                    <el-row class="tw-mb-4" v-if="type === 'pre-post'">
                        <el-col :span="8">
                            <label class="input-label">Complete for</label>
                        </el-col>
                        <el-col :span="6">
                            <el-select id="pre-post" value="" placeholder="Select">
                                    <el-option v-for="select in prePost" 
                                        :key="select.value"
                                        :label="select.value" 
                                        :value="select.value">
                                    </el-option>
                                </el-select>
                        </el-col>
                    </el-row>

                    <el-row class="tw-mb-4">
                        <el-col :span="8">
                            <label class="input-label">Date Completed</label>
                        </el-col>
                        <el-col :span="6">
                            <el-date-picker 
                                v-model="dateCompleted" 
                                type="date" 
                                placeholder="" 
                                :picker-options="pickerOptions">
                            </el-date-picker>
                        </el-col>
                    </el-row>
                <!-- el-divider></el-divider -->

                <el-divider content-position="left"><span>Custom Fields</span></el-divider>

                    <draggable 
                        class="dropArea" 
                        v-model="fields"
                        handle=".handle">
                            <el-row v-for="(field, index) in fields" type="flex" :gutter="2" :key="index">
                            <el-col class="float-left" :span="24">
                                <el-card class="cursor-move tw-my-2" body-style="padding: 5px;" shadow="hover">
                                    <el-tooltip content="Change the order of your fields by clicking this button and dragging to a new position within your form">
                                        <el-button class="handle tw-float-left tw-top-0 tw-left-0 tw-mr-4" icon="el-icon-rank"></el-button>
                                    </el-tooltip>
                                <component 
                                    :is="field.type" 
                                    :fieldData="field"
                                    @update="updateField($event, index)">   
                                        <el-button
                                            @click="removeField(index)" 
                                            size="mini"
                                            class="tw-float-right tw-relative tw-top-0 tw-right-0 tw-p-2 tw-z-10 hover:tw-text-red-600">
                                            <base-icon>delete_forever</base-icon>
                                        </el-button>
                                </component>
                                    
                                </el-card>
                            </el-col>
                        </el-row>
                </draggable>

                <!-- el-divider></el-divider -->
                
            </el-card>
            </el-main>
        </el-container>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import ClickOutside from 'vue-click-outside'
import SidePanel from '@/components/sidePanel.vue'
import EditableText from '@/components/editableText.vue'

import Initialize from '@/FormBuilder/views/initialize'

import TextField from '@/FormBuilder/components/canvas/fields/textField.vue'
import TextBox from '@/FormBuilder/components/canvas/fields/textArea.vue'
import CheckBoxField from '@/FormBuilder/components/canvas/fields/checkbox.vue'
import DropdownField from '@/FormBuilder/components/canvas/fields/dropdown.vue'
import NumberField from '@/FormBuilder/components/canvas/fields/numeric.vue'
import RadioField from '@/FormBuilder/components/canvas/fields/radio.vue'
import DateField from '@/FormBuilder/components/canvas/fields/datePicker.vue'
import MatrixField from '@/FormBuilder/components/canvas/fields/matrix.vue'
import TimeField from '@/FormBuilder/components/canvas/fields/timePicker.vue'
import FileField from '@/FormBuilder/components/canvas/fields/fileUpload.vue'
import SectionDivider from '@/FormBuilder/components/canvas/fields/sectionDivider.vue'

export default {
    data: () => {
        return {
            initialize: {
                active: true
            },
            name: '',
            dateCompleted: '',
            formList: [],
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
            prePost: [
                {id: 0, value: 'Pre-test'},
                {id: 1, value: 'Intermittent'},
                {id: 2, value: 'Post-test'},
            ],
            inputType: {},
        }
    },
    props: {
        newInput: Function,
        // fields: {
        //     type: Array,
        //     default: []
        // },
    },
    components: {
        draggable,
        SidePanel,
        EditableText,
        TextField,
        TextBox,
        SectionDivider,
        NumberField,
        CheckBoxField,
        DropdownField,
        RadioField,
        DateField,
        MatrixField,
        TimeField,
        FileField,
    },
    computed: {
        title: {
            get() { return this.$store.state.title },
            set(title) { this.$store.commit('SET_TITLE', title) }, 
        },
        description: {
            get() { return this.$store.state.description },
            set(description) { this.$store.commit('SET_DESCRIPTION', description) }
        },
        target: {
            get() { return this.$store.state.target },
            set(target) { this.$store.commit('SET_TARGET', target) }, 
        },
        type: {
            get() { return this.$store.state.type },
            set(type) { this.$store.commit('SET_TYPE', type) }, 
        },
        fields: { 
            get() { return this.$store.state.fields },
            set(fields) { this.$store.commit('SET_FIELDS', fields); }
        },
        targetName() {
            if(this.target.name != null)
                return this.target.name;

            return this.target.type.name;
        }
    },
    methods: {
        removeField(fieldIndex) {
            this.$confirm('Are you sure you want to remove this field from your form?', 'Warning', {
                confirmButtonText: 'Remove',
                cancelButtonText: 'Nevermind',
                type: 'warning'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: 'Field removed'
                })

                this.$store.commit('REMOVE_FIELD', fieldIndex);

            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: "Field kept"
                })
            })
        },

        updateField(field, fieldIndex) {
            this.$store.commit({
                type: 'UPDATE_FIELD',
                field,
                fieldIndex
            });

            this.$forceUpdate();
        },

        updateFieldChoices(field, fieldIndex) {
            this.$store.commit({
                type: 'UPDATE_FIELD_CHOICES',
                field,
                fieldIndex
            });

            this.$forceUpdate();
        },

        initializeForm(data) {
            this.title = data.name;
            this.description = data.description;
            this.target = data.target;
        }

    },
}
</script>

<style scoped>
#canvas {
    font-family: 'Inter UI', Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
    max-height: 745px;
    overflow-y: scroll;
}
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
/* .el-row {
    margin: 5px;
  } */
  .el-col {
    border-radius: 4px;
    margin-top: 15px;
  }
  .el-input {
      font-size: 16px;
  }
  .el-divider span {
      font-size: 16px;
  }
  .canvas-card {
      font-size: 100%;
  }
  .handle {
      position: relative;
      z-index: 10;
  }
  .handle:hover {
      cursor: move;
  }
</style>
