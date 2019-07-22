<template>
    <div id="Textbox" class="tw-mb-4">
        <el-row>
            <el-col :span="10">

                <label class="inputLabel">   
                    <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                        {{ fieldLabel }}
                    </editable-text>
                </label> 

                <el-input id="textBox" 
                    v-if="field.settings.isLimited" 
                    type="textarea" 
                    :rows="2" 
                    :maxlength="field.settings.max" 
                    show-word-limit 
                    placeholder="Your text here">
                </el-input>
                <el-input id="textBox" 
                    type="textarea" 
                    v-else
                    :rows="2" 
                    placeholder="Your text here" >
                </el-input>
            </el-col>
        </el-row>

            <el-switch 
                v-model="field.settings.required" 
                active-text="Required" 
                inactive-text="Optional"
                class="tw-float-right tw-mr-48 button-top">
            </el-switch>
            
            <div class="footer">
                <slot></slot>
            </div>
        
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    name: 'Textbox',
    data() {
        return {
            value: '',
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    components: {
        EditableText
    },
    computed: {
        fieldLabel: {
            get() { return this.field.title; },
            set(title) { 
                console.log('field label edited');

                const fieldCopy = _.clone(this.field);

                fieldCopy.title = title;

                this.field = fieldCopy;
            }
        },

        field: {
            get() { return this.fieldData; },
            set(field) { 
                console.log('field edited');
                this.$emit('update', field); 
            }
        },
    },
    // created() {
    //     this.field = _.clone(this.fieldData)
    // },
    // methods: {
    //     showField(value){
    //         return (this.field.label[value] == '' || this.editField == value)
    //     }
    // }
}
</script>

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
.button-top {
    position: absolute;
    top: 30px;;
    right: 10px;
}
.footer{
    position: absolute;
    bottom: 0;
    right: 10px;
}
</style>
