<template>
    <div id="dropdown">
        <label for="dropdown" class="inputLabel">{{ inputFieldData.label }}</label><br>
        <sup>{{ inputFieldData.description }}</sup>
        <el-select id="dropdown" v-model="value" placeholder="select">
            <el-option v-for="item in dropdownList" :key="item.id" :label="item.value" :value="item.value"></el-option>
        </el-select>
         <el-collapse>
            <el-collapse-item>
                <template slot="title">
                    <el-button icon="el-icon-edit">Field Options</el-button>
                </template>
                <div class="tw-flex tw-inline-block tw-w-full">
                    <div class="tw-float-left">
                            
                        <el-row class="tw-my-6">
                            <label for="label">Field Label</label>
                            <el-col :span="20">
                                <el-input id="label" v-model="inputFieldData.label"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <el-col :span="20">
                                <label for="description">Field Description</label>
                                <el-input id="description" v-model="inputFieldData.description"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <label for="switch" class="tw-mb-4">This field is</label><br>
                            <el-switch id="switch" v-model="inputFieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-row>
                    </div>

                    <div class="tw-float-right tw-mx-20 tw-my-6">
                        <form @submit.prevent="addItem">
                            <el-col :span="16">
                                <label for="newItem">Add a new item to the list</label>
                                <el-input id="newItem" v-model="itemText"></el-input>
                                <el-button type="success" @click="addItem">Add</el-button>
                            </el-col>
                        </form>
                    </div>
                    <div class="tw-float-right tw-mx-20 tw-my-6">
                        <h3>Dropdown Items</h3>
                        <el-row v-for="item in dropdownList" :key="item.id">
                                <editable-text class="tw-cursor-pointer" @input="showField" v-model="item.value">{{ item.value }}</editable-text>
                                <el-button class="float-right pr-15" type="text" size="mini" @click="removeItem(item)">Remove</el-button>
                        </el-row>
                    </div>
                </div>

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
            nextItem: 0,
            inputFieldData: []
        }
    },
    components: {
        EditableText
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {
                label: 'Dropdown',
            }
        }
    },
    created() {
        this.inputFieldData = _.clone(this.fieldData)
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
            for(i= 0; i < this.inputFieldData.options.dropdownNum; i++) {
                this.loadItem();
            }
        },
        showField(value){
            return (this.dropdownList[value] == '' || this.editField == value)
        }
    }
}
</script>

<style>

</style>


