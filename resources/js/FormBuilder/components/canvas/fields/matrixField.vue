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

        <table>
            <tr>
                <th>Question</th>
                <th v-for="(radio, index) in radioList" :key="index">
                    <span>
                        <editable-text class="cursor-text float-right" @input="showField" v-model="matrix.response"/>
                        <!-- <span>hey</span> -->
                    </span>
                </th>
                <th>Remove item</th>
            </tr>
            <tr v-for="(item,index) in matrix" :key="index">
                <td>
                    <editable-text class="cursor-text" @input="showField" v-model="matrix.question"/>
                    <!-- <span>hey</span> -->
                </td>
                <td v-for="radio in radioList" :key="radio">
                    <el-radio v-model="radioSelect"></el-radio>
                </td>
                <td class="tw-float-right">
                    <el-button class="float-right" type="text" size="mini" @click="test(question)">Remove</el-button>
                </td>
            </tr>
        </table>

        <el-collapse>   
            <el-collapse-item name="1">
                <template slot="title">
                    <h1>Matrix Settings</h1>
                </template>
                <div>
                    <slot></slot>
                  <div class="my-4">
                    <span>Field Label</span>
                    <el-row>
                      <el-col :span="6">
                        <el-input v-model="myOptions.title"></el-input>
                      </el-col>
                    </el-row>
                  </div>
                  <div class="my-4">
                    <span>Will this field be required?</span>
                    <el-switch v-model="myOptions.required" active-text="Required" inactive-text="Optional"></el-switch>
                  </div>

                    <form @submit.prevent="addItem" class="my-4">
                      <span>Add Question to List</span>
                      <el-row :gutter="5">
                        <el-col :span="6">
                            <el-input class="float-left" v-model="itemText"></el-input>
                        </el-col>
                        <el-col :span="1.7">
                          <el-button class="float-right" type="success" @click="addItem">Add</el-button>
                        </el-col>
                      </el-row>
                        <!-- <span>Add Question to List</span>
                            <el-input v-model="itemText"></el-input>
                            <el-button type="success" @click="addItem">Add</el-button> 
                        -->
                    </form>
                </div>
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
            response: 'derp',
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
                id: this.nextItem++, question: 'Question ' + this.nextItem, response: 'response'
            })
        },
        removeItem(question) {
            var index = this.matrix.indexOf(question);
            if (index !== -1) {
                this.matrix.splice(index, 1);
            }
        },
        getMatrixItems() {
            var i;
            for(i = 0; i < this.myOptions.matrixQuestions; i++) {
                this.loadItem();
                // this.matrix.response["key" + i] = "Value";
            }
        },
        getRadioList() {
            var i;
            for(i = 1; i <= this.myOptions.matrixChoices; i++) {
                this.radioList.push({
                    key: i
                })
            }
        },
        showField(question) {
            return (this.matrix[question] == '' || this.editField == question)
        },
        test(value) {
          var index = this.matrix.indexOf(value);
          console.log(index)
        }
    }
}
</script>

<style>
</style>
