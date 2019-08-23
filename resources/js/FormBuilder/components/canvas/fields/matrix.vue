<template>
    <div id="matrix">

        <slot></slot>

        <el-switch 
            v-model="field.settings.required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right switch-position">
        </el-switch>
        
        <el-row class="tw-mt-1">
            <el-col :span="10">
                <label>
                    <editable-text 
                        class="tw-cursor-pointer mouseOver" 
                        v-model="fieldLabel"
                        @edit="tempValue(fieldLabel)">
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

        <el-alert
            v-if="isEmpty"
            title="Woops! Your question/title cannot be empty. Lets try that again."
            type="error">
        </el-alert>

        <table id="matrix-table">
            <thead>
                <tr class="tw-max-w-sm">
                    <th></th>
                    <th v-for="(choice, index) in choices" :key="choice" >
                        <div class="tw-inline-flex tw-justify-between tw-whitespace-no-wrap">
                            <div class="tw-flex-none">
                                <editable-text 
                                    class="tw-cursor-pointer mouseOver" 
                                    :value="choice"
                                    @input="updateChoiceValue($event, index)"
                                    @edit="tempValue(choice)">
                                        {{ choice }}
                                </editable-text>
                            </div>
                            <div class="tw-flex-1 tw-relative tw-right-0">
                                <el-button 
                                    class="hover:tw-text-red-600" 
                                    type="text" 
                                    size="mini" 
                                    @click="removeChoice(choice)">
                                        <base-icon>delete_forever</base-icon>
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
                <tr v-for="(question, index) in questions" :key="question">
                    <td>
                        <div class="tw-inline-flex tw-justify-between">
                            <div class="tw-flex-auto">
                                <editable-text 
                                    class="tw-cursor-pointer mouseOver tw-inline-block" 
                                    :value="question"
                                    @input="updateQuestionValue($event, index)"
                                    @edit="tempValue(question.name)">
                                        {{ question.name }}
                                </editable-text>
                            </div>
                            <div class="tw-flex-1 tw-relative tw-right-0">
                                <el-button 
                                    class="hover:tw-text-red-600"
                                    type="text" 
                                    size="mini"
                                    @click="removeQuestion(question)">
                                        <base-icon>delete_forever</base-icon>
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

        <el-alert
            v-if="!isUnique"
            title="Woops! it looks like you have already added that as a choice. Let's try again with a different value."
            type="error">
        </el-alert>
        <el-alert
            v-if="isEmptyTable"
            title="Woops! Your question or choice cannot be empty. Lets try that again."
            type="error">
        </el-alert>

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
            isMounted: false,
            isUnique: true,
            isEmpty: false,
            isEmptyTable: false,
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
            get() { return this.field.title },
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

        tempValue(value) {
            this.temp = value;
        },

        addQuestion() {
            const questionsCopy = _.clone(this.questions);
            if(this.itemText === '') {
                return this.isEmptyTable = true;
            }

            for(var i = 0; i < this.questions.length; i++) {
                if(this.questions[i].name.toUpperCase() === this.itemText.toUpperCase()) {

                    this.itemText = ''
                    return this.isUnique = false;
                }
            }

            questionsCopy.push( this.itemText );

            this.questions = questionsCopy;
            this.itemText = '';
            this.isUnique = true;
            this.isEmptyTable = false;
            this.$forceUpdate();
        },
        
        removeQuestion(question) {
            this.$confirm('Are you sure you would like to remove this particular question?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: 'Question deleted'
                });
                var index = this.questions.indexOf(question);

                if (index !== -1) {
                    this.questions.splice(index, 1);
                }
                
                this.$store.commit('UPDATE_FIELD', this.field);
                this.$forceUpdate();
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Delete canceled'
                });          
            });
        },

        addChoice() {
            const choicesCopy = _.clone(this.choices);

            choicesCopy.push( 'New Choice' );

            this.choices = choicesCopy;
            this.$forceUpdate();
        },

        removeChoice(choice) {
            this.$confirm('Are you sure you\'d like to remove this column?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                var index = this.choices.indexOf(choice);

                if (index !== -1) {
                    this.choices.splice(index, 1);
                    this.$store.commit('UPDATE_FIELD', this.field)
                }

                this.$forceUpdate();

                this.$message({
                    type: 'success',
                    message: 'Column deleted'
                });
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Delete canceled'
                });          
            });
        },
        
        updateChoiceValue(value, index) {
            const fieldCopy = _.clone(this.field);

            if(value === '') {
                this.choices[index] = this.temp;
                return this.isEmptyTable = true;
            }

            for(var i = 0; i < this.field.choices.length; i++) {
                if(this.field.choices[i].toUpperCase() === value.toUpperCase()) {
                    this.field.choices[index] = this.temp;
                    
                    return this.isUnique = false;
                }
            }

            fieldCopy.choices[index] = value;
            this.choices = fieldCopy.choices;
            this.isEmptyTable = false;
            this.isUnique = true;

            

            this.$forceUpdate();
        },

        updateQuestionValue(value, index) {
            const fieldCopy = _.clone(this.field);

            if(value === '') {
                this.questions[index] = this.temp;
                return this.isEmptyTable = true;
            }
            for(var i = 0; i < this.questions.length; i++) {
                if(this.questions[i].toUpperCase().name === value.toUpperCase()) {
                    
                    this.questions[index].name = this.temp;
                    
                    return this.isUnique = false;
                }
            }

            fieldCopy.questions[index].name = value;
            this.questions = fieldCopy.questions;
            this.isEmptyTable = false;
            this.isUnique = true;
            this.$forceUpdate();
        }
        
    }
}
</script>

<style scoped>
    table{
        width: 100%; 
        margin-top: 20px; 
        z-index: 0;
        display: block;
        max-height: 300px;
        overflow-y: auto;
    }
    td {
        border: 1px solid #dedfe0;
        max-width: 20%;
    }
    tbody tr:hover {
        background: #9ebdef;
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
</style>
