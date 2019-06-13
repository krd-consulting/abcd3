<template>
    <div id="dropdown">
         <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
            <el-collapse-item>
                <template slot="title">
                    <el-radio-group v-for="item in radioList" :key="item.value">
                        <el-radio v-model="item.value" :label="item.value">{{ item.value }}</el-radio>
                    </el-radio-group>
                </template>
                <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                    <el-form-item label="Field Label">
                        <el-input v-model="options.title"></el-input>
                    </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
                    </el-form-item>
                </el-form>
                <el-form>
                    <el-form-item label="Dropdown Items"></el-form-item>
                </el-form>
                    <!-- <ul>
                        <li v-for="item in radioList" :key="item.id" >
                            <span v-show="!showField('value')" @click="focusField('value')">
                                {{ item.value }}
                            </span>
                            <el-input v-model="item.value" v-show="showField('value')" @focus="focusField('value')" @blur="blurField"></el-input>
                            <el-button type="text" @click="removeItem(item)">Remove</el-button>
                        </li>
                    </ul> -->
                <h3>Radio List Items</h3>
                <el-row v-for="item in radioList" :key="item.id">
                  <el-col :span="5">
                      <editable-text class="cursor-text float-left" @input="showField" v-model="item.value">{{ item.value }}</editable-text>
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
            radioList: [
                // {id: 0, value: 'Item 1'},
            ],
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
        this.setRadioItems(); // calls method upon being rendered in the DOM
    },
    methods: {
        addItem: function() {
            this.radioList.push({
                id: this.nextItem++, value: this.itemText
            })
            this.itemText = ''
        },
        loadItem: function() {
            this.radioList.push({
                id: this.nextItem++, value: 'item ' + this.nextItem + ' '
            })
        },
        removeItem(item) {
            var index = this.radioList.indexOf(item);
            if (index !== -1) {
                this.radioList.splice(index, 1);
            }
        },
        setRadioItems() {
            var i;
            for(i= 0; i < this.options.radioNum; i++) {
                this.loadItem();
            }
        },
        focusField(value){
            this.editField = value;
        },
        blurField(){
            this.editField = '';
        },
        showField(value){
            return (this.radioList[value] == '' || this.editField == value)
        }
    }
}
</script>

<style>
ul {
  list-style-type: none;
}
</style>
