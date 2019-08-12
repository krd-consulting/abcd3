<template>
  <div id="menuSelect">
    <div id="menu-container">
        <el-collapse v-model="step" accordion>
            <el-collapse-item name="1">
                <template slot="title">
                    <p class="menu-title">1. Choose a field</p>
                </template>

                <div v-for="input in inputs" :key="input.id" @click="selectInput(input)">
                    <el-card class="fields cursor-pointer hover:tw-bg-gray-400 hover:tw-text-blue-500" body-style="padding: 5px 0 0 15px;" shadow="never">
                        {{ input.name }}
                    </el-card>
                </div>
            
                <!-- TODO:  Post-MVP feature
                    integrate this feature with the ability to save input option settings and create
                    persisted pre-sets that are reusable in other forms.
                    eg: user knows they need a checklist of the same contents accross multiple forms,
                    they can create it once, and save it into 'presetInputs' 
                -->
              <!-- <h3>Preset Inputs</h3>
              <div v-for="input in presetInputs" :key="input.id" @click="selectInput(input)">
                  <el-card class="fields cursor-pointer" body-style="padding: 5px 0 0 15px;" shadow="hover">
                      {{ input.name }}
                  </el-card>
              </div> -->

        </el-collapse-item>

        <el-collapse-item name="2" disabled class="tw-cursor-default">
            <template slot="title">
                <p class="menu-title">2. Set Options</p>
            </template>

                <component :is="selectedInput.component" 
                    :inputData="selectedInput"
                    @save="addField">
                        
                </component>

            </el-collapse-item>
          </el-collapse>
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
                {name: 'Numeric Field', component: 'NumericField'},
                {name: 'Date', component: 'DatePicker'},
                {name: 'Time', component: 'TimePicker'},
                {name: 'Multiple Choice (dropdown)', component: 'Dropdown'},
                {name: 'Multiple Choice (radio)', component: 'RadioField'},
                {name: 'Multiple Choice (checkbox)', component: 'CheckBox'},
                {name: 'Matrix', component: 'MatrixField'},
                {name: 'Paragraph', component: 'TextBox'},
                {name: 'File Upload', component: 'FileUpload'},
                {name: 'Section Divider', component: 'SectionDivider'},
            ],
            
            fieldData: {} 
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
    
    methods: {

        selectInput(input) {
            this.selectedInput = Object.assign({}, input);

            this.step = '2';
        },

        addField(field) {
            this.$store.commit('ADD_FIELD', field);

            this.selectedInput = {}
            this.step = '1';
        },
    }
}
</script>

<style scoped>
#menu {
    overflow: hidden;
    display: flex;
    min-height: 735px;
}
.el-card {
    margin: 5px;
    border: none;
}
.el-card:hover {
    font-size: 14px;
}
.cursor-pointer {
    cursor: pointer;
}
.menu-title {
    padding-left: 5px;
    font-size: 24px;
    font-weight: bold;
    color: #2c3e50;
}
.fields {
    font-size: 13px;
    font-weight: bold;
}

/* Ipad size */
@media (min-width: 640px){
     .el-collapse {
        width: 300px;
    } 
 
}

 /* Standard monitor size */
@media (min-width: 1024px){
   .el-collapse {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    } 
   

}
 
@media (min-width: 1200px){

    /* large monitor size */
 
}
</style>
