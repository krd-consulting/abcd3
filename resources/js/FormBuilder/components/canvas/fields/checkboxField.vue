<template>
  <div id="checkbox">
        <label class="inputLabel">
            <el-col>
                <editable-text class="tw-cursor-pointer mouseOver" v-model="field.label">{{ field.label}}</editable-text>
            </el-col>
        </label><br>

        <el-checkbox-group id="check" >
            <el-checkbox 
                v-model="item.value" 
                v-for="item in checkList" 
                :key="item.value" 
                :label="item.value">
                    <editable-text 
                        class="tw-cursor-pointer mouseOver"
                        v-model="item.value">
                            {{ item.value }}
                    </editable-text>
                    <el-button 
                        class="float-right pr-15" 
                        type="text" 
                        size="mini" 
                        @click="removeItem(item)">
                            Remove
                    </el-button>
            </el-checkbox>
        </el-checkbox-group>

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
            checkList: [],
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
            }
        }
    },
    created() {
        this.field = _.clone(this.fieldData)
    },
    mounted: function() {
        this.setCheckboxItems(); // calls method upon being rendered in the DOM
    },
    methods: {
        addItem: function() {
            this.checkList.push({
                id: this.nextItem++, value: this.itemText
            })
            this.itemText = ''
        },
        loadItem: function() {
            this.checkList.push({
                id: this.nextItem++, value: 'item ' + this.nextItem + ' '
            })
        },
        removeItem(item) {
            var index = this.checkList.indexOf(item);
            if (index !== -1) {
                this.checkList.splice(index, 1);
            }
        },
        setCheckboxItems() {
            var i;
            for(i= 0; i < this.field.settings.checkboxNum; i++) {
                this.loadItem();
            }
        },
    }
}
</script>

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
</style>