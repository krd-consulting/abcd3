<template>
    <div id="dropdown">
         
        <label class="inputLabel">
            <editable-text class="tw-cursor-pointer" v-model="field.label">{{ field.label}}</editable-text>
        </label>
        
        <el-radio-group id="radioGroup">
            
            <el-radio 
                v-model="item.value" 
                v-for="item in radioList" 
                :key="item.value" 
                :label="item.value" 
                class="tw-mx-4">
                <editable-text 
                    class="tw-cursor-pointer"
                    v-model="item.value">{{ item.value }}</editable-text>
            </el-radio>

        </el-radio-group>

        <slot></slot>

        <el-collapse>
            <el-collapse-item>
                <template slot="title">
                    <form @submit.prevent="addItem">
                        <el-row>
                            <el-col :span="16">
                                <el-input id="newItem" v-model="itemText"></el-input>
                            </el-col>
                            <el-col :span="8">
                                <el-button type="success" @click="addItem">Add</el-button>
                            </el-col>
                        </el-row>
                    </form>
                </template>
                <div>
                        <h1>Edit List Items</h1>
                        <el-row v-for="item in radioList" :key="item.id">
                            <el-col :span="8" class="tw-mr-4">
                                <editable-text class="tw-cursor-pointer float-left" @input="showField" v-model="item.value">{{ item.value }}</editable-text>
                                
                            </el-col>
                            <el-col :span="6" class="tw-ml-4">
                                <el-button class="float-right pr-15" type="text" size="mini" @click="removeItem(item)">Remove</el-button>
                            </el-col>
                        </el-row>
                </div>

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
            radioList: [],
            nextItem: 0,
            field: []
        }
    },
    components: {
      EditableText
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {
                label: 'Radio List'
            }
        }
    },
    created() {
        this.field = _.clone(this.fieldData)
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
            for(i= 0; i < this.field.settings.radioNum; i++) {
                this.loadItem();
            }
        },
        showField(value){
            return (this.radioList[value] == '' || this.editField == value)
        },

        test() {
            alert('hello');
        }
    }
}
</script>

<style>
ul {
  list-style-type: none;
}
</style>
