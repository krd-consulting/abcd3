<template>
    <div id="textarea">
        <label for="matrix-table" class="inputLabel">{{ inputFieldData.label }}</label><br>
        <sup>{{ inputFieldData.description }}</sup>
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

        <el-collapse>   
            <el-collapse-item name="1">
                <template slot="title">
                    <el-button icon="el-icon-edit">Field Options</el-button>
                </template>
                <div class="tw-flex tw-inline-block tw-w-full">
                  <div class="tw-float-left">
                    <el-row class="tw-my-6">
                        <label for="label">Field Label</label>
                        <el-col :span="20">
                            <el-input id="label" v-model="inputFieldData.label"></el-input>
                        </el-col>
                    </el-row>
                    <el-row class="tw-my-6">
                        <el-col :span="20">
                            <label for="description">Field Description</label>
                            <el-input id="description" v-model="inputFieldData.description"></el-input>
                        </el-col>
                    </el-row>
                    <el-row class="tw-my-6">
                        <label for="switch" class="tw-mb-4">This field is</label><br>
                        <el-switch id="switch" v-model="inputFieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
                    </el-row> 
                </div>

                <div class="tw-float-right tw-mx-20">
                    <label for="choices">Number of Choices</label>
                    <el-input-number id="choices" v-model="inputFieldData.options.matrixChoices"
                        controls-position="right"  
                        :min="1" :max="10">
                    </el-input-number>
                    <el-button type="success" class="tw-ml-4" @click="getRadioList">Set </el-button><br>

                    <form @submit.prevent="addItem" class="tw-inline-block tw-my-4">
                      <el-row>
                        <label for="add-item">Add a new question to the matrix</label>
                        <el-col :span="16" class="tw-float-left">
                            <el-input id="add-item" v-model="itemText"></el-input>
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
            inputFieldData: []
        }
    },
    components: {
        EditableText
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {
            }
        }
    },
    created() {
        this.inputFieldData = _.clone(this.fieldData)
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
            for(i = 0; i < this.inputFieldData.options.matrixQuestions; i++) {
                this.loadItem();
            }
        },
        getRadioList() {
            var i;
            this.radioList = []

            for(i = 1; i <= this.inputFieldData.options.matrixChoices; i++) {
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
