<template>
  <div id="checkbox">

        <slot></slot>

        <el-switch 
            v-model="required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right switch-position">
        </el-switch>

      <el-col :span="8" class="tw-mt-1">
          <label>
            <editable-text 
                class="tw-cursor-pointer mouseOver" 
                v-model="fieldLabel"
                @edit="tempValue(fieldLabel)">
                {{ fieldLabel }}
            </editable-text>
        </label>
      </el-col>
        <br><br>
        <div class="zone">
            <div v-for="(item, index) in choices" 
                :key="item.value">

                <el-checkbox>
                    <editable-text 
                        class="tw-cursor-pointer mouseOver"
                        :value="item.value"
                        @input="updateChoiceValue($event, index)"
                        @edit="tempValue(item.value)">
                            {{ item.value }}
                    </editable-text>
                </el-checkbox>

                <el-button 
                    class="tw--ml-6 tw-mt-4 hover:tw-text-red-600"
                    type="text" 
                    size="mini" 
                    @click="removeChoice(item)">
                        <base-icon>delete_forever</base-icon>
                </el-button>
            </div>
        </div>

        <el-alert
            v-if="!isUnique"
            title="Oops! it looks like you have already added that as a choice. Let's try again with a different value."
            type="error">
        </el-alert>

        <el-alert
            v-if="isEmpty"
            title="Oops! This value cannot be empty. Lets try that again."
            type="error">
        </el-alert>

        <form @submit.prevent="addItem" class="tw-inline-block tw-my-4">
            <el-row> 
                <el-col :span="16" class="tw-float-left">
                    <label for="add-item">Add a new Item</label>
                    <el-input id="add-item" v-model="itemText"></el-input>
                    <el-tooltip content="Alternatively, you can press enter after typing in this field to add items to the list">
                        <el-button type="text" @click="addItem">Add</el-button>
                    </el-tooltip>
                </el-col>
            </el-row>
        </form>

  </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
        return {
            nextItem: 0,
            itemText: '',
            isUnique: true,
            isEmpty: false,
            temp: ''
        }
    },
    components: {
        EditableText
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        },
    },
    computed: {

        field: {
            get() { return this.fieldData; },
            set(field) { this.$emit('update', field); }
        },

        fieldLabel: {
            get() { return this.field.title; },
            set(title) {
                if(title === ''){
                    title = this.temp;
                    return this.isEmpty = true;
                }

                const fieldCopy = _.clone(this.field);
                fieldCopy.title = title;
                this.field = fieldCopy;
                this.isEmpty = false;
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
            }
        },

        required: {
            get() { return this.field.settings.required; },
            set(required) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.settings.required = required;
                this.field = fieldCopy;
            }
        }
    },
    methods: {
        getCheckboxItems() {
            for(let i = 0; i < this.field.settings.checkboxNum; i++) {
                this.loadItem();
            }
        },

        loadItem() {
            this.choices.push({
                id: this.nextItem++, 
                value: 'Choice ' + this.nextItem
            })
            this.$store.commit('UPDATE_FIELD', this.field)
        },

        addItem() {
            const choicesCopy = _.clone(this.choices);
            
            if(this.itemText === '') {
                return this.isEmpty = true;
            }

            for(var i = 0; i < this.choices.length; i++) {
                if(this.choices[i].value.toUpperCase() === this.itemText.toUpperCase()) {

                    this.itemText = ''
                    return this.isUnique = false;
                }
            }

            choicesCopy.push({
                id: this.nextItem++, value: this.itemText
            });

            this.choices = choicesCopy;
            this.itemText = ''
            this.isUnique = true;
            this.isEmpty = false;
        },
        
        removeChoice(item) {
            var index = this.choices.indexOf(item);

            if (index !== -1) {
                this.choices.splice(index, 1);
                this.$store.commit('UPDATE_FIELD', this.field)
            }

            this.$forceUpdate();
        },

        tempValue(value) {
            this.temp = value;
        },

        updateChoiceValue(value, index) {
            const fieldCopy = _.clone(this.field);

            if(value === '') {
                this.field.choices[index].value = this.temp;
                return this.isEmpty = true;
            }

            for(var i = 0; i < this.field.choices.length; i++) {
                if(this.field.choices[i].value.toUpperCase() === value.toUpperCase()) {
                    this.field.choices[index].value = this.temp;
                    
                    return this.isUnique = false;
                }
            }
            
            fieldCopy.choices[index].value = value;
            this.choices = fieldCopy.choices;
            this.isEmpty = false;
            this.isUnique = true;
        } ,
    },
}
</script>

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
.switch-position {
    position: relative;
    top: 15px;
    right: 40px;
}
.zone {
    overflow: none;
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    max-height: 300px;
    max-width: 300px;
}
</style>