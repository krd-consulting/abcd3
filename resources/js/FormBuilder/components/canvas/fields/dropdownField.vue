<template>
    <div id="dropdown">
        <label class="inputLabel">
            <editable-text class="tw-cursor-pointer" v-model="field.label">{{ field.label}}</editable-text>
        </label>
        <el-select id="dropdown" v-model="value" placeholder="select">
            <el-option v-for="item in dropdownList" :key="item.id" :label="item.value" :value="item.value"></el-option>
        </el-select>
        <div class="tw-float-right">
            <editable-text class="tw-cursor-pointer" v-model="value">{{ value.value }}</editable-text>
            <el-button v-if="value != ''" class="float-right pr-15" type="text" size="mini" @click="removeItem(value)">Remove Item</el-button>
        </div>
        
        <form @submit.prevent="addItem" class="tw-mt-4">
            <el-row>
                <el-col :span="12">
                    <label for="newItem">Add Item <el-button class="tw-ml-2" type="text" @click="addItem">Add</el-button></label>
                    <el-input id="newItem" v-model="itemText"></el-input>
                </el-col>
            </el-row>
        </form>

        <slot></slot>
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
                label: 'Dropdown',
            }
        }
    },
    created() {
        this.field = _.clone(this.fieldData)
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
            for(i= 0; i < this.field.settings.dropdownNum; i++) {
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


