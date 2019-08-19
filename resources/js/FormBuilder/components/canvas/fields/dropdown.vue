<template>
    <div id="dropdown">
        <slot></slot>
        
        <div class="tw-inline-flex tw-my-1">
        <!-- <el-col :span="6"> -->
            <label class="tw-flex-1">
                <editable-text class="tw-cursor-pointer mouseOver tw-mr-1" v-model="fieldLabel">
                    {{ fieldLabel }}
                </editable-text>
            </label>

            <div class="tw-inline">
                <el-select id="dropdown" v-model="dropItem" placeholder=" ">
                    <el-option v-for="(item, index) in choices" :key="index" :label="item.value" :value="item.value"></el-option>
                </el-select>
            </div>
            <!-- </el-col> -->

            <div class="tw-inline-flex tw-my-1 tw-ml-2" v-if="dropItem != null">
                <editable-text 
                    class="tw-cursor-pointer mouseOver" 
                    v-model="dropItem"
                    @input="updateChoiceValue($event)"
                    @edit="tempValue(dropItem)">
                    {{ dropItem }}
                </editable-text>
                <el-button 
                    class="tw-px-2 tw-py-1 hover:tw-text-red-600 " 
                    type="text" 
                    size="mini" 
                    @click="removeChoice(dropItem, index)">
                            <base-icon>delete_forever</base-icon>
                </el-button>
            </div>
        </div>

        <el-alert
            v-if="!isUnique"
            title="Woops! it looks like you have already added that as a choice. Let's try again with a different value."
            type="error">
        </el-alert>

        <el-switch 
            v-model="required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right switch-position hidden-xs-only">
        </el-switch>
        
        <form @submit.prevent="addItem" class="tw-mt-4 tw-ml-16">
                <!-- <el-col :span="2">
                    <label for="add-item" class="tw-text-right"></label>
                </el-col> -->
                <div class="tw-w-72 tw-inline-block">
                    <el-input id="add-item" placeholder="Add" v-model="itemText"></el-input>
                </div>
                <div class="tw-inline-block">
                    <el-tooltip content="Alternatively, you can press enter after typing in this field to add items to the list">
                        <el-button class="tw-px-2 tw-py-1" size="mini" @click="addItem">
                            <base-icon class="">add_box</base-icon>
                        </el-button>
                    </el-tooltip>
                </div>
        </form>

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
    }
}
</style>


