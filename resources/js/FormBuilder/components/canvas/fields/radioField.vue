<template>
    <div id="dropdown">
         
        <label class="inputLabel">
            <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                {{ fieldLabel }}
            </editable-text>
        </label>

             <el-radio-group id="radioGroup">
                <el-radio 
                    v-model="item.value" 
                    v-for="item in radioList" 
                    :key="item.value" 
                    :label="item.value" 
                    class="tw-mx-4">
                        <editable-text 
                            class="tw-cursor-pointer mouseOver"
                            v-model="item.value">
                                {{ item.value }}
                        </editable-text>
                        <el-button class="float-right pr-15" type="text" size="mini" @click="removeItem(item)">Remove</el-button>
                </el-radio>
                
            </el-radio-group>
        
        
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
            radioList: [],
            nextItem: 0,
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
    computed: {
        fieldLabel: {
            get() { return this.field.label; },
            set(label) { 
                console.log('field label edited');

                const fieldCopy = _.clone(this.field);

                fieldCopy.label = label;

                this.field = fieldCopy;
            }
        },

        field: {
            get() { return this.fieldData; },
            set(field) { 
                console.log('field edited');
                this.$emit('update', field); 
            }
        },
    },
    mounted() {
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
