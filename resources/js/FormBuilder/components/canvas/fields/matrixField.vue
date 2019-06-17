<template>
    <div id="textarea">
        
         <span class="inputLabel">{{ myOptions.title }}</span><br>
        <!--<el-table :data="matrix" style="width: 100%; margin-top: 20px; ; z-index: 0" height="342" border highlight-current-row show-summary>
            <el-table-column fixed label="question" :prop="question" v-slot="{ $index }">
                <editable-text class="cursor-text" @input="showField" v-model="matrix[$index].question"/>
            </el-table-column>
            <div v-for="item in radioList" :key="item.key" class="inline-block">
                <el-table-column prop="response" :label="response" v-slot="{ $index }">
                    <el-radio class="float-left" ></el-radio>
                    <editable-text class="cursor-text float-right" @input="showField" v-model="matrix[$index].response"/>
                </el-table-column>
            </div>
            <el-table-column fixed="right" width="120">
                
            </el-table-column>
        </el-table>  -->

        <table id="matrix-table">
            <thead>
                <tr class="tw-max-w-sm">
                    <th></th>
                    <th v-for="item in radioList" :key="item.key" >
                        <el-col>
                            <editable-text class="tw-cursor-pointer" @input="showField" v-model="item.response"/>
                        </el-col>  
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in matrix" :key="item.id">
                    <td>
                        <editable-text class="tw-cursor-pointer" @input="showField" v-model="item.question"/>
                        <el-button type="text" size="mini" @click="removeItem(item)">Remove</el-button>
                    </td>
                    <td v-for="radio in radioList" :key="radio" class="tw-text-center">
                        <el-radio v-model="radioSelect"></el-radio>
                    </td>
                </tr>
            </tbody>
            
        </table>

        <!-- <div v-for="item in matrix" :key="item"></div> -->

        <el-collapse>   
            <el-collapse-item name="1">
                <template slot="title">
                    <h1>Matrix Settings</h1>
                </template>
                <div class="tw-flex tw-inline-block tw-w-full">
                  <div class="tw-float-left">
                    <span>Field Label</span>
                    <el-row>
                      <el-col :span="20">
                        <el-input v-model="myOptions.title"></el-input>
                      </el-col>
                    </el-row>

                    <div class="tw-my-6">
                        <span class="tw-mb-4">This field is</span><br>
                        <el-switch v-model="myOptions.required" active-text="Required" inactive-text="Optional"></el-switch>
                    </div> 
                </div>

                <div class="tw-float-right tw-mx-20">
                    <span class="tw-mt-8">Number of Choices</span><br>
                    <el-input-number v-model="myOptions.matrixChoices"
                        controls-position="right" 
                        @change="handleChange" 
                        :min="1" :max="10">
                    </el-input-number>
                    <el-button type="success" class="tw-ml-4" @click="getRadioList">Set </el-button><br>

                    <form @submit.prevent="addItem" class="tw-inline-block tw-my-4">
                      <span>Add a new question to the matrix</span>
                      <el-row>
                        <el-col :span="16" class="tw-float-left">
                            <el-input v-model="itemText"></el-input>
                        </el-col>
                        <el-col :span="1.5" class="tw-float-right">
                            <el-tooltip content="Alternatively, you can press enter after typing in this field to add items to the list">
                                <el-button type="success" @click="addItem">Add</el-button>
                            </el-tooltip>
                        </el-col>
                      </el-row>
                    </form>
                </div>
            </div>

                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
        return {
            matrix: [],
            nextItem: 0,
            radioSelect: 1,
            radioList: [],
            question: '',
            response: '',
            editField: '',
            itemText: '',
            myOptions: []
        }
    },
    components: {
        EditableText
    },
    props: {
        options: {
            type: Array | Object,
            default: {
                title: 'Matrix Field',
                required: false,
                reference: '',
                dropdownNum: 2,
                radioNum: 2,
                checkboxNum: 2,
                matrixQuestions: 2,
                matrixChoices: 5,
                setLength: 50,
            }
        }
    },
    created() {
        this.myOptions = _.clone(this.options)
    },
    mounted: function() {
        this.getMatrixItems(); // calls method upon being rendered in the DOM
        this.getRadioList();
    },
    computed: {
        columnText() {

            // <editable-text class="cursor-text float-right" @input="showField" v-model="matrix[$index].response"/>
        }
    },
    methods: {
        addItem: function() {
            this.matrix.push({
                id: this.nextItem++, question: this.itemText, response: ''
            })
            this.itemText = ''
        },
        loadItem: function() {
            // var i;
            // for(i = 0; i < this.myOptions.matrixChoices; i++) {
            //     this.matrix.response["key" + i] = "Value";
            // }
            this.matrix.push({
                id: this.nextItem++, question: 'Question ' + this.nextItem, response: this.nextItem 
            })
        },
        removeItem(item) {
            var index = this.matrix.indexOf(item);
            if (index !== -1) {
                this.matrix.splice(index, 1);
            }
        },
        getMatrixItems() {
            var i;
            for(i = 0; i < this.myOptions.matrixQuestions; i++) {
                this.loadItem();
            }
        },
        getRadioList() {
            var i;
            this.radioList = []

            for(i = 1; i <= this.myOptions.matrixChoices; i++) {
                this.radioList.push({
                    key: i,
                    response: 'Item ' + i
                })
            }
        },
        showField(question) {
            return (this.matrix[question] == '' || this.editField == question)
        },
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
    /* #matrix-table th {
        background-color: #9ebdef;
    } */
    #matrix-table tbody tr:hover {
        background: #9ebdef;
    }
</style>
