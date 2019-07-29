<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="title">
                <el-input v-model="fieldData.title"></el-input>
            </el-form-item>
            
            <el-form-item label="Additional information">
                <el-input v-model="fieldData.description"></el-input>
            </el-form-item>
            
            <el-form-item label="This field is">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            
            <el-form-item label="Number of questions" >
                <el-input-number v-model="fieldData.settings.matrix_questions"
                    controls-position="right" 
                    :min="1">
                </el-input-number>
            </el-form-item>
            
            <el-form-item label="Number of choices per question">
                <el-input-number v-model="fieldData.settings.matrix_choices"
                    controls-position="right"  
                    :min="1" :max="10">
                </el-input-number>
            </el-form-item>
            
            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save" class="tw-w-48">Add it!</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
export default {
    name: 'matrix',
    data: () => {
        return {
            fieldData: {
                type: 'MatrixField',
                name: 'matrix_field',
                title: '',
                description: '',
                settings: {
                    required: false,
                    matrix_questions: 2,
                    matrix_choices: 5,
                    nextQuestion: 0,
                    nextChoice: 0,
                },
                questions: [],
                choices: [],
                rules: {
                    title: [
                        { required: true, message: 'Please input question title', trigger: 'blur' }
                    ]
                }
            },
        }
    },
    props: {
        inputData: Object,
    },

    methods: {

        setQuestions() {

            for(let i = 0; i < this.fieldData.settings.matrix_questions; i++) {
                this.fieldData.questions.push({
                    id: this.fieldData.settings.nextQuestion++, text: 'Question ' + this.fieldData.settings.nextQuestion
                })
            }
        },

        setChoices() {

            for(let i = 1; i <= this.fieldData.settings.matrix_choices; i++) {
                this.fieldData.choices.push({
                    id: this.fieldData.settings.nextChoice++, value: 'Item ' + this.fieldData.settings.nextChoice
                })
            }
        },

        save() {
            this.setQuestions();
            this.setChoices();

            this.$emit('save', this.fieldData);
        }
    }
}
</script>

<style>

</style>
