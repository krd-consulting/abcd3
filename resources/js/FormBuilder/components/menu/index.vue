<template>
  <div id="menu">
    <div id="menu-container" class="abcd-sticky">
      <!-- <el-row class="tw-flex-1 tw-max-w-full"> -->
        <!-- <el-col> -->
          <el-collapse v-model="step" accordion class="tw-w-full">
            <el-collapse-item name="1">
              <template slot="title">
                  <p class="menu-title">Select a Field</p>
              </template>

              <div v-for="input in inputs" :key="input.id" @click="selectInput(input)">
                  <el-card class="fields cursor-pointer" body-style="padding: 5px;" shadow="hover">
                        {{ input.name }}
                  </el-card>
              </div>
            
                <!-- TODO:  Post-MVP feature
                    integrate this feature with the ability to save input option settings and create
                    persisted presets that are reusable in other forms.
                    eg: user knows they need a checklist of the same contents accross multiple forms,
                    they can create it once, and save it into 'presetInputs' 
                -->
              <!-- <h3>Preset Inputs</h3>
              <div v-for="input in presetInputs" :key="input.id" @click="selectInput(input)">
                  <el-card class="fields cursor-pointer" body-style="padding: 5px;" shadow="hover">
                      {{ input.name }}
                  </el-card>
              </div> -->

          </el-collapse-item>

          <el-collapse-item name="2">
              <template slot="title">
                  <p v-if="!selectedInput.name" class="menu-title">Field Requirements</p>
                  <p v-if="selectedInput.name" class="menu-title">{{ selectedInput.name }} Settings</p>
              </template>

                <component :is="selectedInput.component" 
                    :inputData="selectedInput"
                    @outputData="setInputOptions">
                        <template v-slot:default="{ fieldData }">
                            <el-button type="success" @click="setInputOptions(fieldData)">Set</el-button>
                        </template>
                </component>

            </el-collapse-item>
          </el-collapse>
        <!-- </el-col> -->
      <!-- </el-row> -->
    </div>            
  </div>
</template>

<script>
import draggable from 'vuedraggable'
import TextField from './fieldOptions/textField.vue'
import TextBox from './fieldOptions/textArea.vue'
import TimePicker from './fieldOptions/timePicker.vue'
import SectionDivider from './fieldOptions/sectionDivider.vue'
import FileUpload from './fieldOptions/fileUpload.vue'
import NumericField from './fieldOptions/numeric.vue'
import MatrixField from './fieldOptions/matrix.vue'
import DatePicker from './fieldOptions/datePicker.vue'
import CheckBox from './fieldOptions/checkBox.vue'
import RadioField from './fieldOptions/radioField.vue'
import Dropdown from './fieldOptions/dropdown.vue'

export default {
    data: () => {
        return {
            step: '1',
            selectedInput: {},
            inputs: [
                {id: 0, name: 'Text Field', component: 'TextField'},
                {id: 1, name: 'Text Area', component: 'TextBox'},
                {id: 2, name: 'Numeric', component: 'NumericField'},
                {id: 3, name: 'Dropdown', component: 'Dropdown'},
                {id: 4, name: 'Radio', component: 'RadioField'},
                {id: 5, name: 'Checkbox', component: 'CheckBox'},
                {id: 6, name: 'Date Picker', component: 'DatePicker'},
                {id: 7, name: 'Time Picker', component: 'TimePicker'},
                {id: 8, name: 'Matrix', component: 'MatrixField'},
                {id: 9, name: 'File Upload', component: 'FileUpload'},
                {id: 10, name: 'Section Divider', component: 'SectionDivider'},
            ],
            // presetInputs: [],
            fieldData: {} //passed from InputOptions component
        }
    },
    props: {
        outputData: Object,
        inputData: Object
    },
    components: {
        draggable,
        TextField,
        TextBox,
        TimePicker,
        SectionDivider,
        FileUpload,
        NumericField,
        MatrixField,
        DatePicker,
        CheckBox,
        RadioField,
        Dropdown
    },
    computed: {
        
    },
    methods: {

        selectInput(input) {
            console.log(input.name);
            this.selectedInput = Object.assign({}, input);
            console.log(this.selectedInput.name);

            this.step = '2';
        },

        setInputOptions(value) {

            this.fieldData = value;

            const data = {
                input: _.clone(this.selectedInput),
                fieldData: _.clone(this.fieldData)
            };

            this.$emit("add", data);
            this.selectedInput = {}
            this.step = '1';
        },

        submitfieldData(fieldData) {
            this.$emit('inputData', this.fieldData);
            
        }
    }
}
</script>

<style scoped>
    #menu {
        overflow: hidden;
        display: flex;
        max-width: 260px;
        min-width: 160px;
    }
    /* .el-row {
        flex: 100%;
        max-width: 250px;
        min-width: 160px;
    } */
    .el-card {
        margin: 5px;
    }
    .el-card:hover {
        border-color: #badcff;
        font-size: 120%;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .menu-title {
        padding-left: 5px;
        font-size: 18px;
        font-weight: bold;
        color: #2c3e50;
    }
    .fields {
        font-size: 13px;
        font-weight: bold;
    }
</style>
