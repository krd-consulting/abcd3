<template>
  <div id="checkbox">

        <slot></slot>

      <el-col :span="8">
          <label class="inputLabel">
            <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                {{ fieldLabel }}
            </editable-text>
        </label>
      </el-col>
        <br><br>

        <el-checkbox-group 
            id="check" 
            v-for="(item, index) in choices" 
            :key="item.value">

            <el-checkbox 
                v-model="value" 
                :label="item.value">
                    <editable-text 
                        class="tw-cursor-pointer mouseOver"
                        v-model="item.value"
                        @input="updateChoiceValue($event, index)">
                            {{ item.value }}
                    </editable-text>
            </el-checkbox>
            <el-button 
                type="text" 
                size="mini" 
                @click="removeChoice(item)">
                    Remove
            </el-button>
        </el-checkbox-group>
        <el-alert
        v-if="!isUnique"
            title="Woops! it looks like you have a duplicate choice. Let's try again with a different value."
            type="error">
        </el-alert>

        <el-switch 
            v-model="required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right switch-position">
        </el-switch>

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
            isUnique: true
        }
    },
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

        // unique() {
        //     return function (keyname) {
        //         var output = [];
        //         var keys   = [];

        //         this.choices.forEach(function (choice) {
        //             var key = choice.value[keyname];

        //             if (keys.indexOf(key) === -1) {
        //                 keys.push(key);
        //                 output.push(post);
        //             }
        //             return isUnique = false;
        //         });

        //         return output;
        //     };
        // },

        field: {
            get() { return this.fieldData; },
            set(field) { this.$emit('update', field); }
        },

        fieldLabel: {
            get() { return this.field.title; },
            set(title) {
                const fieldCopy = _.clone(this.field);
                fieldCopy.title = title;
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
                // this.$emit('updateChoices', field);
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
    },
    // filters: {
    //     duplicate(value) {
            // for(let i = 0; i <= this.choices.length(); i++) {
            //     if(value === item.value) {

            //         this.removeChoice(item);
            //         return isDuplicate = true;
            //     }
    //         }
    //     }
    // },
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
    position: absolute;
    bottom: 20px;;
    right: 10px;
}
</style>