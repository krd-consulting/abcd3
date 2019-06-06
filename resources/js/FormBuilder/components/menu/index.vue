<template>
  <div id="menu">
    <div class="menu-container">
      <el-row type="flex">
        <el-col>
          <el-collapse v-model="step" accordion>
            <el-collapse-item name="1">
              <template slot="title">
                  <p class="menu-title">Select a Field</p>
              </template>
              <h3>General</h3>
              <div v-for="input in basicInputs" :key="input.id" @click="selectInput(input)">
                  <el-card class="fields cursor-pointer" body-style="padding: 5px;" shadow="hover">
                      {{ input.name }}
                  </el-card>
              </div>

              <h3>Preset Inputs</h3>
              <div v-for="input in presetInputs" :key="input.id" @click="selectInput(input)">
                  <el-card class="fields cursor-pointer" body-style="padding: 5px;" shadow="hover">
                      {{ input.name }}
                  </el-card>
              </div>
          </el-collapse-item>

          <el-collapse-item name="2">
              <template slot="title">
                  <p class="menu-title">Field Requirements</p>
              </template>
              <InputOptions :inputData="selectedInput" @outputData="setInputOptions"/>
            </el-collapse-item>
          </el-collapse>
        </el-col>
      </el-row>
    </div>            
  </div>
</template>

<script>
import draggable from 'vuedraggable'
import InputOptions from './inputOptions' 

export default {
    data: () => {
        return {
            step: '1',
            selectedInput: {id: '', name: '', component: ''},
            basicInputs: [
                {id: 0, name: 'Text Field', component: 'TexBox'},
                {id: 1, name: 'Text Area', component: 'TexArea'},
                {id: 2, name: 'Numeric', component: 'NumericField'},
                {id: 3, name: 'Dropdown', component: 'DropdownField'},
                {id: 4, name: 'Radio', component: 'RadioField'},
                {id: 5, name: 'Checkbox', component: 'CheckboxField'},
                {id: 6, name: 'Date Field', component: 'DateField'},
                {id: 7, name: 'Matrix', component: 'MatrixField'},
            ],
            presetInputs: [
                {id: 8, name: 'Email', component: 'EmailField'},
                {id: 9, name: 'Address', component: 'AddressField'},
                {id: 10, name: 'Phone Number', component: 'PhoneField'},
            ],
            others: [
                {id: 11, name: 'Section Divider', icon: ''},
            ],
            options: {} //passed from InputOptions component
        }
    },
    props: {
        outputData: Object
    },
    components: {
        draggable,
        InputOptions
    },
    computed: {
        
    },
    methods: {
        selectInput(input) {
            console.log(input.name);
            this.selectedInput = Object.assign({}, input);
            console.log(this.selectedInput.id);

            this.step = '2';
        },
        setInputOptions(value) {
            this.options = value;

            const data = {
                input: _.clone(this.selectedInput),
                options: _.clone(this.options)
            };
            this.$emit("add", data);
            this.step = '1';
        }
    }
}
</script>

<style scoped>
    .menu-container .el-row .el-col .el-collapse {
        /* margin-left: 5px;
        padding-left: 5px; */
        max-width: 300px;
        min-width: 150px;
        padding-right: 5px;
    }
    .menu-container .el-row {
        margin-left: 5px;
        padding-left: 5px;
    }
    .el-card:hover {
        border-color: #badcff;
        font-size: 120%;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .menu-title {
        font-size: 18px;
        font-weight: bold;
        color: #2c3e50;
    }
    .fields {
      font-size: 13px;
      font-weight: bold;
    }
</style>
