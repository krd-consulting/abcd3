<template>
    <div id="Textbox">
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
                    placeholder="Your text here" 
                    v-model="value">
                </el-input>
                <el-input id="textBox" 
                    v-else type="textarea" 
                    :rows="2" 
                    placeholder="Your text here" 
                    v-model="value">
                </el-input>
            </el-col>
            
            <slot></slot>
        </el-row>
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
            get() { return this.field.label; },
            set(label) { 
                console.log('field label edited');

                const fieldCopy = _.clone(this.field);

                fieldCopy.label = label;

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
</style>
