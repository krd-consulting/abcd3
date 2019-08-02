<template>
    <div id="dropdown">
        <el-col :span="8">
            <label class="inputLabel">
                <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                    {{ fieldLabel }}
                </editable-text>
            </label>
        </el-col><br><br>
             <el-radio-group id="radioGroup">
                <el-radio 
                    v-model="value" 
                    v-for="(item, index) in choices" 
                    :key="item.value" 
                    :label="item.value" 
                    class="tw-mx-4">
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
                </el-radio>
            </el-radio-group>
        
        <el-switch 
            v-model="required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right tw-mr-48 button-top">
        </el-switch>
        
        <form @submit.prevent="addItem" class=" tw-mt-4">
            <el-row> 
                <el-col :span="6" class="tw-float-left">
                    <label for="add-item">Add a new Item</label>
                    <el-input id="add-item" v-model="itemText"></el-input>
                    <el-tooltip content="Alternatively, you can press enter after typing in this field to add items to the list">
                        <el-button type="text" @click="addItem">Add</el-button>
                    </el-tooltip>
                </el-col>
            </el-row>
        </form>
        
        <div class="footer">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
        return {
            itemText: '',
            nextItem: 0,
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

        field: {
            get() { return this.fieldData; },
            set(field) { 
                console.log('field edited');
                this.$emit('update', field); 
            }
        },

        fieldLabel: {
            get() { return this.field.title; },
            set(title) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.label = label;
                this.field = fieldCopy;
            }
        },

        choices: {
            get() { return this.field.choices},
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

        addItem: function() {
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
.button-top {
    position: absolute;
    top: 30px;;
    right: 10px;
}
.footer{
    position: absolute;
    bottom: 0;
    right: 10px;
}
</style>
