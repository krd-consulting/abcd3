<template>
    <div id="dropdown">
         <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
            <el-collapse-item>
                <template slot="title">
                    <el-select v-model="value" placeholder="select">
                        <el-option v-for="item in dropdownList" :key="item.id" :label="item.value" :value="item.value"></el-option>
                    </el-select>
                </template>
                <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                    <el-form-item label="Field Label">
                        <el-input v-model="options.title"></el-input>
                    </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
                    </el-form-item>
                </el-form>
                
                <h3>Dropdown Items</h3>
                <el-row v-for="item in dropdownList" :key="item.id">
                  <el-col :span="5">
                      <editable-text class="float-left" @input="showField" v-model="item.value">{{ item.value }}</editable-text>
                      <el-button class="float-right pr-15" type="text" size="mini" @click="removeItem(item)">Remove</el-button>
                  </el-col>
                </el-row>
                        
                <form @submit.prevent="addItem">
                    <el-form>
                        <el-form-item label="Add Item to List"></el-form-item>
                    </el-form>
                    <el-input v-model="itemText"></el-input>
                    <el-button type="success" @click="addItem">Add</el-button>
                </form>
                
                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
        return {
            itemText: '',
            value: '',
            editField: '',
            dropdownList: [],
            nextItem: 0
        }
    },
    components: {
        EditableText
    },
    props: {
        options: {
            type: Array | Object,
            default: {
                title: 'Dropdown',
                required: false,
                reference: '',
                dropdownNum: 0,
                radioNum: 2,
                checkboxNum: 2,
                matrixQuestions: 2,
                matrixChoices: 5,
                setLength: 50,
            }
        }
    },
    mounted: function() {
        this.setDropdownItems(); // calls method upon being rendered in the DOM
    },
    methods: {
        addItem: function() {
            this.dropdownList.push({
                id: this.nextItem++, value: this.itemText
            })
            this.itemText = ''
        },
        loadItem: function() {
            this.dropdownList.push({
                id: this.nextItem++, value: 'item ' + this.nextItem
            })
        },
        removeItem(item) {
            var index = this.dropdownList.indexOf(item);
            if (index !== -1) {
                this.dropdownList.splice(index, 1);
            }
        },
        setDropdownItems() {
            var i;
            for(i= 0; i < this.options.dropdownNum; i++) {
                this.loadItem();
            }
        },
        // focusField(value){
        //     this.editField = value;
        // },
        // blurField(){
        //     this.editField = '';
        // },
        showField(value){
            return (this.dropdownList[value] == '' || this.editField == value)
        }
    }
}
</script>

<style>
#dropdown {
  font-family: 'Inter UI', Arial, sans-serif;
  font-weight: bold;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
ul {
  list-style-type: none;
}
</style>


