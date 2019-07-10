<template>
    <div id="matrix">
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
        <table id="matrix-table">
            <thead>
                <tr class="tw-max-w-sm">
                    <th><el-button type="text" class="tw-ml-4" @click="addChoice">Add Radio Column</el-button></th>
                    <th v-for="(item, index) in choices" :key="item.index" >
                        <el-col>
                            <editable-text 
                                class="tw-cursor-pointer mouseOver" 
                                v-model="item.value"
                                @input="updateChoiceValue($event, index)"
                            />
                            <el-button 
                                class="tw-pr-15" 
                                type="text" 
                                size="mini" 
                                @click="removeChoice(item)">
                                    Remove
                            </el-button>
                        </el-col>  
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in questions" :key="item.index">
                    <td>
                        <editable-text 
                            class="tw-cursor-pointer mouseOver" 
                            v-model="item.text"
                            @input="updateQuestionValue($event, index)"
                        />
                        <el-button type="text" size="mini" @click="removeQuestion(item)">Remove</el-button>
                    </td>
                    <td v-for="radio in choices" :key="radio.index" class="tw-text-center">
                        <el-radio v-model="radioSelect" disabled></el-radio>
                    </td>
                </tr>
            </tbody>
        </table>

         <form @submit.prevent="addQuestion" class="tw-inline-block tw-my-4">
            <el-row>
                <label for="add-item">Add a new question</label>
                <el-col :span="16" class="tw-float-left">
                    <el-input id="add-item" v-model="itemText"></el-input>
                </el-col>
                <el-col :span="1.5" class="tw-float-right">
                    <el-tooltip content="Alternatively, you can press enter after typing in this field to add items to the list">
                        <el-button type="text" @click="addQuestion">Add</el-button>
                    </el-tooltip>
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
            nextQuestion: 0,
            nextChoice: 0,
            radioSelect: 1,
            itemText: '',
            isMounted: false
        }
    },
    mounted() {
        // calls methods upon being rendered in the DOM
        this.getMatrixItems(); 
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
            get() { return this.field.label },
            set(label) {
                const fieldCopy = _.clone(this.field);
                fieldCopy.label = label;
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
    },
    methods: {

        getMatrixItems() {
            var i;
            // if(!isMounted) {
                for(i = 0; i < this.field.settings.matrix_questions; i++) {
                    this.questions.push({
                        id: this.nextQuestion++, text: 'Question ' + this.nextQuestion
                    })
                }

                for(i = 1; i <= this.field.settings.matrix_choices; i++) {
                    this.choices.push({
                        id: this.nextChoice++, value: 'Item ' + this.nextChoice
                    })
                }

                this.$store.commit('UPDATE_FIELD', this.field)
            //     return this.isMounted = true
            // }
            
        },

        addQuestion() {
            const questionsCopy = _.clone(this.questions);

            questionsCopy.push({
                id: this.nextQuestion++, text: this.itemText
            });

            this.questions = questionsCopy;
            this.itemText = ''
        },
        
        removeQuestion(item) {
            // TODO: fix
            // const questionsCopy = _.clone(this.questions);

            var index = this.questions.indexOf(item);

            if (index !== -1) {
                this.questions.splice(index, 1);
            }
            // this.questions = questionsCopy;
            this.$store.commit('UPDATE_FIELD', this.field)
        },

        addChoice() {
            const choicesCopy = _.clone(this.choices);

            choicesCopy.push({
                id: this.nextQuestion++, value: 'New Item'
            });

            console.log(choicesCopy)
            this.choices = choicesCopy;
        },

        removeChoice(item) {
            var index = this.choices.indexOf(item);

            if (index !== -1) {
                this.choices.splice(index, 1);
                this.$store.commit('UPDATE_FIELD', this.field)
            }
        },
        
        updateChoiceValue(value, index) {
            const fieldCopy = _.clone(this.field);
            fieldCopy.choices[index].value = value;
            this.choices = fieldCopy.choices;
        },

        updateQuestionValue(value, index) {
            const fieldCopy = _.clone(this.field);
            fieldCopy.questions[index].value = value;
            this.questions = fieldCopy.questions;
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
</style>
