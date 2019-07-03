<template>
    <div id="textarea">
        <label for="matrix-table" class="inputLabel">{{ field.label }}</label><br>
        <sup>{{ field.description }}</sup>
        <table id="matrix-table">
            <thead>
                <tr class="tw-max-w-sm">
                    <th><el-button type="text" class="tw-ml-4" @click="addColumn">Add Radio Column</el-button></th>
                    <th v-for="item in radioList" :key="item.key" >
                        <el-col>
                            <editable-text class="tw-cursor-pointer" v-model="item.text"/>
                            <el-button 
                                class="tw-float-right tw-pr-15" 
                                type="text" 
                                size="mini" 
                                @click="removeColumn(item)">
                                    Remove
                            </el-button>
                        </el-col>  
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in matrix" :key="item.id">
                    <td>
                        <editable-text class="tw-cursor-pointer" v-model="item.question"/>
                        <el-button type="text" size="mini" @click="removeRow(item)">Remove</el-button>
                    </td>
                    <td v-for="radio in radioList" :key="radio" class="tw-text-center">
                        <el-radio v-model="radioSelect" disabled></el-radio>
                    </td>
                </tr>
            </tbody>
        </table>

         <form @submit.prevent="addItem" class="tw-inline-block tw-my-4">
            <el-row>
                <label for="add-item">Add a new question</label>
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

        <slot></slot>
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
            editField: '',
            itemText: '',
            field: []
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
    created() {
        this.field = _.clone(this.fieldData)
    },
    mounted() {
        // calls methods upon being rendered in the DOM
        this.getMatrixItems(); 
        this.getRadioList();
    },
    methods: {
        addItem() {
            this.matrix.push({
                id: this.nextItem++, question: this.itemText, response: ''
            })
            this.itemText = ''
        },
        loadItem() {
            this.matrix.push({
                id: this.nextItem++, question: 'Question ' + this.nextItem, response: this.radioList
            })
        },
        removeRow(item) {
            var index = this.matrix.indexOf(item);
            if (index !== -1) {
                this.matrix.splice(index, 1);
            }
        },
        addColumn() {
            // this.getRadioList();
            this.radioList.push({
                key: this.field.settings.matrix_choices++,
                text: 'Item ' + this.field.settings.matrix_choices
            })
        },
        removeColumn(item) {
            var index = this.radioList.indexOf(item);
            if (index !== -1) {
                this.radioList.splice(index, 1);
            }
        },
        getMatrixItems() {
            var i;
            for(i = 0; i < this.field.settings.matrix_questions; i++) {
                this.loadItem();
            }
        },
        getRadioList() {
            var i;
            this.radioList = []

            for(i = 1; i <= this.field.settings.matrix_choices; i++) {
                this.radioList.push({
                    key: i,
                    text: 'Item ' + i
                })
            }
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
    #matrix-table tbody tr:hover {
        background: #9ebdef;
    }
</style>
