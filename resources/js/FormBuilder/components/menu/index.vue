<template>
  <div id="menu">
    <div id="menu-container">
      <!-- <el-row class="tw-flex-1 tw-max-w-full"> -->
        <!-- <el-col> -->
          <el-collapse v-model="step" accordion id="menu-stepper">
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
                    :inputData="selectedInput">
                        <template v-slot:default="{ fieldData }">
                            <el-button type="success" @click="addField(fieldData)">Set</el-button>
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
                {name: 'Text Field', component: 'TextField'},
                {name: 'Text Area', component: 'TextBox'},
                {name: 'Numeric', component: 'NumericField'},
                {name: 'Dropdown', component: 'Dropdown'},
                {name: 'Radio', component: 'RadioField'},
                {name: 'Checkbox', component: 'CheckBox'},
                {name: 'Date Picker', component: 'DatePicker'},
                {name: 'Time Picker', component: 'TimePicker'},
                {name: 'Matrix', component: 'MatrixField'},
                {name: 'File Upload', component: 'FileUpload'},
                {name: 'Section Divider', component: 'SectionDivider'},
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

        addField(field) {
            this.$store.commit('ADD_FIELD', field);

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
 
@media (min-width: 768px){
    
    /* Ipad size */
 
}
 
@media (min-width: 1024px){
    
    /* Standard monitor size */

}
 
@media (min-width: 1200px){

    /* large monitor size */
 
}
    #menu {
        overflow: hidden;
        display: flex;
        max-width: 260px;
        min-width: 160px;
    }
    .el-collapse {
        width: 250px;
    }
    /* #menu-stepper {
        width: auto;
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
