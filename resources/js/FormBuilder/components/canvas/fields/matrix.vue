<template>
    <div id="matrix">

        <slot></slot>
        
        <el-row>
            <el-col :span="10">
                <label class="inputLabel">
                    <editable-text 
                        class="tw-cursor-pointer mouseOver" 
                        v-model="fieldLabel">
                            {{ fieldLabel }}
                    </editable-text>

                    <editable-text 
                        class="tw-cursor-pointer mouseOver tw-text-xs" 
                        v-model="fieldDescription">
                            {{ fieldDescription }}
                    </editable-text>
                </label>
            </el-col>
        </el-row>
        <table id="matrix-table">
            <thead>
                <tr class="tw-max-w-sm">
                    <th></th>
                    <th v-for="(item, index) in choices" :key="item.index" >
                        <div class="tw-inline-flex tw-justify-between tw-whitespace-no-wrap">
                            <div class="tw-flex-none">
                                <editable-text 
                                    class="tw-cursor-pointer mouseOver" 
                                    v-model="item.value"
                                    @input="updateChoiceValue($event, index)"
                                />
                            </div>
                            <div class="tw-flex-1 tw-relative tw-right-0">
                                <el-button 
                                    class="hover:tw-text-red-600" 
                                    type="text" 
                                    size="mini"
                                    icon="el-icon-close" 
                                    @click="removeChoice(item)">
                                </el-button>
                            </div>
                        </div>  
                    </th>
                    <el-tooltip content="Add a new choice column">
                        <el-button class="tw-ml-4 tw-bg-blue-500 tw-text-white hover:tw-bg-blue-100" @click="addChoice" icon="el-icon-plus" circle></el-button>
                    </el-tooltip>
                    
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in questions" :key="item.index">
                    <td>
                        <div class="tw-inline-flex tw-justify-between">
                            <div class="tw-flex-auto">
                                <editable-text 
                                    class="tw-cursor-pointer mouseOver" 
                                    v-model="item.text"
                                    @input="updateQuestionValue($event, index)"
                                />
                            </div>
                            <div class="tw-flex-1 tw-relative tw-right-0">
                                <el-button 
                                    class="hover:tw-text-red-600"
                                    type="text" 
                                    size="mini"
                                    icon="el-icon-close" 
                                    @click="removeQuestion(item)">
                                </el-button>
                            </div>
                        </div>
                    </td>
                    <td v-for="radio in choices" :key="radio.index" class="tw-text-center">
                        <el-radio v-model="radioSelect" disabled></el-radio>
                    </td>
                </tr>
            </tbody>
        </table>

        <el-switch 
            v-model="field.settings.required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right switch-position">
        </el-switch>

         <form @submit.prevent="addQuestion" class="tw-inline-block tw-my-4">
            <el-row>
                <label for="add-item">Add a new question</label>
                <el-col :span="16" class="tw-float-left">
                    <el-input id="add-item" v-model="itemText"></el-input>
                    <el-tooltip content="Alternatively, you can press enter after typing in this field to add items to the list">
                        <el-button type="text" @click="addQuestion">Add</el-button>
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
            radioSelect: 1,
            itemText: '',
            isMounted: false
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
            get() { return this.field.title },
            set(title) {
                const fieldCopy = _.clone(this.field);
                fieldCopy.title = title;
                this.field = fieldCopy;
            }
        },

        fieldDescription: {
            get() { return this.field.description },
            set(description) {
                const fieldCopy = _.clone(this.field);
                fieldCopy.description = description;
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

        questions: {
            get() { return this.field.questions },
            set(questions) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.questions = questions;
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

        addQuestion() {
            const questionsCopy = _.clone(this.questions);

            questionsCopy.push({
                id: this.nextQuestion++, text: this.itemText
            });

            this.questions = questionsCopy;
            this.itemText = '';

            this.$forceUpdate();
        },
        
        removeQuestion(item) {

            var index = this.questions.indexOf(item);

            if (index !== -1) {
                this.questions.splice(index, 1);
            }
            this.$store.commit('UPDATE_FIELD', this.field);

            this.$forceUpdate();
        },

        addChoice() {
            const choicesCopy = _.clone(this.choices);

            choicesCopy.push({
                id: this.nextQuestion++, value: 'New Choice'
            });

            console.log(choicesCopy)
            this.choices = choicesCopy;

            this.$forceUpdate();
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

            this.$forceUpdate();
        },

        updateQuestionValue(value, index) {
            const fieldCopy = _.clone(this.field);
            fieldCopy.questions[index].value = value;
            this.questions = fieldCopy.questions;

            this.$forceUpdate();
        }
        
    }
}
</script>

<style scoped>
    #matrix-table {
        width: 100%; 
        margin-top: 20px; 
        z-index: 0;
        
    }
    #matrix-table table, td {
        border: 1px solid #dedfe0;
    }
    #matrix-table tbody tr:hover {
        background: #9ebdef;
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
    .footer{
        position: absolute;
        bottom: 0;
        right: 10px;
    }
</style>
