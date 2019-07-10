<template>
  <div id="checkbox">
        <label class="inputLabel">
            <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                {{ fieldLabel }}
            </editable-text>
        </label><br>

        <el-checkbox-group id="check" >
            <el-checkbox 
                v-model="value" 
                v-for="(item, index) in choices" 
                :key="item.value" 
                :label="item.value">
                    <editable-text 
                        class="tw-cursor-pointer mouseOver"
                        v-model="item.value"
                        @input="updateChoiceValue($event, index)">
                            {{ item.value }}
                    </editable-text>
                    <el-button 
                        class="float-right pr-15" 
                        type="text" 
                        size="mini" 
                        @click="removeChoice(item)">
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
            nextItem: 0,
            itemText: ''
        }
    },
    // mounted() {
    //     this.getCheckboxItems(); // calls method upon being rendered in the DOM
    // },
    components: {
        EditableText
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    computed: {

        field: {
            get() { return this.fieldData; },
            set(field) { this.$emit('update', field); }
        },

        fieldLabel: {
            get() { return this.field.label; },
            set(label) {
                const fieldCopy = _.clone(this.field);
                fieldCopy.label = label;
                this.field = fieldCopy;
            }
        },

        choices: {
            get() { return this.field.choices },
            set(choices) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.choices = choices;
                this.field = fieldCopy;
            }
        },

        value: {
            get(){ return this.field.choices.value},
            set(value){
                const fieldValue = _.clone(this.field);
                fieldValue.choices.value = value;
                this.field = fieldValue;
                this.$emit('updateChoices', field);
            }
        },
    },
    methods: {
        getCheckboxItems() {
            var i;
            for(i= 0; i < this.field.settings.checkboxNum; i++) {
                this.loadItem();
            }
        },

        loadItem() {
            this.choices.push({
                id: this.nextItem++, 
                value: 'item ' + this.nextItem
            })
            this.$store.commit('UPDATE_FIELD', this.field)
            
        },

        addItem() {
            const choicesCopy = _.clone(this.choices);

            choicesCopy.push({
                id: this.nextItem++, value: this.itemText
            });

            this.choices = choicesCopy;
            this.itemText = ''
        },
        
        removeChoice(item) {
            var index = this.choices.indexOf(item);

            if (index !== -1) {
                this.choices.splice(index, 1);
                this.$store.commit('UPDATE_FIELD', this.field)
            }

            this.$forceUpdate();
        },

        updateChoiceValue(value, index) {
            const fieldCopy = _.clone(this.field);
            fieldCopy.choices[index].value = value;
            this.choices = fieldCopy.choices;
        }
        
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