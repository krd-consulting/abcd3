<template>
    <div id="canvas">
        <el-container>
            <el-main>
                <el-card body-style="padding: 10px;" shadow="hover" >
                    <el-divider content-position="left"><span>Required Content</span></el-divider>

                    <el-card body-style="padding: 10px;" shadow="hover">
                        <span class="inputLabel">Client Name</span>
                        <el-input class="inputField" placeholder="Name of client" v-model="clientName"></el-input>
                    </el-card>
                            
                    <el-card body-style="padding: 10px;" shadow="hover">
                        <!-- <div class="block"> -->
                            <span class="inputLabel">Date Completed</span><br>
                            <el-date-picker v-model="dateCompleted" type="date" placeholder="Pick a day" :picker-options="pickerOptions">
                            </el-date-picker>
                        <!-- </div> -->
                    </el-card>
                            
                    <el-card body-style="padding: 10px;" shadow="hover">
                        <span class="inputLabel">Team</span><br>
                        <el-select value="" placeholder="Select">
                            <el-option v-for="department in departments" :key="department.value"
                            :label="department.label" :value="department.value">
                            </el-option>
                        </el-select>
                    </el-card>
                        
                    <el-divider></el-divider>
                </el-card>

            <el-card class="cursor-move" body-style="padding: 10px;" shadow="hover">
                <el-divider content-position="left">
                    <!-- <form @submit.prevent="showField"> -->
                        <span v-show="!showField('sectionHeader')" @click="focusField('sectionHeader')">{{ sectionHeader }}</span>
                        <el-input v-model="sectionHeader" v-show="showField('sectionHeader')" @focus="focusField('sectionHeader')" @blur="blurField"></el-input>
                    <!-- </form> -->
                </el-divider>
                    <draggable class="dropArea" v-model="fieldList">
                        <div v-for="(inputType, index) in fieldList" :key="index">
                            <el-row type="flex" :gutter="2">
                            <el-col class="float-left" :span="24">
                                <el-card class="cursor-move" body-style="padding: 10px;" shadow="hover">
                                    <div v-if="fieldList === null">
                                        <p>New fields will be placed here</p>
                                    </div>
                                    <div v-if="inputType.input.id === 0"> <!-- textbox -->
                                        <Text-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Text-field>
                                    </div>
                                    <div v-else-if="inputType.input.id === 1"> <!-- textArea -->
                                        <Text-box :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Text-box>
                                    </div>
                                    <div v-else-if="inputType.input.id === 2"> <!-- Numeric field -->
                                        <Numeric-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Numeric-field>
                                    </div>
                                    <div v-else-if="inputType.input.id === 3"> <!-- Dropdown -->
                                        <Dropdown-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Dropdown-field>
                                    </div>
                                    <div v-else-if="inputType.input.id === 4"> <!-- Radio -->
                                        <Radio-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Radio-field>
                                    </div>
                                    <div v-else-if="inputType.input.id === 5"> <!-- Checkbox -->
                                        <Checkbox-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Checkbox-field>
                                    </div>
                                    <div v-else-if="inputType.input.id === 6"> <!-- Date Field -->
                                        <Date-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Date-field>
                                    </div>
                                    <div v-else-if="inputType.input.id === 7"> <!-- Matrix Field -->
                                        <Matrix-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Matrix-field>
                                    </div>
                                    <div v-else-if="inputType.input.id === 8"> <!-- Email -->
                                        <Email-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Email-field>
                                    </div>
                                    <div v-else-if="inputType.input.id === 9"> <!-- Address -->
                                        <Address-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Address-field>
                                    </div>
                                    <div v-else-if="inputType.input.id === 10"> <!-- Phone Number -->
                                        <Phone-field :options="inputType.options">
                                            <el-button class="canvas-card float-right text-x1" type="text" @click="removeItem(index)"><strong>I no longer want this field</strong></el-button>
                                        </Phone-field>
                                    </div>
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

import TextField from '@/FormBuilder/components/canvas/fields/TextField.vue'
import TextBox from '@/FormBuilder/components/canvas/fields/TextArea.vue'
import EmailField from '@/FormBuilder/components/canvas/fields/EmailField.vue'
import AddressField from '@/FormBuilder/components/canvas/fields/AddressField.vue'
import CheckboxField from '@/FormBuilder/components/canvas/fields/CheckboxField.vue'
import DropdownField from '@/FormBuilder/components/canvas/fields/DropdownField.vue'
import NumericField from '@/FormBuilder/components/canvas/fields/NumericField.vue'
import PhoneField from '@/FormBuilder/components/canvas/fields/PhoneField.vue'
import RadioField from '@/FormBuilder/components/canvas/fields/RadioField.vue'
import DateField from '@/FormBuilder/components/canvas/fields/DateField.vue'
import MatrixField from '@/FormBuilder/components/canvas/fields/MatrixField.vue'

export default {
    data: () => {
        return {
            visible: false,
            clientName: '',
            dateCompleted: '',
            fieldList: [],
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
            departments: [
                { value: 'Counselling', label: 'Counselling'},
                { value: 'Community Programs', label: 'Community Programs'}
            ],
            sectionHeader: 'New Section',
            input: {},
            inputType: {},
            inputOptions: {},
        }
    },
    props: {
        newInput: Function,
        fields: {
            type: Array,
            default: []
        },
        options: Function
    },
    components: {
        draggable,
        SidePanel,
        TextField,
        TextBox,
        EmailField,
        NumericField,
        AddressField,
        CheckboxField,
        DropdownField,
        PhoneField,
        RadioField,
        DateField,
        MatrixField,
    },
    computed: {
        
    },
    methods: {
        removeItem(index) {
            alert(index);
            this.fields.splice(index, 1);
        },
        focusField(value){
            this.editField = value;
        },
        blurField(){
            this.editField = '';
        },
        showField(value){
            return (this.sectionHeader[value] == '' || this.editField == value)
        }
    },
    watch: {
        mouseOver: function(){
            this.visible = !this.visible;   
        },
        newInput() {
            this.form.push(this.input.id)
        },
        fields() {
            this.fieldList = _.clone(this.fields);
        }
    }
}
</script>

<style scoped>
@tailwind base;

@tailwind components;

@tailwind utilities;

#canvas {
  font-family: 'Avenir', Helvetica, Arial, sans-serif; 
  font-size: 20px;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
.el-row {
    margin-bottom: 5px;
    margin-left: 5px;
    margin-right: 5px;
    margin-top: 5px;
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
