<template>
  <div id="checkbox">
        <label class="inputLabel">
            <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                {{ fieldLabel }}
            </editable-text>
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
            // checkList: [],
            nextItem: 0,
        }
    },
    mounted() {
        this.setCheckboxItems(); // calls method upon being rendered in the DOM
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
    computed: {

        field: {
            get() { return this.fieldData; },
            set(field) { 
                console.log('field edited');
                this.$emit('update', field); 
            }
        },

        fieldLabel: {
            get() { return this.field.label; },
            set(label) { 
                console.log('field label edited');

                const fieldCopy = _.clone(this.field);

                fieldCopy.label = label;

                this.field = fieldCopy;
            }
        },

        // itemText: {
        //     get(){ return this.fieldData.choices.value},
        //     set(value){
        //         console.log('choices updated');
        //         const fieldCopy = _.clone(this.field);
        //         fieldCopy.choices.value = value;
        //         this.field = fieldCopy;
        //     }
        // },

        checkList: {
            get() { return this.field.choices},
            set(field) { this.$emit('update', field)}
        }
    },
    methods: {
        setCheckboxItems() {
            var i;
            for(i= 0; i < this.field.settings.checkboxNum; i++) {
                this.loadItem();
            }
        },

        loadItem: function() {
            this.checkList.push({
                id: this.nextItem++, value: 'item ' + this.nextItem + ' '
            })
            this.$store.commit('UPDATE_FIELD', field)
        },

        addItem: function() {
            this.checkList.push({
                id: this.nextItem++, value: this.itemText
            })
            this.itemText = ''
        },
        
        removeItem(item) {
            var index = this.checkList.indexOf(item);
            if (index !== -1) {
                this.checkList.splice(index, 1);
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