<template>
    <div id="dropdown">
        <slot></slot>

        <el-switch 
            v-model="required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right switch-position hidden-xs-only">
        </el-switch>
        
        <div class="tw-inline-flex tw-my-1">
            <label class="tw-flex-1">
                <editable-text 
                class="tw-cursor-pointer mouseOver tw-mr-1" 
                v-model="fieldLabel"
                @edit="tempValue(fieldLabel)">
                    {{ fieldLabel }}
                </editable-text>
            </label>

            <div class="tw-inline-block">
                <el-select id="dropdown" v-model="dropItem" :value="dropItem" placeholder=" ">
                    <el-option v-for="(item, index) in choices" :key="index" :label="item.value" :value="item.value"></el-option>
                </el-select>
            </div>

            
            <form @submit.prevent="addItem" class="tw-inline-flex tw-ml-8">
                <div class="tw-w-72 tw-inline-block tw-mt-0">
                    <el-input id="add-item" class="tw-w-72" placeholder="Add" v-model="itemText"></el-input>
                </div>
                <div class="tw-inline-block">
                    <el-tooltip content="Alternatively, you can press enter after typing in this field to add items to the list">
                        <el-button class="button" size="small" @click="addItem">
                            <base-icon>add_box</base-icon>
                        </el-button>
                    </el-tooltip>
                </div>
            </form>    
        </div>

        <el-alert
            v-if="!isUnique"
            title="Woops! it looks like you have already added that as a choice. Let's try again with a different value."
            type="error">
        </el-alert>

        <el-alert
            v-if="isEmpty"
            title="Woops! This value cannot be empty. Lets try that again."
            type="error">
        </el-alert>

    <div class="tw-ml-16 tw-pl-2" v-if="dropItem != null">
        <span>Edit this list item: </span>
        <div class="tw-inline-flex tw-justify-between">
            <div class="tw-flex-auto">
                <editable-text 
                    class="tw-cursor-pointer mouseOver tw-inline-block tw-w-64" 
                    :value="dropItem"
                    @input="updateChoiceValue($event)"
                    @edit="tempValue(dropItem)">
                    {{ dropItem }}
                </editable-text>
            </div>
            <div class="tw-flex-1 tw-relative tw-right-0">
                <el-button 
                    class="tw-px-2 tw-py-1 hover:tw-text-red-600" 
                    type="text" 
                    size="mini" 
                    @click="removeChoice(dropItem, index)">
                            <base-icon>delete_forever</base-icon>
                </el-button>
            </div>
        </div>
    </div>
        

    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
        return {
            itemText: '',
            value: '',
            nextItem: 0,
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
        }
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

        dropItem: {
            get(){ return this.choices.value},
            set(value){
                const choicesCopy = _.clone(this.choices);
                choicesCopy.value = value;
                this.choices = choicesCopy;

                this.$forceUpdate();
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
        addItem() {
            const choicesCopy = _.clone(this.choices);

            if(this.itemText === '') {
                return this.isEmpty = true;
            }

            for(var i = 0; i < this.choices.length; i++) {
                if(this.choices[i].value === this.itemText) {

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
            this.$forceUpdate();
        },
        removeChoice(item, index) {

            if (index !== -1) {
                this.choices.splice(index, 1);
                this.$store.commit('UPDATE_FIELD', this.field)
            }
            this.dropItem = null;
            this.$forceUpdate();
        },

        tempValue(value) {
            this.temp = value;
        },

        updateChoiceValue(value, index) {
            const fieldCopy = _.clone(this.field);

            for(var i = 0; i < this.field.choices.length; i++) {
                if(this.field.choices[i].value.toUpperCase() === value.toUpperCase()) {

                    // this.field.choices[index].value = this.temp;
                    this.dropItem = this.temp;
                    
                    return this.isUnique = false;
                }
            }

            fieldCopy.choices[index].value = value;
            this.choices = fieldCopy.choices;
            this.dropItem = value;
            this.isUnique = true;
            this.$forceUpdate();
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
.button {
    margin-top: 3px !important;
    padding: 5px;
}
.switch-position {
    position: relative;
    top: 15px;
    right: 40px;
}

@media (max-width: 768px) {
    .switch-position {
        position: relative;
        bottom: 0;
        right: 0;
        margin-right: 4px;
    }
}
</style>


